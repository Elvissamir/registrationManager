<?php

namespace Tests\Feature\Students;

use Carbon\Carbon;
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

        Student::factory()->count(4)->create();

        $response = $this->actingAs($this->user())->get(route('students.index'));

        $students = Student::paginate(10);

        $response->assertInertia(fn(Assert $page) => 
            $page->component('Students/Index')
                ->has('students')
                ->where('students', StudentResource::collection($students))
        );
    }

    public function test_the_user_can_see_the_list_of_students_ordered_by_name()
    {
        $this->withoutExceptionHandling();

        $studentA = Student::factory()->create(['first_name' => 'Al', 'last_name' => 'Birhen']);
        $studentB = Student::factory()->create(['first_name' => 'Abin', 'last_name' => 'Carglon']);
        $studentC = Student::factory()->create(['first_name' => 'Aaron', 'last_name' => 'Daniels']);
        $studentD = Student::factory()->create(['first_name' => 'Bobby', 'last_name' => 'Angels']);

        $response = $this->actingAs($this->user())->get('/students?orderBy=name');

        $students = Student::orderBy('first_name', 'asc')->orderBy('last_name', 'asc')->paginate(10);

        // dd(StudentResource::collection($students));

        $response->assertInertia(fn(Assert $page) => 
            $page->component('Students/Index')
                ->has('students')
                ->where('students', StudentResource::collection($students)));
    }

    public function test_the_user_can_see_the_list_of_students_ordered_by_registration_date()
    {
        $this->withoutExceptionHandling();

        $studentD = Student::factory()->create(['created_at' => Carbon::now()->subDays(4)]);
        $studentC = Student::factory()->create(['created_at' => Carbon::now()->subDays(3)]);
        $studentB = Student::factory()->create(['created_at' => Carbon::now()->subDays(2)]);
        $studentA = Student::factory()->create(['created_at' => Carbon::now()->subDays(1)]);

        $response = $this->actingAs($this->user())->get('/students?orderBy=registration');

        $students = Student::orderBy('created_at', 'desc')->paginate(10);

        $response->assertInertia(fn(Assert $page) => 
            $page->component('Students/Index')
                ->has('students')
                ->where('students', StudentResource::collection($students))
        );
    }

    public function test_the_students_show_page_has_the_student_data() {
       
        $this->withoutExceptionHandling();

        $student = Student::factory()->create();

        $response = $this->actingAs($this->user())->get(route('students.show', $student->id));

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
