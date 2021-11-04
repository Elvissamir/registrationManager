<?php

namespace Tests\Feature\Sections;

use Tests\TestCase;
use App\Models\Course;
use App\Models\Section;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SectionModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_course_has_many_students()
    {
        $section = Section::factory()->create();

        $courseA = Course::factory()->create(['section_id' => $section->id]);
        $courseB = Course::factory()->create(['section_id' => $section->id]);

        $section->courses()->save($courseA);
        $section->courses()->save($courseB);

        $this->assertEquals($section->courses()->count(), 2);
        $this->assertEquals($section->courses[0]->id, $courseA->id);

        $this->assertEquals($section->courses()->count(), 2);
        $this->assertEquals($section->courses[1]->id, $courseB->id);
    }
}
