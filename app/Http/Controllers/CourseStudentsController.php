<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Course;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Resources\CourseResource;
use App\Http\Resources\StudentResource;
use App\Http\Requests\EnrollStudentRequest;

class CourseStudentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Course $course)
    {
        $notEnrolledStudents = Student::notEnrolledInCourse($course->id);

        return Inertia::render('CourseStudents/Create', [
            'course' => new CourseResource($course),
            'students' => StudentResource::collection($notEnrolledStudents),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EnrollStudentRequest $request, Course $course)
    {
        $course->students()->attach($request->student_id);
        
        return redirect(route('courseStudents.show', $course->id));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        $course->load(['section', 'degree']);
        $students = $course->students()->orderBy('first_name', 'asc')->orderBy('last_name', 'asc')->paginate(10);

        return Inertia::render('CourseStudents/Show', [
            'course' => new CourseResource($course),
            'students' => StudentResource::collection($students),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
