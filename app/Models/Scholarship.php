<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scholarship extends Model
{
    use HasFactory;

    protected $primaryKey = 'scholarship_id';

    protected $fillable = [
        'university_id',
        'scholarship_name',
        'funding_type',
        'coverage_details',
        'application_deadline',
        'eligibility_criteria',
        'min_cgpa',
        'eligible_degree_levels',
        'eligible_fields',
        'annual_amount_cny',
        'is_active',
        'is_visible',
    ];

    protected $casts = [
        'application_deadline' => 'date',
        'min_cgpa'             => 'decimal:2',
        'annual_amount_cny'    => 'integer',
        'is_active'            => 'boolean',
        'is_visible'           => 'boolean',
    ];

    // ── Relationships ─────────────────────────────────────────
    public function university()
    {
        return $this->belongsTo(University::class, 'university_id', 'university_id');
    }

    public function applications()
    {
        return $this->hasMany(Application::class, 'scholarship_id', 'scholarship_id');
    }

    // ── Scopes ────────────────────────────────────────────────
    public function scopeVisible($query)
    {
        return $query->where('is_visible', true)->where('is_active', true);
    }

    public function scopeByFundingType($query, string $type)
    {
        return $query->where('funding_type', $type);
    }

    public function scopeDeadlineUpcoming($query)
    {
        return $query->where('application_deadline', '>=', now())
                     ->orderBy('application_deadline');
    }

    public function scopeEligibleFor($query, User $user)
    {
        $query->where(function ($q) use ($user) {
            $q->whereNull('min_cgpa')->orWhere('min_cgpa', '<=', $user->cgpa ?? 0);
        });

        if ($user->degree_seeking) {
            $query->where(function ($q) use ($user) {
                $q->whereNull('eligible_degree_levels')
                  ->orWhere('eligible_degree_levels', 'like', "%{$user->degree_seeking}%");
            });
        }

        if ($user->preferred_field) {
            $query->where(function ($q) use ($user) {
                $q->whereNull('eligible_fields')
                  ->orWhere('eligible_fields', 'like', "%{$user->preferred_field}%");
            });
        }

        return $query;
    }

    // ── Accessors ─────────────────────────────────────────────
    public function getFundingLabelAttribute(): string
    {
        return match ($this->funding_type) {
            'full'        => 'Full Scholarship',
            'partial'     => 'Partial Scholarship',
            'tuition_only'=> 'Tuition Only',
            default       => ucfirst($this->funding_type),
        };
    }

    public function getFundingBadgeColorAttribute(): string
    {
        return match ($this->funding_type) {
            'full'        => 'bg-green-100 text-green-700',
            'partial'     => 'bg-blue-100 text-blue-700',
            'tuition_only'=> 'bg-yellow-100 text-yellow-700',
            default       => 'bg-gray-100 text-gray-600',
        };
    }

    public function getAmountFormatted(): string
    {
        if (! $this->annual_amount_cny) {
            return 'Amount varies';
        }
        return '¥' . number_format($this->annual_amount_cny) . '/year';
    }

    public function getDaysUntilDeadlineAttribute(): int
    {
        return (int) now()->diffInDays($this->application_deadline, false);
    }

    public function getEligibleDegreeLevelsArrayAttribute(): array
    {
        if (! $this->eligible_degree_levels) {
            return ['bachelor', 'master', 'phd'];
        }
        return array_map('trim', explode(',', $this->eligible_degree_levels));
    }
}
