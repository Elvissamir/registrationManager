<?php

namespace Tests\Feature\CourseStudent;

use Tests\TestCase;
use App\Models\Course;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteCourseStudentTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_user_can_disenroll_a_student_from_a_course()
    {
        $this->withoutExceptionHandling();

        $course = Course::factory()->create();
        $student = Student::factory()->create();

        $course->students()->attach($student->id);

        $response = $this->actingAs($this->user())->delete(route('courseStudents.destroy', [$course->id, $student->id]));

        $this->assertEquals(0, $course->students()->count());

        $response->assertRedirect(route('courseStudents.show', $course->id));
    }

    public function test_a_student_can_not_be_disenrolled_from_finished_courses()
    {    
        $this->withoutExceptionHandling();
 
        $course = Course::factory()->create(['status' => 'finished']);
        $student = Student::factory()->create();
 
        $course->students()->attach($student->id);
 
        $response = $this->actingAs($this->user())->delete(route('courseStudents.destroy', [$course->id, $student->id]));
 
        $this->assertEquals(1, $course->students()->count());
 
        $response->assertRedirect(route('courseStudents.show', $course->id));
    }

   public function test_when_a_student_is_disenrolled_from_a_course_the_student_subject_records_are_deleted()
   {    
        $this->withoutExceptionHandling();

        $course = Course::factory()->create();
        $student = Student::factory()->create();

        $subjectA = Subject::factory()->create();
        $subjectB = SUbject::factory()->create();
        $subjectC = Subject::factory()->create();
        $subjectD = Subject::factory()->create();

        $course->subjects()->attach([$subjectA->id, $subjectB->id, $subjectC->id]);
        $student->subjects()->attach([$subjectA->id, $subjectB->id, $subjectC->id]);

        $response = $this->actingAs($this->user())->delete(route('courseStudents.destroy', [$course->id, $student->id]));

        $this->assertEquals(0, $student->subjects()->count());

        $response->assertRedirect(route('courseStudents.show', $course->id));
   }
}
