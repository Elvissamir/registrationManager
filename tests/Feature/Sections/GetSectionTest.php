<?php

namespace Tests\Feature\Sections;

use Tests\TestCase;
use App\Models\Course;
use App\Models\Section;
use Inertia\Testing\Assert;
use App\Http\Resources\CourseResource;
use App\Http\Resources\SectionResource;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GetSectionTest extends TestCase
{
   use RefreshDatabase;

   public function test_the_index_page_exists()
   {
        $this->withoutExceptionHandling();

        Section::factory()->count(2)->create();

        $response = $this->actingAs($this->user())->get(route('sections.index'));

        $sections = Section::orderBy('name', 'asc')->get();

        $response->assertInertia(fn(Assert $page) => 
            $page->component('Sections/Index')
                 ->where('sections', SectionResource::collection($sections)));
   }

   public function test_the_show_page_exists()
   {
        // $this->withoutExceptionHandling();

        $section = Section::factory()->create();

        $courseB = Course::factory()->create(['section_id' => $section->id]);
        $courseA = Course::factory()->create(['section_id' => $section->id]);
        
        $response = $this->actingAs($this->user())->get(route('sections.show', $section->id));

        $courses = $section->courses;

        $response->assertInertia(fn(Assert $page) => 
            $page->component('Sections/Show')
                 ->where('section', new SectionResource($section))
                 ->where('courses', CourseResource::collection($courses)));
   }

   public function test_only_authenticated_users_can_see_the_index_page()
   {
      // $this->withoutExceptionHandling();

      $response = $this->get(route('sections.index'));

      $response->assertRedirect(route('login'));
   }
}
