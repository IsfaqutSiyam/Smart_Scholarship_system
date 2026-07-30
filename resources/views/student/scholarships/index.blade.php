@extends('layouts.app')
@section('title', 'Scholarships')
@section('page-title', 'Scholarships')

@section('content')
<div class="space-y-4">

    <form method="GET" class="card p-4 space-y-3">
        <div class="flex gap-3">
            <div class="flex-1 relative">
                <svg class="absolute left-3 top-2.5 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" name="search" value="{{ $request->input('search') }}"
                       class="form-input pl-9" placeholder="Search scholarships, universities, regions…">
            </div>
            <button type="submit" class="btn-primary">Search</button>
            <a href="{{ route('student.scholarships.index') }}" class="btn-secondary">Reset</a>
        </div>

        <div class="flex flex-wrap gap-2 items-center">
            {{-- Region --}}
            <select name="region" class="form-input w-44 text-sm" onchange="this.form.submit()">
                <option value="">🗺 All Regions</option>
                @foreach($regions as $region)
                <option value="{{ $region }}" {{ $request->input('region') === $region ? 'selected' : '' }}>
                    {{ $region }}
                </option>
                @endforeach
            </select>

            {{-- Funding type --}}
            <select name="funding_type" class="form-input w-44 text-sm" onchange="this.form.submit()">
                <option value="">💰 All Types</option>
                <option value="full"         {{ $request->input('funding_type') === 'full'         ? 'selected' : '' }}>Full Scholarship</option>
                <option value="partial"      {{ $request->input('funding_type') === 'partial'      ? 'selected' : '' }}>Partial</option>
                <option value="tuition_only" {{ $request->input('funding_type') === 'tuition_only' ? 'selected' : '' }}>Tuition Only</option>
            </select>

            {{-- Upcoming --}}
            <label class="flex items-center gap-2 text-sm text-gray-600 cursor-pointer px-3 py-2 rounded-lg border border-gray-200 hover:border-blue-300 transition-colors">
                <input type="checkbox" name="upcoming_only" value="1"
                       {{ $request->boolean('upcoming_only') ? 'checked' : '' }}
                       class="rounded border-gray-300 text-blue-600" onchange="this.form.submit()">
                Open deadlines only
            </label>

            {{-- Eligible only (premium gate) --}}
            @auth
            @if(auth()->user()->isPremium())
            <label class="flex items-center gap-2 text-sm text-gray-600 cursor-pointer px-3 py-2 rounded-lg border border-yellow-300 bg-yellow-50 hover:border-yellow-400 transition-colors">
                <input type="checkbox" name="eligible_only" value="1"
                       {{ $request->boolean('eligible_only') ? 'checked' : '' }}
                       class="rounded border-gray-300 text-yellow-500" onchange="this.form.submit()">
                ⭐ Eligible for me
            </label>
            @else
            <a href="{{ route('student.subscription.index') }}"
               class="flex items-center gap-2 text-sm text-gray-400 cursor-pointer px-3 py-2 rounded-lg border border-gray-200 hover:border-yellow-300 hover:text-yellow-600 transition-colors">
                🔒 Eligible-for-me filter <span class="badge bg-yellow-100 text-yellow-700 ml-1">Premium</span>
            </a>
            @endif
            @endauth
        </div>
    </form>

    <p class="text-sm text-gray-500">
        <span class="font-semibold text-gray-800">{{ $scholarships->total() }}</span>
        {{ Str::plural('scholarship', $scholarships->total()) }} found
    </p>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
        @forelse($scholarships as $s)
        <a href="{{ route('student.scholarships.show', $s) }}"
           class="card p-5 hover:shadow-md hover:border-blue-200 transition-all block group">
            <div class="flex items-start justify-between mb-2">
                <span class="badge {{ $s->funding_badge_color }}">{{ $s->funding_label }}</span>
                @if($s->days_until_deadline <= 30 && $s->days_until_deadline >= 0)
                <span class="badge bg-red-100 text-red-700">{{ $s->days_until_deadline }}d left</span>
                @elseif($s->days_until_deadline < 0)
                <span class="badge bg-gray-100 text-gray-500">Closed</span>
                @endif
            </div>

            <h3 class="font-semibold text-gray-900 group-hover:text-blue-700 text-sm line-clamp-2 mb-1 transition-colors">
                {{ $s->scholarship_name }}
            </h3>
            <p class="text-xs text-gray-500 mb-1">{{ $s->university->university_name }}</p>
            <p class="text-xs text-gray-400 mb-3">
                📍 {{ $s->university->city }} ·
                <span class="badge {{ $s->university->region_badge_color }} text-xs">{{ $s->university->region }}</span>
            </p>

            @if($s->annual_amount_cny)
            <p class="text-sm font-bold text-green-600 mb-2">{{ $s->getAmountFormatted() }}</p>
            @endif

            <div class="flex items-center justify-between text-xs text-gray-400">
                <span>{{ $s->min_cgpa ? 'Min CGPA '.$s->min_cgpa : 'No CGPA minimum' }}</span>
                <span>{{ $s->application_deadline->format('d M Y') }}</span>
            </div>
        </a>
        @empty
        <div class="col-span-3 py-16 text-center text-gray-400">
            <p class="text-sm">No scholarships found matching your filters.</p>
            <a href="{{ route('student.scholarships.index') }}" class="text-blue-600 text-sm hover:underline mt-2 block">
                Clear filters
            </a>
        </div>
        @endforelse
    </div>

    {{ $scholarships->links() }}
</div>
@endsection
