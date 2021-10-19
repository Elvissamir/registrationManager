<?php

namespace Tests\Feature\Teachers;

use Tests\TestCase;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TeacherModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_subject_has_many_teachers_assigned_to_it()
    {
        $this->withoutExceptionHandling();

        $subject = Subject::factory()->create();

        $teacherA = Teacher::factory()->create();
        $teacherB = Teacher::factory()->create();
        $teacherC = Teacher::factory()->create();

        $subject->teachers()->attach($teacherA->id);
        $subject->teachers()->attach($teacherB->id);

        $this->assertEquals(2, $subject->teachers()->count());
        $this->assertEquals($teacherA->id, $subject->teachers[0]->id);
        $this->assertEquals($teacherB->id, $subject->teachers[1]->id);
    }
}
