@extends('layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Student Dashboard')

@section('content')
<div class="space-y-6">

    {{-- Profile completion alert --}}
    @unless($profileComplete)
    <div class="flex items-start gap-4 p-4 bg-blue-50 border border-blue-200 rounded-xl">
        <svg class="w-5 h-5 text-blue-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <div class="flex-1">
            <p class="text-sm font-medium text-blue-900">Complete your academic profile to get personalized recommendations</p>
            <p class="text-xs text-blue-700 mt-0.5">Add your CGPA, preferred field, and degree level so we can match you with the best universities and scholarships.</p>
        </div>
        <a href="{{ route('student.profile.edit') }}" class="btn-primary text-xs">Complete Profile</a>
    </div>
    @endunless

    {{-- Stats --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        @foreach([
            ['label' => 'Universities', 'value' => $stats['universities'], 'color' => 'bg-blue-50 text-blue-700', 'route' => 'student.universities.index'],
            ['label' => 'Scholarships', 'value' => $stats['scholarships'], 'color' => 'bg-green-50 text-green-700', 'route' => 'student.scholarships.index'],
            ['label' => 'My Applications', 'value' => $stats['my_applications'], 'color' => 'bg-orange-50 text-orange-700', 'route' => 'student.applications.index'],
            ['label' => 'Recommendations', 'value' => $stats['recommendations'], 'color' => 'bg-purple-50 text-purple-700', 'route' => 'student.recommendations.index'],
        ] as $stat)
        <a href="{{ route($stat['route']) }}" class="card p-5 hover:shadow-md transition-shadow">
            <p class="text-2xl font-bold text-gray-900">{{ $stat['value'] }}</p>
            <p class="text-sm text-gray-500 mt-1">{{ $stat['label'] }}</p>
        </a>
        @endforeach
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Top Recommendations --}}
        <div class="lg:col-span-2 card">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                <h2 class="font-semibold text-gray-800">Top Recommendations</h2>
                <div class="flex gap-2">
                    @if($profileComplete)
                    <form method="POST" action="{{ route('student.recommendations.refresh') }}">
                        @csrf
                        <button class="btn-secondary text-xs">↻ Refresh</button>
                    </form>
                    @endif
                    <a href="{{ route('student.recommendations.index') }}" class="text-xs text-blue-600 hover:underline self-center">View all →</a>
                </div>
            </div>

            @if($recommendations->isEmpty())
            <div class="px-6 py-12 text-center text-gray-400">
                <svg class="w-10 h-10 mx-auto mb-3 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                </svg>
                <p class="text-sm">{{ $profileComplete ? 'No recommendations yet.' : 'Complete your profile to see recommendations.' }}</p>
            </div>
            @else
            <div class="divide-y divide-gray-50">
                @foreach($recommendations as $rec)
                <div class="px-6 py-4 flex items-center gap-4 hover:bg-gray-50 transition-colors">
                    <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-bold text-sm flex-shrink-0">
                        {{ $rec->match_percent }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">{{ $rec->program->program_name }}</p>
                        <p class="text-xs text-gray-500 truncate">{{ $rec->university->university_name }} · {{ $rec->university->city }}</p>
                    </div>
                    <span class="badge {{ $rec->match_score >= 80 ? 'bg-green-100 text-green-700' : ($rec->match_score >= 60 ? 'bg-blue-100 text-blue-700' : 'bg-yellow-100 text-yellow-700') }}">
                        {{ $rec->match_level }}
                    </span>
                </div>
                @endforeach
            </div>
            @endif
        </div>

        {{-- Upcoming Deadlines --}}
        <div class="card">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                <h2 class="font-semibold text-gray-800">Upcoming Deadlines</h2>
            </div>
            @forelse($upcomingScholarships as $scholarship)
            <div class="px-6 py-3 border-b border-gray-50 last:border-0">
                <a href="{{ route('student.scholarships.show', $scholarship) }}" class="block hover:text-blue-600">
                    <p class="text-sm font-medium text-gray-900 line-clamp-1">{{ $scholarship->scholarship_name }}</p>
                    <p class="text-xs text-gray-500">{{ $scholarship->university->university_name }}</p>
                    <div class="flex items-center justify-between mt-1">
                        <span class="badge {{ $scholarship->funding_badge_color }}">{{ $scholarship->funding_label }}</span>
                        <span class="text-xs {{ $scholarship->days_until_deadline <= 30 ? 'text-red-600 font-semibold' : 'text-gray-400' }}">
                            {{ $scholarship->days_until_deadline <= 0 ? 'Closed' : $scholarship->application_deadline->format('d M Y') }}
                        </span>
                    </div>
                </a>
            </div>
            @empty
            <p class="px-6 py-8 text-center text-sm text-gray-400">No upcoming deadlines.</p>
            @endforelse
            <div class="px-6 py-3 border-t border-gray-100">
                <a href="{{ route('student.scholarships.index') }}?upcoming_only=1"
                   class="text-xs text-blue-600 hover:underline">View all scholarships →</a>
            </div>
        </div>
    </div>
</div>
@endsection
