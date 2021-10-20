<?php

namespace Tests\Feature\CourseSubject;

use Tests\TestCase;
use App\Models\Course;
use App\Models\Subject;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostCourseSubjectTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_user_can_add_a_subject_to_a_course()
    {
        $this->withoutExceptionHandling();

        $course = Course::factory()->create();

        $subjectA = Subject::factory()->create();
        $subjectB = Subject::factory()->create();

        $subjectData = [
            'subject_id' => $subjectA->id,
        ];

        $this->assertEquals(0, $course->subjects()->count());

        $response = $this->actingAs($this->user())->post(route('courseSubjects.store', $course->id), $subjectData);

        $this->assertEquals(1, $course->subjects()->count());

        $this->assertEquals($subjectA->id, $course->subjects[0]->id);
        $this->assertEquals($subjectA->title, $course->subjects[0]->title);

        $response->assertRedirect(route('courseSubjects.show', $course->id));
    }

    public function test_guests_can_not_add_a_subject_to_a_course()
    {
        // $this->withoutExceptionHandling();

        $course = Course::factory()->create();

        $subjectA = Subject::factory()->create();
        $subjectB = Subject::factory()->create();

        $subjectData = [
            'subject_id' => $subjectA->id,
        ];

        $this->assertEquals(0, $course->subjects()->count());

        $response = $this->post(route('courseSubjects.store', $course->id), $subjectData);

        $this->assertEquals(0, $course->subjects()->count());

        $response->assertRedirect(route('login'));
    }


    public function test_the_subject_id_is_required()
    {
        // $this->withoutExceptionHandling();

        $course = Course::factory()->create();

        $subjectA = Subject::factory()->create();
        $subjectB = Subject::factory()->create();

        $subjectData = [
            'subject_id' => '',
        ];

        $this->assertEquals(0, $course->subjects()->count());

        $response = $this->actingAs($this->user())->post(route('courseSubjects.store', $course->id), $subjectData);

        $this->assertEquals(0, $course->subjects()->count());

        $response->assertSessionHasErrors('subject_id');
        $response->assertRedirect();
    }

    public function test_the_subject_id_must_exist()
    {
        // $this->withoutExceptionHandling();

        $course = Course::factory()->create();

        $subjectA = Subject::factory()->create();
        $subjectB = Subject::factory()->create();

        $subjectData = [
            'subject_id' => rand(1000, 2000),
        ];

        $this->assertEquals(0, $course->subjects()->count());

        $response = $this->actingAs($this->user())->post(route('courseSubjects.store', $course->id), $subjectData);

        $this->assertEquals(0, $course->subjects()->count());

        $response->assertSessionHasErrors('subject_id');
        $response->assertRedirect();
    }
}
