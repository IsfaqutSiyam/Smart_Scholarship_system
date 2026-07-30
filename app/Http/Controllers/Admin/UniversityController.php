<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\University;
use Illuminate\Http\Request;

class UniversityController extends Controller
{
    private array $rules = [
        'university_name'       => ['required', 'string', 'max:150'],
        'city'                  => ['required', 'string', 'max:100'],
        'province'              => ['required', 'string', 'max:100'],
        'ranking_tier'          => ['required', 'in:985,211,Double First Class,Provincial,Private'],
        'language_of_instruction'=> ['required', 'in:English,Mandarin,Bilingual'],
        'description'           => ['nullable', 'string'],
        'website_url'           => ['nullable', 'url', 'max:255'],
        'established_year'      => ['nullable', 'integer', 'min:1800', 'max:2025'],
        'is_active'             => ['boolean'],
    ];

    public function index(Request $request)
    {
        $query = University::withCount(['programs', 'scholarships']);

        if ($search = $request->input('search')) {
            $query->where('university_name', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%");
        }

        $universities = $query->orderBy('university_name')->paginate(15)->withQueryString();

        return view('admin.universities.index', compact('universities'));
    }

    public function create()
    {
        return view('admin.universities.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules);
        $data['is_active'] = $request->boolean('is_active', true);

        University::create($data);

        return redirect()->route('admin.universities.index')
            ->with('success', 'University added successfully.');
    }

    public function edit(University $university)
    {
        return view('admin.universities.edit', compact('university'));
    }

    public function update(Request $request, University $university)
    {
        $data = $request->validate($this->rules);
        $data['is_active'] = $request->boolean('is_active', true);

        $university->update($data);

        return redirect()->route('admin.universities.index')
            ->with('success', 'University updated successfully.');
    }

    public function destroy(University $university)
    {
        $university->delete();
        return redirect()->route('admin.universities.index')
            ->with('success', 'University deleted.');
    }

    public function show(University $university)
    {
        $university->load(['programs', 'scholarships']);
        return view('admin.universities.show', compact('university'));
    }
}
