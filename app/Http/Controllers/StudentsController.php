<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Resources\StudentResource;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;

class StudentsController extends Controller
{
    public function index(Request $request) {

        if (array_key_exists('orderBy', $request->query()))
        {
            if ($request->query('orderBy') == 'name')
                $students = Student::orderBy('first_name', 'asc')->orderBy('last_name', 'asc')->paginate(10);
            else if ($request->query('orderBy') == 'registration')
                $students = Student::orderBy('created_at', 'desc')->paginate(10);
        }
        else 
        {
            $students = Student::paginate(10);
        }

        return Inertia::render('Students/Index', [
            'students' => StudentResource::collection($students),
        ]);
    }

    public function show(Student $student) {
        
        return Inertia::render('Students/Show', [
            'student' => new StudentResource($student),
        ]);
    }

    public function create() {
        return Inertia::render('Students/Create', []);
    }

    public function store(StoreStudentRequest $request) {

        Student::create($request->all());

        return redirect(route('students.index'));
    }

    public function edit(Student $student) {
        
        return Inertia::render('Students/Edit', [
            'student' => new StudentResource($student),
        ]);
    }

    public function update(UpdateStudentRequest $request, Student $student) {
        
        $student->update($request->all());

        return redirect(route('students.index'));
    }

    public function destroy(Student $student) {

        $student->delete();

        return redirect(route('students.index'));
    }

}
