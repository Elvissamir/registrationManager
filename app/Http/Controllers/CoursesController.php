<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Course;
use App\Models\Degree;
use App\Models\Section;
use Illuminate\Http\Request;
use App\Http\Resources\CourseResource;
use App\Http\Resources\DegreeResource;
use App\Http\Resources\SectionResource;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;

class CoursesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $courses = Course::with(['section', 'degree'])->get();

        return Inertia::render('Courses/Index', [
            'courses' => CourseResource::collection($courses),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $degrees = Degree::all();
        $sections = Section::all();

        return Inertia::render('Courses/Create', [
            'sections' => SectionResource::collection($sections),
            'degrees' => DegreeResource::collection($degrees),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCourseRequest $request)
    {
        Section::findOrFail($request->section_id);
        Degree::findOrFail($request->degree_id);

        Course::create($request->all());

        return redirect(route('courses.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        return Inertia::render('Courses/Show', [
            'course' => new CourseResource($course),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
        $sections = Section::all();
        $degrees = Degree::all();

        return Inertia::render('Courses/Edit', [
            'course' => new CourseResource($course),
            'sections' => SectionResource::collection($sections),
            'degrees' => DegreeResource::collection($degrees),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCourseRequest $request, Course $course)
    {
        Section::findOrFail($request->section_id);
        Degree::findOrFail($request->degree_id);

        $course->update($request->all());

        return redirect(route('courses.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        $course->delete();

        return redirect(route('courses.index'));
    }
}
