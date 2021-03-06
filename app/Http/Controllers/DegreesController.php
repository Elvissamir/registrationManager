<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Degree;
use Illuminate\Http\Request;
use App\Http\Resources\CourseResource;
use App\Http\Resources\DegreeResource;
use App\Http\Requests\StoreDegreeRequest;
use App\Http\Requests\UpdateDegreeRequest;
use App\Exceptions\CanNotDeleteAssignedDegree;

class DegreesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $degrees = Degree::orderBy('title', 'asc')->get();

        return Inertia::render('Degrees/Index', [
            'degrees' => DegreeResource::collection($degrees),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Degrees/Create', []);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDegreeRequest $request)
    {
        Degree::create($request->validated());

        return redirect(route('degrees.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Degree  $degree
     * @return \Illuminate\Http\Response
     */
    public function show(Degree $degree)
    {
        $courses = $degree->courses;

        return Inertia::render('Degrees/Show', [
            'degree' => new DegreeResource($degree),
            'courses' => CourseResource::collection($courses),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Degree  $degree
     * @return \Illuminate\Http\Response
     */
    public function edit(Degree $degree)
    {
        return Inertia::render('Degrees/Edit', [
            'degree' => new DegreeResource($degree),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Degree  $degree
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDegreeRequest $request, Degree $degree)
    {
        $degree->update($request->validated());

        return redirect(route('degrees.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Degree  $degree
     * @return \Illuminate\Http\Response
     */
    public function destroy(Degree $degree)
    {
        try {
            $degree->delete();
        }
        catch (CanNotDeleteAssignedDegree $exception) 
        {
            return Inertia::render('Exceptions/Degrees/Assigned', [
                'exception' => $exception->getMessage(),
            ]);
        }

        return redirect(route('degrees.index'));
    }
}
