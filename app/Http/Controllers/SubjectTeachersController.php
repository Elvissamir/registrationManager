<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;
use App\Http\Resources\SubjectResource;
use App\Http\Resources\TeacherResource;

class SubjectTeachersController extends Controller
{
    
    public function index(Subject $subject)
    {
        
    }

    public function show(Subject $subject)
    {
        $assignedTeachers = $subject->teachers;

        return Inertia::render('SubjectTeachers/Show', [
            'subject' => new SubjectResource($subject),
            'teachers' => TeacherResource::collection($assignedTeachers),
        ]);
    }

    public function create(Subject $subject)
    {
        $teachers = Teacher::all();

        return Inertia::render('SubjectTeachers/Create', [
            'subject' => new SubjectResource($subject),
            'teachers' => TeacherResource::collection($teachers),
        ]);
    }
}
