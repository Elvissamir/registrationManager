<?php

namespace Tests\Feature\Teachers;

use Tests\TestCase;
use App\Models\Subject;
use App\Models\Teacher;
use Inertia\Testing\Assert;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteTeacherTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_user_can_delete_a_teacher()
    {
        $this->withoutExceptionHandling();

        $teacher = Teacher::factory()->create();

        $this->assertDatabaseCount('teachers', 1);

        $response = $this->actingAs($this->user())->delete(route('teachers.destroy', $teacher->id));

        $this->assertDatabaseCount('teachers', 0);

        $response->assertRedirect(route('teachers.index'));
    }

    public function test_guests_can_not_delete_a_teacher()
    {
        // $this->withoutExceptionHandling();

        $teacher = Teacher::factory()->create();

        $this->assertDatabaseCount('teachers', 1);

        $response = $this->delete(route('teachers.destroy', $teacher->id));

        $this->assertDatabaseCount('teachers', 1);

        $response->assertRedirect(route('login'));
    }

    public function test_teachers_can_not_be_deleted_if_they_are_assigned_to_or_have_taught_subjects()
    {
        // $this->withoutExceptionHandling();

        $teacher = Teacher::factory()->create();
        $subject = Subject::factory()->create();

        $teacher->subjects()->attach($subject->id);

        $this->assertDatabaseCount('teachers', 1);

        $response = $this->actingAs($this->user())->delete(route('teachers.destroy', $teacher->id));

        $this->assertDatabaseCount('teachers', 1);

        $response->assertInertia(fn (Assert $page) => 
            $page->component('Exceptions/Teachers/Assigned')
                 ->where('exception', 'Could not delete. The teacher is assigned to a subject or has taught subjects in the past.')
        );
    }
}
