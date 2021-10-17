<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\CoursesController;
use App\Http\Controllers\StudentsController;

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


// COURSES
Route::post('courses', [CoursesController::class, 'store'])
     ->middleware('auth:sanctum')
     ->name('courses.store');

Route::get('courses', [CoursesController::class, 'index'])
    ->middleware('auth:sanctum')
    ->name('courses.index');

Route::get('courses/create', [CoursesController::class, 'create'])
    ->middleware('auth:sanctum')
    ->name('courses.create');

Route::get('courses/{course}', [CoursesController::class, 'show'])
    ->middleware('auth:sanctum')
    ->name('courses.show');


// STUDENTS
Route::post('students', [StudentsController::class, 'store'])
     ->middleware('auth:sanctum')
     ->name('students.store');

Route::get('students', [StudentsController::class, 'index'])
     ->middleware('auth:sanctum')
     ->name('students.index');
     
Route::get('students/create', [StudentsController::class, 'create'])
     ->middleware('auth:sanctum')
    ->name('students.create');

Route::get('students/{student}', [StudentsController::class, 'show'])
    ->middleware('auth:sanctum')
    ->name('students.show');
    
Route::get('students/{student}/edit', [StudentsController::class, 'edit'])
    ->middleware('auth:sanctum')
    ->name('students.edit');

Route::put('students/{student}', [StudentsController::class, 'update'])
    ->middleware('auth:sanctum')
    ->name('students.update');

Route::delete('students/{student}', [StudentsController::class, 'destroy'])
    ->middleware('auth:sanctum')
    ->name('students.destroy');