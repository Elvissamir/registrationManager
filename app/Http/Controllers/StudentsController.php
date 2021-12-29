<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Resources\CourseResource;
use App\Http\Resources\StudentResource;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Exceptions\CanNotDeleteEnrolledStudent;
use App\Exceptions\CanNotDeleteStudentWithFinishedCourses;

class StudentsController extends Controller
{
    public function index(Request $request) {

        if (array_key_exists('orderBy', $request->query()))
        {

            if ($request->query('orderBy') == 'registration') {

                $students = Student::orderBy('created_at', 'desc')->paginate(10);
                $students->appends(['orderBy' => 'registration']);
                $order = 'registration';
            }

            else {
                $students = Student::orderBy('first_name', 'asc')->orderBy('last_name', 'asc')->paginate(10);
                $students->appends(['orderBy' => 'name']);
                $order = 'name';    
            }
        }
        else 
        {
            $students = Student::paginate(10);
            $order = 'id';
        }

        return Inertia::render('Students/Index', [
            'students' => StudentResource::collection($students),
            'order' => $order,
        ]);
    }

    public function show(Student $student) {

        $finishedCourses = $student->courses()->where('status', 'finished')->with(['section', 'degree'])->get();
        $activeCourses = $student->courses()->where('status', 'active')->with(['section', 'degree'])->get();

        return Inertia::render('Students/Show', [
            'student' => new StudentResource($student),
            'finishedCourses' => CourseResource::collection($finishedCourses),
            'activeCourses' => CourseResource::collection($activeCourses),
        ]);
    }

    public function create() {
        return Inertia::render('Students/Create', []);
    }

    public function store(StoreStudentRequest $request) {

        Student::create($request->validated());

        return redirect(route('students.index'));
    }

    public function edit(Student $student) {
        
        return Inertia::render('Students/Edit', [
            'student' => new StudentResource($student),
        ]);
    }

    public function update(UpdateStudentRequest $request, Student $student) {
        
        $student->update($request->validated());

        return redirect(route('students.index'));
    }

    public function destroy(Student $student) {

        try {
            $student->delete();
        }
        catch (CanNotDeleteEnrolledStudent $exception) {
            return Inertia::render('Exceptions/Students/DeleteEnrolled', [
                'exception' => $exception->getMessage(),
            ]);       
        }
        catch (CanNotDeleteStudentWithFinishedCourses $exception)
        {
            return Inertia::render('Exceptions/Students/DeleteIfHasFinishedCourses', [
                'exception' => $exception->getMessage(),
            ]); 
        }

        return redirect(route('students.index'));
    }

}
