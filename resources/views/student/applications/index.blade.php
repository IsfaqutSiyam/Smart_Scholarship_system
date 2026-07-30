@extends('layouts.app')
@section('title', 'My Applications')
@section('page-title', 'My Applications')

@section('content')
<div class="space-y-5">
    @if($applications->isEmpty())
    <div class="card py-16 text-center text-gray-400">
        <p class="text-sm">You haven't saved any programs yet.</p>
        <a href="{{ route('student.universities.index') }}" class="btn-primary mt-4 inline-flex">Browse Universities</a>
    </div>
    @else
    <div class="card divide-y divide-gray-100">
        @foreach($applications as $app)
        <div class="px-6 py-4 flex items-start gap-4">
            <div class="flex-1 min-w-0">
                <p class="font-medium text-gray-900">{{ $app->program->program_name }}</p>
                <p class="text-sm text-gray-500">{{ $app->program->university->university_name }} · {{ $app->program->degree_label }}</p>
                @if($app->scholarship)
                <p class="text-xs text-green-600 mt-0.5">🎓 Linked scholarship: {{ $app->scholarship->scholarship_name }}</p>
                @endif
                <p class="text-xs text-gray-400 mt-0.5">Saved {{ $app->created_at->diffForHumans() }}</p>
            </div>
            <div class="flex items-center gap-3">
                <span class="badge {{ $app->status_badge_color }}">{{ $app->status_label }}</span>
                <a href="{{ route('student.applications.show', $app) }}" class="btn-secondary text-xs">View</a>
                <form method="POST" action="{{ route('student.applications.destroy', $app) }}">
                    @csrf @method('DELETE')
                    <button type="submit" class="text-xs text-red-500 hover:text-red-700"
                            onclick="return confirm('Remove this application?')">Remove</button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection
