<div class="card divide-y divide-gray-100">
    <div class="px-6 py-5">
        <h3 class="text-sm font-semibold text-gray-700 mb-4">Scholarship Details</h3>
        <div class="space-y-4">

            <div>
                <label class="form-label">University <span class="text-red-500">*</span></label>
                <select name="university_id" class="form-input @error('university_id') border-red-400 @enderror">
                    <option value="">Select university…</option>
                    @foreach($universities as $id => $name)
                    <option value="{{ $id }}"
                        {{ old('university_id', $scholarship->university_id ?? '') == $id ? 'selected' : '' }}>
                        {{ $name }}
                    </option>
                    @endforeach
                </select>
                @error('university_id')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="form-label">Scholarship Name <span class="text-red-500">*</span></label>
                <input type="text" name="scholarship_name"
                       value="{{ old('scholarship_name', $scholarship->scholarship_name ?? '') }}"
                       class="form-input @error('scholarship_name') border-red-400 @enderror"
                       placeholder="e.g. Chinese Government Scholarship (CSC)">
                @error('scholarship_name')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="form-label">Funding Type <span class="text-red-500">*</span></label>
                    <select name="funding_type" class="form-input @error('funding_type') border-red-400 @enderror">
                        <option value="">Select…</option>
                        @foreach(['full'=>'Full Scholarship','partial'=>'Partial','tuition_only'=>'Tuition Only'] as $val => $lbl)
                        <option value="{{ $val }}"
                            {{ old('funding_type', $scholarship->funding_type ?? '') === $val ? 'selected' : '' }}>
                            {{ $lbl }}
                        </option>
                        @endforeach
                    </select>
                    @error('funding_type')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="form-label">Annual Amount (CNY)</label>
                    <input type="number" name="annual_amount_cny" min="0"
                           value="{{ old('annual_amount_cny', $scholarship->annual_amount_cny ?? '') }}"
                           class="form-input" placeholder="e.g. 36000">
                </div>
            </div>

            <div>
                <label class="form-label">Application Deadline <span class="text-red-500">*</span></label>
                <input type="date" name="application_deadline"
                       value="{{ old('application_deadline', isset($scholarship->application_deadline) ? $scholarship->application_deadline->format('Y-m-d') : '') }}"
                       class="form-input w-48 @error('application_deadline') border-red-400 @enderror">
                @error('application_deadline')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>
        </div>
    </div>

    <div class="px-6 py-5">
        <h3 class="text-sm font-semibold text-gray-700 mb-4">Eligibility</h3>
        <div class="space-y-4">

            <div>
                <label class="form-label">Eligibility Criteria <span class="text-red-500">*</span></label>
                <textarea name="eligibility_criteria" rows="5"
                          class="form-input @error('eligibility_criteria') border-red-400 @enderror"
                          placeholder="Describe the eligibility requirements...">{{ old('eligibility_criteria', $scholarship->eligibility_criteria ?? '') }}</textarea>
                @error('eligibility_criteria')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="form-label">Minimum CGPA</label>
                    <input type="number" name="min_cgpa" step="0.01" min="0" max="4"
                           value="{{ old('min_cgpa', $scholarship->min_cgpa ?? '') }}"
                           class="form-input" placeholder="e.g. 3.00">
                </div>
                <div>
                    <label class="form-label">Eligible Degree Levels</label>
                    <input type="text" name="eligible_degree_levels"
                           value="{{ old('eligible_degree_levels', $scholarship->eligible_degree_levels ?? '') }}"
                           class="form-input" placeholder="bachelor,master,phd">
                    <p class="text-xs text-gray-400 mt-1">Comma-separated. Leave blank for all.</p>
                </div>
            </div>

            <div>
                <label class="form-label">Eligible Fields</label>
                <input type="text" name="eligible_fields"
                       value="{{ old('eligible_fields', $scholarship->eligible_fields ?? '') }}"
                       class="form-input" placeholder="Computer Science,Engineering (leave blank = all fields)">
            </div>
        </div>
    </div>

    <div class="px-6 py-5">
        <h3 class="text-sm font-semibold text-gray-700 mb-3">Coverage Details</h3>
        <textarea name="coverage_details" rows="4"
                  class="form-input"
                  placeholder="What does this scholarship cover? Tuition, accommodation, living allowance, flights...">{{ old('coverage_details', $scholarship->coverage_details ?? '') }}</textarea>
    </div>

    <div class="px-6 py-4 flex gap-6">
        <div class="flex items-center gap-2">
            <input type="checkbox" id="sch_active" name="is_active" value="1"
                   {{ old('is_active', $scholarship->is_active ?? true) ? 'checked' : '' }}
                   class="rounded border-gray-300 text-blue-600">
            <label for="sch_active" class="text-sm text-gray-700">Active</label>
        </div>
        <div class="flex items-center gap-2">
            <input type="checkbox" id="sch_visible" name="is_visible" value="1"
                   {{ old('is_visible', $scholarship->is_visible ?? true) ? 'checked' : '' }}
                   class="rounded border-gray-300 text-blue-600">
            <label for="sch_visible" class="text-sm text-gray-700">Visible to students</label>
        </div>
    </div>
</div>
