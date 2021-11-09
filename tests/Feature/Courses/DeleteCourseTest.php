<?php

namespace Tests\Feature\Courses;

use Tests\TestCase;
use App\Models\Course;
use App\Models\Student;
use Inertia\Testing\Assert;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteCourseTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_user_can_delete_a_course()
    {
        $this->withoutExceptionHandling();

        $course = Course::factory()->create();

        $this->assertDatabaseCount('courses', 1);

        $response = $this->actingAs($this->user())->delete(route('courses.destroy', $course->id));

        $this->assertDatabaseCount('courses', 0);

        $response->assertRedirect(route('courses.index'));
    }

    public function test_a_course_can_not_be_deleted_if_it_has_enrolled_students()
    {
        $this->withoutExceptionHandling();

        $course = Course::factory()->create();
        $student = Student::factory()->create();

        $course->students()->attach($student->id);

        $this->assertDatabaseCount('courses', 1);

        $response = $this->actingAs($this->user())->delete(route('courses.destroy', $course->id));

        $this->assertDatabaseCount('courses', 1);

        $exceptionMessage = 'Can not delete the course ' . $course->section->name . ' ' . $course->degree->title . ', it has enrolled students.';

        $response->assertInertia(fn (Assert $page) => 
            $page->component('Exceptions/Courses/DeleteIfEnrolledStudents')
                 ->where('exception', $exceptionMessage)
        );
    }

    public function test_guests_can_not_delete_a_course()
    {
        // $this->withoutExceptionHandling();

        $course = Course::factory()->create();

        $this->assertDatabaseCount('courses', 1);

        $response = $this->delete(route('courses.destroy', $course->id));

        $this->assertDatabaseCount('courses', 1);

        $response->assertRedirect(route('login'));
    }
}
