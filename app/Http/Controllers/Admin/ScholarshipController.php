<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Scholarship;
use App\Models\University;
use Illuminate\Http\Request;

class ScholarshipController extends Controller
{
    private function rules(): array
    {
        return [
            'university_id'          => ['required', 'exists:universities,university_id'],
            'scholarship_name'       => ['required', 'string', 'max:150'],
            'funding_type'           => ['required', 'in:full,partial,tuition_only'],
            'coverage_details'       => ['nullable', 'string'],
            'application_deadline'   => ['required', 'date'],
            'eligibility_criteria'   => ['required', 'string'],
            'min_cgpa'               => ['nullable', 'numeric', 'min:0', 'max:4'],
            'eligible_degree_levels' => ['nullable', 'string', 'max:100'],
            'eligible_fields'        => ['nullable', 'string', 'max:255'],
            'annual_amount_cny'      => ['nullable', 'integer', 'min:0'],
            'is_active'              => ['boolean'],
            'is_visible'             => ['boolean'],
        ];
    }

    public function index(Request $request)
    {
        $query = Scholarship::with('university');

        if ($search = $request->input('search')) {
            $query->where('scholarship_name', 'like', "%{$search}%");
        }

        if ($type = $request->input('funding_type')) {
            $query->byFundingType($type);
        }

        $scholarships = $query->orderBy('application_deadline')->paginate(15)->withQueryString();
        $universities = University::active()->orderBy('university_name')
                            ->pluck('university_name', 'university_id');

        return view('admin.scholarships.index', compact('scholarships', 'universities'));
    }

    public function create()
    {
        $universities = University::active()->orderBy('university_name')
                            ->pluck('university_name', 'university_id');
        return view('admin.scholarships.create', compact('universities'));
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules());
        $data['is_active']  = $request->boolean('is_active', true);
        $data['is_visible'] = $request->boolean('is_visible', true);

        Scholarship::create($data);

        return redirect()->route('admin.scholarships.index')
            ->with('success', 'Scholarship added successfully.');
    }

    public function edit(Scholarship $scholarship)
    {
        $universities = University::active()->orderBy('university_name')
                            ->pluck('university_name', 'university_id');
        return view('admin.scholarships.edit', compact('scholarship', 'universities'));
    }

    public function update(Request $request, Scholarship $scholarship)
    {
        $data = $request->validate($this->rules());
        $data['is_active']  = $request->boolean('is_active', true);
        $data['is_visible'] = $request->boolean('is_visible', true);

        $scholarship->update($data);

        return redirect()->route('admin.scholarships.index')
            ->with('success', 'Scholarship updated successfully.');
    }

    public function destroy(Scholarship $scholarship)
    {
        $scholarship->delete();
        return redirect()->route('admin.scholarships.index')
            ->with('success', 'Scholarship deleted.');
    }

    public function toggleVisibility(Scholarship $scholarship)
    {
        $scholarship->update(['is_visible' => ! $scholarship->is_visible]);
        $label = $scholarship->is_visible ? 'visible' : 'hidden';
        return back()->with('success', "Scholarship is now {$label} to students.");
    }
}
