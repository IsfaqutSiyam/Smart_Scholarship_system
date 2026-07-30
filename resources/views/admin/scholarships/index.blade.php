@extends('layouts.app')
@section('title', 'Manage Scholarships')
@section('page-title', 'Scholarships')

@section('content')
<div class="space-y-4">
    <div class="flex flex-wrap items-center justify-between gap-3">
        <form method="GET" class="flex flex-wrap gap-2">
            <input type="text" name="search" value="{{ request('search') }}"
                   class="form-input w-52" placeholder="Search scholarships…">
            <select name="funding_type" class="form-input w-40">
                <option value="">All Types</option>
                @foreach(['full'=>'Full','partial'=>'Partial','tuition_only'=>'Tuition Only'] as $v => $l)
                <option value="{{ $v }}" {{ request('funding_type') === $v ? 'selected' : '' }}>{{ $l }}</option>
                @endforeach
            </select>
            <button class="btn-secondary">Filter</button>
        </form>
        <a href="{{ route('admin.scholarships.create') }}" class="btn-primary">+ Add Scholarship</a>
    </div>

    <div class="card overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-3 text-left font-semibold text-gray-600">Scholarship</th>
                    <th class="px-6 py-3 text-left font-semibold text-gray-600">University</th>
                    <th class="px-6 py-3 text-left font-semibold text-gray-600">Type</th>
                    <th class="px-6 py-3 text-left font-semibold text-gray-600">Amount</th>
                    <th class="px-6 py-3 text-left font-semibold text-gray-600">Deadline</th>
                    <th class="px-6 py-3 text-center font-semibold text-gray-600">Visible</th>
                    <th class="px-6 py-3 text-right font-semibold text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($scholarships as $s)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-3 font-medium text-gray-900 max-w-xs">
                        <p class="truncate">{{ $s->scholarship_name }}</p>
                    </td>
                    <td class="px-6 py-3 text-gray-500 text-xs">{{ $s->university->university_name }}</td>
                    <td class="px-6 py-3">
                        <span class="badge {{ $s->funding_badge_color }}">{{ $s->funding_label }}</span>
                    </td>
                    <td class="px-6 py-3 text-gray-500 text-xs">{{ $s->getAmountFormatted() }}</td>
                    <td class="px-6 py-3 text-xs
                        {{ $s->days_until_deadline <= 14 && $s->days_until_deadline >= 0 ? 'text-red-600 font-semibold' : 'text-gray-500' }}">
                        {{ $s->application_deadline->format('d M Y') }}
                    </td>
                    <td class="px-6 py-3 text-center">
                        <form method="POST" action="{{ route('admin.scholarships.toggle-visibility', $s) }}">
                            @csrf
                            <button type="submit"
                                    class="text-xs {{ $s->is_visible ? 'text-green-600 hover:text-green-800' : 'text-gray-400 hover:text-gray-600' }}">
                                {{ $s->is_visible ? '👁 Yes' : '🚫 No' }}
                            </button>
                        </form>
                    </td>
                    <td class="px-6 py-3 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.scholarships.edit', $s) }}"
                               class="text-blue-600 hover:underline text-xs">Edit</a>
                            <form method="POST" action="{{ route('admin.scholarships.destroy', $s) }}"
                                  onsubmit="return confirm('Delete this scholarship?')">
                                @csrf @method('DELETE')
                                <button class="text-red-500 hover:text-red-700 text-xs">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-6 py-10 text-center text-gray-400">No scholarships found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    {{ $scholarships->links() }}
</div>
@endsection
