<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Course;
use App\Models\Subject;
use Illuminate\Http\Request;
use App\Http\Resources\CourseResource;
use App\Http\Resources\SubjectResource;
use App\Http\Resources\TeacherResource;
use App\Http\Requests\StoreSubjectRequest;
use App\Http\Requests\UpdateSubjectRequest;
use App\Exceptions\CanNotDeleteAssignedSubjects;

class SubjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (array_key_exists('orderBy', $request->query())) {

            if ($request->query('orderBy') == 'credits') {

                $subjects = Subject::orderBy('credits', 'desc')->paginate(10);
                $subjects->appends(['orderBy' => 'credits']);
                $order = 'credits';    
            }

            else {
                $subjects = Subject::orderBy('title', 'asc')->paginate(10);
                $subjects->appends(['orderBy' => 'title']);
                $order = 'title';
            }
        }
        else {
            $subjects = Subject::paginate(10);
            $order = 'id';
        }

        return Inertia::render('Subjects/Index', [
            'subjects' => SubjectResource::collection($subjects),
            'order' => $order,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $courses = Course::all();

        return Inertia::render('Subjects/Create', [
            'courses' => CourseResource::collection($courses),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSubjectRequest $request)
    {
        Subject::create($request->validated());

        return redirect(route('subjects.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\r  $r
     * @return \Illuminate\Http\Response
     */
    public function show(Subject $subject)
    {
        $teachers = $subject->teachers()->orderBy('first_name', 'asc')->orderBy('last_name', 'asc')->paginate(10);

        return Inertia::render('Subjects/Show', [
            'subject' => new SubjectResource($subject),
            'teachers' => TeacherResource::collection($teachers),
        ]);       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\r  $r
     * @return \Illuminate\Http\Response
     */
    public function edit(Subject $subject)
    {
        return Inertia::render('Subjects/Edit', [
            'subject' => new SubjectResource($subject),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\r  $r
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSubjectRequest $request, Subject $subject)
    {
        $subject->update($request->validated());

        return redirect(route('subjects.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\r  $r
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subject $subject)
    {
        try {
            $subject->delete();
        }
        catch (CanNotDeleteAssignedSubjects $exception) {
            return Inertia::render('Exceptions/Subjects/Assigned', [
                'exception' => $exception->getMessage(),
            ]);
        }

        return redirect(route('subjects.index'));
    }
}
