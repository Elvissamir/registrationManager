<?php

namespace Tests\Feature\Students;

use Tests\TestCase;
use App\Models\User;
use App\Models\Student;
use Inertia\Testing\Assert;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostStudentRequestTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_create_student_page_exists()
    {
        $this->withoutExceptionHandling();

        $response = $this->actingAs($this->user())->get(route('students.create'));

        $response->assertInertia(fn (Assert $page) => $page->component('Students/Create'));
        $response->assertStatus(200);
    }

    public function test_guests_can_not_access_the_create_student_page() 
    {
        // $this->withoutExceptionHandling();

        $response = $this->get(route('students.create'));

        $response->assertRedirect(route('login'));
    }

    public function test_a_user_can_register_students() 
    {
        $this->withoutExceptionHandling();

        $studentData = [
            'first_name' => 'FirstName',
            'last_name' => 'LastName',
            'age' => 16,
            'phone_mobile' => '0424-240-99-99',
            'phone_house' => '0424-240-50-50'
        ];

        $this->assertDatabaseCount('students', 0);

        $response = $this->actingAs($this->user())->post(route('students.store'), $studentData);

        $this->assertDatabaseCount('students', 1);
        $this->assertDatabaseHas('students', $studentData);

        $response->assertRedirect(route('students.index'));
    }

    public function test_guests_can_not_register_students() 
    {
        //$this->withoutExceptionHandling();

        $studentData = Student::factory()->make()->toArray();

        $this->assertDatabaseCount('students', 0);

        $response = $this->post(route('students.store'), $studentData);

        $this->assertDatabaseCount('students', 0);
        $response->assertRedirect(route('login'));
    }

    public function test_the_students_first_name_is_required()
    {
        //$this->withoutExceptionHandling();

        $studentData = Student::factory()->make(['first_name' => ''])->toArray();

        $this->assertDatabaseCount('students', 0);

        $response = $this->actingAs($this->user())
                         ->post(route('students.store'), $studentData);

        $this->assertDatabaseCount('students', 0);

        $response->assertSessionHasErrors('first_name');
        $response->assertRedirect();
    }

    public function test_the_first_name_must_have_more_than_two_letters() 
    {
        //$this->withoutExceptionHandling();

        $studentData = Student::factory()->make(['first_name' => 'A'])->toArray();

        $this->assertDatabaseCount('students', 0);

        $response = $this->actingAs($this->user())
                         ->post(route('students.store'), $studentData);

        $this->assertDatabaseCount('students', 0);

        $response->assertSessionHasErrors('first_name');
        $response->assertRedirect();
    }

    public function test_the_first_name_must_have_less_than_fifteen_letters() 
    {
        //$this->withoutExceptionHandling();

        $studentData = Student::factory()->make(['first_name' => 'ABCDEFGHIJKLMNOP'])->toArray();

        $this->assertDatabaseCount('students', 0);

        $response = $this->actingAs($this->user())
                         ->post(route('students.store'), $studentData);

        $this->assertDatabaseCount('students', 0);

        $response->assertSessionHasErrors('first_name');
        $response->assertRedirect();
    }

    public function test_the_first_name_must_have_only_letters()
    {
        //$this->withoutExceptionHandling();

        $studentData = Student::factory()->make(['first_name' => 'A1B2'])->toArray();

        $this->assertDatabaseCount('students', 0);

        $response = $this->actingAs($this->user())
                         ->post(route('students.store'), $studentData);

        $this->assertDatabaseCount('students', 0);

        $response->assertSessionHasErrors('first_name');
        $response->assertRedirect();   
    }


    // LAST NAME TESTS
    //////////////////////////////////

    public function test_the_students_last_name_is_required()
    {
        //$this->withoutExceptionHandling();

        $studentData = Student::factory()->make(['last_name' => ''])->toArray();

        $this->assertDatabaseCount('students', 0);

        $response = $this->actingAs($this->user())
                         ->post(route('students.store'), $studentData);

        $this->assertDatabaseCount('students', 0);

        $response->assertSessionHasErrors('last_name');
        $response->assertRedirect();
    }

    public function test_the_last_name_must_have_more_than_two_letters() 
    {
        //$this->withoutExceptionHandling();

        $studentData = Student::factory()->make(['last_name' => 'A'])->toArray();

        $this->assertDatabaseCount('students', 0);

        $response = $this->actingAs($this->user())
                         ->post(route('students.store'), $studentData);

        $this->assertDatabaseCount('students', 0);

        $response->assertSessionHasErrors('last_name');
        $response->assertRedirect();
    }

    public function test_the_last_name_must_have_less_than_fifteen_letters() 
    {
        //$this->withoutExceptionHandling();

        $studentData = Student::factory()->make(['last_name' => 'ABCDEFGHIJKLMNOP'])->toArray();

        $this->assertDatabaseCount('students', 0);

        $response = $this->actingAs($this->user())
                         ->post(route('students.store'), $studentData);

        $this->assertDatabaseCount('students', 0);

        $response->assertSessionHasErrors('last_name');
        $response->assertRedirect();
    }

    public function test_the_last_name_must_have_only_letters()
    {
        //$this->withoutExceptionHandling();

        $studentData = Student::factory()->make(['last_name' => 'A1B2'])->toArray();

        $this->assertDatabaseCount('students', 0);

        $response = $this->actingAs($this->user())
                         ->post(route('students.store'), $studentData);

        $this->assertDatabaseCount('students', 0);

        $response->assertSessionHasErrors('last_name');
        $response->assertRedirect();   
    }


    // AGE TESTS
    public function test_the_students_age_is_required() {
        
        //$this->withoutExceptionHandling();

        $studentData = Student::factory()->make(['age' => NULL])->toArray();

        $this->assertDatabaseCount('students', 0);

        $response = $this->actingAs($this->user())
                         ->post(route('students.store'), $studentData);

        $this->assertDatabaseCount('students', 0);

        $response->assertSessionHasErrors('age');
        $response->assertRedirect(); 
    }


    //PHONE NUMBERS
    public function test_the_parents_mobile_phone_number_is_required()
    {
        //$this->withoutExceptionHandling();

        $studentData = Student::factory()->make(['phone_mobile' => ''])->toArray();

        $this->assertDatabaseCount('students', 0);
 
        $response = $this->actingAs($this->user())
                          ->post(route('students.store'), $studentData);
 
        $this->assertDatabaseCount('students', 0);

        $response->assertSessionHasErrors('phone_mobile');
        $response->assertRedirect(); 
    }
    
    public function test_the_house_phone_number_is_required()
    {
        //$this->withoutExceptionHandling();

        $studentData = Student::factory()->make(['phone_house' => ''])->toArray();

        $this->assertDatabaseCount('students', 0);
 
        $response = $this->actingAs($this->user())
                          ->post(route('students.store'), $studentData);
 
        $this->assertDatabaseCount('students', 0);

        $response->assertSessionHasErrors('phone_house');
        $response->assertRedirect(); 
    }


}
