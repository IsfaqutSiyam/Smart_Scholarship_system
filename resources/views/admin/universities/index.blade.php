@extends('layouts.app')
@section('title', 'Manage Universities')
@section('page-title', 'Universities')

@section('content')
<div class="space-y-4">
    <div class="flex items-center justify-between">
        <form method="GET" class="flex gap-2">
            <input type="text" name="search" value="{{ request('search') }}"
                   class="form-input w-64" placeholder="Search universities…">
            <button class="btn-secondary">Search</button>
        </form>
        <a href="{{ route('admin.universities.create') }}" class="btn-primary">+ Add University</a>
    </div>

    <div class="card overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-3 text-left font-semibold text-gray-600">University</th>
                    <th class="px-6 py-3 text-left font-semibold text-gray-600">City / Province</th>
                    <th class="px-6 py-3 text-left font-semibold text-gray-600">Tier</th>
                    <th class="px-6 py-3 text-left font-semibold text-gray-600">Language</th>
                    <th class="px-6 py-3 text-center font-semibold text-gray-600">Programs</th>
                    <th class="px-6 py-3 text-center font-semibold text-gray-600">Active</th>
                    <th class="px-6 py-3 text-right font-semibold text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($universities as $uni)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-3 font-medium text-gray-900">{{ $uni->university_name }}</td>
                    <td class="px-6 py-3 text-gray-500">{{ $uni->city }}, {{ $uni->province }}</td>
                    <td class="px-6 py-3"><span class="badge {{ $uni->ranking_badge_color }}">{{ $uni->ranking_tier }}</span></td>
                    <td class="px-6 py-3"><span class="badge {{ $uni->language_badge_color }}">{{ $uni->language_of_instruction }}</span></td>
                    <td class="px-6 py-3 text-center text-gray-500">{{ $uni->programs_count }}</td>
                    <td class="px-6 py-3 text-center">
                        <span class="{{ $uni->is_active ? 'text-green-600' : 'text-gray-400' }}">
                            {{ $uni->is_active ? '✓' : '—' }}
                        </span>
                    </td>
                    <td class="px-6 py-3 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.universities.edit', $uni) }}" class="text-blue-600 hover:underline text-xs">Edit</a>
                            <form method="POST" action="{{ route('admin.universities.destroy', $uni) }}"
                                  onsubmit="return confirm('Delete {{ addslashes($uni->university_name) }}?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 text-xs">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-6 py-10 text-center text-gray-400">No universities found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $universities->links() }}
</div>
@endsection
