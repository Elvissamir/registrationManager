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

class PostCourseStudentTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_create_page_has_the_course_and_list_of_students_that_are_not_enrolled()
    {
        $this->withoutExceptionHandling();
 
        $studentA = Student::factory()->create();
        $studentB = Student::factory()->create();
        $studentB = Student::factory()->create();

        $course = Course::factory()->create();
 
        $course->students()->attach($studentA->id);

        $notEnrolledStudents = Student::notEnrolledInCourse($course->id);

        $response = $this->actingAs($this->user())->get(route('courseStudents.create', $course->id));
 
        $response->assertInertia(fn(Assert $page) => 
            $page->component('CourseStudents/Create')
                 ->where('course', new CourseResource($course))
                 ->where('students', StudentResource::collection($notEnrolledStudents)));
    }

    public function test_a_user_can_enroll_a_student_on_a_course()
    {
        $this->withoutExceptionHandling();

        $studentA = Student::factory()->create();
        $studentB = Student::factory()->create();

        $course = Course::factory()->create();

        $enrollData = [
            'student_id' => $studentB->id,
        ];

        $this->assertEquals($course->students()->count(), 0);

        $response = $this->actingAs($this->user())->post(route('courseStudents.store', $course->id), $enrollData);

        $this->assertEquals($course->students()->count(), 1);

        $this->assertEquals($course->students[0]->first_name, $studentB->first_name);
        $this->assertEquals($course->students[0]->first_name, $studentB->first_name);

        $response->assertRedirect(route('courseStudents.show', $course->id));
    }

  
    public function test_guests_can_not_enroll_students_on_courses()
    {
        // $this->withoutExceptionHandling();

        $studentA = Student::factory()->create();
        $studentB = Student::factory()->create();

        $course = Course::factory()->create();

        $enrollData = [
            'student_id' => $studentB->id,
        ];

        $this->assertEquals($course->students()->count(), 0);

        $response = $this->post(route('courseStudents.store', $course->id), $enrollData);

        $this->assertEquals($course->students()->count(), 0);
        $response->assertRedirect(route('login'));
    }
}
