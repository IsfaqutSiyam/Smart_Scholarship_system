@extends('layouts.app')
@section('title', 'Universities')
@section('page-title', 'Chinese Universities')

@section('content')
<div class="space-y-4">

    {{-- Search & Filters --}}
    <form method="GET" class="card p-4 space-y-3">
        {{-- Search row --}}
        <div class="flex gap-3">
            <div class="flex-1 relative">
                <svg class="absolute left-3 top-2.5 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" name="search" value="{{ $request->input('search') }}"
                       class="form-input pl-9" placeholder="Search by name, city, region, field…">
            </div>
            <button type="submit" class="btn-primary">Search</button>
            <a href="{{ route('student.universities.index') }}" class="btn-secondary">Reset</a>
        </div>

        {{-- Filter chips row --}}
        <div class="flex flex-wrap gap-2">
            {{-- Region --}}
            <select name="region" class="form-input w-44 text-sm"
                    onchange="this.form.submit()">
                <option value="">🗺 All Regions</option>
                @foreach($regions as $region)
                <option value="{{ $region }}" {{ $request->input('region') === $region ? 'selected' : '' }}>
                    {{ $region }}
                </option>
                @endforeach
            </select>

            {{-- City --}}
            <select name="city" class="form-input w-36 text-sm"
                    onchange="this.form.submit()">
                <option value="">🏙 All Cities</option>
                @foreach($cities as $city)
                <option value="{{ $city }}" {{ $request->input('city') === $city ? 'selected' : '' }}>{{ $city }}</option>
                @endforeach
            </select>

            {{-- Language --}}
            <select name="language" class="form-input w-36 text-sm"
                    onchange="this.form.submit()">
                <option value="">🌐 Any Language</option>
                @foreach(['English','Mandarin','Bilingual'] as $lang)
                <option value="{{ $lang }}" {{ $request->input('language') === $lang ? 'selected' : '' }}>{{ $lang }}</option>
                @endforeach
            </select>

            {{-- Tier --}}
            <select name="tier" class="form-input w-44 text-sm"
                    onchange="this.form.submit()">
                <option value="">🏛 Any Tier</option>
                @foreach($tiers as $tier)
                <option value="{{ $tier }}" {{ $request->input('tier') === $tier ? 'selected' : '' }}>{{ $tier }}</option>
                @endforeach
            </select>

            {{-- Sort --}}
            <select name="sort" class="form-input w-36 text-sm"
                    onchange="this.form.submit()">
                <option value="name" {{ $request->input('sort','name') === 'name' ? 'selected' : '' }}>Sort: A–Z</option>
                <option value="tier" {{ $request->input('sort') === 'tier' ? 'selected' : '' }}>Sort: Top Tier</option>
                <option value="city" {{ $request->input('sort') === 'city' ? 'selected' : '' }}>Sort: City</option>
                <option value="new"  {{ $request->input('sort') === 'new'  ? 'selected' : '' }}>Sort: Newest</option>
            </select>
        </div>

        {{-- Active filter tags --}}
        @php
            $activeFilters = array_filter([
                'region'   => $request->input('region'),
                'city'     => $request->input('city'),
                'language' => $request->input('language'),
                'tier'     => $request->input('tier'),
                'search'   => $request->input('search'),
            ]);
        @endphp
        @if($activeFilters)
        <div class="flex flex-wrap gap-2 pt-1">
            @foreach($activeFilters as $key => $val)
            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-blue-100 text-blue-700 text-xs font-medium">
                {{ ucfirst($key) }}: {{ $val }}
                <a href="{{ request()->fullUrlWithQuery([$key => null]) }}" class="ml-0.5 hover:text-red-600">✕</a>
            </span>
            @endforeach
        </div>
        @endif
    </form>

    {{-- Result count --}}
    <div class="flex items-center justify-between">
        <p class="text-sm text-gray-500">
            <span class="font-semibold text-gray-800">{{ $universities->total() }}</span>
            {{ Str::plural('university', $universities->total()) }} found
        </p>
        {{-- Region quick-jump --}}
        <div class="hidden md:flex gap-1 flex-wrap justify-end">
            @foreach($regions as $r)
            <a href="{{ request()->fullUrlWithQuery(['region' => $r, 'page' => null]) }}"
               class="text-xs px-2.5 py-1 rounded-full transition-colors
                      {{ $request->input('region') === $r
                         ? 'bg-blue-700 text-white'
                         : 'bg-white border border-gray-200 text-gray-600 hover:border-blue-300 hover:text-blue-700' }}">
                {{ $r }}
            </a>
            @endforeach
        </div>
    </div>

    {{-- Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
        @forelse($universities as $uni)
        <a href="{{ route('student.universities.show', $uni) }}"
           class="card p-5 hover:shadow-md hover:border-blue-200 transition-all block group">

            <div class="flex items-start justify-between mb-3">
                <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                <span class="badge {{ $uni->ranking_badge_color }}">{{ $uni->ranking_tier }}</span>
            </div>

            <h3 class="font-semibold text-gray-900 group-hover:text-blue-700 transition-colors line-clamp-2 mb-1 text-sm leading-snug">
                {{ $uni->university_name }}
            </h3>

            <div class="flex items-center gap-1.5 text-xs text-gray-500 mb-3">
                <span>📍 {{ $uni->city }}</span>
                <span>·</span>
                <span class="badge {{ $uni->region_badge_color }} text-xs">{{ $uni->region }}</span>
            </div>

            <div class="flex items-center justify-between text-xs">
                <span class="badge {{ $uni->language_badge_color }}">{{ $uni->language_of_instruction }}</span>
                <span class="text-gray-400">
                    {{ $uni->programs_count }} prog · {{ $uni->scholarships_count }} schol
                </span>
            </div>
        </a>
        @empty
        <div class="col-span-3 py-16 text-center text-gray-400">
            <svg class="w-12 h-12 mx-auto mb-3 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                      d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"/>
            </svg>
            <p class="text-sm font-medium">No universities match your filters.</p>
            <a href="{{ route('student.universities.index') }}"
               class="text-blue-600 text-sm hover:underline mt-2 inline-block">Clear all filters</a>
        </div>
        @endforelse
    </div>

    {{ $universities->links() }}
</div>
@endsection
