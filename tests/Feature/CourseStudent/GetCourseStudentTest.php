<?php

namespace Tests\Feature\CourseStudent;

use Tests\TestCase;
use App\Models\Course;
use App\Models\Student;
use Inertia\Testing\Assert;
use App\Http\Resources\CourseResource;
use App\Http\Resources\StudentResource;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GetCourseStudentTest extends TestCase
{
    use RefreshDatabase;

   public function test_the_show_page_has_the_course_and_list_of_students_enrolled_on_it()
   {
        $this->withoutExceptionHandling();

        $studentA = Student::factory()->create();
        $studentB = Student::factory()->create();

        $course = Course::factory()->create();

        $course->students()->attach($studentA->id);
        $course->students()->attach($studentB->id);

        $response = $this->actingAs($this->user())->get(route('courseStudents.show', $course->id));

        $response->assertInertia(fn(Assert $page) => 
        $page->component('CourseStudents/Show')
                ->where('course', new CourseResource($course))
                ->where('students', StudentResource::collection($course->students)));
   }

   public function test_guests_can_not_access_the_show_page()
   {
        //$this->withoutExceptionHandling();

        $course = Course::factory()->create();

        $response = $this->get(route('courseStudents.show', $course->id));

        $response->assertRedirect(route('login'));
   }
}
