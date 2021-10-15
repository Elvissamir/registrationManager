<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Resources\StudentResource;
use App\Http\Requests\StoreStudentRequest;

class StudentsController extends Controller
{
    public function index() {

        $students = Student::all();

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

        Student::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'age' => $request->age,
            'phone_mobile' => $request->phone_mobile,
            'phone_house' => $request->phone_house,
        ]);

        return redirect(route('students.index'));
    }

}
