<?php

namespace Tests\Feature\Degrees;

use Tests\TestCase;
use App\Models\Course;
use App\Models\Degree;
use Inertia\Testing\Assert;
use App\Http\Resources\CourseResource;
use App\Http\Resources\DegreeResource;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GetDegreeTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_index_page_exists()
    {
        $this->withoutExceptionHandling();
 
        Degree::factory()->count(2)->create();
 
        $response = $this->actingAs($this->user())->get(route('degrees.index'));
 
        $degrees = Degree::orderBy('title', 'asc')->get();
 
        $response->assertInertia(fn(Assert $page) => 
            $page->component('Degrees/Index')
                 ->where('degrees', DegreeResource::collection($degrees)));
    }
 
    public function test_the_show_page_exists()
    {
        $this->withoutExceptionHandling();
 
        $degree = Degree::factory()->create();
 
        $courseB = Course::factory()->create(['degree_id' => $degree->id]);
        $courseA = Course::factory()->create(['degree_id' => $degree->id]);
         
        $response = $this->actingAs($this->user())->get(route('degrees.show', $degree->id));
 
        $courses = $degree->courses;
 
        $response->assertInertia(fn(Assert $page) => 
             $page->component('Degrees/Show')
                  ->where('degree', new DegreeResource($degree))
                  ->where('courses', CourseResource::collection($courses)));
    }
 
    public function test_only_authenticated_users_can_see_the_index_page()
    {
       // $this->withoutExceptionHandling();
 
       $response = $this->get(route('degrees.index'));
 
       $response->assertRedirect(route('login'));
    }
}
