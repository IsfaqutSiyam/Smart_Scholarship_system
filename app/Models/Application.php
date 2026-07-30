<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $primaryKey = 'application_id';

    protected $fillable = [
        'user_id',
        'program_id',
        'scholarship_id',
        'status',
        'notes',
        'submitted_date',
    ];

    protected $casts = [
        'submitted_date' => 'date',
    ];

    // ── Relationships ─────────────────────────────────────────
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id', 'program_id');
    }

    public function scholarship()
    {
        return $this->belongsTo(Scholarship::class, 'scholarship_id', 'scholarship_id');
    }

    // ── Accessors ─────────────────────────────────────────────
    public function getStatusBadgeColorAttribute(): string
    {
        return match ($this->status) {
            'draft'        => 'bg-gray-100 text-gray-600',
            'submitted'    => 'bg-blue-100 text-blue-700',
            'under_review' => 'bg-yellow-100 text-yellow-700',
            'accepted'     => 'bg-green-100 text-green-700',
            'rejected'     => 'bg-red-100 text-red-700',
            default        => 'bg-gray-100 text-gray-600',
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'draft'        => 'Draft',
            'submitted'    => 'Submitted',
            'under_review' => 'Under Review',
            'accepted'     => 'Accepted',
            'rejected'     => 'Rejected',
            default        => ucfirst($this->status),
        };
    }
}
