<?php

namespace Tests\Feature\Degrees;

use Tests\TestCase;
use App\Models\Course;
use App\Models\Degree;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DegreeModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_course_has_many_courses()
    {
        $degree = Degree::factory()->create();

        $courseA = Course::factory()->create(['degree_id' => $degree->id]);
        $courseB = Course::factory()->create(['degree_id' => $degree->id]);

        $degree->courses()->save($courseA);
        $degree->courses()->save($courseB);

        $this->assertEquals($degree->courses()->count(), 2);
        $this->assertEquals($degree->courses[0]->id, $courseA->id);

        $this->assertEquals($degree->courses()->count(), 2);
        $this->assertEquals($degree->courses[1]->id, $courseB->id);
    }
}
