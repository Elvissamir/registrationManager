<?php

namespace Tests\Feature\Degrees;

use Tests\TestCase;
use App\Models\Degree;
use Illuminate\Support\Str;
use Inertia\Testing\Assert;
use App\Http\Resources\DegreeResource;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PutDegreeTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_edit_degree_page_exists()
    {
        $this->withoutExceptionHandling();

        $degree = Degree::factory()->create();
 
        $response = $this->actingAs($this->user())->get(route('degrees.edit', $degree->id));
 
        $response->assertInertia(fn(Assert $page) => 
            $page->component('Degrees/Edit')
                 ->where('degree', new DegreeResource($degree)));
    }

    public function test_only_authenticated_users_can_see_the_edit_page()
    {
       // $this->withoutExceptionHandling();

       $degree = Degree::factory()->create();
 
       $response = $this->get(route('degrees.edit', $degree->id));
 
       $response->assertRedirect(route('login'));
    }

    public function test_the_user_can_update_a_degree()
    {
        $this->withoutExceptionHandling();

        $degree = Degree::factory()->create(['title' => 'oldTitle', 'level' => 1]);

        $degreeData = ['title' => 'newTitle', 'level' => 5];

        $response = $this->actingAs($this->user())->put(route('degrees.update', $degree->id), $degreeData);    
        
        $this->assertDatabaseHas('degrees', ['title' => 'newTitle', 'level' => 5]);

        $response->assertRedirect(route('degrees.index'));
    }

    public function test_guests_can_not_update_degrees()
    {
        // $this->withoutExceptionHandling();

        $degree = Degree::factory()->create(['title' => 'oldTitle', 'level' => 1]);

        $degreeData = ['title' => 'newTitle', 'level' => 5];

        $response = $this->put(route('degrees.update', $degree->id), $degreeData);    
        
        $this->assertDatabaseHas('degrees', ['title' => 'oldTitle', 'level' => 1]);

        $response->assertRedirect(route('login'));
    }

    public function test_the_degree_title_is_required()
    {
        // $this->withoutExceptionHandling();

        $degree = Degree::factory()->create(['title' => 'oldTitle', 'level' => 1]);

        $degreeData = Degree::factory()->make(['title' => ''])->toArray();

        $response = $this->actingAs($this->user())->put(route('degrees.update', $degree->id), $degreeData);    
        
        $this->assertDatabaseHas('degrees', ['title' => 'oldTitle']);

        $response->assertRedirect();
        $response->assertSessionHasErrors('title');
    }

    public function test_the_degree_title_max_length_must_be_less_than_26()
    {
        // $this->withoutExceptionHandling();

        $degree = Degree::factory()->create(['title' => 'oldTitle', 'level' => 1]);

        $degreeData = Degree::factory()->make(['title' => Str::random(26)])->toArray();

        $response = $this->actingAs($this->user())->put(route('degrees.update', $degree->id), $degreeData);    
        
        $this->assertDatabaseHas('degrees', ['title' => 'oldTitle']);

        $response->assertRedirect();
        $response->assertSessionHasErrors('title');
    }

    public function test_the_degree_title_must_have_only_letters()
    {
        // $this->withoutExceptionHandling();

        $degree = Degree::factory()->create(['title' => 'oldTitle', 'level' => 1]);

        $degreeData = Degree::factory()->make(['title' => 'Title1'])->toArray();

        $response = $this->actingAs($this->user())->put(route('degrees.update', $degree->id), $degreeData);    
        
        $this->assertDatabaseHas('degrees', ['title' => 'oldTitle']);

        $response->assertRedirect();
        $response->assertSessionHasErrors('title');
    }

    public function test_the_degree_level_is_required()
    {
        // $this->withoutExceptionHandling();

        $degree = Degree::factory()->create(['title' => 'oldTitle', 'level' => 1]);

        $degreeData = Degree::factory()->make(['level' => Null])->toArray();

        $response = $this->actingAs($this->user())->put(route('degrees.update', $degree->id), $degreeData);    
        
        $this->assertDatabaseHas('degrees', ['level' => 1]);

        $response->assertRedirect();
        $response->assertSessionHasErrors('level');
    }

    public function test_the_degree_level_must_be_a_number()
    {
        // $this->withoutExceptionHandling();

        $degree = Degree::factory()->create(['title' => 'oldTitle', 'level' => 1]);

        $degreeData = Degree::factory()->make(['level' => 'A'])->toArray();

        $response = $this->actingAs($this->user())->put(route('degrees.update', $degree->id), $degreeData);    
        
        $this->assertDatabaseHas('degrees', ['level' => 1]);

        $response->assertRedirect();
        $response->assertSessionHasErrors('level');
    }
}
