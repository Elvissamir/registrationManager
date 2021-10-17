<?php

namespace Tests\Feature\Courses;

use Tests\TestCase;
use App\Models\Course;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteCourseRequestTest extends TestCase
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
