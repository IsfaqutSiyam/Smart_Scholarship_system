<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $primaryKey = 'subscription_id';

    protected $fillable = [
        'user_id', 'plan', 'duration_months', 'amount_bdt',
        'payment_method', 'transaction_id', 'status',
        'starts_at', 'expires_at', 'payment_response',
    ];

    protected $casts = [
        'starts_at'        => 'datetime',
        'expires_at'       => 'datetime',
        'payment_response' => 'array',
        'amount_bdt'       => 'decimal:2',
    ];

    // ── Plans & Pricing ───────────────────────────────────────
    public const PLANS = [
        'premium' => [
            'name'  => 'Premium',
            'color' => 'yellow',
            'features' => [
                'Unlimited personalized recommendations',
                'Region & city-based filtering',
                'Eligible-only scholarship filter',
                'Full application guidance access',
                'Email deadline reminders',
                'Priority support',
            ],
        ],
    ];

    public const PRICING = [
        1  => ['bdt' => 299,  'label' => '1 Month',  'save' => null],
        3  => ['bdt' => 799,  'label' => '3 Months', 'save' => '11%'],
        6  => ['bdt' => 1499, 'label' => '6 Months', 'save' => '16%'],
        12 => ['bdt' => 2499, 'label' => '1 Year',   'save' => '30%'],
    ];

    // ── Relationships ─────────────────────────────────────────
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    // ── Accessors ─────────────────────────────────────────────
    public function getStatusBadgeColorAttribute(): string
    {
        return match ($this->status) {
            'completed'  => 'bg-green-100 text-green-700',
            'pending'    => 'bg-yellow-100 text-yellow-700',
            'failed'     => 'bg-red-100 text-red-700',
            'cancelled'  => 'bg-gray-100 text-gray-500',
            default      => 'bg-gray-100 text-gray-500',
        };
    }
}
