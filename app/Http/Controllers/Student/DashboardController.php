<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Recommendation;
use App\Models\Scholarship;
use App\Models\University;
use App\Services\RecommendationEngine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct(private RecommendationEngine $engine) {}

    public function index()
    {
        $user = Auth::user();

        if ($user->hasCompleteProfile()) {
            $this->engine->generate($user, 5);
        }

        // Top recommendations
        $recommendations = Recommendation::with(['university', 'program'])
            ->where('user_id', $user->user_id)
            ->orderByDesc('match_score')
            ->take(5)
            ->get();

        // Upcoming scholarship deadlines
        $upcomingScholarships = Scholarship::with('university')
            ->visible()
            ->deadlineUpcoming()
            ->take(4)
            ->get();

        // Stats
        $stats = [
            'universities'    => University::active()->count(),
            'scholarships'    => Scholarship::visible()->count(),
            'my_applications' => $user->applications()->count(),
            'recommendations' => Recommendation::where('user_id', $user->user_id)->count(),
        ];

        $profileComplete = $user->hasCompleteProfile();

        return view('student.dashboard', compact(
            'user', 'recommendations', 'upcomingScholarships', 'stats', 'profileComplete'
        ));
    }
}
