<?php

namespace Tests\Feature\Students;

use Tests\TestCase;
use App\Models\Course;
use App\Models\Student;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StudentModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_student_has_many_courses()
    {
        $student = Student::factory()->create();

        $course = Course::factory()->create();

        $student->courses()->attach($course->id);

        $this->assertEquals($student->courses()->count(), 1);

        $this->assertEquals($student->courses[0]->id, $course->id);
    }

    public function test_gets_the_students_not_enrolled_on_the_course()
    {
        $studentA = Student::factory()->create();
        $studentB = Student::factory()->create();
        $studentC = Student::factory()->create();
        $studentD = Student::factory()->create();
        $studentE = Student::factory()->create();        

        $course = Course::factory()->create();

        $studentA->courses()->attach($course->id);
        $studentB->courses()->attach($course->id);

        $studentsNotEnrolled = Student::notEnrolledInCourse($course->id);

        $this->assertEquals($course->students()->count(), 2);
        $this->assertEquals($studentsNotEnrolled->count(), 3);
        $this->assertEquals($studentsNotEnrolled[0]->id, $studentC->id);
        $this->assertEquals($studentsNotEnrolled[1]->id, $studentD->id);
    }
}
