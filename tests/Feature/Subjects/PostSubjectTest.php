<?php

namespace Tests\Feature\Subjects;

use Tests\TestCase;
use App\Models\Course;
use Illuminate\Support\Str;
use Inertia\Testing\Assert;
use App\Http\Resources\CourseResource;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostSubjectTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_create_subject_page_exists_and_has_the_list_of_courses()
    {
        $this->withoutExceptionHandling();

        $courses = Course::factory()->count(2)->create();

        $response = $this->actingAs($this->user())->get(route('subjects.create'));

        $response->assertInertia(fn(Assert $page) => 
            $page->component('Subjects/Create')
                 ->where('courses', CourseResource::collection($courses)));
    }

    public function test_a_user_can_create_a_new_subject()
    {
        $this->withoutExceptionHandling();

        $subjectData = [
            'title' => 'Subject Title',
            'credits' => 2
        ];

        $this->assertDatabaseCount('subjects', 0);

        $response = $this->actingAs($this->user())->post(route('subjects.store'), $subjectData);

        $this->assertDatabaseCount('subjects', 1);

        $response->assertRedirect(route('subjects.index'));
    }


    public function test_guests_can_not_create_a_new_subject()
    {
        // $this->withoutExceptionHandling();

        $subjectData = [
            'title' => 'Subject Title',
            'credits' => 2
        ];

        $this->assertDatabaseCount('subjects', 0);

        $response = $this->post(route('subjects.store'), $subjectData);

        $this->assertDatabaseCount('subjects', 0);

        $response->assertRedirect(route('login'));
    }

    public function test_the_subject_title_is_required()
    {
        // $this->withoutExceptionHandling();

        $subjectData = [
            'title' => '',
            'credits' => 2
        ];

        $this->assertDatabaseCount('subjects', 0);

        $response = $this->actingAs($this->user())->post(route('subjects.store'), $subjectData);

        $this->assertDatabaseCount('subjects', 0);

        $response->assertSessionHasErrors('title');
        $response->assertRedirect();
    }

    public function test_the_subject_title_must_have_less_than_twenty_six_letters()
    {
         // $this->withoutExceptionHandling();

         $subjectData = [
            'title' => Str::random(26),
            'credits' => 2
        ];

        $this->assertDatabaseCount('subjects', 0);

        $response = $this->actingAs($this->user())->post(route('subjects.store'), $subjectData);

        $this->assertDatabaseCount('subjects', 0);

        $response->assertSessionHasErrors('title');
        $response->assertRedirect();   
    }

    public function test_the_credit_field_is_required()
    {
        // $this->withoutExceptionHandling();

        $subjectData = [
            'title' => 'Subject Title',
            'credits' => NULL
        ];

        $this->assertDatabaseCount('subjects', 0);

        $response = $this->actingAs($this->user())->post(route('subjects.store'), $subjectData);

        $this->assertDatabaseCount('subjects', 0);

        $response->assertSessionHasErrors('credits');
        $response->assertRedirect();
    }


}
