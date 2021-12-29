<?php

namespace Tests\Feature\StudentSubject;

use Tests\TestCase;
use App\Models\Course;
use App\Models\Student;
use App\Models\Subject;
use Inertia\Testing\Assert;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PutStudentSubjectTest extends TestCase
{
   use RefreshDatabase;

   public function test_the_edit_subject_student_score_page_exists()
   {
       $this->withoutExceptionHandling();

       $courseA = Course::factory()->create();
       $courseB = Course::factory()->create();

       $student = Student::factory()->create();
       $subjectA = Subject::factory()->create();
       $subjectB = Subject::factory()->create();

       $courseA->subjects()->attach([$subjectA->id, $subjectB->id]);
       $courseA->students()->attach($student);
       $student->subjects()->attach($subjectA->id);

       $response = $this->actingAs($this->user())->get(route('studentSubjects.edit', [$student->id, $subjectA->id]));

       $response->assertInertia(fn (Assert $page) => 
            $page->component('StudentSubjects/Edit')
                 ->where('course.section.name', $courseA->section->name)
                 ->where('course.degree.title', $courseA->degree->title)
                 ->where('student.first_name', $student->first_name)
                 ->where('subject.title', $subjectA->title)
                 ->where('subject.first', $student->subjects()->where('subjects.id', $subjectA->id)->first()->pivot->first)
       );
   }

   public function test_the_user_can_update_the_scores_of_a_student_subject()
   {
        $this->withoutExceptionHandling();

        $courseA = Course::factory()->create();
        $courseB = Course::factory()->create();

        $student = Student::factory()->create();
        $subjectA = Subject::factory()->create();
        $subjectB = Subject::factory()->create();

        $courseA->subjects()->attach([$subjectA->id, $subjectB->id]);
        $courseA->students()->attach($student);
        $student->subjects()->attach($subjectA->id);

        $scoresData = [
            'first' => 20,
            'second' => 15,
            'third' => 10,
            'fourth' => 12
        ];

        $response = $this->actingAs($this->user())->put(route('studentSubjects.update', [$student->id, $subjectA->id]), $scoresData);

        $this->assertEquals(20, $student->subjects()->where('subjects.id', $subjectA->id)->first()->pivot->first);
        $this->assertEquals(15, $student->subjects()->where('subjects.id', $subjectA->id)->first()->pivot->second);
        $this->assertEquals(10, $student->subjects()->where('subjects.id', $subjectA->id)->first()->pivot->third);
        $this->assertEquals(12, $student->subjects()->where('subjects.id', $subjectA->id)->first()->pivot->fourth);

        $response->assertRedirect(route('courseStudents.show', [$courseA->id, $student->id]));
   }
}
