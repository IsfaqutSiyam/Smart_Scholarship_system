<?php

namespace Tests;

use App\Models\Program;
use App\Models\Recommendation;
use App\Models\University;
use App\Models\User;
use App\Services\RecommendationEngine;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RecommendationEngineTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_generates_recommendations_for_complete_profile(): void
    {
        $user = User::factory()->create([
            'role' => 'student',
            'academic_background' => 'HSC from Dhaka College, 2023',
            'preferred_field' => 'Computer Science',
            'cgpa' => 3.70,
            'language_proficiency' => 'IELTS 6.5',
            'degree_seeking' => 'bachelor',
        ]);

        $university = University::create([
            'university_name' => 'Test University',
            'city' => 'Dhaka',
            'province' => 'Dhaka',
            'region' => 'East China',
            'ranking_tier' => '985',
            'language_of_instruction' => 'English',
            'is_active' => true,
        ]);

        Program::create([
            'university_id' => $university->university_id,
            'program_name' => 'Computer Science',
            'degree_level' => 'bachelor',
            'field_of_study' => 'Computer Science',
            'duration' => '4 years',
            'tuition_fee' => '¥20,000/yr',
            'language_requirement' => 'IELTS 6.0',
            'min_cgpa' => 3.50,
            'application_deadline' => now()->addMonth(),
            'is_active' => true,
        ]);

        $engine = new RecommendationEngine();
        $results = $engine->generate($user, 5);

        $this->assertCount(1, $results);
        $this->assertDatabaseCount('recommendations', 1);
        $this->assertTrue(Recommendation::where('user_id', $user->user_id)->exists());
    }
}
