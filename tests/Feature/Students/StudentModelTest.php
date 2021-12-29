<?php

namespace Tests\Feature\Students;

use Tests\TestCase;
use App\Models\Course;
use App\Models\Student;
use App\Models\Subject;
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

    public function test_a_student_has_many_subjects()
    {
        $student = Student::factory()->create();

        $subjectA = Subject::factory()->create();
        $subjectB = Subject::factory()->create();

        $student->subjects()->attach([$subjectA->id, $subjectB->id]);

        $this->assertEquals($student->subjects()->count(), 2);

        $this->assertEquals($student->subjects[0]->title, $subjectA->title);
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

    public function test_the_current_course_method_gets_the_active_course_the_student_is_studying()
    {
        $student = Student::factory()->create(); 

        $courseA = Course::factory()->create();
        $courseB = Course::factory()->create(['status' => 'finished']);

        $student->courses()->attach([$courseA->id, $courseB->id]);

       $this->assertEquals($student->currentCourse()->degree->title, $courseA->degree->title);
    }
}
