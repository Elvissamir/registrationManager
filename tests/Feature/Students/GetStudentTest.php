<?php

namespace Tests\Feature\Students;

use Tests\TestCase;
use App\Models\User;
use App\Models\Student;
use Inertia\Testing\Assert;
use App\Http\Resources\StudentResource;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GetStudentTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_students_index_page_has_a_list_of_all_students()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();

        $students = Student::factory()->count(2)->create();

        $response = $this->actingAs($user)->get(route('students.index'));

        $response->assertInertia(fn(Assert $page) => 
            $page->component('Students/Index')
                ->has('students')
                ->where('students', StudentResource::collection($students))
        );
    }

    public function test_the_students_show_page_has_the_student_data() {
       
        $this->withoutExceptionHandling();

        $user = User::factory()->create();

        $student = Student::factory()->create();

        $response = $this->actingAs($user)->get(route('students.show', $student->id));

        $response->assertInertia(fn(Assert $page) => 
            $page->component('Students/Show')
                ->has('student')
                ->where('student', new StudentResource($student))
        );
    }

    public function test_guests_can_not_see_the_students_index_page() {
        
        //$this->withoutExceptionHandling();

        $response = $this->get(route('students.index'));

        $response->assertRedirect(route('login'));
        $response->assertStatus(302);
    }

    public function test_guests_can_not_see_the_students_show_page() {
        
        //$this->withoutExceptionHandling();
        
        $student = Student::factory()->create();

        $response = $this->get(route('students.show', $student->id));

        $response->assertRedirect(route('login'));
        $response->assertStatus(302);
    }
}
