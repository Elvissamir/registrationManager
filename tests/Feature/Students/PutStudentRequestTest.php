<?php

namespace Tests\Feature\Students;

use Tests\TestCase;
use App\Models\Student;
use Inertia\Testing\Assert;
use App\Http\Resources\StudentResource;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PutStudentRequestTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_edit_student_page_exists_and_has_the_student_data()
    {
        $this->withoutExceptionHandling();

        $student = Student::factory()->create();

        $response = $this->actingAs($this->user())->get(route('students.edit', $student->id));

        $response->assertInertia(fn (Assert $page) => 
            $page->component('Students/Edit')
                 ->where('student', new StudentResource($student)));

        $response->assertStatus(200);
    }

    public function test_guests_can_not_access_the_edit_student_page()
    {
        // $this->withoutExceptionHandling();

        $student = Student::factory()->create();

        $response = $this->get(route('students.edit', $student->id));

        $response->assertRedirect(route('login'));
    }

    
    // UPDATE DATA
    public function test_the_user_can_update_a_student()
    {
        $this->withoutExceptionHandling();

        $student = Student::factory()->create();

        $newData = [
            'first_name' => 'NewFName',
            'last_name' => 'NewLName',
            'age' => 10,
            'phone_mobile' => '0424-249-23-54',
            'phone_house' => '0424-565-78-32',
        ];

        $response = $this->actingAs($this->user())->put(route('students.update', $student->id), $newData);

        $this->assertDatabaseHas('students', [
            'id' => $student->id,
            'first_name' => 'NewFName',
            'last_name' => 'NewLName',
            'age' => 10,
            'phone_mobile' => '0424-249-23-54',
            'phone_house' => '0424-565-78-32',
        ]);

        $response->assertRedirect(route('students.index'));
    }

    public function test_guests_can_not_update_a_student()
    {
        // $this->withoutExceptionHandling();

        $student = Student::factory()->create();

        $newData = [
            'first_name' => 'NewFName',
            'last_name' => 'NewLName',
            'age' => 10,
            'phone_mobile' => '0424-249-23-54',
            'phone_house' => '0424-565-78-32',
        ];

        $response = $this->put(route('students.update', $student->id), $newData);

        $this->assertDatabaseMissing('students', [
            'id' => $student->id,
            'first_name' => 'NewFName',
            'last_name' => 'NewLName',
            'age' => 10,
            'phone_mobile' => '0424-249-23-54',
            'phone_house' => '0424-565-78-32',
        ]);

        $response->assertRedirect(route('login'));
    }

    
    // FIRST NAME TESTS
     public function test_the_student_first_name_is_required()
     {
         // $this->withoutExceptionHandling();
 
         $student = Student::factory()->create();
 
         $newData = [
             'first_name' => '',
             'last_name' => 'NewLName',
             'age' => 10,
             'phone_mobile' => '0424-249-23-54',
             'phone_house' => '0424-565-78-32',
         ];
 
         $response = $this->actingAs($this->user())->put(route('students.update', $student->id), $newData);
 
         $this->assertDatabaseHas('students', [
             'id' => $student->id,
             'first_name' => $student->first_name,
         ]);
 
         $response->assertSessionHasErrors('first_name');
         $response->assertRedirect();
     }

     public function test_the_student_first_name_must_have_more_than_two_letters()
     {
        // $this->withoutExceptionHandling();
 
        $student = Student::factory()->create();
 
        $newData = [
             'first_name' => 'A',
             'last_name' => 'NewLName',
             'age' => 10,
             'phone_mobile' => '0424-249-23-54',
             'phone_house' => '0424-565-78-32',
        ];
 
        $response = $this->actingAs($this->user())->put(route('students.update', $student->id), $newData);
 
        $this->assertDatabaseHas('students', [
             'id' => $student->id,
             'first_name' => $student->first_name,
         ]);
 
        $response->assertSessionHasErrors('first_name');
        $response->assertRedirect();
     }

     public function test_the_student_first_name_must_have_less_than_fifteen_letters()
     {
        // $this->withoutExceptionHandling();
 
        $student = Student::factory()->create();
 
        $newData = [
            'first_name' => 'ABCDEFGHIJKLMNOPQRS',
            'last_name' => 'NewLName',
            'age' => 10,
            'phone_mobile' => '0424-249-23-54',
            'phone_house' => '0424-565-78-32',
        ];
 
        $response = $this->actingAs($this->user())->put(route('students.update', $student->id), $newData);
 
        $this->assertDatabaseHas('students', [
            'id' => $student->id,
            'first_name' => $student->first_name,
        ]);
 
        $response->assertSessionHasErrors('first_name');
        $response->assertRedirect();
     }

     public function  test_the_first_name_must_have_only_letters() 
     {
        // $this->withoutExceptionHandling();
 
        $student = Student::factory()->create();
 
        $newData = [
            'first_name' => 'NAME123',
            'last_name' => 'NewLName',
            'age' => 10,
            'phone_mobile' => '0424-249-23-54',
            'phone_house' => '0424-565-78-32',
        ];

        $response = $this->actingAs($this->user())->put(route('students.update', $student->id), $newData);

        $this->assertDatabaseHas('students', [
            'id' => $student->id,
            'first_name' => $student->first_name,
        ]);

        $response->assertSessionHasErrors('first_name');
        $response->assertRedirect();
     }

     // LAST NAME TESTS
     public function test_the_student_last_name_is_required()
     {
         // $this->withoutExceptionHandling();
 
         $student = Student::factory()->create();
 
         $newData = [
             'first_name' => 'NewFName',
             'last_name' => '',
             'age' => 10,
             'phone_mobile' => '0424-249-23-54',
             'phone_house' => '0424-565-78-32',
         ];
 
         $response = $this->actingAs($this->user())->put(route('students.update', $student->id), $newData);
 
         $this->assertDatabaseHas('students', [
             'id' => $student->id,
             'last_name' => $student->last_name,
         ]);
 
         $response->assertSessionHasErrors('last_name');
         $response->assertRedirect();
     }

     public function test_the_student_last_name_must_have_more_than_two_letters()
     {
         // $this->withoutExceptionHandling();
 
         $student = Student::factory()->create();
 
         $newData = [
             'first_name' => 'NewFName',
             'last_name' => 'A',
             'age' => 10,
             'phone_mobile' => '0424-249-23-54',
             'phone_house' => '0424-565-78-32',
         ];
 
         $response = $this->actingAs($this->user())->put(route('students.update', $student->id), $newData);
 
         $this->assertDatabaseHas('students', [
             'id' => $student->id,
             'last_name' => $student->last_name,
         ]);
 
         $response->assertSessionHasErrors('last_name');
         $response->assertRedirect();
     }

     public function test_the_student_last_name_must_have_less_than_fifteen_letters()
     {
         // $this->withoutExceptionHandling();
 
         $student = Student::factory()->create();
 
         $newData = [
             'first_name' => 'NewFName',
             'last_name' => 'ABCDEFGHIJKLMNOPQRS',
             'age' => 10,
             'phone_mobile' => '0424-249-23-54',
             'phone_house' => '0424-565-78-32',
         ];
 
         $response = $this->actingAs($this->user())->put(route('students.update', $student->id), $newData);
 
         $this->assertDatabaseHas('students', [
             'id' => $student->id,
             'last_name' => $student->last_name,
         ]);
 
         $response->assertSessionHasErrors('last_name');
         $response->assertRedirect();
     }

     public function  test_the_last_name_must_have_only_letters() 
     {
        // $this->withoutExceptionHandling();
 
        $student = Student::factory()->create();
 
        $newData = [
            'first_name' => 'NewFName',
            'last_name' => 'NAME123',
            'age' => 10,
            'phone_mobile' => '0424-249-23-54',
            'phone_house' => '0424-565-78-32',
        ];

        $response = $this->actingAs($this->user())->put(route('students.update', $student->id), $newData);

        $this->assertDatabaseHas('students', [
            'id' => $student->id,
            'last_name' => $student->last_name,
        ]);

        $response->assertSessionHasErrors('last_name');
        $response->assertRedirect();
     }


     // AGE TESTS
     public function test_the_students_age_is_required()
     {
        // $this->withoutExceptionHandling();

        $student = Student::factory()->create();

        $newData = [
            'first_name' => 'NewFName',
            'last_name' => 'NewLName',
            'age' => NULL,
            'phone_mobile' => '0424-249-23-54',
            'phone_house' => '0424-565-78-32',
        ];

        $response = $this->actingAs($this->user())->put(route('students.update', $student->id), $newData);

        $this->assertDatabaseHas('students', [
            'id' => $student->id,
            'age' => $student->age,
        ]);

        $response->assertSessionHasErrors('age');
        $response->assertRedirect();
     }


     // PHONE TESTS
     public function test_the_parents_mobile_phone_number_is_required()
     {
         // $this->withoutExceptionHandling();

        $student = Student::factory()->create();

        $newData = [
            'first_name' => 'NewFName',
            'last_name' => 'NewLName',
            'age' => 15,
            'phone_mobile' => '',
            'phone_house' => '0424-565-78-32',
        ];

        $response = $this->actingAs($this->user())->put(route('students.update', $student->id), $newData);

        $this->assertDatabaseHas('students', [
            'id' => $student->id,
            'phone_mobile' => $student->phone_mobile,
        ]);

        $response->assertSessionHasErrors('phone_mobile');
        $response->assertRedirect();
     }

     public function test_the_parents_house_phone_number_is_required()
     {
         // $this->withoutExceptionHandling();

        $student = Student::factory()->create();

        $newData = [
            'first_name' => 'NewFName',
            'last_name' => 'NewLName',
            'age' => 15,
            'phone_mobile' => '0424-565-78-32',
            'phone_house' => '',
        ];

        $response = $this->actingAs($this->user())->put(route('students.update', $student->id), $newData);

        $this->assertDatabaseHas('students', [
            'id' => $student->id,
            'phone_house' => $student->phone_house,
        ]);

        $response->assertSessionHasErrors('phone_house');
        $response->assertRedirect();
     }

}
