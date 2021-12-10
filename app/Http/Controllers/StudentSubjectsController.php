<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Course;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;
use App\Http\Resources\CourseResource;
use App\Http\Resources\StudentResource;
use App\Http\Resources\SubjectResource;
use App\Http\Requests\UpdateStudentScoreRequest;

class StudentSubjectsController extends Controller
{
    public function edit(Student $student, Subject $subject)
    {
        $course = Course::whereHas('students', function ($query) use ($student) {$query->where('students.id', $student->id);})
                        ->whereHas('subjects', function ($query) use ($subject) {$query->where('subjects.id', $subject->id);})
                        ->with(['degree', 'section'])
                        ->first();

        $student->load(['subjects' => function ($query) use ($subject) { $query->where('subjects.id', $subject->id); }]);

        return Inertia::render('StudentSubjects/Edit', [
            'course' => new CourseResource($course),
            'student' => new StudentResource($student),
            'subject' => new SubjectResource($student->subjects[0])
        ]);
    }

    public function update(UpdateStudentScoreRequest $request, Student $student, Subject $subject)
    {
        $student->subjects()->updateExistingPivot($subject->id, $request->validated());

        $course = Course::whereHas('students', function ($query) use ($student) {$query->where('students.id', $student->id);})
                        ->whereHas('subjects', function ($query) use ($subject) {$query->where('subjects.id', $subject->id);})
                        ->first();

        return redirect(route('courseStudents.show', [$course->id, $student->id]));
    }
}
