<?php

namespace Tests\Feature\Courses;

use Tests\TestCase;
use App\Models\Degree;
use App\Models\Section;
use Illuminate\Support\Str;
use Inertia\Testing\Assert;
use App\Http\Resources\DegreeResource;
use App\Http\Resources\SectionResource;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostCourseTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_create_course_page_exists_and_has_the_list_of_sections_and_degrees()
    {
        $this->withoutExceptionHandling();

        $sections = Section::factory()->count(2)->create();
        $degrees = Degree::factory()->count(2)->create();

        $response = $this->actingAs($this->user())->get(route('courses.create'));

        $response->assertInertia(fn(Assert $page) => 
            $page->component('Courses/Create')
                 ->where('sections', SectionResource::collection($sections))
                 ->where('degrees', DegreeResource::collection($degrees)));
    }

    public function test_guests_can_not_access_the_create_course_page()
    {
        // $this->withoutExceptionHandling();

        $response = $this->get(route('courses.create'));

        $response->assertRedirect(route('login'));
    }

    public function test_a_user_can_create_a_new_course()
    {
        $this->withoutExceptionHandling();

        $section = Section::factory()->create();
        $degree = Degree::factory()->create();

        $courseData = [
            'section_id' => $section->id,
            'degree_id' => $degree->id,
            'period' => '2021 - I',
        ];

        $this->assertDatabaseCount('courses', 0);

        $response = $this->actingAs($this->user())->post(route('courses.store'), $courseData);

        $this->assertDatabaseCount('courses', 1);

        $response->assertRedirect(route('courses.index'));
    }

    public function test_guests_can_not_create_a_new_course()
    {
        // $this->withoutExceptionHandling();

        $section = Section::factory()->create();
        $degree = Degree::factory()->create();

        $courseData = [
            'section_id' => $section->id,
            'degree_id' => $degree->id,
            'period' => '2021 - I',
        ];

        $this->assertDatabaseCount('courses', 0);

        $response = $this->post(route('courses.store'), $courseData);

        $this->assertDatabaseCount('courses', 0);

        $response->assertRedirect(route('login'));
    }

    
    // SECTION ID FIELD TESTS
    public function test_the_section_id_is_required()
    {
        // $this->withoutExceptionHandling();

        $section = Section::factory()->create();
        $degree = Degree::factory()->create();

        $courseData = [
            'section_id' => '',
            'degree_id' => $degree->id,
            'period' => '2021 - I',
        ];

        $this->assertDatabaseCount('courses', 0);

        $response = $this->actingAs($this->user())->post(route('courses.store'), $courseData);

        $this->assertDatabaseCount('courses', 0);

        $response->assertSessionHasErrors('section_id');
        $response->assertRedirect();
    }

    public function test_the_section_id_must_exits()
    {
        // $this->withoutExceptionHandling();

        $section = Section::factory()->create();
        $degree = Degree::factory()->create();

        $courseData = [
            'section_id' => rand(1000,2000),
            'degree_id' => $degree->id,
            'period' => '2021 - I',
        ];

        $this->assertDatabaseCount('courses', 0);

        $response = $this->actingAs($this->user())->post(route('courses.store'), $courseData);

        $this->assertDatabaseCount('courses', 0);

        $response->assertStatus(404);
    }


    // DEGREE ID FIELD TESTS

    public function test_the_degree_id_is_required()
    {
        // $this->withoutExceptionHandling();

        $section = Section::factory()->create();
        $degree = Degree::factory()->create();

        $courseData = [
            'section_id' => $section->id,
            'degree_id' => '',
            'period' => '2021 - I',
        ];

        $this->assertDatabaseCount('courses', 0);

        $response = $this->actingAs($this->user())->post(route('courses.store'), $courseData);

        $this->assertDatabaseCount('courses', 0);

        $response->assertSessionHasErrors('degree_id');
        $response->assertRedirect();
    }

    public function test_the_degree_id_must_exits()
    {
        // $this->withoutExceptionHandling();

        $section = Section::factory()->create();
        $degree = Degree::factory()->create();

        $courseData = [
            'section_id' => $section->id,
            'degree_id' => rand(1000, 2000),
            'period' => '2021 - I',
        ];

        $this->assertDatabaseCount('courses', 0);

        $response = $this->actingAs($this->user())->post(route('courses.store'), $courseData);

        $this->assertDatabaseCount('courses', 0);

        $response->assertStatus(404);
    }


    // PERIOD FIELD TESTS
    public function test_the_period_is_required()
    {
        // $this->withoutExceptionHandling();

        $section = Section::factory()->create();
        $degree = Degree::factory()->create();

        $courseData = [
            'section_id' => $section->id,
            'degree_id' => $degree->id,
            'period' => '',
        ];

        $this->assertDatabaseCount('courses', 0);

        $response = $this->actingAs($this->user())->post(route('courses.store'), $courseData);

        $this->assertDatabaseCount('courses', 0);

        $response->assertSessionHasErrors('period');
        $response->assertRedirect();
    }

    public function test_the_period_must_have_less_than_twenty_one_chars()
    {
        // $this->withoutExceptionHandling();

        $section = Section::factory()->create();
        $degree = Degree::factory()->create();
 
        $courseData = [
             'section_id' => $section->id,
             'degree_id' => $degree->id,
             'period' => Str::random(21),
         ];
 
        $this->assertDatabaseCount('courses', 0);
 
        $response = $this->actingAs($this->user())->post(route('courses.store'), $courseData);
 
        $this->assertDatabaseCount('courses', 0);
 
        $response->assertSessionHasErrors('period');
        $response->assertRedirect();
    }
}
