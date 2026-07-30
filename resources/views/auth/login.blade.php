<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Scholarify</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-blue-900 via-blue-800 to-indigo-900 flex items-center justify-center p-4">

<div class="w-full max-w-md">
    {{-- Logo --}}
    <div class="text-center mb-8">
        <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
            <svg class="w-8 h-8 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 14l9-5-9-5-9 5 9 5z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
            </svg>
        </div>
        <h1 class="text-2xl font-bold text-white">Scholarify</h1>
        <p class="text-blue-200 text-sm mt-1">Bangladesh → China Study Guide</p>
    </div>

    {{-- Card --}}
    <div class="bg-white rounded-2xl shadow-xl p-8">
        <h2 class="text-xl font-bold text-gray-900 mb-1">Welcome back</h2>
        <p class="text-sm text-gray-500 mb-6">Sign in to your account</p>

        @if(session('status'))
        <div class="mb-4 p-3 bg-green-50 border border-green-200 rounded-lg text-green-800 text-sm">
            {{ session('status') }}
        </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email address</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus
                       class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') border-red-400 @enderror"
                       placeholder="you@example.com">
                @error('email')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <div class="flex justify-between items-center mb-1">
                    <label class="text-sm font-medium text-gray-700">Password</label>
                    @if(Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-xs text-blue-600 hover:underline">Forgot?</a>
                    @endif
                </div>
                <input type="password" name="password" required
                       class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('password') border-red-400 @enderror"
                       placeholder="••••••••">
                @error('password')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="flex items-center gap-2">
                <input type="checkbox" id="remember" name="remember"
                       class="rounded border-gray-300 text-blue-600">
                <label for="remember" class="text-sm text-gray-600">Remember me</label>
            </div>

            <button type="submit"
                    class="w-full py-2.5 bg-blue-700 text-white text-sm font-semibold rounded-lg hover:bg-blue-800 transition-colors">
                Sign In
            </button>
        </form>

        <p class="text-center text-sm text-gray-500 mt-6">
            Don't have an account?
            <a href="{{ route('register') }}" class="text-blue-600 font-medium hover:underline">Create one</a>
        </p>
    </div>

    <p class="text-center text-blue-300 text-xs mt-6">
        IUBAT · CSC 470 Software Engineering · Group-7 Apotheosis
    </p>
</div>
</body>
</html>
