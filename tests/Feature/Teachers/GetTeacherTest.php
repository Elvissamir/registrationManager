<?php

namespace Tests\Feature\Teachers;

use Tests\TestCase;
use App\Models\Subject;
use App\Models\Teacher;
use Inertia\Testing\Assert;
use App\Http\Resources\TeacherResource;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class  GetTeacherTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_teachers_index_page_has_a_list_of_all_teachers()
    {
        $this->withoutExceptionHandling();

        $teacherC = Teacher::factory()->create(['first_name' => 'Capo', 'last_name' => 'Dumas']);
        $teacherA = Teacher::factory()->create(['first_name' => 'Al', 'last_name' => 'Bondiga']);
        $teacherB = Teacher::factory()->create(['first_name' => 'Bob', 'last_name' => 'Cardono']);

        $response = $this->actingAs($this->user())->get(route('teachers.index'));

        $response->assertInertia(fn(Assert $page) => 
            $page->component('Teachers/Index')
                ->where('teachers.data.0.first_name', $teacherA->first_name)
                ->where('teachers.data.0.first_name', $teacherA->first_name)
                ->where('teachers.data.0.first_name', $teacherA->first_name)
                ->where('teachers.meta.per_page', 10)
        );
    }

    public function test_the_teacher_show_page_has_the_teacher_data() {

        $this->withoutExceptionHandling();

        $teacher = Teacher::factory()->create();

        $subjectB = Subject::factory()->create(['title' => 'Btitle']);
        $subjectA = Subject::factory()->create(['title' => 'Atitle']);
        $subjectC = Subject::factory()->create(['title' => 'Ctitle']);

        $teacher->subjects()->attach([$subjectA->id, $subjectB->id, $subjectC->id]);

        $response = $this->actingAs($this->user())->get(route('teachers.show', $teacher->id));

        $response->assertInertia(fn(Assert $page) => 
            $page->component('Teachers/Show')
                ->where('teacher.first_name', $teacher->first_name)
                ->where('teacher.subjects.0.title', $subjectA->title)
                ->where('teacher.subjects.1.title', $subjectB->title)
                ->where('teacher.subjects.2.title', $subjectC->title)
            );
    }

    public function test_guests_can_not_see_the_teachers_index_page() {
        
        //$this->withoutExceptionHandling();

        $response = $this->get(route('teachers.index'));

        $response->assertRedirect(route('login'));
        $response->assertStatus(302);
    }

    public function test_guests_can_not_see_the_teacher_show_page() {
        
        //$this->withoutExceptionHandling();
        
        $teacher = Teacher::factory()->create();

        $response = $this->get(route('teachers.show', $teacher->id));

        $response->assertRedirect(route('login'));
        $response->assertStatus(302);
    }
}
