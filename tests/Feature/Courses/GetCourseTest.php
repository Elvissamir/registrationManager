<?php

namespace Tests\Feature\Courses;

use Tests\TestCase;
use App\Models\Course;
use Inertia\Testing\Assert;
use App\Http\Resources\CourseResource;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GetCourseTest extends TestCase
{
   use RefreshDatabase;

   public function test_the_course_index_page_exists_and_has_the_courses_data()
   {
        $this->withoutExceptionHandling();

        $courses = Course::factory()->count(2)->create();

        $response = $this->actingAs($this->user())->get(route('courses.index'));

        $response->assertInertia(fn(Assert $page) => 
            $page->component('Courses/Index')
                 ->has('courses'));
   }

   public function test_guests_can_not_access_the_index_page() 
   {
      // $this->withoutExceptionHandling();

      $courses = Course::factory()->create();

      $response = $this->get(route('courses.index'));

      $response->assertRedirect(route('login'));
   }

   public function test_the_course_show_page_exists_and_has_the_course_data()
   {
        $this->withoutExceptionHandling();

        $course = Course::factory()->create();

        $response = $this->actingAs($this->user())->get(route('courses.show', $course->id));

        $response->assertInertia(fn(Assert $page) => 
            $page->component('Courses/Show')
                 ->where('course', new CourseResource($course)));
   }

   public function test_guests_can_not_access_the_show_page() 
   {
      // $this->withoutExceptionHandling();

      $course = Course::factory()->create();

      $response = $this->get(route('courses.show', $course->id));

      $response->assertRedirect(route('login'));
   }

}
