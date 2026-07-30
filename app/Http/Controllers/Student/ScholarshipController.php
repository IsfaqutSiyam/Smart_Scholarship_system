<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Scholarship;
use App\Models\University;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScholarshipController extends Controller
{
    public function index(Request $request)
    {
        $query = Scholarship::with('university')->visible();

        // Search
        if ($search = $request->input('search')) {
            $tokens = array_filter(explode(' ', trim($search)));
            foreach ($tokens as $token) {
                $t = '%' . $token . '%';
                $query->where(function ($q) use ($t) {
                    $q->where('scholarship_name', 'like', $t)
                      ->orWhere('eligibility_criteria', 'like', $t)
                      ->orWhereHas('university', fn ($u) =>
                          $u->where('university_name', 'like', $t)
                            ->orWhere('city', 'like', $t)
                            ->orWhere('region', 'like', $t)
                      );
                });
            }
        }

        // Region filter (via university relationship)
        if ($region = $request->input('region')) {
            $query->whereHas('university', fn ($q) => $q->where('region', $region));
        }

        // Funding type filter
        if ($type = $request->input('funding_type')) {
            $query->byFundingType($type);
        }

        // Open deadlines only
        if ($request->boolean('upcoming_only')) {
            $query->deadlineUpcoming();
        }

        // Eligible only (premium feature)
        if ($request->boolean('eligible_only') && Auth::check()) {
            $user = Auth::user();
            if ($user->isPremium()) {
                $query->eligibleFor($user);
            }
        }

        $scholarships = $query->orderBy('application_deadline')->paginate(12)->withQueryString();
        $regions      = array_keys(University::REGION_MAP);

        return view('student.scholarships.index', compact('scholarships', 'regions', 'request'));
    }

    public function show(Scholarship $scholarship)
    {
        $scholarship->load('university');
        return view('student.scholarships.show', compact('scholarship'));
    }
}
