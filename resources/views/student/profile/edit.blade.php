@extends('layouts.app')
@section('title', 'My Profile')
@section('page-title', 'My Academic Profile')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

    {{-- Profile completeness indicator --}}
    @php
        $fields = ['full_name','academic_background','preferred_field','cgpa','language_proficiency','degree_seeking'];
        $filled  = collect($fields)->filter(fn($f) => !empty($user->$f))->count();
        $pct     = (int)(($filled / count($fields)) * 100);
    @endphp
    <div class="card p-5">
        <div class="flex items-center justify-between mb-2">
            <span class="text-sm font-medium text-gray-700">Profile Completeness</span>
            <span class="text-sm font-bold {{ $pct === 100 ? 'text-green-600' : 'text-blue-600' }}">{{ $pct }}%</span>
        </div>
        <div class="w-full bg-gray-100 rounded-full h-2">
            <div class="h-2 rounded-full transition-all {{ $pct === 100 ? 'bg-green-500' : 'bg-blue-600' }}"
                 style="width: {{ $pct }}%"></div>
        </div>
        @if($pct === 100)
        <p class="text-xs text-green-600 mt-2">✓ Your profile is complete. Recommendations are up to date.</p>
        @else
        <p class="text-xs text-gray-500 mt-2">Fill all fields below to get personalized university & scholarship recommendations.</p>
        @endif
    </div>

    <form method="POST" action="{{ route('student.profile.update') }}">
        @csrf
        @method('PUT')

        <div class="card divide-y divide-gray-100">

            {{-- Personal --}}
            <div class="px-6 py-5">
                <h3 class="text-sm font-semibold text-gray-800 mb-4">Personal Information</h3>
                <div class="space-y-4">
                    <div>
                        <label class="form-label">Full Name <span class="text-red-500">*</span></label>
                        <input type="text" name="full_name" value="{{ old('full_name', $user->full_name) }}"
                               class="form-input @error('full_name') border-red-400 @enderror"
                               placeholder="e.g. Rahima Begum">
                        @error('full_name')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            {{-- Academic --}}
            <div class="px-6 py-5">
                <h3 class="text-sm font-semibold text-gray-800 mb-4">Academic Background</h3>
                <div class="space-y-4">
                    <div>
                        <label class="form-label">Academic Background <span class="text-red-500">*</span></label>
                        <input type="text" name="academic_background"
                               value="{{ old('academic_background', $user->academic_background) }}"
                               class="form-input @error('academic_background') border-red-400 @enderror"
                               placeholder="e.g. HSC from Dhaka College, 2023">
                        @error('academic_background')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="form-label">CGPA (out of 4.0) <span class="text-red-500">*</span></label>
                            <input type="number" name="cgpa" step="0.01" min="0" max="4"
                                   value="{{ old('cgpa', $user->cgpa) }}"
                                   class="form-input @error('cgpa') border-red-400 @enderror"
                                   placeholder="e.g. 3.50">
                            @error('cgpa')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="form-label">Degree Seeking <span class="text-red-500">*</span></label>
                            <select name="degree_seeking"
                                    class="form-input @error('degree_seeking') border-red-400 @enderror">
                                <option value="">Select...</option>
                                @foreach(['bachelor' => "Bachelor's", 'master' => "Master's", 'phd' => 'PhD'] as $val => $lbl)
                                <option value="{{ $val }}" {{ old('degree_seeking', $user->degree_seeking) === $val ? 'selected' : '' }}>
                                    {{ $lbl }}
                                </option>
                                @endforeach
                            </select>
                            @error('degree_seeking')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div>
                        <label class="form-label">Preferred Field of Study <span class="text-red-500">*</span></label>
                        <select name="preferred_field"
                                class="form-input @error('preferred_field') border-red-400 @enderror">
                            <option value="">Select field...</option>
                            @foreach([
                                'Computer Science','Engineering','Business','Medicine',
                                'Science','Agriculture','Arts & Humanities','Architecture'
                            ] as $field)
                            <option value="{{ $field }}"
                                {{ old('preferred_field', $user->preferred_field) === $field ? 'selected' : '' }}>
                                {{ $field }}
                            </option>
                            @endforeach
                        </select>
                        @error('preferred_field')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            {{-- Language --}}
            <div class="px-6 py-5">
                <h3 class="text-sm font-semibold text-gray-800 mb-1">Language Proficiency <span class="text-red-500">*</span></h3>
                <p class="text-xs text-gray-500 mb-4">Enter your highest language certificate. Examples: <em>IELTS 6.5</em>, <em>TOEFL 90</em>, <em>HSK 4</em>, <em>English Native</em></p>
                <input type="text" name="language_proficiency"
                       value="{{ old('language_proficiency', $user->language_proficiency) }}"
                       class="form-input @error('language_proficiency') border-red-400 @enderror"
                       placeholder="e.g. IELTS 6.5">
                @error('language_proficiency')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror

                <div class="mt-3 p-3 bg-blue-50 rounded-lg">
                    <p class="text-xs text-blue-800 font-medium mb-1">How this is used:</p>
                    <ul class="text-xs text-blue-700 space-y-0.5 list-disc list-inside">
                        <li>English programs typically require IELTS ≥ 6.0 or TOEFL ≥ 80</li>
                        <li>Mandarin programs typically require HSK 4 or above</li>
                        <li>Bilingual programs may accept either</li>
                    </ul>
                </div>
            </div>

            {{-- Actions --}}
            <div class="px-6 py-4 flex justify-end gap-3">
                <button type="submit" class="btn-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Save & Update Recommendations
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
