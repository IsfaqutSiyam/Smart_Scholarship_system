<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected $primaryKey = 'program_id';

    protected $fillable = [
        'university_id',
        'program_name',
        'degree_level',
        'field_of_study',
        'duration',
        'tuition_fee',
        'language_requirement',
        'min_cgpa',
        'application_guidance',
        'application_deadline',
        'is_active',
    ];

    protected $casts = [
        'min_cgpa'             => 'decimal:2',
        'application_deadline' => 'date',
        'is_active'            => 'boolean',
    ];

    // ── Relationships ─────────────────────────────────────────
    public function university()
    {
        return $this->belongsTo(University::class, 'university_id', 'university_id');
    }

    public function applications()
    {
        return $this->hasMany(Application::class, 'program_id', 'program_id');
    }

    public function recommendations()
    {
        return $this->hasMany(Recommendation::class, 'program_id', 'program_id');
    }

    // ── Scopes ────────────────────────────────────────────────
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByField($query, string $field)
    {
        return $query->where('field_of_study', 'like', "%{$field}%");
    }

    public function scopeByDegree($query, string $level)
    {
        return $query->where('degree_level', $level);
    }

    public function scopeDeadlineUpcoming($query)
    {
        return $query->where('application_deadline', '>=', now())
                     ->orderBy('application_deadline');
    }

    // ── Accessors ─────────────────────────────────────────────
    public function getDegreeLabelAttribute(): string
    {
        return match ($this->degree_level) {
            'bachelor' => "Bachelor's",
            'master'   => "Master's",
            'phd'      => 'PhD',
            default    => ucfirst($this->degree_level),
        };
    }

    public function getDeadlineStatusAttribute(): string
    {
        if (! $this->application_deadline) {
            return 'unknown';
        }
        $diff = now()->diffInDays($this->application_deadline, false);
        if ($diff < 0) {
            return 'closed';
        }
        if ($diff <= 30) {
            return 'closing_soon';
        }
        return 'open';
    }
}
