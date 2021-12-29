<?php

namespace Tests\Feature\Sections;

use Tests\TestCase;
use App\Models\Course;
use App\Models\Section;
use Inertia\Testing\Assert;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteSectionTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_user_can_delete_sections()
    {
        $this->withoutExceptionHandling();
    
        $section = Section::factory()->create();
    
        $this->assertDatabaseCount('sections', 1);
    
        $response = $this->actingAs($this->user())->delete(route('sections.destroy', $section->id));    
        
        $this->assertDatabaseCount('sections', 0);
    
        $response->assertRedirect(route('sections.index'));
    }

    public function test_a_section_can_not_be_deleted_if_it_has_courses_assigned_to_it()
    {
        $this->withoutExceptionHandling();

        $section = Section::factory()->create();

        Course::factory()->create(['section_id' => $section->id]);
    
        $this->assertDatabaseCount('sections', 1);
    
        $response = $this->actingAs($this->user())->delete(route('sections.destroy', $section->id));    
        
        $this->assertDatabaseCount('sections', 1);
    
        $response->assertInertia(fn(Assert $page) => 
            $page->component('Exceptions/Sections/Assigned')
                 ->where('exception', 'Can not delete the section of id ' . $section->id . ' , it has been assigned to some courses.'));
    }

    public function test_guests_can_not_delete_sections()
    {
        // $this->withoutExceptionHandling();
    
        $section = Section::factory()->create();
    
        $this->assertDatabaseCount('sections', 1);
    
        $response = $this->delete(route('sections.destroy', $section->id));    
        
        $this->assertDatabaseCount('sections', 1);
    
        $response->assertRedirect(route('login'));
    }

}
