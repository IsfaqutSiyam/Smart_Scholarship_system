<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Program;
use App\Models\Scholarship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{
    public function index()
    {
        $applications = Application::with(['program.university', 'scholarship'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('student.applications.index', compact('applications'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'program_id'    => ['required', 'exists:programs,program_id'],
            'scholarship_id'=> ['nullable', 'exists:scholarships,scholarship_id'],
        ]);

        $user = Auth::user();

        // Prevent duplicates
        if (Application::where('user_id', $user->user_id)
                       ->where('program_id', $validated['program_id'])->exists()) {
            return back()->with('error', 'You have already saved this program in your applications.');
        }

        Application::create([
            'user_id'       => $user->user_id,
            'program_id'    => $validated['program_id'],
            'scholarship_id'=> $validated['scholarship_id'] ?? null,
            'status'        => 'draft',
        ]);

        return back()->with('success', 'Program saved to your applications list.');
    }

    public function destroy(Application $application)
    {
        abort_if($application->user_id !== Auth::id(), 403);
        $application->delete();
        return back()->with('success', 'Application removed.');
    }

    public function show(Application $application)
    {
        abort_if($application->user_id !== Auth::id(), 403);
        $application->load(['program.university', 'scholarship']);
        return view('student.applications.show', compact('application'));
    }
}
