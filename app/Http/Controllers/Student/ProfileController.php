<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Services\RecommendationEngine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function __construct(private RecommendationEngine $engine) {}

    public function edit()
    {
        $user = Auth::user();
        return view('student.profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'full_name'            => ['required', 'string', 'max:100'],
            'academic_background'  => ['required', 'string', 'max:150'],
            'preferred_field'      => ['required', 'string', 'max:100'],
            'cgpa'                 => ['required', 'numeric', 'min:0', 'max:4'],
            'language_proficiency' => ['required', 'string', 'max:100'],
            'degree_seeking'       => ['required', Rule::in(['bachelor', 'master', 'phd'])],
        ]);

        $user->update($validated);

        // Re-generate recommendations whenever profile changes
        $this->engine->generate($user);

        return redirect()->route('student.profile.edit')
            ->with('success', 'Profile updated! Recommendations have been refreshed.');
    }
}
