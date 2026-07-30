@extends('layouts.app')
@section('title', 'Admin Dashboard')
@section('page-title', 'Admin Dashboard')

@section('content')
<div class="space-y-6">

    {{-- Stats --}}
    <div class="grid grid-cols-2 lg:grid-cols-5 gap-4">
        @foreach([
            ['label'=>'Universities', 'value'=>$stats['universities'],  'color'=>'text-blue-700',   'bg'=>'bg-blue-50',   'route'=>'admin.universities.index'],
            ['label'=>'Programs',     'value'=>$stats['programs'],      'color'=>'text-indigo-700', 'bg'=>'bg-indigo-50', 'route'=>'admin.programs.index'],
            ['label'=>'Scholarships', 'value'=>$stats['scholarships'],  'color'=>'text-green-700',  'bg'=>'bg-green-50',  'route'=>'admin.scholarships.index'],
            ['label'=>'Students',     'value'=>$stats['students'],      'color'=>'text-purple-700', 'bg'=>'bg-purple-50', 'route'=>'admin.dashboard'],
            ['label'=>'Applications', 'value'=>$stats['applications'],  'color'=>'text-orange-700', 'bg'=>'bg-orange-50', 'route'=>'admin.dashboard'],
        ] as $s)
        <a href="{{ route($s['route']) }}" class="card p-5 hover:shadow-md transition-shadow">
            <p class="text-2xl font-bold {{ $s['color'] }}">{{ $s['value'] }}</p>
            <p class="text-xs text-gray-500 mt-1">{{ $s['label'] }}</p>
        </a>
        @endforeach
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Recent Universities --}}
        <div class="card">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <h3 class="font-semibold text-gray-800">Recent Universities</h3>
                <a href="{{ route('admin.universities.create') }}" class="btn-primary text-xs">+ Add</a>
            </div>
            <div class="divide-y divide-gray-50">
                @foreach($recentUniversities as $uni)
                <div class="px-6 py-3 flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-900">{{ $uni->university_name }}</p>
                        <p class="text-xs text-gray-500">{{ $uni->city }} · {{ $uni->ranking_tier }}</p>
                    </div>
                    <a href="{{ route('admin.universities.edit', $uni) }}" class="text-xs text-blue-600 hover:underline">Edit</a>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Upcoming Deadlines --}}
        <div class="card">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <h3 class="font-semibold text-gray-800">Upcoming Scholarship Deadlines</h3>
                <a href="{{ route('admin.scholarships.create') }}" class="btn-primary text-xs">+ Add</a>
            </div>
            <div class="divide-y divide-gray-50">
                @forelse($upcomingDeadlines as $s)
                <div class="px-6 py-3 flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-900 line-clamp-1">{{ $s->scholarship_name }}</p>
                        <p class="text-xs text-gray-500">{{ $s->university->university_name }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-xs {{ $s->days_until_deadline <= 14 ? 'text-red-600 font-semibold' : 'text-gray-500' }}">
                            {{ $s->application_deadline->format('d M Y') }}
                        </p>
                        <form method="POST" action="{{ route('admin.scholarships.toggle-visibility', $s) }}" class="mt-0.5">
                            @csrf
                            <button type="submit" class="text-xs {{ $s->is_visible ? 'text-green-600' : 'text-gray-400' }}">
                                {{ $s->is_visible ? '👁 Visible' : '🚫 Hidden' }}
                            </button>
                        </form>
                    </div>
                </div>
                @empty
                <p class="px-6 py-6 text-center text-sm text-gray-400">No upcoming deadlines.</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Quick links --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @foreach([
            ['label'=>'Add University', 'route'=>'admin.universities.create', 'icon'=>'🏛'],
            ['label'=>'Add Program',    'route'=>'admin.programs.create',    'icon'=>'📚'],
            ['label'=>'Add Scholarship','route'=>'admin.scholarships.create','icon'=>'💰'],
            ['label'=>'View All Programs','route'=>'admin.programs.index',   'icon'=>'📋'],
        ] as $link)
        <a href="{{ route($link['route']) }}"
           class="card p-4 text-center hover:shadow-md hover:border-blue-200 transition-all">
            <p class="text-2xl mb-1">{{ $link['icon'] }}</p>
            <p class="text-sm font-medium text-gray-700">{{ $link['label'] }}</p>
        </a>
        @endforeach
    </div>
</div>
@endsection
