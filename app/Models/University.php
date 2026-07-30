<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class University extends Model
{
    use HasFactory;

    protected $primaryKey = 'university_id';

    protected $fillable = [
        'university_name', 'city', 'province', 'region',
        'ranking_tier', 'language_of_instruction',
        'description', 'website_url', 'logo_url',
        'established_year', 'is_active',
    ];

    protected $casts = ['is_active' => 'boolean'];

    // China's 7 macro-regions → provinces mapping
    public const REGION_MAP = [
        'North China'     => ['Beijing', 'Tianjin', 'Hebei', 'Shanxi', 'Inner Mongolia'],
        'Northeast China' => ['Liaoning', 'Jilin', 'Heilongjiang'],
        'East China'      => ['Shanghai', 'Jiangsu', 'Zhejiang', 'Anhui', 'Fujian', 'Jiangxi', 'Shandong'],
        'Central China'   => ['Henan', 'Hubei', 'Hunan'],
        'South China'     => ['Guangdong', 'Guangxi', 'Hainan'],
        'Southwest China' => ['Chongqing', 'Sichuan', 'Guizhou', 'Yunnan', 'Tibet'],
        'Northwest China' => ['Shaanxi', 'Gansu', 'Qinghai', 'Ningxia', 'Xinjiang'],
    ];

    public static function regionForProvince(string $province): string
    {
        foreach (self::REGION_MAP as $region => $provinces) {
            if (in_array($province, $provinces)) return $region;
        }
        return 'East China';
    }

    // ── Relationships ─────────────────────────────────────────
    public function programs()      { return $this->hasMany(Program::class,        'university_id', 'university_id'); }
    public function scholarships()  { return $this->hasMany(Scholarship::class,    'university_id', 'university_id'); }
    public function recommendations(){ return $this->hasMany(Recommendation::class,'university_id', 'university_id'); }

    // ── Scopes ────────────────────────────────────────────────
    public function scopeActive($q)                { return $q->where('is_active', true); }
    public function scopeByCity($q, string $city)  { return $q->where('city', $city); }
    public function scopeByRegion($q, string $r)   { return $q->where('region', $r); }
    public function scopeByLanguage($q, string $l) { return $q->where('language_of_instruction', $l); }
    public function scopeByTier($q, string $t)     { return $q->where('ranking_tier', $t); }

    /**
     * Optimised search: splits query into tokens and ANDs them across
     * name / city / province / region using indexed LIKE lookups.
     */
    public function scopeSearch($query, string $term)
    {
        $tokens = array_filter(explode(' ', trim($term)));
        foreach ($tokens as $token) {
            $t = '%' . $token . '%';
            $query->where(function ($q) use ($t) {
                $q->where('university_name', 'like', $t)
                  ->orWhere('city',          'like', $t)
                  ->orWhere('province',      'like', $t)
                  ->orWhere('region',        'like', $t)
                  ->orWhere('description',   'like', $t);
            });
        }
        return $query;
    }

    // ── Accessors ─────────────────────────────────────────────
    public function getRankingBadgeColorAttribute(): string
    {
        return match ($this->ranking_tier) {
            '985'                => 'bg-red-100 text-red-700',
            '211'                => 'bg-orange-100 text-orange-700',
            'Double First Class' => 'bg-purple-100 text-purple-700',
            default              => 'bg-gray-100 text-gray-600',
        };
    }

    public function getLanguageBadgeColorAttribute(): string
    {
        return match ($this->language_of_instruction) {
            'English'  => 'bg-blue-100 text-blue-700',
            'Mandarin' => 'bg-yellow-100 text-yellow-700',
            'Bilingual'=> 'bg-green-100 text-green-700',
            default    => 'bg-gray-100 text-gray-600',
        };
    }

    public function getRegionBadgeColorAttribute(): string
    {
        return match ($this->region) {
            'North China'     => 'bg-slate-100 text-slate-700',
            'Northeast China' => 'bg-cyan-100 text-cyan-700',
            'East China'      => 'bg-blue-100 text-blue-700',
            'Central China'   => 'bg-indigo-100 text-indigo-700',
            'South China'     => 'bg-emerald-100 text-emerald-700',
            'Southwest China' => 'bg-teal-100 text-teal-700',
            'Northwest China' => 'bg-amber-100 text-amber-700',
            default           => 'bg-gray-100 text-gray-600',
        };
    }
}
