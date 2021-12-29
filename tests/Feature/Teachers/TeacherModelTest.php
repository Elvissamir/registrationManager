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

    public function test_a_teacher_has_many_subjects()
    {
        $this->withoutExceptionHandling();

        $teacher = Teacher::factory()->create();

        $subjectA = Subject::factory()->create();
        $subjectB = Subject::factory()->create();
        $subjectC = Subject::factory()->create();

        $teacher->subjects()->attach([$subjectA->id, $subjectB->id, $subjectC->id]);

        $this->assertEquals(3, $teacher->subjects()->count());
        $this->assertEquals($subjectA->id, $teacher->subjects[0]->id);
        $this->assertEquals($subjectB->id, $teacher->subjects[1]->id);
        $this->assertEquals($subjectC->id, $teacher->subjects[2]->id);
    }
}
