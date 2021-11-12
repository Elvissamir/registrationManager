<?php

namespace Tests\Feature\Subjects;

use Tests\TestCase;
use App\Models\Course;
use App\Models\Subject;
use Inertia\Testing\Assert;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteSubjectTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_user_can_delete_a_subject()
    {
       $this->withoutExceptionHandling();

       $subject = Subject::factory()->create();

       $this->assertDatabaseCount('subjects', 1);

       $response = $this->actingAs($this->user())->delete(route('subjects.destroy', $subject->id));

       $this->assertDatabaseCount('subjects', 0);

       $response->assertRedirect(route('subjects.index'));
    }

    public function test_guests_can_not_delete_a_subject()
    {
       // $this->withoutExceptionHandling();

       $subject = Subject::factory()->create();

       $this->assertDatabaseCount('subjects', 1);

       $response = $this->delete(route('subjects.destroy', $subject->id));

       $this->assertDatabaseCount('subjects', 1);

       $response->assertRedirect(route('login'));
    }

    public function test_a_subject_can_not_be_deleted_if_it_has_courses()
    {
       $this->withoutExceptionHandling();

       $subject = Subject::factory()->create();
       $course = Course::factory()->create();

       $subject->courses()->attach($course->id);

       $this->assertDatabaseCount('subjects', 1);

       $response = $this->actingAs($this->user())->delete(route('subjects.destroy', $subject->id));

       $this->assertDatabaseCount('subjects', 1);

       $response->assertInertia(fn (Assert $page) => 
            $page->component('Exceptions/Subjects/Assigned')
                 ->where('exception', 'The subject can not be deleted, it has been assigned to some courses.')
       );
    }
}
