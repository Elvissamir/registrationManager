<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\CoursesController;
use App\Http\Controllers\DegreesController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\SectionsController;
use App\Http\Controllers\StudentsController;
use App\Http\Controllers\SubjectsController;
use App\Http\Controllers\CourseStudentsController;
use App\Http\Controllers\CourseSubjectsController;
use App\Http\Controllers\StudentSubjectsController;
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


// SECTIONS
Route::resource('sections', SectionsController::class)->middleware('auth:sanctum');

// DEGREES
Route::resource('degrees', DegreesController::class)->middleware('auth:sanctum');


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

// COURSES SUBJECTS    
Route::get('courses/{course}/subjects/create', [CourseSubjectsController::class, 'create'])
     ->name('courseSubjects.create')
     ->middleware('auth:sanctum');

Route::post('courses/{course}/subjects', [CourseSubjectsController::class, 'store'])
     ->name('courseSubjects.store')
     ->middleware('auth:sanctum');

// COURSE STUDENTS
Route::get('courses/{course}/students', [CourseStudentsController::class, 'index'])
     ->name('courseStudents.index')
     ->middleware('auth:sanctum');

Route::post('courses/{course}/students', [CourseStudentsController::class, 'store'])
     ->name('courseStudents.store')
     ->middleware('auth:sanctum');

Route::get('courses/{course}/students/create', [CourseStudentsController::class, 'create'])
     ->name('courseStudents.create')
     ->middleware('auth:sanctum');

Route::get('courses/{course}/students/{student}', [CourseStudentsController::class, 'show'])
     ->name('courseStudents.show')
     ->middleware('auth:sanctum');

Route::delete('courses/{course}/students/{student}', [CourseStudentsController::class, 'destroy'])
     ->name('courseStudents.destroy')
     ->middleware('auth:sanctum');

// TEACHERS
Route::resource('teachers', TeacherController::class)->middleware('auth:sanctum');

// STUDENTS
Route::resource('students', StudentsController::class)->middleware('auth:sanctum');

// STUDENT SUBJECTS
Route::get('students/{student}/subjects/{subject}/edit', [StudentSubjectsController::class, 'edit'])
     ->name('studentSubjects.edit')
     ->middleware('auth:sanctum');

Route::put('students/{student}/subjects/{subject}', [StudentSubjectsController::class, 'update'])
     ->name('studentSubjects.update')
     ->middleware('auth:sanctum');