<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\University;
use Illuminate\Http\Request;

class UniversityController extends Controller
{
    public function index(Request $request)
    {
        $query = University::active()->withCount(['programs', 'scholarships']);

        // ── Optimised multi-token search ──────────────────────
        if ($search = $request->input('search')) {
            $query->search($search);
        }

        // ── Filters ───────────────────────────────────────────
        if ($region = $request->input('region')) {
            $query->byRegion($region);
        }
        if ($city = $request->input('city')) {
            $query->byCity($city);
        }
        if ($lang = $request->input('language')) {
            $query->byLanguage($lang);
        }
        if ($tier = $request->input('tier')) {
            $query->byTier($tier);
        }

        // ── Sorting ───────────────────────────────────────────
        $sort = $request->input('sort', 'name');
        match ($sort) {
            'tier'  => $query->orderByRaw("FIELD(ranking_tier,'985','211','Double First Class','Provincial','Private')"),
            'city'  => $query->orderBy('city')->orderBy('university_name'),
            'new'   => $query->orderByDesc('created_at'),
            default => $query->orderBy('university_name'),
        };

        $universities = $query->paginate(12)->withQueryString();

        // Filter option lists (only active universities)
        $regions = array_keys(University::REGION_MAP);
        $cities  = University::active()->distinct()->orderBy('city')->pluck('city');
        $tiers   = ['985', '211', 'Double First Class', 'Provincial', 'Private'];

        return view('student.universities.index', compact(
            'universities', 'regions', 'cities', 'tiers', 'request'
        ));
    }

    public function show(University $university)
    {
        $university->load([
            'programs'     => fn ($q) => $q->active()->orderBy('degree_level')->orderBy('program_name'),
            'scholarships' => fn ($q) => $q->visible()->orderBy('application_deadline'),
        ]);

        return view('student.universities.show', compact('university'));
    }
}
