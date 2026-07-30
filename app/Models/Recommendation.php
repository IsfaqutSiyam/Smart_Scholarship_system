<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recommendation extends Model
{
    use HasFactory;

    protected $primaryKey = 'recommendation_id';

    protected $fillable = [
        'user_id',
        'university_id',
        'program_id',
        'match_score',
        'score_breakdown',
    ];

    protected $casts = [
        'match_score'     => 'decimal:2',
        'score_breakdown' => 'array',
    ];

    // ── Relationships ─────────────────────────────────────────
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function university()
    {
        return $this->belongsTo(University::class, 'university_id', 'university_id');
    }

    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id', 'program_id');
    }

    // ── Accessors ─────────────────────────────────────────────
    public function getMatchPercentAttribute(): int
    {
        return (int) round($this->match_score);
    }

    public function getMatchLevelAttribute(): string
    {
        if ($this->match_score >= 80) {
            return 'Excellent Match';
        }
        if ($this->match_score >= 60) {
            return 'Good Match';
        }
        if ($this->match_score >= 40) {
            return 'Fair Match';
        }
        return 'Possible Match';
    }

    public function getMatchColorAttribute(): string
    {
        if ($this->match_score >= 80) {
            return 'text-green-600';
        }
        if ($this->match_score >= 60) {
            return 'text-blue-600';
        }
        if ($this->match_score >= 40) {
            return 'text-yellow-600';
        }
        return 'text-gray-500';
    }
}
