<?php

namespace Tests\Feature\Students;

use Tests\TestCase;
use App\Models\Student;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteStudentRequestTest extends TestCase
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
