<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $primaryKey = 'user_id';

    protected $fillable = [
        'full_name', 'email', 'password_hash',
        'academic_background', 'preferred_field',
        'cgpa', 'language_proficiency', 'degree_seeking',
        'role', 'plan', 'plan_expires_at',
    ];

    protected $hidden = ['password_hash', 'remember_token'];

    protected $casts = [
        'cgpa'           => 'decimal:2',
        'plan_expires_at'=> 'datetime',
    ];

    public function getAuthPassword(): string { return $this->password_hash; }
    public function setPasswordAttribute(string $v): void { $this->attributes['password_hash'] = bcrypt($v); }

    public function isAdmin(): bool   { return $this->role === 'admin'; }
    public function isStudent(): bool { return $this->role === 'student'; }

    public function isPremium(): bool
    {
        if ($this->plan !== 'premium') return false;
        if ($this->plan_expires_at && $this->plan_expires_at->isPast()) return false;
        return true;
    }

    public function isFree(): bool { return ! $this->isPremium(); }

    public function hasCompleteProfile(): bool
    {
        return ! empty($this->cgpa)
            && ! empty($this->preferred_field)
            && ! empty($this->degree_seeking);
    }

    // Free tier limits
    public const FREE_REC_LIMIT = 5;

    public function recommendations()
    {
        return $this->hasMany(Recommendation::class, 'user_id', 'user_id');
    }

    public function applications()
    {
        return $this->hasMany(Application::class, 'user_id', 'user_id');
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, 'user_id', 'user_id');
    }

    public function latestSubscription()
    {
        return $this->hasOne(Subscription::class, 'user_id', 'user_id')
                    ->latestOfMany('subscription_id');
    }
}
