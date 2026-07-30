@extends('layouts.app')
@section('title', 'Manage Programs')
@section('page-title', 'Programs')

@section('content')
<div class="space-y-4">
    <div class="flex flex-wrap items-center justify-between gap-3">
        <form method="GET" class="flex flex-wrap gap-2">
            <input type="text" name="search" value="{{ request('search') }}"
                   class="form-input w-52" placeholder="Search programs…">
            <select name="university_id" class="form-input w-48">
                <option value="">All Universities</option>
                @foreach($universities as $id => $name)
                <option value="{{ $id }}" {{ request('university_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                @endforeach
            </select>
            <select name="degree_level" class="form-input w-36">
                <option value="">All Levels</option>
                @foreach(['bachelor'=>"Bachelor's",'master'=>"Master's",'phd'=>'PhD'] as $val => $lbl)
                <option value="{{ $val }}" {{ request('degree_level') === $val ? 'selected' : '' }}>{{ $lbl }}</option>
                @endforeach
            </select>
            <button class="btn-secondary">Filter</button>
        </form>
        <a href="{{ route('admin.programs.create') }}" class="btn-primary">+ Add Program</a>
    </div>

    <div class="card overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-3 text-left font-semibold text-gray-600">Program</th>
                    <th class="px-6 py-3 text-left font-semibold text-gray-600">University</th>
                    <th class="px-6 py-3 text-left font-semibold text-gray-600">Level</th>
                    <th class="px-6 py-3 text-left font-semibold text-gray-600">Field</th>
                    <th class="px-6 py-3 text-left font-semibold text-gray-600">Deadline</th>
                    <th class="px-6 py-3 text-right font-semibold text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($programs as $prog)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-3 font-medium text-gray-900">{{ $prog->program_name }}</td>
                    <td class="px-6 py-3 text-gray-500 text-xs">{{ $prog->university->university_name }}</td>
                    <td class="px-6 py-3">
                        <span class="badge bg-indigo-100 text-indigo-700">{{ $prog->degree_label }}</span>
                    </td>
                    <td class="px-6 py-3 text-gray-500">{{ $prog->field_of_study }}</td>
                    <td class="px-6 py-3 text-xs
                        {{ $prog->deadline_status === 'closed' ? 'text-red-500' :
                           ($prog->deadline_status === 'closing_soon' ? 'text-orange-600 font-semibold' : 'text-gray-500') }}">
                        {{ $prog->application_deadline?->format('d M Y') ?? '—' }}
                    </td>
                    <td class="px-6 py-3 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.programs.edit', $prog) }}"
                               class="text-blue-600 hover:underline text-xs">Edit</a>
                            <form method="POST" action="{{ route('admin.programs.destroy', $prog) }}"
                                  onsubmit="return confirm('Delete this program?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 text-xs">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-6 py-10 text-center text-gray-400">No programs found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    {{ $programs->links() }}
</div>
@endsection
