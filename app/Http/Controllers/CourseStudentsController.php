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
    public function index(Course $course)
    {
        $course->load(['section', 'degree']);
        $students = $course->students()->orderBy('first_name', 'asc')->orderBy('last_name', 'asc')->paginate(10);

        return Inertia::render('CourseStudents/Index', [
            'course' => new CourseResource($course),
            'students' => StudentResource::collection($students),
        ]);
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
        if ($course->status == 'finished')
            return redirect(route('courseStudents.index', $course->id));
        
        $student = Student::find($request->validated()['student_id']);

        if ($student->currentCourse() != Null)
            return redirect(route('courseStudents.index', $course->id));

        $course->students()->attach($student->id);

        $subjectsToReset = [];
        $subjectsToAssign = [];
        $studentSubjectIds = $student->subjects()->allRelatedIds()->toArray();
        $courseSubjectIds = $course->subjects()->allRelatedIds()->toArray();

        foreach ($courseSubjectIds as $subjectId)
        {
            if (in_array($subjectId, $studentSubjectIds))
                array_push($subjectsToReset, $subjectId);
            else 
                array_push($subjectsToAssign, $subjectId);
        }

        if (count($subjectsToReset) > 0) {
            foreach ($subjectsToReset as $id)
                $student->subjects()->updateExistingPivot($id, ['first' => 0, 'second' => 0, 'third' => 0, 'fourth' => 0]);
        }

        if (count($subjectsToAssign) > 0)
            $student->subjects()->attach($subjectsToAssign);

        return redirect(route('courseStudents.index', $course->id));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course, Student $student)
    {
        $course->load(['degree', 'section', 'subjects']);
        
        $courseSubjectsIds = [];
        
        foreach ($course->subjects as $subject)
        {
            array_push($courseSubjectsIds, $subject->id);
        }
        
        $student->load(['subjects' => function ($query) use($courseSubjectsIds) {
            $query->whereIn('subjects.id', $courseSubjectsIds);
        }]);

        return Inertia::render('CourseStudents/Show', [
            'course' => new CourseResource($course),
            'student' => new StudentResource($student),
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
    public function destroy(Course $course, Student $student)
    {
        if ($course->status == 'finished')
            return redirect(route('courseStudents.index', $course->id));

        $course->load(['students', 'subjects']);
        $course->students()->detach($student->id);

        foreach ($course->subjects as $subject)
        {
            $student->subjects()->detach($subject->id);
        }

        return redirect(route('courseStudents.index', $course->id));
    }
}
