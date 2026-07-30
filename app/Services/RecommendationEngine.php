<?php

namespace App\Services;

use App\Models\Program;
use App\Models\Recommendation;
use App\Models\User;
use Illuminate\Support\Collection;

/**
 * Rule-Based Recommendation Engine
 *
 * Scores every active program against the student's academic profile
 * using four weighted criteria:
 *
 *   1. Field-of-Study Match     — 40 pts  (is the program in the student's preferred field?)
 *   2. CGPA Score               — 25 pts  (how far above the program's minimum CGPA is the student?)
 *   3. Language Compatibility   — 20 pts  (does the student's language level meet the requirement?)
 *   4. Ranking / Tier Score     — 15 pts  (weighting by university tier)
 *
 * Total max = 100 pts.
 * Results are sorted descending and the top N stored in the recommendations table.
 */
class RecommendationEngine
{
    // ── Weights ───────────────────────────────────────────────
    private const W_FIELD    = 40;
    private const W_CGPA     = 25;
    private const W_LANGUAGE = 20;
    private const W_RANKING  = 15;

    // ── Field matching keywords ───────────────────────────────
    // Maps a student's preferred_field to related keywords in programs
    private const FIELD_KEYWORDS = [
        'Computer Science'  => ['computer', 'software', 'information technology', 'it', 'data science', 'ai', 'artificial intelligence'],
        'Engineering'       => ['engineering', 'mechanical', 'electrical', 'civil', 'chemical', 'industrial'],
        'Business'          => ['business', 'management', 'mba', 'finance', 'accounting', 'economics', 'marketing', 'commerce'],
        'Medicine'          => ['medicine', 'medical', 'mbbs', 'clinical', 'pharmacy', 'nursing', 'health'],
        'Science'           => ['science', 'physics', 'chemistry', 'biology', 'mathematics', 'statistics'],
        'Agriculture'       => ['agriculture', 'agronomy', 'food science', 'horticulture', 'forestry'],
        'Arts & Humanities' => ['arts', 'humanities', 'literature', 'history', 'philosophy', 'linguistics', 'education'],
        'Architecture'      => ['architecture', 'urban planning', 'design', 'interior'],
    ];

    // ── Ranking tier scores (out of 15) ──────────────────────
    private const TIER_SCORES = [
        '985'                => 15,
        'Double First Class' => 13,
        '211'                => 11,
        'Provincial'         => 8,
        'Private'            => 5,
    ];

    // ── Language level parsing ────────────────────────────────
    // Extracts a numeric level from strings like "IELTS 6.5", "HSK 4", "None"
    private function parseLanguageLevel(string $proficiency): array
    {
        $proficiency = strtolower(trim($proficiency));

        if ($proficiency === '' || $proficiency === 'none' || $proficiency === 'n/a') {
            return ['type' => 'none', 'level' => 0];
        }

        if (str_contains($proficiency, 'ielts')) {
            preg_match('/[\d.]+/', $proficiency, $m);
            return ['type' => 'ielts', 'level' => (float) ($m[0] ?? 0)];
        }

        if (str_contains($proficiency, 'hsk')) {
            preg_match('/\d+/', $proficiency, $m);
            return ['type' => 'hsk', 'level' => (int) ($m[0] ?? 0)];
        }

        if (str_contains($proficiency, 'toefl')) {
            preg_match('/\d+/', $proficiency, $m);
            return ['type' => 'toefl', 'level' => (int) ($m[0] ?? 0)];
        }

        // English/Mandarin native
        if (str_contains($proficiency, 'native') || str_contains($proficiency, 'english')) {
            return ['type' => 'native', 'level' => 999];
        }

        return ['type' => 'unknown', 'level' => 0];
    }

    // ── 1. Field-of-Study Score (max 40) ─────────────────────
    private function scoreField(string $preferredField, Program $program): float
    {
        $programField = strtolower($program->field_of_study . ' ' . $program->program_name);

        // Exact match on normalised label
        if (strtolower(trim($preferredField)) === strtolower(trim($program->field_of_study))) {
            return self::W_FIELD; // 40 — perfect
        }

        // Keyword-based partial match
        $keywords = self::FIELD_KEYWORDS[$preferredField] ?? [];
        foreach ($keywords as $kw) {
            if (str_contains($programField, $kw)) {
                return self::W_FIELD * 0.8; // 32 — strong match
            }
        }

        // Broad category match (first word of preferred field against program)
        $firstWord = strtolower(explode(' ', $preferredField)[0]);
        if (str_contains($programField, $firstWord)) {
            return self::W_FIELD * 0.5; // 20 — weak match
        }

        return 0; // no field match
    }

    // ── 2. CGPA Score (max 25) ───────────────────────────────
    private function scoreCgpa(?float $studentCgpa, Program $program): float
    {
        if ($studentCgpa === null) {
            return 0;
        }

        $minRequired = $program->min_cgpa ?? 0;

        if ($minRequired == 0) {
            // No minimum — award based purely on CGPA level
            return min(self::W_CGPA, ($studentCgpa / 4.0) * self::W_CGPA);
        }

        if ($studentCgpa < $minRequired) {
            return 0; // Does not meet minimum — hard fail
        }

        // Score how comfortably above the minimum the student is
        $buffer = $studentCgpa - $minRequired;
        $maxBuffer = 4.0 - $minRequired;
        $comfortRatio = $maxBuffer > 0 ? min(1.0, $buffer / $maxBuffer) : 1.0;

        return self::W_CGPA * (0.7 + 0.3 * $comfortRatio); // 70% base + up to 30% comfort bonus
    }

    // ── 3. Language Compatibility Score (max 20) ─────────────
    private function scoreLanguage(string $studentProficiency, Program $program): float
    {
        $required = $program->language_requirement ?? 'None';

        if ($required === 'None' || trim($required) === '' || strtolower($required) === 'none') {
            return self::W_LANGUAGE; // No requirement — full score
        }

        $req   = $this->parseLanguageLevel($required);
        $have  = $this->parseLanguageLevel($studentProficiency);

        if ($have['type'] === 'native') {
            return self::W_LANGUAGE; // Native speaker — full score
        }

        if ($have['type'] === 'none' || $have['type'] === 'unknown') {
            return 0; // Cannot assess
        }

        // Same type comparison (IELTS vs IELTS, HSK vs HSK)
        if ($have['type'] === $req['type']) {
            if ($have['level'] >= $req['level']) {
                // Exceeds requirement — scale bonus
                $surplus = min(1.0, ($have['level'] - $req['level']) / max(1, $req['level']));
                return self::W_LANGUAGE * (0.8 + 0.2 * $surplus);
            }
            // Below requirement
            $ratio = $have['level'] / $req['level'];
            return $ratio >= 0.9 ? self::W_LANGUAGE * 0.4 : 0; // Slightly below: partial; far below: 0
        }

        // Cross-type approximation (IELTS ↔ TOEFL equivalences)
        if ($have['type'] === 'ielts' && $req['type'] === 'toefl') {
            // Approximate: IELTS × 14.5 ≈ TOEFL
            $equiv = $have['level'] * 14.5;
            return $equiv >= $req['level'] ? self::W_LANGUAGE : 0;
        }

        if ($have['type'] === 'toefl' && $req['type'] === 'ielts') {
            $equiv = $have['level'] / 14.5;
            return $equiv >= $req['level'] ? self::W_LANGUAGE : 0;
        }

        // Mandarin program but only have IELTS — still possible if bilingual program
        if ($req['type'] === 'hsk' && str_contains(strtolower($program->university->language_of_instruction ?? ''), 'english')) {
            return self::W_LANGUAGE * 0.5;
        }

        return 0;
    }

    // ── 4. Ranking / Tier Score (max 15) ─────────────────────
    private function scoreRanking(Program $program): float
    {
        $tier = $program->university->ranking_tier ?? 'Provincial';
        return self::TIER_SCORES[$tier] ?? 5;
    }

    // ── Main: generate recommendations for a user ─────────────
    public function generate(User $user, int $limit = 20): Collection
    {
        if (! $user->hasCompleteProfile()) {
            return collect();
        }

        $programs = Program::with('university')
            ->active()
            ->byDegree($user->degree_seeking)
            ->get();

        $scored = $programs->map(function (Program $program) use ($user) {
            $fieldScore    = $this->scoreField($user->preferred_field, $program);
            $cgpaScore     = $this->scoreCgpa($user->cgpa, $program);
            $languageScore = $this->scoreLanguage($user->language_proficiency ?? '', $program);
            $rankingScore  = $this->scoreRanking($program);

            $totalScore = $fieldScore + $cgpaScore + $languageScore + $rankingScore;

            return [
                'program'   => $program,
                'score'     => round($totalScore, 2),
                'breakdown' => [
                    'field_score'    => round($fieldScore, 2),
                    'cgpa_score'     => round($cgpaScore, 2),
                    'language_score' => round($languageScore, 2),
                    'ranking_score'  => round($rankingScore, 2),
                ],
            ];
        })->filter(fn ($r) => $r['score'] > 0) // discard zero-score results
          ->sortByDesc('score')
          ->take($limit);

        // Persist to recommendations table (replace previous run)
        Recommendation::where('user_id', $user->user_id)->delete();

        foreach ($scored as $result) {
            Recommendation::create([
                'user_id'        => $user->user_id,
                'university_id'  => $result['program']->university_id,
                'program_id'     => $result['program']->program_id,
                'match_score'    => $result['score'],
                'score_breakdown'=> $result['breakdown'],
            ]);
        }

        return $scored;
    }

    // ── Quick score without persisting (for live preview) ─────
    public function preview(User $user, int $limit = 5): Collection
    {
        if (! $user->hasCompleteProfile()) {
            return collect();
        }

        $programs = Program::with('university')
            ->active()
            ->byDegree($user->degree_seeking)
            ->take(200)
            ->get();

        return $programs->map(function (Program $p) use ($user) {
            return [
                'program' => $p,
                'score'   => round(
                    $this->scoreField($user->preferred_field, $p) +
                    $this->scoreCgpa($user->cgpa, $p) +
                    $this->scoreLanguage($user->language_proficiency ?? '', $p) +
                    $this->scoreRanking($p),
                    2
                ),
            ];
        })->sortByDesc('score')->take($limit);
    }
}
