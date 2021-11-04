<?php

namespace Tests\Feature\Sections;

use Tests\TestCase;
use App\Models\Section;
use Inertia\Testing\Assert;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostSectionTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_create_section_page_exists()
    {
        $this->withoutExceptionHandling();
 
        $response = $this->actingAs($this->user())->get(route('sections.create'));
 
        $response->assertInertia(fn(Assert $page) => 
            $page->component('Sections/Create'));
    }

    public function test_only_authenticated_users_can_see_the_create_page()
    {
       // $this->withoutExceptionHandling();
 
       $response = $this->get(route('sections.create'));
 
       $response->assertRedirect(route('login'));
    }

    public function test_the_user_can_create_a_new_section()
    {
        $this->withoutExceptionHandling();

        $sectionData = ['name' => 'A'];

        $this->assertDatabaseCount('sections', 0);

        $response = $this->actingAs($this->user())->post(route('sections.store'), $sectionData);    
        
        $this->assertDatabaseCount('sections', 1);
        $this->assertDatabaseHas('sections', ['name' => 'A']);

        $response->assertRedirect(route('sections.index'));
    }

    public function test_the_section_name_is_stored_in_uppercase_letter()
    {
        $this->withoutExceptionHandling();

        $sectionData = ['name' => 'a'];

        $this->assertDatabaseCount('sections', 0);

        $response = $this->actingAs($this->user())->post(route('sections.store'), $sectionData);    
        
        $this->assertDatabaseCount('sections', 1);
        $this->assertEquals('A', Section::all()->first()->name);

        $response->assertRedirect(route('sections.index'));
    }

    public function test_the_section_name_is_required()
    {
        // $this->withoutExceptionHandling();

        $sectionData = ['name' => ''];

        $this->assertDatabaseCount('sections', 0);

        $response = $this->actingAs($this->user())->post(route('sections.store'), $sectionData);    
        
        $this->assertDatabaseCount('sections', 0);

        $response->assertRedirect();
        $response->assertSessionHasErrors('name');
    }

    public function test_the_section_name_must_be_1_letter_long()
    {
        // $this->withoutExceptionHandling();

        $sectionData = ['name' => 'AB'];

        $this->assertDatabaseCount('sections', 0);

        $response = $this->actingAs($this->user())->post(route('sections.store'), $sectionData);    
        
        $this->assertDatabaseCount('sections', 0);

        $response->assertRedirect();
        $response->assertSessionHasErrors('name');
    }

    public function test_the_section_name_must_be_a_letter()
    {
        // $this->withoutExceptionHandling();

        $sectionData = ['name' => '1'];

        $this->assertDatabaseCount('sections', 0);

        $response = $this->actingAs($this->user())->post(route('sections.store'), $sectionData);    
        
        $this->assertDatabaseCount('sections', 0);

        $response->assertRedirect();
        $response->assertSessionHasErrors('name');
    }
}
