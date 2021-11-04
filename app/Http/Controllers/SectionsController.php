<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Section;
use Illuminate\Http\Request;
use App\Http\Resources\CourseResource;
use App\Http\Resources\SectionResource;
use App\Http\Requests\StoreSectionRequest;
use App\Exceptions\CanNotDeleteAssignedSection;

class SectionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sections = Section::orderBy('name', 'asc')->get();

        return Inertia::render('Sections/Index', [
            'sections' => SectionResource::collection($sections),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Sections/Create', []);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSectionRequest $request)
    {
        Section::create([
            'name' => strtoupper($request->validated()['name']),
        ]);

        return redirect(route('sections.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\section  $section
     * @return \Illuminate\Http\Response
     */
    public function show(Section $section)
    {
        $courses = $section->courses;

        return Inertia::render('Sections/Show', [
            'section' => new SectionResource($section),
            'courses' => CourseResource::collection($courses),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\section  $section
     * @return \Illuminate\Http\Response
     */
    public function edit(Section $section)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\section  $section
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Section $section)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\section  $section
     * @return \Illuminate\Http\Response
     */
    public function destroy(Section $section)
    {   
        try {
            $section->delete();
        }
        catch (CanNotDeleteAssignedSection $exception) {
            return Inertia::render('Exceptions/Sections/Assigned', [
                'exception' => $exception->getMessage(),
            ]);
        }

        return redirect(route('sections.index'));
    }
}
