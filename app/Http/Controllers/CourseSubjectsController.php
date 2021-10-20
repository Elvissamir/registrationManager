<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Course;
use App\Models\Subject;
use Illuminate\Http\Request;
use App\Http\Resources\CourseResource;
use App\Http\Resources\SubjectResource;
use App\Http\Requests\StoreCourseSubjectRequest;

class CourseSubjectsController extends Controller
{
    public function show(Course $course)
    {
        $subjects = $course->subjects;

        return Inertia::render('CourseSubjects/Show', [
            'course' => new CourseResource($course),
            'subjects' => SubjectResource::collection($subjects),
        ]);
    }

    public function create(Course $course)
    {
        $subjects = Subject::notAddedToCourse($course->id);
        
        return Inertia::render('CourseSubjects/Create', [
            'course' => new CourseResource($course),
            'subjects' => SubjectResource::collection($subjects),
        ]);
    }

    public function store(StoreCourseSubjectRequest $request, Course $course)
    {
        $course->subjects()->attach($request->subject_id);

        return redirect(route('courseSubjects.show', $course->id));
    }
}