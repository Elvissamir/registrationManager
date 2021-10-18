<?php

namespace Tests\Feature\Teachers;

use Tests\TestCase;
use App\Models\Teacher;
use Inertia\Testing\Assert;
use App\Http\Resources\TeacherResource;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class  GetTeacherRequestTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_teachers_index_page_has_a_list_of_all_teachers()
    {
        $this->withoutExceptionHandling();

        $teachers = Teacher::factory()->count(2)->create();

        $response = $this->actingAs($this->user())->get(route('teachers.index'));

        $response->assertInertia(fn(Assert $page) => 
            $page->component('Teachers/Index')
                ->where('teachers', TeacherResource::collection($teachers))
        );
    }

    public function test_the_teacher_show_page_has_the_teacher_data() {

        $this->withoutExceptionHandling();

        $teacher = Teacher::factory()->create();

        $response = $this->actingAs($this->user())->get(route('teachers.show', $teacher->id));

        $response->assertInertia(fn(Assert $page) => 
            $page->component('Teachers/Show')
                ->where('teacher', new TeacherResource($teacher))
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
