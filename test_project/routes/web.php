<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\CustomRegisterController;
use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\InstructorDashboardController;
use App\Http\Controllers\InstructorController; // Import Instructor Controller

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes
Route::get('/login', function () {
    return view('auth.login'); // Custom login view
})->name('login');
Route::post('/login', [CustomAuthController::class, 'login']);
Route::get('/register', function () {
    return view('auth.register'); // Custom registration form
})->name('register');
Route::post('/register', [CustomRegisterController::class, 'register']);

/*
|--------------------------------------------------------------------------
| Student Routes (Protected by 'auth:student' Middleware)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:student'])->group(function () {
    Route::get('/student-dashboard', [StudentDashboardController::class, 'index'])->name('student.dashboard');
});

/*
|--------------------------------------------------------------------------
| Instructor Routes (Protected by 'auth:instructor' Middleware)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:instructor'])->group(function () {
    Route::get('/instructor-dashboard', [InstructorDashboardController::class, 'index'])->name('instructor.dashboard');

    // 🟢 Course Management
    Route::get('/courses', [InstructorController::class, 'courses'])->name('instructor.courses');
    Route::post('/courses/store', [InstructorController::class, 'storeCourse'])->name('courses.store');
    Route::put('/courses/update/{id}', [InstructorController::class, 'updateCourse'])->name('courses.update');
    Route::delete('/courses/delete/{id}', [InstructorController::class, 'deleteCourse'])->name('courses.delete');

    // 🟢 Section Management
    Route::get('/sections', [InstructorController::class, 'sections'])->name('instructor.sections');
    Route::post('/sections/store', [InstructorController::class, 'storeSection'])->name('sections.store');
    Route::put('/sections/update/{id}', [InstructorController::class, 'updateSection'])->name('sections.update');
    Route::delete('/sections/delete/{id}', [InstructorController::class, 'deleteSection'])->name('sections.delete');

    // 🟢 Enrollment Management
    Route::get('/enrollments', [InstructorController::class, 'enrollments'])->name('instructor.enrollments');
    Route::post('/enrollments/store', [InstructorController::class, 'storeEnrollment'])->name('enrollments.store');
    Route::put('/enrollments/update/{id}', [InstructorController::class, 'updateEnrollment'])->name('enrollments.update');
    Route::delete('/enrollments/delete/{id}', [InstructorController::class, 'deleteEnrollment'])->name('enrollments.delete');

    // 🟢 Plan Management
    Route::get('/plans', [InstructorController::class, 'plans'])->name('instructor.plans');
    Route::post('/plans/store', [InstructorController::class, 'storePlan'])->name('plans.store');
    Route::put('/plans/update/{id}', [InstructorController::class, 'updatePlan'])->name('plans.update');
    Route::delete('/plans/delete/{id}', [InstructorController::class, 'deletePlan'])->name('plans.delete');

    // 🟢 Role Management
    Route::get('/roles', [InstructorController::class, 'roles'])->name('instructor.roles');
    Route::post('/roles/store', [InstructorController::class, 'storeRole'])->name('roles.store');
    Route::put('/roles/update/{id}', [InstructorController::class, 'updateRole'])->name('roles.update');
    Route::delete('/roles/delete/{id}', [InstructorController::class, 'deleteRole'])->name('roles.delete');

    // 🟢 Student Progress Management
    Route::get('/progress', [InstructorController::class, 'progress'])->name('instructor.progress');
    Route::post('/progress/store', [InstructorController::class, 'storeProgress'])->name('progress.store');
    Route::put('/progress/update/{id}', [InstructorController::class, 'updateProgress'])->name('progress.update');
    Route::delete('/progress/delete/{id}', [InstructorController::class, 'deleteProgress'])->name('progress.delete');

    // 🟢 Team Management
    Route::get('/teams', [InstructorController::class, 'teams'])->name('instructor.teams');
    Route::post('/teams/store', [InstructorController::class, 'storeTeam'])->name('teams.store');
    Route::put('/teams/update/{id}', [InstructorController::class, 'updateTeam'])->name('teams.update');
    Route::delete('/teams/delete/{id}', [InstructorController::class, 'deleteTeam'])->name('teams.delete');
});

/*
|--------------------------------------------------------------------------
| Logout Route
|--------------------------------------------------------------------------
*/
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');
