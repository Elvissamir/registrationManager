<?php

namespace Tests\Feature\Courses;

use Tests\TestCase;
use App\Models\Course;
use App\Models\Degree;
use App\Models\Section;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CourseModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_course_belongs_to_a_section()
    {
        $section = Section::factory()->create();
        $degree = Degree::factory()->create();

        $course = Course::factory()->create([
            'section_id' => $section->id, 
            'degree_id' => $degree->id,    
        ]);

        $this->assertEquals($course->section->name, $section->name);
    }

    public function test_a_course_belongs_to_a_degree()
    {
        $section = Section::factory()->create();
        $degree = Degree::factory()->create();

        $course = Course::factory()->create([
            'section_id' => $section->id, 
            'degree_id' => $degree->id,    
        ]);

        $this->assertEquals($course->degree->title, $degree->title);
    }
}
