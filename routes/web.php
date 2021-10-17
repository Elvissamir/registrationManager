<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\CoursesController;
use App\Http\Controllers\StudentsController;
use App\Http\Controllers\SubjectsController;

//
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');



// SUBJECTS
Route::resource('subjects', SubjectsController::class)->middleware('auth:sanctum');

// COURSES
Route::resource('courses', CoursesController::class)->middleware('auth:sanctum');

// STUDENTS
Route::resource('students', StudentsController::class)->middleware('auth:sanctum');
