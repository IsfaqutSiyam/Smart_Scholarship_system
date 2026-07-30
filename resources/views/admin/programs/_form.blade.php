<div class="card divide-y divide-gray-100">
    <div class="px-6 py-5">
        <h3 class="text-sm font-semibold text-gray-700 mb-4">Program Details</h3>
        <div class="space-y-4">

            <div>
                <label class="form-label">University <span class="text-red-500">*</span></label>
                <select name="university_id" class="form-input @error('university_id') border-red-400 @enderror">
                    <option value="">Select university…</option>
                    @foreach($universities as $id => $name)
                    <option value="{{ $id }}"
                        {{ old('university_id', $program->university_id ?? '') == $id ? 'selected' : '' }}>
                        {{ $name }}
                    </option>
                    @endforeach
                </select>
                @error('university_id')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="form-label">Program Name <span class="text-red-500">*</span></label>
                <input type="text" name="program_name"
                       value="{{ old('program_name', $program->program_name ?? '') }}"
                       class="form-input @error('program_name') border-red-400 @enderror"
                       placeholder="e.g. Computer Science and Technology">
                @error('program_name')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="form-label">Degree Level <span class="text-red-500">*</span></label>
                    <select name="degree_level" class="form-input @error('degree_level') border-red-400 @enderror">
                        <option value="">Select…</option>
                        @foreach(['bachelor'=>"Bachelor's",'master'=>"Master's",'phd'=>'PhD'] as $val => $lbl)
                        <option value="{{ $val }}"
                            {{ old('degree_level', $program->degree_level ?? '') === $val ? 'selected' : '' }}>
                            {{ $lbl }}
                        </option>
                        @endforeach
                    </select>
                    @error('degree_level')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="form-label">Field of Study <span class="text-red-500">*</span></label>
                    <input type="text" name="field_of_study"
                           value="{{ old('field_of_study', $program->field_of_study ?? '') }}"
                           class="form-input @error('field_of_study') border-red-400 @enderror"
                           placeholder="e.g. Computer Science">
                    @error('field_of_study')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="form-label">Duration <span class="text-red-500">*</span></label>
                    <input type="text" name="duration"
                           value="{{ old('duration', $program->duration ?? '') }}"
                           class="form-input @error('duration') border-red-400 @enderror"
                           placeholder="e.g. 4 years">
                    @error('duration')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="form-label">Tuition Fee</label>
                    <input type="text" name="tuition_fee"
                           value="{{ old('tuition_fee', $program->tuition_fee ?? '') }}"
                           class="form-input" placeholder="e.g. ¥28,000/year">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="form-label">Language Requirement</label>
                    <input type="text" name="language_requirement"
                           value="{{ old('language_requirement', $program->language_requirement ?? '') }}"
                           class="form-input" placeholder="e.g. IELTS 6.0 / None">
                </div>
                <div>
                    <label class="form-label">Minimum CGPA</label>
                    <input type="number" name="min_cgpa" step="0.01" min="0" max="4"
                           value="{{ old('min_cgpa', $program->min_cgpa ?? '') }}"
                           class="form-input" placeholder="e.g. 3.00">
                </div>
            </div>

            <div>
                <label class="form-label">Application Deadline</label>
                <input type="date" name="application_deadline"
                       value="{{ old('application_deadline', isset($program->application_deadline) ? $program->application_deadline->format('Y-m-d') : '') }}"
                       class="form-input w-48">
            </div>
        </div>
    </div>

    <div class="px-6 py-5">
        <h3 class="text-sm font-semibold text-gray-700 mb-2">Application Guidance</h3>
        <p class="text-xs text-gray-500 mb-3">List the required documents, steps, and important notes for applicants.</p>
        <textarea name="application_guidance" rows="6"
                  class="form-input"
                  placeholder="Required documents:&#10;1. Passport copy&#10;2. Academic transcripts (notarized)&#10;3. Personal Statement (500 words)&#10;4. Two recommendation letters&#10;&#10;Steps:&#10;1. Submit online application at...">{{ old('application_guidance', $program->application_guidance ?? '') }}</textarea>
    </div>

    <div class="px-6 py-4">
        <div class="flex items-center gap-3">
            <input type="checkbox" id="prog_active" name="is_active" value="1"
                   {{ old('is_active', $program->is_active ?? true) ? 'checked' : '' }}
                   class="rounded border-gray-300 text-blue-600">
            <label for="prog_active" class="text-sm text-gray-700">Active (visible to students)</label>
        </div>
    </div>
</div>
