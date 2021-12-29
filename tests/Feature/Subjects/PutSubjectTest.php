<?php

namespace Tests\Feature\Subjects;

use Tests\TestCase;
use App\Models\Subject;
use Illuminate\Support\Str;
use Inertia\Testing\Assert;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PutSubjectTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_edit_subject_page_exists()
    {
        $this->withoutExceptionHandling();

        $subject = Subject::factory()->create();

        $response = $this->actingAs($this->user())->get(route('subjects.edit', $subject->id));

        $response->assertInertia(fn(Assert $page) => 
            $page->component('Subjects/Edit')
                 ->where('subject.id', $subject->id));
    }

    public function test_guests_can_not_access_the_edit_subject_page()
    {
        // $this->withoutExceptionHandling();

        $subject = Subject::factory()->create();

        $response = $this->get(route('subjects.edit', $subject->id));

       $response->assertRedirect(route('login'));
    }

    public function test_the_user_can_edit_a_subject() {
        
        $this->withoutExceptionHandling();

        $subject = Subject::factory()->create(['title' => 'OldTitle', 'credits' => 1]);

        $subjectData = ['title' => 'NewTitle', 'credits' => 5];

        $response = $this->actingAs($this->user())->put(route('subjects.update', $subject->id), $subjectData);

        $this->assertDatabaseHas('subjects', [
            'title' => 'NewTitle',
            'credits' => 5
        ]);

        $response->assertRedirect(route('subjects.index'));
    }

    public function test_guests_can_not_edit_a_subject() {
        
        // $this->withoutExceptionHandling();

        $subject = Subject::factory()->create(['title' => 'OldTitle', 'credits' => 1]);

        $subjectData = ['title' => 'NewTitle', 'credits' => 5];

        $response = $this->put(route('subjects.update', $subject->id), $subjectData);

        $this->assertDatabaseMissing('subjects', [
            'title' => 'NewTitlte',
            'credits' => 5
        ]);

        $response->assertRedirect(route('login'));
    }

    public function test_the_subject_title_is_required()
    {
        // $this->withoutExceptionHandling();

        $subject = Subject::factory()->create();

        $subjectData = [
            'title' => '',
            'credits' => 2
        ];

        $response = $this->actingAs($this->user())->put(route('subjects.update', $subject->id), $subjectData);

        $response->assertSessionHasErrors('title');
        $response->assertRedirect();
    }

    public function test_the_subject_title_must_have_less_than_twenty_six_letters()
    {
         // $this->withoutExceptionHandling();

        $subject = Subject::factory()->create();

        $subjectData = [
            'title' => Str::random(26),
            'credits' => 2
        ];

        $response = $this->actingAs($this->user())->put(route('subjects.update', $subject->id), $subjectData);

        $response->assertSessionHasErrors('title');
        $response->assertRedirect();   
    }

    public function test_the_credit_field_is_required()
    {
        // $this->withoutExceptionHandling();

        $subject = Subject::factory()->create();

        $subjectData = [
            'title' => 'Subject Title',
            'credits' => NULL
        ];

        $response = $this->actingAs($this->user())->put(route('subjects.update', $subject->id), $subjectData);

        $response->assertSessionHasErrors('credits');
        $response->assertRedirect();
    }

    public function test_the_credit_field_must_be_a_number()
    {
        // $this->withoutExceptionHandling();

        $subject = Subject::factory()->create();

        $subjectData = [
            'title' => 'Subject Title',
            'credits' => Str::random(2)
        ];

        $response = $this->actingAs($this->user())->put(route('subjects.update', $subject->id), $subjectData);

        $response->assertSessionHasErrors('credits');
        $response->assertRedirect();
    }

   
}