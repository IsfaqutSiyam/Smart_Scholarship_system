<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scholarify — Study in China from Bangladesh</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="antialiased text-gray-900">

{{-- ── Nav ───────────────────────────────────────────────── --}}
<nav class="bg-white border-b border-gray-100 sticky top-0 z-50">
    <div class="max-w-6xl mx-auto px-6 h-16 flex items-center justify-between">
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 bg-blue-700 rounded-lg flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 14l9-5-9-5-9 5 9 5zM12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                </svg>
            </div>
            <span class="font-bold text-gray-900 text-lg">Scholarify</span>
        </div>
        <div class="flex items-center gap-3">
            @auth
                <a href="{{ url('/dashboard') }}"
                   class="inline-flex items-center px-4 py-2 bg-blue-700 text-white text-sm font-medium rounded-lg hover:bg-blue-800 transition-colors">
                    Go to Dashboard →
                </a>
            @else
                <a href="{{ route('login') }}"
                   class="text-sm font-medium text-gray-600 hover:text-gray-900">Sign In</a>
                <a href="{{ route('register') }}"
                   class="inline-flex items-center px-4 py-2 bg-blue-700 text-white text-sm font-medium rounded-lg hover:bg-blue-800 transition-colors">
                    Get Started Free
                </a>
            @endauth
        </div>
    </div>
</nav>

{{-- ── Hero ─────────────────────────────────────────────── --}}
<section class="bg-gradient-to-br from-blue-900 via-blue-800 to-indigo-900 text-white py-24 px-6">
    <div class="max-w-4xl mx-auto text-center">
        <span class="inline-flex items-center gap-2 px-3 py-1 bg-blue-700 bg-opacity-60 rounded-full text-xs font-medium text-blue-100 mb-6">
            🇧🇩 → 🇨🇳 For Bangladeshi Students Applying to China
        </span>
        <h1 class="text-4xl md:text-5xl font-extrabold leading-tight mb-6">
            Find Your Perfect<br>
            <span class="text-yellow-400">University & Scholarship</span><br>
            in China
        </h1>
        <p class="text-lg text-blue-200 max-w-2xl mx-auto mb-8">
            Scholarify aggregates hundreds of Chinese university programs and scholarships,
            then uses a transparent rule-based engine to match you with the best options
            based on your CGPA, field of study, and language skills.
        </p>
        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <a href="{{ route('register') }}"
               class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-yellow-400 text-gray-900 font-semibold rounded-xl hover:bg-yellow-300 transition-colors text-base">
                Get Free Recommendations →
            </a>
            <a href="{{ route('login') }}"
               class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-white bg-opacity-10 text-white font-medium rounded-xl hover:bg-opacity-20 transition-colors text-base">
                Sign In
            </a>
        </div>
    </div>
</section>

{{-- ── Stats ────────────────────────────────────────────── --}}
<section class="bg-white border-b border-gray-100 py-10">
    <div class="max-w-4xl mx-auto px-6 grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
        @foreach([
            ['value' => '50+',   'label' => 'Chinese Universities'],
            ['value' => '200+',  'label' => 'Degree Programs'],
            ['value' => '80+',   'label' => 'Scholarships Listed'],
            ['value' => '100%',  'label' => 'Free to Use'],
        ] as $s)
        <div>
            <p class="text-3xl font-extrabold text-blue-700">{{ $s['value'] }}</p>
            <p class="text-sm text-gray-500 mt-1">{{ $s['label'] }}</p>
        </div>
        @endforeach
    </div>
</section>

{{-- ── Features ─────────────────────────────────────────── --}}
<section class="py-20 px-6 bg-gray-50">
    <div class="max-w-5xl mx-auto">
        <div class="text-center mb-14">
            <h2 class="text-3xl font-bold text-gray-900">Everything you need in one place</h2>
            <p class="text-gray-500 mt-3 text-base max-w-xl mx-auto">
                No more tab-switching across dozens of university websites. Scholarify brings it all together.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach([
                [
                    'icon'  => '🏛',
                    'title' => 'University Search',
                    'desc'  => 'Filter Chinese universities by city, province, ranking tier (985, 211, Double First Class), and language of instruction.',
                ],
                [
                    'icon'  => '💰',
                    'title' => 'Scholarship Finder',
                    'desc'  => 'Browse full, partial, and tuition-only scholarships. Filter by funding type, deadline, and your own eligibility.',
                ],
                [
                    'icon'  => '⭐',
                    'title' => 'Rule-Based Recommendations',
                    'desc'  => 'Our transparent scoring engine (no black-box ML) ranks programs by how well they match your CGPA, field, and language level.',
                ],
                [
                    'icon'  => '📋',
                    'title' => 'Application Guidance',
                    'desc'  => 'Each program lists required documents, steps, and deadlines — everything in one structured view.',
                ],
                [
                    'icon'  => '🔔',
                    'title' => 'Deadline Tracking',
                    'desc'  => 'See upcoming scholarship deadlines at a glance so you never miss an application window.',
                ],
                [
                    'icon'  => '🔍',
                    'title' => 'Explainable Scores',
                    'desc'  => 'Every recommendation shows a score breakdown: field match, CGPA, language, and university tier — so you understand why.',
                ],
            ] as $f)
            <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm hover:shadow-md transition-shadow">
                <p class="text-3xl mb-3">{{ $f['icon'] }}</p>
                <h3 class="font-semibold text-gray-900 mb-2">{{ $f['title'] }}</h3>
                <p class="text-sm text-gray-500 leading-relaxed">{{ $f['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ── How it works ─────────────────────────────────────── --}}
<section class="py-20 px-6 bg-white">
    <div class="max-w-3xl mx-auto text-center">
        <h2 class="text-3xl font-bold text-gray-900 mb-12">Get matched in 3 steps</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach([
                ['step'=>'1','title'=>'Create your profile','desc'=>'Enter your CGPA, preferred field of study, degree level, and language proficiency.'],
                ['step'=>'2','title'=>'Get recommendations','desc'=>'Our engine scores every available program against your profile and ranks them 0–100.'],
                ['step'=>'3','title'=>'Apply with confidence','desc'=>'View application guidance for each program and save the ones that match you best.'],
            ] as $step)
            <div class="flex flex-col items-center">
                <div class="w-12 h-12 rounded-full bg-blue-700 text-white font-bold text-lg flex items-center justify-center mb-4">
                    {{ $step['step'] }}
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">{{ $step['title'] }}</h3>
                <p class="text-sm text-gray-500">{{ $step['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ── CTA ──────────────────────────────────────────────── --}}
<section class="py-20 px-6 bg-gradient-to-r from-blue-700 to-indigo-700 text-white text-center">
    <h2 class="text-3xl font-bold mb-4">Start your journey today</h2>
    <p class="text-blue-100 mb-8 text-base max-w-md mx-auto">
        Join students who found their Chinese university through Scholarify. It's free, fast, and fully transparent.
    </p>
    <a href="{{ route('register') }}"
       class="inline-flex items-center gap-2 px-8 py-3.5 bg-yellow-400 text-gray-900 font-bold rounded-xl hover:bg-yellow-300 transition-colors text-base">
        Create Free Account →
    </a>
</section>

{{-- ── Footer ───────────────────────────────────────────── --}}
<footer class="bg-gray-900 text-gray-400 py-10 px-6 text-center text-sm">
    <p class="font-semibold text-white mb-1">Scholarify</p>
    <p>CSC 470 — Software Engineering · Group-7 Apotheosis · IUBAT · Summer 2026</p>
    <p class="mt-2">Built with Laravel 11 · MySQL · Tailwind CSS</p>
</footer>

</body>
</html>
