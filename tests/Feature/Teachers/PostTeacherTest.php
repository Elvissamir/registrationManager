<?php

namespace Tests\Feature\Teachers;

use Tests\TestCase;
use App\Models\Teacher;
use Inertia\Testing\Assert;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostTeacherTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_create_teachers_page_exists()
    {
        $this->withoutExceptionHandling();

        $response = $this->actingAs($this->user())->get(route('teachers.create'));

        $response->assertInertia(fn(Assert $page) => 
            $page->component('Teachers/Create')
        );
    }

    public function test_guests_can_not_access_the_teachers_create_page()
    {
        // $this->withoutExceptionHandling();

        $response = $this->get(route('teachers.create'));

        $response->assertRedirect(route('login'));
    }

    public function test_a_user_can_register_teachers() 
    {
        $this->withoutExceptionHandling();

        $teacherData = [
            'first_name' => 'FirstName',
            'last_name' => 'LastName',
            'ci' => '18232323',
            'age' => 16,
            'phone_mobile' => '0424-240-99-99',
            'phone_house' => '0424-240-50-50'
        ];

        $this->assertDatabaseCount('teachers', 0);

        $response = $this->actingAs($this->user())->post(route('teachers.store'), $teacherData);

        $this->assertDatabaseCount('teachers', 1);
        $this->assertDatabaseHas('teachers', $teacherData);

        $response->assertRedirect(route('teachers.index'));
    }

    public function test_guests_can_not_register_teachers() 
    {
        // $this->withoutExceptionHandling();

        $teacherData = [
            'first_name' => 'FirstName',
            'last_name' => 'LastName',
            'ci' => '18232323',
            'age' => 16,
            'phone_mobile' => '0424-240-99-99',
            'phone_house' => '0424-240-50-50'
        ];

        $this->assertDatabaseCount('teachers', 0);

        $response = $this->post(route('teachers.store'), $teacherData);

        $this->assertDatabaseCount('teachers', 0);

        $response->assertRedirect(route('login'));
    }

    // FIELDS VALIDATION
    public function test_the_ci_is_required() 
    {
        // $this->withoutExceptionHandling();

        $teacherData = [
            'first_name' => 'FirstName',
            'last_name' => 'LastName',
            'ci' => '',
            'age' => 16,
            'phone_mobile' => '0424-240-99-99',
            'phone_house' => '0424-240-50-50'
        ];

        $this->assertDatabaseCount('teachers', 0);

        $response = $this->actingAs($this->user())->post(route('teachers.store'), $teacherData);

        $this->assertDatabaseCount('teachers', 0);

        $response->assertSessionHasErrors('ci');
        $response->assertRedirect();
    }

    public function test_the_first_name_is_required() 
    {
        // $this->withoutExceptionHandling();

        $teacherData = [
            'first_name' => '',
            'last_name' => 'LastName',
            'ci' => '18456444',
            'age' => 16,
            'phone_mobile' => '0424-240-99-99',
            'phone_house' => '0424-240-50-50'
        ];

        $this->assertDatabaseCount('teachers', 0);

        $response = $this->actingAs($this->user())->post(route('teachers.store'), $teacherData);

        $this->assertDatabaseCount('teachers', 0);

        $response->assertSessionHasErrors('first_name');
        $response->assertRedirect();
    }

    public function test_the_last_name_is_required() 
    {
        // $this->withoutExceptionHandling();

        $teacherData = Teacher::factory()->make(['last_name' => ''])->toArray();

        $this->assertDatabaseCount('teachers', 0);

        $response = $this->actingAs($this->user())->post(route('teachers.store'), $teacherData);

        $this->assertDatabaseCount('teachers', 0);

        $response->assertSessionHasErrors('last_name');
        $response->assertRedirect();
    }

    public function test_the_first_name_must_have_more_than_two_letters() 
    {
        //$this->withoutExceptionHandling();

        $teacherData = Teacher::factory()->make(['first_name' => 'A'])->toArray();

        $this->assertDatabaseCount('teachers', 0);

        $response = $this->actingAs($this->user())
                         ->post(route('teachers.store'), $teacherData);

        $this->assertDatabaseCount('teachers', 0);

        $response->assertSessionHasErrors('first_name');
        $response->assertRedirect();
    }

    public function test_the_first_name_must_have_less_than_fifteen_letters() 
    {
        //$this->withoutExceptionHandling();

        $teacherData = Teacher::factory()->make(['first_name' => 'ABCDEFGHIJKLMNOP'])->toArray();

        $this->assertDatabaseCount('teachers', 0);

        $response = $this->actingAs($this->user())
                         ->post(route('teachers.store'), $teacherData);

        $this->assertDatabaseCount('teachers', 0);

        $response->assertSessionHasErrors('first_name');
        $response->assertRedirect();
    }


    public function test_the_last_name_must_have_more_than_two_letters() 
    {
        //$this->withoutExceptionHandling();

        $teacherData = Teacher::factory()->make(['last_name' => 'A'])->toArray();

        $this->assertDatabaseCount('teachers', 0);

        $response = $this->actingAs($this->user())
                         ->post(route('teachers.store'), $teacherData);

        $this->assertDatabaseCount('teachers', 0);

        $response->assertSessionHasErrors('last_name');
        $response->assertRedirect();
    }

    public function test_the_last_name_must_have_less_than_fifteen_letters() 
    {
        //$this->withoutExceptionHandling();

        $teacherData = Teacher::factory()->make(['last_name' => 'ABCDEFGHIJKLMNOP'])->toArray();

        $this->assertDatabaseCount('teachers', 0);

        $response = $this->actingAs($this->user())
                         ->post(route('teachers.store'), $teacherData);

        $this->assertDatabaseCount('teachers', 0);

        $response->assertSessionHasErrors('last_name');
        $response->assertRedirect();
    }

    public function test_the_last_name_must_have_only_letters() 
    {
        // $this->withoutExceptionHandling();

        $teacherData = Teacher::factory()->make(['last_name' => 'A132B'])->toArray();

        $this->assertDatabaseCount('teachers', 0);

        $response = $this->actingAs($this->user())->post(route('teachers.store'), $teacherData);

        $this->assertDatabaseCount('teachers', 0);

        $response->assertSessionHasErrors('last_name');
        $response->assertRedirect();
    }

    public function test_the_first_name_must_have_only_letters() 
    {
        // $this->withoutExceptionHandling();

        $teacherData = Teacher::factory()->make(['first_name' => 'A132B'])->toArray();

        $this->assertDatabaseCount('teachers', 0);

        $response = $this->actingAs($this->user())->post(route('teachers.store'), $teacherData);

        $this->assertDatabaseCount('teachers', 0);

        $response->assertSessionHasErrors('first_name');
        $response->assertRedirect();
    }

    public function test_the_age_is_required() 
    {
        // $this->withoutExceptionHandling();

        $teacherData = Teacher::factory()->make(['age' => ''])->toArray();

        $this->assertDatabaseCount('teachers', 0);

        $response = $this->actingAs($this->user())->post(route('teachers.store'), $teacherData);

        $this->assertDatabaseCount('teachers', 0);

        $response->assertSessionHasErrors('age');
        $response->assertRedirect();
    }

    public function test_the_phone_mobile_name_is_required() 
    {
        // $this->withoutExceptionHandling();

        $teacherData = Teacher::factory()->make(['phone_mobile' => ''])->toArray();

        $this->assertDatabaseCount('teachers', 0);

        $response = $this->actingAs($this->user())->post(route('teachers.store'), $teacherData);

        $this->assertDatabaseCount('teachers', 0);

        $response->assertSessionHasErrors('phone_mobile');
        $response->assertRedirect();
    }

    public function test_the_phone_house_is_required() 
    {
        // $this->withoutExceptionHandling();

        $teacherData = Teacher::factory()->make(['phone_house' => ''])->toArray();

        $this->assertDatabaseCount('teachers', 0);

        $response = $this->actingAs($this->user())->post(route('teachers.store'), $teacherData);

        $this->assertDatabaseCount('teachers', 0);

        $response->assertSessionHasErrors('phone_house');
        $response->assertRedirect();
    }
}
