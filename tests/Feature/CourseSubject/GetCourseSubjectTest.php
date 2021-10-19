<?php

namespace Tests\Feature\CourseSubject;

use Tests\TestCase;
use App\Models\Course;
use App\Models\Subject;
use Inertia\Testing\Assert;
use App\Http\Resources\CourseResource;
use App\Http\Resources\SubjectResource;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GetCourseSubjectTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_show_page_has_the_course_and_list_of_added_subjects()
    {
        $this->withoutExceptionHandling();

        $subjectA = Subject::factory()->create();
        $subjectB = Subject::factory()->create();

        $course = Course::factory()->create();

        $course->subjects()->attach($subjectA->id);
        $course->subjects()->attach($subjectB->id);

        $response = $this->actingAs($this->user())->get(route('courseSubjects.show', $course->id));

        $response->assertInertia(fn(Assert $page) => 
        $page->component('CourseSubjects/Show')
                ->where('course', new CourseResource($course))
                ->where('subjects', SubjectResource::collection($course->subjects)));
    }

    public function test_guests_can_not_acess_the_show_page()
    {
        //$this->withoutExceptionHandling();

        $subjectA = Subject::factory()->create();
        $subjectB = Subject::factory()->create();

        $course = Course::factory()->create();

        $course->subjects()->attach($subjectA->id);
        $course->subjects()->attach($subjectB->id);

        $response = $this->get(route('courseSubjects.show', $course->id));

        $response->assertRedirect(route('login'));
    }

    public function test_the_create_page_has_the_course_and_list_of_subjects_that_havent_been_added_to_the_course()
    {
        $this->withoutExceptionHandling();

        $subjectA = Subject::factory()->create();
        $subjectB = Subject::factory()->create();
        $subjectC = Subject::factory()->create();

        $course = Course::factory()->create();

        $course->subjects()->attach($subjectA->id);
        $course->subjects()->attach($subjectB->id);

        $notAddedSubjects = Subject::notAddedToCourse($course->id);

        $response = $this->actingAs($this->user())->get(route('courseSubjects.create', $course->id));

        $response->assertInertia(fn(Assert $page) => 
        $page->component('CourseSubjects/Create')
                ->where('course', new CourseResource($course))
                ->where('subjects', SubjectResource::collection($notAddedSubjects)));
    }

    public function test_guests_can_not_access_the_create_page()
    {
        // $this->withoutExceptionHandling();

        $subjectA = Subject::factory()->create();
        $subjectB = Subject::factory()->create();
        $subjectC = Subject::factory()->create();

        $course = Course::factory()->create();

        $response = $this->get(route('courseSubjects.create', $course->id));

        $response->assertRedirect(route('login'));
    }

}
