<?php

namespace Tests\Feature\Teachers;

use Tests\TestCase;
use App\Models\Teacher;
use Inertia\Testing\Assert;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PutTeacherTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_edit_teacher_page_exists()
    {
        $this->withoutExceptionHandling();

        $teacher = Teacher::factory()->create();

        $response = $this->actingAs($this->user())->get(route('teachers.edit', $teacher->id));

        $response->assertInertia(fn (Assert $page) =>
            $page->component('Teachers/Edit')
                 ->where('teacher.first_name', $teacher->first_name)    
        );
    }

    public function test_the_user_can_edit_a_teacher()
    {
        $this->withoutExceptionHandling();

        $teacher = Teacher::factory()->create();

        $teacherData = [
            'first_name' => 'newFname',
            'last_name' => 'newLname',
            'ci'=> '25516108',
            'age' => 39,
            'phone_house' => '02128645345',
            'phone_mobile' => '04164534576'
        ];

        $response = $this->actingAs($this->user())->put(route('teachers.update', $teacher->id), $teacherData);

        $this->assertDatabaseHas('teachers', [
            'first_name' => $teacherData['first_name'],
            'last_name' => $teacherData['last_name'],
            'ci' => $teacherData['ci'],
            'age' => $teacherData['age'],
            'phone_house' => $teacherData['phone_house'],
            'phone_mobile' => $teacherData['phone_mobile'],
        ]);

        $response->assertRedirect(route('teachers.index'));
    }

    public function test_the_ci_is_required() 
    {
        $teacher = Teacher::factory()->create();

        $teacherData = [
            'first_name' => 'newFname',
            'last_name' => 'newLname',
            'ci'=> '',
            'age' => 39,
            'phone_house' => '02128645345',
            'phone_mobile' => '04164534576'
        ];

        $response = $this->actingAs($this->user())->put(route('teachers.update', $teacher->id), $teacherData);

        $response->assertRedirect();
        $response->assertSessionHasErrors('ci');
    }

    public function test_the_first_name_is_required() 
    {
        // $this->withoutExceptionHandling();

        $teacher = Teacher::factory()->create();

        $teacherData = Teacher::factory()->make(['first_name' => ''])->toArray();

        $response = $this->actingAs($this->user())->put(route('teachers.update', $teacher->id), $teacherData);

        $response->assertRedirect();
        $response->assertSessionHasErrors('first_name');
    }

    public function test_the_last_name_is_required() 
    {
        // $this->withoutExceptionHandling();

        $teacher = Teacher::factory()->create();

        $teacherData = Teacher::factory()->make(['last_name' => ''])->toArray();

        $response = $this->actingAs($this->user())->put(route('teachers.update', $teacher->id), $teacherData);

        $response->assertRedirect();
        $response->assertSessionHasErrors('last_name');
    }

    public function test_the_first_name_must_have_at_least_two_letters() 
    {
        // $this->withoutExceptionHandling();

        $teacher = Teacher::factory()->create();

        $teacherData = Teacher::factory()->make(['first_name' => 'A'])->toArray();

        $response = $this->actingAs($this->user())->put(route('teachers.update', $teacher->id), $teacherData);

        $response->assertRedirect();
        $response->assertSessionHasErrors('first_name');
    }

    public function test_the_first_name_must_have_less_than_fifteen_letters() 
    {
        //$this->withoutExceptionHandling();
        $teacher = Teacher::factory()->create();

        $teacherData = Teacher::factory()->make(['first_name' => 'ABCDEFGHIJKLMNOP'])->toArray();

        $response = $this->actingAs($this->user())->put(route('teachers.update', $teacher->id), $teacherData);

        $response->assertRedirect();
        $response->assertSessionHasErrors('first_name');
    }

    public function test_the_first_name_must_have_only_letters() 
    {
        // $this->withoutExceptionHandling();
        $teacher = Teacher::factory()->create();

        $teacherData = Teacher::factory()->make(['first_name' => 'A132B'])->toArray();

        $response = $this->actingAs($this->user())->put(route('teachers.update', $teacher->id), $teacherData);

        $response->assertRedirect();
        $response->assertSessionHasErrors('first_name');
    }


    public function test_the_last_name_must_have_at_least_two_letters() 
    {
        // $this->withoutExceptionHandling();

        $teacher = Teacher::factory()->create();

        $teacherData = Teacher::factory()->make(['last_name' => 'A'])->toArray();

        $response = $this->actingAs($this->user())->put(route('teachers.update', $teacher->id), $teacherData);

        $response->assertRedirect();
        $response->assertSessionHasErrors('last_name');
    }

    public function test_the_last_name_must_have_less_than_fifteen_letters() 
    {
        //$this->withoutExceptionHandling();
        $teacher = Teacher::factory()->create();

        $teacherData = Teacher::factory()->make(['last_name' => 'ABCDEFGHIJKLMNOP'])->toArray();

        $response = $this->actingAs($this->user())->put(route('teachers.update', $teacher->id), $teacherData);

        $response->assertRedirect();
        $response->assertSessionHasErrors('last_name');
    }

    public function test_the_last_name_must_have_only_letters() 
    {
        // $this->withoutExceptionHandling();
        $teacher = Teacher::factory()->create();

        $teacherData = Teacher::factory()->make(['last_name' => 'A132B'])->toArray();

        $response = $this->actingAs($this->user())->put(route('teachers.update', $teacher->id), $teacherData);

        $response->assertRedirect();
        $response->assertSessionHasErrors('last_name');
    }

    public function test_the_age_is_required() 
    {
        // $this->withoutExceptionHandling();

        $teacher = Teacher::factory()->create();

        $teacherData = Teacher::factory()->make(['age' => ''])->toArray();

        $response = $this->actingAs($this->user())->put(route('teachers.update', $teacher->id), $teacherData);

        $response->assertRedirect();
        $response->assertSessionHasErrors('age');
    }

    public function test_the_house_phone_number_is_required() 
    {
        // $this->withoutExceptionHandling();

        $teacher = Teacher::factory()->create();

        $teacherData = Teacher::factory()->make(['phone_house' => ''])->toArray();

        $response = $this->actingAs($this->user())->put(route('teachers.update', $teacher->id), $teacherData);

        $response->assertRedirect();
        $response->assertSessionHasErrors('phone_house');
    }

    public function test_the_mobile_phone_number_is_required() 
    {
        // $this->withoutExceptionHandling();

        $teacher = Teacher::factory()->create();

        $teacherData = Teacher::factory()->make(['phone_mobile' => ''])->toArray();

        $response = $this->actingAs($this->user())->put(route('teachers.update', $teacher->id), $teacherData);

        $response->assertRedirect();
        $response->assertSessionHasErrors('phone_mobile');
    }
}
