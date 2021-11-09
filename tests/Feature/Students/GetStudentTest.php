<?php

namespace Tests\Feature\Students;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\User;
use App\Models\Course;
use App\Models\Student;
use Inertia\Testing\Assert;
use App\Http\Resources\CourseResource;
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
                ->where('order', 'id')
        );
    }

    public function test_the_user_can_see_the_list_of_students_ordered_by_name()
    {
        $this->withoutExceptionHandling();

        $studentB = Student::factory()->create(['first_name' => 'Abin', 'last_name' => 'Carglon']);
        $studentC = Student::factory()->create(['first_name' => 'Aaron', 'last_name' => 'Daniels']);
        $studentA = Student::factory()->create(['first_name' => 'Al', 'last_name' => 'Birhen']);
        $studentD = Student::factory()->create(['first_name' => 'Bobby', 'last_name' => 'Angels']);

        $response = $this->actingAs($this->user())->get('/students?orderBy=name');

        $students = Student::orderBy('first_name', 'asc')->orderBy('last_name', 'asc')->paginate(10);
        $students->appends(['orderBy' => 'name']);

        $response->assertInertia(fn(Assert $page) => 
            $page->component('Students/Index')
                ->has('students')
                ->where('students', StudentResource::collection($students))
                ->where('students.data.0.first_name', $studentC->first_name)
                ->where('students.links.first', 'http://servm.test/students?orderBy=name&page=1')
                ->where('order', 'name')
            );
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
        $students->appends(['orderBy' => 'registration']);

        $response->assertInertia(fn(Assert $page) => 
            $page->component('Students/Index')
                ->has('students')
                ->where('students', StudentResource::collection($students))
                ->where('students.data.0.first_name', $studentA->first_name)
                ->where('students.links.first', 'http://servm.test/students?orderBy=registration&page=1')
                ->where('order', 'registration')
        );
    }

    public function test_the_students_show_page_has_the_student_data() {
       
        $this->withoutExceptionHandling();

        $student = Student::factory()->create();
        $courseA = Course::factory()->create(['status' => 'active']);
        $courseB = Course::factory()->create(['status' => 'finished']);

        $student->courses()->attach($courseA->id);
        $student->courses()->attach($courseB->id);

        $response = $this->actingAs($this->user())->get(route('students.show', $student->id));

        $finishedCourses = $student->courses()->where('status', 'finished')->with(['degree', 'section'])->get();
        $activeCourses = $student->courses()->where('status', 'active')->with(['degree', 'section'])->get();

        $response->assertInertia(fn(Assert $page) => 
            $page->component('Students/Show')
                ->has('student')
                ->where('student', new StudentResource($student))
                ->where('finishedCourses', CourseResource::collection($finishedCourses))
                ->where('activeCourses', CourseResource::collection($activeCourses)));
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
