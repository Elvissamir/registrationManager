<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
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

// STUDENTS
Route::get('students', [StudentsController::class, 'index'])
     ->middleware('auth:sanctum')
     ->name('students.index');

Route::get('students/{student}', [StudentsController::class, 'show'])
     ->middleware('auth:sanctum')
     ->name('students.show');
