<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisteredUserController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:100'],
            'email'     => ['required', 'string', 'email', 'max:150', 'unique:users,email'],
            'password'  => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'full_name'     => $validated['full_name'],
            'email'         => $validated['email'],
            'password_hash' => Hash::make($validated['password']),
            'role'          => 'student',
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('student.profile.edit'))
            ->with('success', 'Welcome to Scholarify! Please complete your academic profile to get recommendations.');
    }
}
