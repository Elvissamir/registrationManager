<?php

namespace Tests\Feature\Subjects;

use Tests\TestCase;
use App\Models\Subject;
use Inertia\Testing\Assert;
use App\Http\Resources\SubjectResource;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GetSubjectTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_index_page_exists_and_has_the_list_of_subjects()
    {
        $this->withoutExceptionHandling();

        $subjects = Subject::factory()->count(2)->create();

        $response = $this->actingAs($this->user())->get(route('subjects.index'));

        $response->assertInertia(fn(Assert $page) => 
            $page->component('Subjects/Index')
                 ->where('subjects', SubjectResource::collection($subjects)));
    }


    public function test_guests_can_not_access_the_subject_index_page()
    {
        // $this->withoutExceptionHandling();

        $subjects = Subject::factory()->count(2)->create();

        $response = $this->get(route('subjects.index'));

        $response->assertRedirect(route('login'));
    }

    public function test_the_show_page_exists_and_has_the_subject_data()
    {
        $this->withoutExceptionHandling();

        $subject = Subject::factory()->create();

        $response = $this->actingAs($this->user())->get(route('subjects.show', $subject->id));

        $response->assertInertia(fn(Assert $page) => 
            $page->component('Subjects/Show')
                 ->where('subject', new SubjectResource($subject)));
    }


    public function test_guests_can_not_access_the_show_page()
    {
        // $this->withoutExceptionHandling();

        $subject = Subject::factory()->create();

        $response = $this->get(route('subjects.show', $subject->id));

        $response->assertRedirect(route('login'));
    }


}
