<div class="card divide-y divide-gray-100">
    <div class="px-6 py-5">
        <h3 class="text-sm font-semibold text-gray-700 mb-4">Basic Information</h3>
        <div class="space-y-4">

            <div>
                <label class="form-label">University Name <span class="text-red-500">*</span></label>
                <input type="text" name="university_name"
                       value="{{ old('university_name', $university->university_name ?? '') }}"
                       class="form-input @error('university_name') border-red-400 @enderror"
                       placeholder="e.g. Peking University">
                @error('university_name')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="form-label">City <span class="text-red-500">*</span></label>
                    <input type="text" name="city"
                           value="{{ old('city', $university->city ?? '') }}"
                           class="form-input @error('city') border-red-400 @enderror"
                           placeholder="e.g. Beijing">
                    @error('city')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="form-label">Province <span class="text-red-500">*</span></label>
                    <input type="text" name="province"
                           value="{{ old('province', $university->province ?? '') }}"
                           class="form-input @error('province') border-red-400 @enderror"
                           placeholder="e.g. Beijing">
                    @error('province')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="form-label">Ranking Tier <span class="text-red-500">*</span></label>
                    <select name="ranking_tier" class="form-input @error('ranking_tier') border-red-400 @enderror">
                        <option value="">Select tier…</option>
                        @foreach(['985','211','Double First Class','Provincial','Private'] as $tier)
                        <option value="{{ $tier }}"
                            {{ old('ranking_tier', $university->ranking_tier ?? '') === $tier ? 'selected' : '' }}>
                            {{ $tier }}
                        </option>
                        @endforeach
                    </select>
                    @error('ranking_tier')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="form-label">Language of Instruction <span class="text-red-500">*</span></label>
                    <select name="language_of_instruction"
                            class="form-input @error('language_of_instruction') border-red-400 @enderror">
                        @foreach(['English','Mandarin','Bilingual'] as $lang)
                        <option value="{{ $lang }}"
                            {{ old('language_of_instruction', $university->language_of_instruction ?? '') === $lang ? 'selected' : '' }}>
                            {{ $lang }}
                        </option>
                        @endforeach
                    </select>
                    @error('language_of_instruction')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            <div>
                <label class="form-label">Established Year</label>
                <input type="number" name="established_year" min="1800" max="2025"
                       value="{{ old('established_year', $university->established_year ?? '') }}"
                       class="form-input w-40" placeholder="e.g. 1898">
                @error('established_year')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>
        </div>
    </div>

    <div class="px-6 py-5">
        <h3 class="text-sm font-semibold text-gray-700 mb-4">Additional Details</h3>
        <div class="space-y-4">
            <div>
                <label class="form-label">Description</label>
                <textarea name="description" rows="4"
                          class="form-input @error('description') border-red-400 @enderror"
                          placeholder="Brief description of the university…">{{ old('description', $university->description ?? '') }}</textarea>
                @error('description')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="form-label">Official Website URL</label>
                <input type="url" name="website_url"
                       value="{{ old('website_url', $university->website_url ?? '') }}"
                       class="form-input @error('website_url') border-red-400 @enderror"
                       placeholder="https://www.pku.edu.cn">
                @error('website_url')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="flex items-center gap-3">
                <input type="checkbox" id="is_active" name="is_active" value="1"
                       {{ old('is_active', $university->is_active ?? true) ? 'checked' : '' }}
                       class="rounded border-gray-300 text-blue-600">
                <label for="is_active" class="text-sm text-gray-700">Active (visible to students)</label>
            </div>
        </div>
    </div>
</div>
