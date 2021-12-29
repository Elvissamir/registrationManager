<?php

namespace Tests\Feature\Degrees;

use Tests\TestCase;
use App\Models\Degree;
use Illuminate\Support\Str;
use Inertia\Testing\Assert;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostDegreeTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_create_degree_page_exists()
    {
        $this->withoutExceptionHandling();
 
        $response = $this->actingAs($this->user())->get(route('degrees.create'));
 
        $response->assertInertia(fn(Assert $page) => 
            $page->component('Degrees/Create'));
    }

    public function test_only_authenticated_users_can_see_the_create_page()
    {
       // $this->withoutExceptionHandling();
 
       $response = $this->get(route('degrees.create'));
 
       $response->assertRedirect(route('login'));
    }

    public function test_the_user_can_create_a_new_degree()
    {
        $this->withoutExceptionHandling();

        $degreeData = ['title' => 'Title', 'level' => 1];

        $this->assertDatabaseCount('degrees', 0);

        $response = $this->actingAs($this->user())->post(route('degrees.store'), $degreeData);    
        
        $this->assertDatabaseCount('degrees', 1);
        $this->assertDatabaseHas('degrees', ['title' => 'Title', 'level' => 1]);

        $response->assertRedirect(route('degrees.index'));
    }

    public function test_the_degree_title_is_required()
    {
        // $this->withoutExceptionHandling();

        $degreeData = Degree::factory()->make(['title' => ''])->toArray();

        $this->assertDatabaseCount('degrees', 0);

        $response = $this->actingAs($this->user())->post(route('degrees.store'), $degreeData);    
        
        $this->assertDatabaseCount('degrees', 0);

        $response->assertRedirect();
        $response->assertSessionHasErrors('title');
    }

    public function test_the_degree_title_max_length_must_be_less_than_26()
    {
        // $this->withoutExceptionHandling();

        $degreeData = Degree::factory()->make(['title' => Str::random(26)])->toArray();

        $this->assertDatabaseCount('degrees', 0);

        $response = $this->actingAs($this->user())->post(route('degrees.store'), $degreeData);    
        
        $this->assertDatabaseCount('degrees', 0);

        $response->assertRedirect();
        $response->assertSessionHasErrors('title');
    }

    public function test_the_degree_title_must_have_only_letters()
    {
        // $this->withoutExceptionHandling();

        $degreeData = Degree::factory()->make(['title' => 'TITLE 1'])->toArray();

        $this->assertDatabaseCount('degrees', 0);

        $response = $this->actingAs($this->user())->post(route('degrees.store'), $degreeData);    
        
        $this->assertDatabaseCount('degrees', 0);

        $response->assertRedirect();
        $response->assertSessionHasErrors('title');
    }

    public function test_the_degree_level_is_required()
    {
        // $this->withoutExceptionHandling();

        $degreeData = Degree::factory()->make(['level' => ''])->toArray();

        $this->assertDatabaseCount('degrees', 0);

        $response = $this->actingAs($this->user())->post(route('degrees.store'), $degreeData);    
        
        $this->assertDatabaseCount('degrees', 0);

        $response->assertRedirect();
        $response->assertSessionHasErrors('level');
    }

    public function test_the_degree_level_must_be_a_number()
    {
        // $this->withoutExceptionHandling();

        $degreeData = Degree::factory()->make(['level' => Str::random(5)])->toArray();

        $this->assertDatabaseCount('degrees', 0);

        $response = $this->actingAs($this->user())->post(route('degrees.store'), $degreeData);    
        
        $this->assertDatabaseCount('degrees', 0);

        $response->assertRedirect();
        $response->assertSessionHasErrors('level');
    }
}
