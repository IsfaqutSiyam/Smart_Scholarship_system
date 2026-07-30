<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\Student;
use Illuminate\Support\Facades\Route;

// ── Public landing page ───────────────────────────────────────
Route::get('/', function () {
    return view('welcome');
})->name('home');

// ── Auth routes (Laravel Breeze) ──────────────────────────────
require __DIR__ . '/auth.php';

// ── Redirect after login based on role ───────────────────────
Route::get('/dashboard', function () {
    return auth()->user()->isAdmin()
        ? redirect()->route('admin.dashboard')
        : redirect()->route('student.dashboard');
})->middleware(['auth'])->name('dashboard');

// ═══════════════════════════════════════════════════════════════
// STUDENT routes  (auth + student role)
// ═══════════════════════════════════════════════════════════════
Route::middleware(['auth'])->prefix('student')->name('student.')->group(function () {

    Route::get('/dashboard', [Student\DashboardController::class, 'index'])
        ->name('dashboard');

    // Profile
    Route::get('/profile', [Student\ProfileController::class, 'edit'])
        ->name('profile.edit');
    Route::put('/profile', [Student\ProfileController::class, 'update'])
        ->name('profile.update');

    // Universities
    Route::get('/universities', [Student\UniversityController::class, 'index'])
        ->name('universities.index');
    Route::get('/universities/{university}', [Student\UniversityController::class, 'show'])
        ->name('universities.show');

    // Scholarships
    Route::get('/scholarships', [Student\ScholarshipController::class, 'index'])
        ->name('scholarships.index');
    Route::get('/scholarships/{scholarship}', [Student\ScholarshipController::class, 'show'])
        ->name('scholarships.show');

    // Recommendations
    Route::get('/recommendations', [Student\RecommendationController::class, 'index'])
        ->name('recommendations.index');
    Route::post('/recommendations/refresh', [Student\RecommendationController::class, 'refresh'])
        ->name('recommendations.refresh');

    // Applications (saved programs)
    Route::get('/applications', [Student\ApplicationController::class, 'index'])
        ->name('applications.index');
    Route::get('/applications/{application}', [Student\ApplicationController::class, 'show'])
        ->name('applications.show');
    Route::post('/applications', [Student\ApplicationController::class, 'store'])
        ->name('applications.store');
    Route::delete('/applications/{application}', [Student\ApplicationController::class, 'destroy'])
        ->name('applications.destroy');
});

// ═══════════════════════════════════════════════════════════════
// ADMIN routes  (auth + admin role)
// ═══════════════════════════════════════════════════════════════
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [Admin\DashboardController::class, 'index'])
        ->name('dashboard');

    // Universities
    Route::resource('universities', Admin\UniversityController::class);

    // Programs
    Route::resource('programs', Admin\ProgramController::class);

    // Scholarships
    Route::resource('scholarships', Admin\ScholarshipController::class);
    Route::post('scholarships/{scholarship}/toggle-visibility',
        [Admin\ScholarshipController::class, 'toggleVisibility'])
        ->name('scholarships.toggle-visibility');
});

// ── Subscription routes (student) ─────────────────────────────
Route::middleware(['auth'])->prefix('student/subscription')->name('student.subscription.')->group(function () {
    Route::get('/',                              [\App\Http\Controllers\Student\SubscriptionController::class, 'index'])   ->name('index');
    Route::post('/checkout',                     [\App\Http\Controllers\Student\SubscriptionController::class, 'checkout'])->name('checkout');
    Route::get('/{subscription}/pay',            [\App\Http\Controllers\Student\SubscriptionController::class, 'pay'])    ->name('pay');
    Route::get('/{subscription}/success',        [\App\Http\Controllers\Student\SubscriptionController::class, 'success'])->name('success');
    Route::get('/{subscription}/cancel',         [\App\Http\Controllers\Student\SubscriptionController::class, 'cancel']) ->name('cancel');
});
