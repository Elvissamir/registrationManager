<?php

namespace Tests\Feature\CourseStudent;

use Tests\TestCase;
use App\Models\Course;
use App\Models\Degree;
use App\Models\Section;
use App\Models\Student;
use App\Models\Subject;
use Inertia\Testing\Assert;
use App\Http\Resources\CourseResource;
use App\Http\Resources\StudentResource;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GetCourseStudentTest extends TestCase
{
    use RefreshDatabase;

   public function test_the_index_page_has_the_course_and_list_of_students_enrolled_on_it()
   {
        $this->withoutExceptionHandling();

        $studentB = Student::factory()->create(['first_name' => 'Bob', 'last_name' => 'Cabrera']);
        $studentC = Student::factory()->create(['first_name' => 'Carlos', 'last_name' => 'DonaChoco']);
        $studentA = Student::factory()->create(['first_name' => 'Al', 'last_name' => 'Bondiga']);

        $degree = Degree::factory()->create();
        $section = Section::factory()->create();

        $course = Course::factory()->create(['section_id' => $section->id, 'degree_id' => $degree->id]);

        $course->students()->attach($studentB->id);
        $course->students()->attach($studentA->id);
        $course->students()->attach($studentC->id);

        $response = $this->actingAs($this->user())->get(route('courseStudents.index', $course->id));

        $response->assertInertia(fn(Assert $page) => 
        $page->component('CourseStudents/Index')
                ->where('course.id', $course->id)
                ->where('course.degree.title', $degree->title)
                ->where('course.section.name', $section->name)
                ->where('students.links.first', 'http://servm.test/courses/'.$course->id.'/students?page=1')
                ->where('students.data.0.first_name', $studentA->first_name)
                ->where('students.data.1.first_name', $studentB->first_name)
                ->where('students.data.2.first_name', $studentC->first_name));
   }

   public function test_the_show_page_has_the_course_student_scores_and_subject_data()
   {
        $this->withoutExceptionHandling();

        $student = Student::factory()->create();

        $degree = Degree::factory()->create();
        $section = Section::factory()->create();

        $subjectA = Subject::factory()->create();
        $subjectB = Subject::factory()->create();
        $subjectC = Subject::factory()->create();

        $subjectD = Subject::factory()->create();
        $subjectE = Subject::factory()->create();

        $courseA = Course::factory()->create(['section_id' => $section->id, 'degree_id' => $degree->id]);
        $courseB = Course::factory()->create(['section_id' => $section->id, 'degree_id' => $degree->id]);

        $courseA->subjects()->attach([$subjectA->id, $subjectB->id, $subjectC->id]);
        $student->subjects()->attach([$subjectA->id, $subjectB->id, $subjectC->id, $subjectD->id, $subjectE->id]);

        $courseA->students()->attach($student->id);

        $response = $this->actingAs($this->user())->get(route('courseStudents.show', [$courseA->id, $student->id]));

        $response->assertInertia(fn(Assert $page) => 
        $page->component('CourseStudents/Show')
                ->where('course.id', $courseA->id)
                ->where('course.degree.title', $degree->title)
                ->where('course.section.name', $section->name)
                ->where('student.subjects.0.first', $student->subjects[0]->pivot->first)
                ->where('student.subjects.0.second', $student->subjects[0]->pivot->second)
                ->where('student.subjects.0.third', $student->subjects[0]->pivot->third)
                ->where('student.subjects.0.fourth', $student->subjects[0]->pivot->fourth)
        );
   }

   public function test_guests_can_not_access_the_index_page()
   {
        //$this->withoutExceptionHandling();

        $course = Course::factory()->create();

        $response = $this->get(route('courseStudents.index', $course->id));

        $response->assertRedirect(route('login'));
   }
}
