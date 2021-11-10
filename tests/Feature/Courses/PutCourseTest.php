<?php

namespace Tests\Feature\Courses;

use Tests\TestCase;
use App\Models\Course;
use App\Models\Degree;
use App\Models\Section;
use Illuminate\Support\Str;
use Inertia\Testing\Assert;
use App\Http\Resources\CourseResource;
use App\Http\Resources\DegreeResource;
use App\Http\Resources\SectionResource;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PutCourseTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_edit_course_page_exists_and_has_the_list_of_sections_and_degrees()
    {
        $this->withoutExceptionHandling();

        $degree = Degree::factory()->create();
        $section = Section::factory()->create();

        $course = Course::factory()->create(['section_id' => $section->id, 'degree_id' => $degree->id]);

        $sections = Section::all();
        $degrees = Degree::all();

        $response = $this->actingAs($this->user())->get(route('courses.edit', $course->id));

        $response->assertInertia(fn(Assert $page) => 
            $page->component('Courses/Edit')
                 ->where('course.id', $course->id)
                 ->where('course.degree.title', $degree->title)
                 ->where('course.section.name', $section->name)
                 ->where('sections', SectionResource::collection($sections))
                 ->where('degrees', DegreeResource::collection($degrees)));
    }

    public function test_guests_can_not_access_the_edit_course_page()
    {
        // $this->withoutExceptionHandling();

        $course = Course::factory()->create();

        $response = $this->get(route('courses.edit', $course->id));

        $response->assertRedirect(route('login'));
    }

    public function test_a_user_can_update_a_course()
    {
        $this->withoutExceptionHandling();

        $course = Course::factory()->create();

        $newSection = Section::factory()->create();
        $newDegree = Degree::factory()->create();

        $courseData = [
            'section_id' => $newSection->id,
            'degree_id' => $newDegree->id,
            'period' => '2021 - II',
        ];

        $response = $this->actingAs($this->user())->put(route('courses.update', $course->id), $courseData);

        $this->assertDatabaseHas('courses', [
            'id' => $course->id,
            'section_id' => $newSection->id,
            'degree_id' => $newDegree->id,
            'period' => '2021 - II',
        ]);

        $response->assertRedirect(route('courses.index'));
    }

    public function test_guests_can_not_update_a_course()
    {
        // $this->withoutExceptionHandling();

        $course = Course::factory()->create();

        $newSection = Section::factory()->create();
        $newDegree = Degree::factory()->create();

        $courseData = [
            'section_id' => $newSection->id,
            'degree_id' => $newDegree->id,
            'period' => '2021 - II',
        ];

        $response = $this->put(route('courses.update', $course->id), $courseData);

        $this->assertDatabaseMissing('courses', [
            'id' => $course->id,
            'section_id' => $newSection->id,
            'degree_id' => $newDegree->id,
            'period' => '2021 - II',
        ]);

        $response->assertRedirect();
    }

    // SECTION ID FIELD TESTS
    public function test_the_section_id_is_required()
    {
        // $this->withoutExceptionHandling();

        $course = Course::factory()->create();

        $newSection = Section::factory()->create();
        $newDegree = Degree::factory()->create();

        $courseData = [
            'section_id' => '',
            'degree_id' => $newDegree->id,
            'period' => '2021 - II',
        ];

        $response = $this->actingAs($this->user())->put(route('courses.update', $course->id), $courseData);

        $response->assertSessionHasErrors('section_id');
        $response->assertRedirect();
    }

    public function test_the_section_id_must_exits()
    {
        //$this->withoutExceptionHandling();

        $course = Course::factory()->create();

        $newDegree = Degree::factory()->create();

        $randomSectionId = rand(1000, 2000);

        $courseData = [
            'section_id' => $randomSectionId,
            'degree_id' => $newDegree->id,
            'period' => '2021 - II',
        ];

        $response = $this->actingAs($this->user())->put(route('courses.update', $course->id), $courseData);

        $this->assertDatabaseMissing('courses', [
            'id' => $course->id,
            'section_id' => $randomSectionId,
            'degree_id' => $newDegree->id,
            'period' => '2021 - II',
        ]);

        $response->assertStatus(404);
    }


    public function test_the_degree_id_is_required()
    {
        // $this->withoutExceptionHandling();

        $course = Course::factory()->create();

        $newSection = Section::factory()->create();
        $newDegree = Degree::factory()->create();

        $courseData = [
            'section_id' => $newSection->id,
            'degree_id' => '',
            'period' => '2021 - II',
        ];

        $response = $this->actingAs($this->user())->put(route('courses.update', $course->id), $courseData);

        $response->assertSessionHasErrors('degree_id');
        $response->assertRedirect();
    }

    public function test_the_degree_id_must_exits()
    {
        // $this->withoutExceptionHandling();

        $course = Course::factory()->create();

        $newSection = Section::factory()->create();
        $newDegree = Degree::factory()->create();

        $randomDegreeId = rand(1000, 2000);

        $courseData = [
            'section_id' => $newSection->id,
            'degree_id' => $randomDegreeId,
            'period' => '2021 - II',
        ];

        $response = $this->actingAs($this->user())->put(route('courses.update', $course->id), $courseData);

        $this->assertDatabaseMissing('courses', [
            'id' => $course->id,
            'section_id' => $newSection->id,
            'section_id' => $randomDegreeId,
            'period' => '2021 - II',
        ]);

        $response->assertStatus(404);
    }



      // PERIOD FIELD TESTS
      public function test_the_period_is_required()
      {
        // $this->withoutExceptionHandling();

        $course = Course::factory()->create();

        $newSection = Section::factory()->create();
        $newDegree = Degree::factory()->create();

        $courseData = [
            'section_id' => $newSection->id,
            'degree_id' => $newDegree->Id,
            'period' => '',
        ];

        $response = $this->actingAs($this->user())->put(route('courses.update', $course->id), $courseData);

        $response->assertSessionHasErrors('period');
        $response->assertRedirect();
      }
  
      public function test_the_period_must_have_less_than_twenty_one_chars()
      {
           // $this->withoutExceptionHandling();

        $course = Course::factory()->create();

        $newSection = Section::factory()->create();
        $newDegree = Degree::factory()->create();

        $courseData = [
            'section_id' => $newSection->id,
            'degree_id' => $newDegree->id,
            'period' => Str::random(21),
        ];

        $response = $this->actingAs($this->user())->put(route('courses.update', $course->id), $courseData);

        $response->assertSessionHasErrors('period');
        $response->assertRedirect();
      }


}
