<?php

namespace Tests\Feature\Degrees;

use Tests\TestCase;
use App\Models\Course;
use App\Models\Degree;
use Inertia\Testing\Assert;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteDegreeTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_user_can_delete_degrees()
    {
        $this->withoutExceptionHandling();
    
        $degree = Degree::factory()->create();
    
        $this->assertDatabaseCount('degrees', 1);
    
        $response = $this->actingAs($this->user())->delete(route('degrees.destroy', $degree->id));    
        
        $this->assertDatabaseCount('degrees', 0);
    
        $response->assertRedirect(route('degrees.index'));
    }

    public function test_a_degree_can_not_be_deleted_if_it_has_courses_assigned_to_it()
    {
        $this->withoutExceptionHandling();

        $degree = Degree::factory()->create();

        Course::factory()->create(['degree_id' => $degree->id]);
    
        $this->assertDatabaseCount('degrees', 1);
    
        $response = $this->actingAs($this->user())->delete(route('degrees.destroy', $degree->id));    
        
        $this->assertDatabaseCount('degrees', 1);
    
        $response->assertInertia(fn(Assert $page) => 
            $page->component('Exceptions/Degrees/Assigned')
                 ->where('exception', 'Can not delete the degree of id ' . $degree->id . ', it has been assigned to some courses.'));
    }

    public function test_guests_can_not_delete_degrees()
    {
        // $this->withoutExceptionHandling();
    
        $degree = Degree::factory()->create();
    
        $this->assertDatabaseCount('degrees', 1);
    
        $response = $this->delete(route('degrees.destroy', $degree->id));    
        
        $this->assertDatabaseCount('degrees', 1);
    
        $response->assertRedirect(route('login'));
    }
}
