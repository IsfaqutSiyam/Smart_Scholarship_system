<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Models\University;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    private function rules(bool $isUpdate = false): array
    {
        return [
            'university_id'       => ['required', 'exists:universities,university_id'],
            'program_name'        => ['required', 'string', 'max:150'],
            'degree_level'        => ['required', 'in:bachelor,master,phd'],
            'field_of_study'      => ['required', 'string', 'max:100'],
            'duration'            => ['required', 'string', 'max:50'],
            'tuition_fee'         => ['nullable', 'string', 'max:100'],
            'language_requirement'=> ['nullable', 'string', 'max:100'],
            'min_cgpa'            => ['nullable', 'numeric', 'min:0', 'max:4'],
            'application_guidance'=> ['nullable', 'string'],
            'application_deadline'=> ['nullable', 'date'],
            'is_active'           => ['boolean'],
        ];
    }

    public function index(Request $request)
    {
        $query = Program::with('university');

        if ($search = $request->input('search')) {
            $query->where('program_name', 'like', "%{$search}%")
                  ->orWhere('field_of_study', 'like', "%{$search}%");
        }

        if ($uni = $request->input('university_id')) {
            $query->where('university_id', $uni);
        }

        if ($level = $request->input('degree_level')) {
            $query->where('degree_level', $level);
        }

        $programs      = $query->orderBy('program_name')->paginate(15)->withQueryString();
        $universities  = University::active()->orderBy('university_name')->pluck('university_name', 'university_id');

        return view('admin.programs.index', compact('programs', 'universities'));
    }

    public function create()
    {
        $universities = University::active()->orderBy('university_name')
                            ->pluck('university_name', 'university_id');
        return view('admin.programs.create', compact('universities'));
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules());
        $data['is_active'] = $request->boolean('is_active', true);

        Program::create($data);

        return redirect()->route('admin.programs.index')
            ->with('success', 'Program added successfully.');
    }

    public function edit(Program $program)
    {
        $universities = University::active()->orderBy('university_name')
                            ->pluck('university_name', 'university_id');
        return view('admin.programs.edit', compact('program', 'universities'));
    }

    public function update(Request $request, Program $program)
    {
        $data = $request->validate($this->rules(true));
        $data['is_active'] = $request->boolean('is_active', true);

        $program->update($data);

        return redirect()->route('admin.programs.index')
            ->with('success', 'Program updated successfully.');
    }

    public function destroy(Program $program)
    {
        $program->delete();
        return redirect()->route('admin.programs.index')
            ->with('success', 'Program deleted.');
    }
}
