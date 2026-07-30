<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Scholarship;
use App\Models\University;
use App\Models\User;
use App\Models\Program;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'universities' => University::count(),
            'programs'     => Program::count(),
            'scholarships' => Scholarship::count(),
            'students'     => User::where('role', 'student')->count(),
            'applications' => Application::count(),
        ];

        $recentUniversities = University::latest()->take(5)->get();
        $upcomingDeadlines  = Scholarship::with('university')
            ->deadlineUpcoming()
            ->take(6)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentUniversities', 'upcomingDeadlines'));
    }
}
