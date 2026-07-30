@extends('layouts.app')
@section('title', $scholarship->scholarship_name)
@section('page-title', $scholarship->scholarship_name)

@section('content')
<div class="max-w-3xl space-y-5">

    <div class="card p-6">
        <div class="flex flex-wrap gap-2 mb-4">
            <span class="badge {{ $scholarship->funding_badge_color }} text-sm px-3 py-1">{{ $scholarship->funding_label }}</span>
            @if($scholarship->days_until_deadline >= 0)
                @if($scholarship->days_until_deadline <= 30)
                <span class="badge bg-red-100 text-red-700 text-sm px-3 py-1">⚠ Closes in {{ $scholarship->days_until_deadline }} days</span>
                @else
                <span class="badge bg-green-100 text-green-700 text-sm px-3 py-1">Open</span>
                @endif
            @else
            <span class="badge bg-gray-100 text-gray-600 text-sm px-3 py-1">Deadline Passed</span>
            @endif
        </div>

        <h2 class="text-xl font-bold text-gray-900">{{ $scholarship->scholarship_name }}</h2>
        <a href="{{ route('student.universities.show', $scholarship->university) }}"
           class="text-sm text-blue-600 hover:underline">
            🏛 {{ $scholarship->university->university_name }}
        </a>

        <dl class="mt-5 grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="p-4 bg-gray-50 rounded-lg">
                <dt class="text-xs text-gray-500">Annual Award</dt>
                <dd class="text-lg font-bold text-green-600 mt-1">{{ $scholarship->getAmountFormatted() }}</dd>
            </div>
            <div class="p-4 bg-gray-50 rounded-lg">
                <dt class="text-xs text-gray-500">Application Deadline</dt>
                <dd class="text-base font-semibold text-gray-900 mt-1">{{ $scholarship->application_deadline->format('d F Y') }}</dd>
            </div>
            @if($scholarship->min_cgpa)
            <div class="p-4 bg-gray-50 rounded-lg">
                <dt class="text-xs text-gray-500">Minimum CGPA</dt>
                <dd class="text-base font-semibold text-gray-900 mt-1">{{ $scholarship->min_cgpa }} / 4.00</dd>
            </div>
            @endif
            @if($scholarship->eligible_degree_levels)
            <div class="p-4 bg-gray-50 rounded-lg">
                <dt class="text-xs text-gray-500">Eligible Degrees</dt>
                <dd class="text-base font-semibold text-gray-900 mt-1">
                    {{ implode(', ', array_map('ucfirst', $scholarship->eligible_degree_levels_array)) }}
                </dd>
            </div>
            @endif
        </dl>
    </div>

    @if($scholarship->coverage_details)
    <div class="card p-6">
        <h3 class="font-semibold text-gray-800 mb-3">What's Covered</h3>
        <p class="text-sm text-gray-600 leading-relaxed whitespace-pre-line">{{ $scholarship->coverage_details }}</p>
    </div>
    @endif

    <div class="card p-6">
        <h3 class="font-semibold text-gray-800 mb-3">Eligibility Criteria</h3>
        <p class="text-sm text-gray-600 leading-relaxed whitespace-pre-line">{{ $scholarship->eligibility_criteria }}</p>
    </div>

    <div class="flex gap-3">
        <a href="{{ route('student.scholarships.index') }}" class="btn-secondary">← Back</a>
        <a href="{{ route('student.universities.show', $scholarship->university) }}" class="btn-primary">
            View University Programs
        </a>
    </div>
</div>
@endsection
