<?php

namespace Tests\Feature\Courses;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\Course;
use App\Models\Subject;
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

        $courseC = Course::factory()->create(['created_at' => Carbon::now()->subYears(2)]);
        $courseB = Course::factory()->create(['created_at' => Carbon::now()->subYears(1)]);
        $courseA = Course::factory()->create(['created_at' => Carbon::now()]);

        $response = $this->actingAs($this->user())->get(route('courses.index'));

        $response->assertInertia(fn(Assert $page) => 
            $page->component('Courses/Index')
               ->where('courses.data.0.id', $courseA->id)
               ->where('courses.data.1.id', $courseB->id)
               ->where('courses.data.2.id', $courseC->id)
               ->where('courses.data.0.section.id', $courseA->section->id)
               ->where('courses.data.0.degree.id', $courseA->degree->id)
               ->where('courses.data.0.created_at', $courseA->created_at->format('d-m-Y'))
               ->where('courses.links.first', 'http://servm.test/courses?page=1'));
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

        $subjectC = Subject::factory()->create(['title' => 'C Subject']);
        $subjectB = Subject::factory()->create(['title' => 'B Subject']);
        $subjectA = Subject::factory()->create(['title' => 'A Subject']);

        $course = Course::factory()->create();

        $course->subjects()->attach([$subjectC->id, $subjectB->id, $subjectA->id]);

        $response = $this->actingAs($this->user())->get(route('courses.show', $course->id));

        $response->assertInertia(fn(Assert $page) => 
            $page->component('Courses/Show')
                 ->where('course.id', $course->id)
                 ->where('course.degree.title', $course->degree->title)
                 ->where('course.section.name', $course->section->name)
                 ->where('course.subjects.0.title', $subjectA->title)
                 ->where('course.subjects.1.title', $subjectB->title)
                 ->where('course.subjects.2.title', $subjectC->title)
               );
   }

   public function test_guests_can_not_access_the_show_page() 
   {
      // $this->withoutExceptionHandling();

      $course = Course::factory()->create();

      $response = $this->get(route('courses.show', $course->id));

      $response->assertRedirect(route('login'));
   }
}
