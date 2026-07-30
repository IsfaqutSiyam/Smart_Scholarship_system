@extends('layouts.app')
@section('title', $university->university_name)
@section('page-title', $university->university_name)

@section('content')
<div class="space-y-6">

    {{-- Header card --}}
    <div class="card p-6">
        <div class="flex items-start gap-4">
            <div class="w-14 h-14 rounded-xl bg-blue-50 flex items-center justify-center flex-shrink-0">
                <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
            <div class="flex-1">
                <div class="flex items-center gap-2 flex-wrap">
                    <h2 class="text-xl font-bold text-gray-900">{{ $university->university_name }}</h2>
                    <span class="badge {{ $university->ranking_badge_color }}">{{ $university->ranking_tier }}</span>
                    <span class="badge {{ $university->language_badge_color }}">{{ $university->language_of_instruction }}</span>
                </div>
                <p class="text-sm text-gray-500 mt-1">📍 {{ $university->city }}, {{ $university->province }}, China</p>
                @if($university->established_year)
                <p class="text-sm text-gray-500">Est. {{ $university->established_year }}</p>
                @endif
                @if($university->website_url)
                <a href="{{ $university->website_url }}" target="_blank" rel="noopener"
                   class="inline-flex items-center gap-1 text-xs text-blue-600 hover:underline mt-1">
                    🔗 Official Website
                </a>
                @endif
            </div>
        </div>
        @if($university->description)
        <p class="mt-4 text-sm text-gray-600 leading-relaxed">{{ $university->description }}</p>
        @endif
    </div>

    {{-- Programs --}}
    <div class="card">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <h3 class="font-semibold text-gray-800">Programs ({{ $university->programs->count() }})</h3>
        </div>
        @if($university->programs->isEmpty())
            <p class="px-6 py-8 text-center text-sm text-gray-400">No programs listed yet.</p>
        @else
        <div class="divide-y divide-gray-50">
            @foreach($university->programs->groupBy('degree_level') as $level => $programs)
            <div class="px-6 py-4">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-3">
                    {{ ['bachelor' => "Bachelor's", 'master' => "Master's", 'phd' => 'PhD'][$level] ?? ucfirst($level) }}
                </p>
                <div class="space-y-3">
                    @foreach($programs as $program)
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <div class="flex items-start justify-between gap-3">
                            <div class="flex-1">
                                <p class="font-medium text-gray-900 text-sm">{{ $program->program_name }}</p>
                                <p class="text-xs text-gray-500 mt-0.5">
                                    {{ $program->field_of_study }} · {{ $program->duration }}
                                    @if($program->tuition_fee) · {{ $program->tuition_fee }} @endif
                                </p>
                                @if($program->language_requirement)
                                <p class="text-xs text-gray-500">Language: {{ $program->language_requirement }}</p>
                                @endif
                                @if($program->min_cgpa)
                                <p class="text-xs text-gray-500">Min CGPA: {{ $program->min_cgpa }}</p>
                                @endif
                                @if($program->application_deadline)
                                <p class="text-xs {{ $program->deadline_status === 'closing_soon' ? 'text-red-600 font-medium' : 'text-gray-500' }} mt-1">
                                    Deadline: {{ $program->application_deadline->format('d M Y') }}
                                    @if($program->deadline_status === 'closed') <span class="badge bg-red-100 text-red-700 ml-1">Closed</span>
                                    @elseif($program->deadline_status === 'closing_soon') <span class="badge bg-orange-100 text-orange-700 ml-1">Closing Soon</span>
                                    @endif
                                </p>
                                @endif
                            </div>
                            <form method="POST" action="{{ route('student.applications.store') }}">
                                @csrf
                                <input type="hidden" name="program_id" value="{{ $program->program_id }}">
                                <button type="submit" class="btn-secondary text-xs whitespace-nowrap">+ Save</button>
                            </form>
                        </div>
                        @if($program->application_guidance)
                        <details class="mt-3">
                            <summary class="text-xs text-blue-600 cursor-pointer hover:underline">View Application Guidance</summary>
                            <div class="mt-2 text-xs text-gray-600 leading-relaxed whitespace-pre-line">{{ $program->application_guidance }}</div>
                        </details>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>

    {{-- Scholarships --}}
    @if($university->scholarships->isNotEmpty())
    <div class="card">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="font-semibold text-gray-800">Scholarships ({{ $university->scholarships->count() }})</h3>
        </div>
        <div class="divide-y divide-gray-50">
            @foreach($university->scholarships as $s)
            <div class="px-6 py-4">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <p class="font-medium text-gray-900 text-sm">{{ $s->scholarship_name }}</p>
                        <span class="badge {{ $s->funding_badge_color }} mt-1">{{ $s->funding_label }}</span>
                        @if($s->annual_amount_cny)
                        <span class="text-xs text-gray-500 ml-2">{{ $s->getAmountFormatted() }}</span>
                        @endif
                        <p class="text-xs text-gray-500 mt-1">Deadline: {{ $s->application_deadline->format('d M Y') }}</p>
                    </div>
                    <a href="{{ route('student.scholarships.show', $s) }}" class="btn-secondary text-xs">Details</a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <div class="flex">
        <a href="{{ route('student.universities.index') }}" class="btn-secondary">← Back to Universities</a>
    </div>
</div>
@endsection
