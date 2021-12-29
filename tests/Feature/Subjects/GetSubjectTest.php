<?php

namespace Tests\Feature\Subjects;

use Tests\TestCase;
use App\Models\Subject;
use App\Models\Teacher;
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

        $subjectC = Subject::factory()->create(['title' => 'Matematica']);
        $subjectA = Subject::factory()->create(['title' => 'Fisica']);
        $subjectB = Subject::factory()->create(['title' => 'Historia']);

        $response = $this->actingAs($this->user())->get(route('subjects.index'));

        $response->assertInertia(fn(Assert $page) => 
            $page->component('Subjects/Index')
                 ->where('subjects.data.0.title', $subjectC->title)
                 ->where('subjects.data.1.title', $subjectA->title)
                 ->where('subjects.data.2.title', $subjectB->title)
                 ->where('order', 'id')
                 ->where('subjects.links.first', 'http://servm.test/subjects?page=1')
        );
    }

    public function test_the_user_can_see_the_list_of_subjects_ordered_by_title_on_index()
    {
        $this->withoutExceptionHandling();

        $subjectC = Subject::factory()->create(['title' => 'Matematica']);
        $subjectA = Subject::factory()->create(['title' => 'Fisica']);
        $subjectB = Subject::factory()->create(['title' => 'Historia']);
        
        $response = $this->actingAs($this->user())->get('/subjects?orderBy=title');

        $response->assertInertia(fn(Assert $page) => 
            $page->component('Subjects/Index')
                 ->where('subjects.data.0.title', $subjectA->title)
                 ->where('subjects.data.1.title', $subjectB->title)
                 ->where('subjects.data.2.title', $subjectC->title)
                 ->where('order', 'title')
                 ->where('subjects.links.first', 'http://servm.test/subjects?orderBy=title&page=1')
        );
    }

    public function test_the_user_can_see_the_list_of_subjects_ordered_by_credits_on_index()
    {
        $this->withoutExceptionHandling();

        $subjectC = Subject::factory()->create(['credits' => 1]);
        $subjectA = Subject::factory()->create(['credits' => 3]);
        $subjectB = Subject::factory()->create(['credits' => 5]);
        
        $response = $this->actingAs($this->user())->get('/subjects?orderBy=credits');

        $response->assertInertia(fn(Assert $page) => 
            $page->component('Subjects/Index')
                 ->where('subjects.data.0.credits', $subjectB->credits)
                 ->where('subjects.data.1.credits', $subjectA->credits)
                 ->where('subjects.data.2.credits', $subjectC->credits)
                 ->where('order', 'credits')
                 ->where('subjects.links.first', 'http://servm.test/subjects?orderBy=credits&page=1')
        );
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

        $teacherB = Teacher::factory()->create(['first_name' => 'Bob', 'last_name' => 'Cardono']);
        $teacherA = Teacher::factory()->create(['first_name' => 'Al', 'last_name' => 'Bondiga']);
        $teacherC = Teacher::factory()->create(['first_name' => 'Carlos', 'last_name' => 'Churupa']);

        $subject->teachers()->attach([$teacherA->id, $teacherB->id, $teacherC->id]);

        $response = $this->actingAs($this->user())->get(route('subjects.show', $subject->id));

        $response->assertInertia(fn(Assert $page) => 
            $page->component('Subjects/Show')
                 ->where('subject.title', $subject->title)
                 ->where('teachers.data.0.first_name', $teacherA->first_name)
                 ->where('teachers.data.1.first_name', $teacherB->first_name)
                 ->where('teachers.data.2.first_name', $teacherC->first_name)
                 ->where('teachers.links.first', 'http://servm.test/subjects/'.$subject->id.'?page=1')
        );
    }


    public function test_guests_can_not_access_the_show_page()
    {
        // $this->withoutExceptionHandling();

        $subject = Subject::factory()->create();

        $response = $this->get(route('subjects.show', $subject->id));

        $response->assertRedirect(route('login'));
    }


}
