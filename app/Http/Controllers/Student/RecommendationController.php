<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Recommendation;
use App\Models\User;
use App\Services\RecommendationEngine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecommendationController extends Controller
{
    public function __construct(private RecommendationEngine $engine) {}

    public function index()
    {
        $user  = Auth::user();

        if (! $user->hasCompleteProfile()) {
            return redirect()->route('student.profile.edit')
                ->with('warning', 'Please complete your academic profile to get personalized recommendations.');
        }

        // Enforce free-tier cap
        $limit = $user->isPremium() ? 50 : User::FREE_REC_LIMIT;

        $recommendations = Recommendation::with(['university', 'program'])
            ->where('user_id', $user->user_id)
            ->orderByDesc('match_score')
            ->get();

        if ($recommendations->isEmpty()) {
            $this->engine->generate($user, $limit);
            $recommendations = Recommendation::with(['university', 'program'])
                ->where('user_id', $user->user_id)
                ->orderByDesc('match_score')
                ->get();
        }

        // Cap for free users on display
        $locked      = 0;
        $isPremium   = $user->isPremium();
        if (! $isPremium && $recommendations->count() > User::FREE_REC_LIMIT) {
            $locked          = $recommendations->count() - User::FREE_REC_LIMIT;
            $recommendations = $recommendations->take(User::FREE_REC_LIMIT);
        }

        return view('student.recommendations.index',
            compact('recommendations', 'user', 'isPremium', 'locked'));
    }

    public function refresh()
    {
        $user  = Auth::user();

        if (! $user->hasCompleteProfile()) {
            return redirect()->route('student.profile.edit')
                ->with('warning', 'Complete your profile first.');
        }

        $limit = $user->isPremium() ? 50 : User::FREE_REC_LIMIT;
        $this->engine->generate($user, $limit);

        return redirect()->route('student.recommendations.index')
            ->with('success', 'Recommendations refreshed based on your latest profile.');
    }
}
