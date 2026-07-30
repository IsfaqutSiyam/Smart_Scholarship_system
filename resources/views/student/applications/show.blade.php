@extends('layouts.app')
@section('title', 'Application Detail')
@section('page-title', 'Application Detail')

@section('content')
<div class="max-w-2xl space-y-5">
    <div class="card p-6">
        <h2 class="text-lg font-bold text-gray-900 mb-1">{{ $application->program->program_name }}</h2>
        <a href="{{ route('student.universities.show', $application->program->university) }}"
           class="text-sm text-blue-600 hover:underline">
            🏛 {{ $application->program->university->university_name }}
        </a>

        <dl class="mt-5 grid grid-cols-2 gap-4">
            <div class="p-3 bg-gray-50 rounded-lg">
                <dt class="text-xs text-gray-500">Degree Level</dt>
                <dd class="font-medium text-gray-900 mt-0.5">{{ $application->program->degree_label }}</dd>
            </div>
            <div class="p-3 bg-gray-50 rounded-lg">
                <dt class="text-xs text-gray-500">Status</dt>
                <dd class="mt-0.5">
                    <span class="badge {{ $application->status_badge_color }}">{{ $application->status_label }}</span>
                </dd>
            </div>
            <div class="p-3 bg-gray-50 rounded-lg">
                <dt class="text-xs text-gray-500">Field of Study</dt>
                <dd class="font-medium text-gray-900 mt-0.5">{{ $application->program->field_of_study }}</dd>
            </div>
            <div class="p-3 bg-gray-50 rounded-lg">
                <dt class="text-xs text-gray-500">Duration</dt>
                <dd class="font-medium text-gray-900 mt-0.5">{{ $application->program->duration }}</dd>
            </div>
            @if($application->program->tuition_fee)
            <div class="p-3 bg-gray-50 rounded-lg">
                <dt class="text-xs text-gray-500">Tuition Fee</dt>
                <dd class="font-medium text-gray-900 mt-0.5">{{ $application->program->tuition_fee }}</dd>
            </div>
            @endif
            @if($application->program->application_deadline)
            <div class="p-3 bg-gray-50 rounded-lg">
                <dt class="text-xs text-gray-500">Application Deadline</dt>
                <dd class="font-medium mt-0.5 {{ $application->program->deadline_status === 'closing_soon' ? 'text-orange-600' : 'text-gray-900' }}">
                    {{ $application->program->application_deadline->format('d M Y') }}
                </dd>
            </div>
            @endif
        </dl>

        @if($application->scholarship)
        <div class="mt-5 p-4 bg-green-50 border border-green-200 rounded-lg">
            <p class="text-sm font-semibold text-green-800">Linked Scholarship</p>
            <p class="text-sm text-green-700 mt-1">{{ $application->scholarship->scholarship_name }}</p>
            <p class="text-xs text-green-600">{{ $application->scholarship->funding_label }} · Deadline: {{ $application->scholarship->application_deadline->format('d M Y') }}</p>
        </div>
        @endif
    </div>

    @if($application->program->application_guidance)
    <div class="card p-6">
        <h3 class="font-semibold text-gray-800 mb-3">📋 Application Guidance</h3>
        <div class="text-sm text-gray-600 leading-relaxed whitespace-pre-line">{{ $application->program->application_guidance }}</div>
    </div>
    @endif

    <div class="flex gap-3">
        <a href="{{ route('student.applications.index') }}" class="btn-secondary">← Back</a>
        <form method="POST" action="{{ route('student.applications.destroy', $application) }}">
            @csrf @method('DELETE')
            <button type="submit" class="btn-danger"
                    onclick="return confirm('Remove this application?')">Remove</button>
        </form>
    </div>
</div>
@endsection
