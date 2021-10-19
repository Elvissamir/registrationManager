<?php

namespace Tests\Feature\Subjects;

use Tests\TestCase;
use App\Models\Course;
use App\Models\Subject;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubjectModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_subject_has_many_courses()
    {
        $this->withoutExceptionHandling();

        $subject = Subject::factory()->create();

        $course = Course::factory()->create();

        $subject->courses()->attach($course->id);

        $this->assertEquals($subject->courses()->count(), 1);

        $this->assertEquals($subject->courses[0]->id, $course->id);
    }

    public function test_the_method_not_added_subjects_gets_the_right_subjects()
    {
        $this->withoutExceptionHandling();

        $subjectA = Subject::factory()->create();
        $subjectB = Subject::factory()->create();
        $subjectC = Subject::factory()->create();

        $course = Course::factory()->create();

        $course->subjects()->attach($subjectA->id);
        $course->subjects()->attach($subjectB->id);

        $notAddedSubjects = Subject::notAddedToCourse($course->id);

        $this->assertEquals(1, $notAddedSubjects->count());
        $this->assertEquals($subjectC->id, $notAddedSubjects[0]->id);
        $this->assertEquals($subjectC->title, $notAddedSubjects[0]->title);
    }
}
