<?php

namespace Tests\Feature\Students;

use Tests\TestCase;
use App\Models\Course;
use App\Models\Student;
use Inertia\Testing\Assert;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteStudentTest extends TestCase
{
    use RefreshDatabase;

   public function test_a_user_can_delete_a_student()
   {
        $this->withoutExceptionHandling();

        $student = Student::factory()->create();

        $this->assertDatabaseCount('students', 1);

        $response = $this->actingAs($this->user())->delete(route('students.destroy', $student->id));

        $this->assertDatabaseCount('students', 0);

        $response->assertRedirect(route('students.index'));
   }

   public function test_can_not_delete_student_if_he_is_enrolled_on_a_course()
   {
        $this->withoutExceptionHandling();

        $student = Student::factory()->create(); 
        $course = Course::factory()->create();

        $student->courses()->attach($course->id);

        $this->assertDatabaseCount('students', 1);

        $response = $this->actingAs($this->user())->delete(route('students.destroy', $student->id));

        $this->assertDatabaseCount('students', 1);

        $response->assertInertia(fn(Assert $page) => 
          $page->component('Exceptions/Students/DeleteEnrolled')
               ->where('exception', 'Could not delete student. The student is currently enrolled on a course.'));
   }

   public function test_can_not_delete_student_if_he_has_finished_courses()
   {
        $this->withoutExceptionHandling();

        $student = Student::factory()->create(); 
        $course = Course::factory()->create(['status' => 'finished']);

        $student->courses()->attach($course->id);

        $this->assertDatabaseCount('students', 1);

        $response = $this->actingAs($this->user())->delete(route('students.destroy', $student->id));

        $this->assertDatabaseCount('students', 1);

        $response->assertInertia(fn(Assert $page) => 
          $page->component('Exceptions/Students/DeleteIfHasFinishedCourses')
               ->where('exception', 'Could not delete student. The student has some finished courses.'));
   }

   public function test_guests_can_not_delete_students()
   {
        // $this->withoutExceptionHandling();

        $student = Student::factory()->create();

        $this->assertDatabaseCount('students', 1);

        $response = $this->delete(route('students.destroy', $student->id));

        $this->assertDatabaseCount('students', 1);

        $response->assertRedirect(route('login'));
   }
}
