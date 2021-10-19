<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\CoursesController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\StudentsController;
use App\Http\Controllers\SubjectsController;
use App\Http\Controllers\CourseStudentsController;
use App\Http\Controllers\SubjectTeachersController;

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

// SUBJECTS TEACHERS
Route::get('subjects/{subject}/teachers', [SubjectTeachersController::class, 'show'])
     ->name('subjectTeachers.show')
     ->middleware('auth:sanctum');

Route::post('subjects/{subject}/teachers', [SubjectTeachersController::class, 'store'])
     ->name('subjectTeachers.store')
     ->middleware('auth:sanctum');

Route::get('subjects/{subject}/teachers/create', [SubjectTeachersController::class, 'create'])
     ->name('subjectTeachers.create')
     ->middleware('auth:sanctum');

// COURSES
Route::resource('courses', CoursesController::class)->middleware('auth:sanctum');

// COURSES STUDENTS
Route::get('courses/{course}/students', [CourseStudentsController::class, 'show'])
     ->name('courseStudents.show')
     ->middleware('auth:sanctum');

Route::post('courses/{course}/students', [CourseStudentsController::class, 'store'])
     ->name('courseStudents.store')
     ->middleware('auth:sanctum');

Route::get('courses/{course}/students/create', [CourseStudentsController::class, 'create'])
     ->name('courseStudents.create')
     ->middleware('auth:sanctum');

// TEACHERS
Route::resource('teachers', TeacherController::class)->middleware('auth:sanctum');

// STUDENTS
Route::resource('students', StudentsController::class)->middleware('auth:sanctum');
