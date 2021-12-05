<?php

namespace Tests\Feature\CourseStudent;

use Tests\TestCase;
use App\Models\Course;
use App\Models\Student;
use App\Models\Subject;
use Inertia\Testing\Assert;
use App\Http\Resources\CourseResource;
use App\Http\Resources\StudentResource;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostCourseStudentTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_create_page_has_the_course_and_list_of_students_that_are_not_enrolled()
    {
        $this->withoutExceptionHandling();
 
        $studentA = Student::factory()->create();
        $studentB = Student::factory()->create();
        $studentB = Student::factory()->create();

        $course = Course::factory()->create();
 
        $course->students()->attach($studentA->id);

        $notEnrolledStudents = Student::notEnrolledInCourse($course->id);

        $response = $this->actingAs($this->user())->get(route('courseStudents.create', $course->id));
 
        $response->assertInertia(fn(Assert $page) => 
            $page->component('CourseStudents/Create')
                 ->where('course', new CourseResource($course))
                 ->where('students', StudentResource::collection($notEnrolledStudents)));
    }

    public function test_a_user_can_enroll_a_student_on_a_course()
    {
        $this->withoutExceptionHandling();

        $studentA = Student::factory()->create();
        $studentB = Student::factory()->create();

        $course = Course::factory()->create();

        $enrollData = [
            'student_id' => $studentB->id,
        ];

        $this->assertEquals($course->students()->count(), 0);

        $response = $this->actingAs($this->user())->post(route('courseStudents.store', $course->id), $enrollData);

        $this->assertEquals($course->students()->count(), 1);

        $this->assertEquals($course->students[0]->first_name, $studentB->first_name);
        $this->assertEquals($course->students[0]->first_name, $studentB->first_name);

        $response->assertRedirect(route('courseStudents.show', $course->id));
    }

    public function test_a_student_can_only_enroll_on_active_courses()
    {
        $this->withoutExceptionHandling();

        $course = Course::factory()->create(['status' => 'finished']);
        $student = Student::factory()->create();

        $enrollData = [
            'student_id' => $student->id,
        ];

        $this->assertEquals($course->students()->count(), 0);

        $response = $this->actingAs($this->user())->post(route('courseStudents.store', $course->id), $enrollData);

        $this->assertEquals($course->students()->count(), 0);

        $response->assertRedirect(route('courseStudents.show', $course->id));
    }

    public function test_when_the_student_is_enrolled_on_a_course_he_is_assigned_to_the_course_subjects()
    {
        $this->withoutExceptionHandling();

        $student = Student::factory()->create();

        $course = Course::factory()->create();

        $subjectA = Subject::factory()->create();
        $subjectB = SUbject::factory()->create();
        $subjectC = Subject::factory()->create();
        $subjectD = Subject::factory()->create();

        $course->subjects()->attach([$subjectA->id, $subjectB->id, $subjectC->id]);

        $enrollData = [
            'student_id' => $student->id,
        ];

        $response = $this->actingAs($this->user())->post(route('courseStudents.store', $course->id), $enrollData);

        $this->assertEquals($course->subjects()->count(), $student->subjects()->count());
        $this->assertEquals($subjectA->title, $student->subjects[0]->title);
        $this->assertEquals($subjectB->title, $student->subjects[1]->title);
        $this->assertEquals($subjectC->title, $student->subjects[2]->title);
    }

    public function test_guests_can_not_enroll_students_on_courses()
    {
        // $this->withoutExceptionHandling();

        $studentA = Student::factory()->create();
        $studentB = Student::factory()->create();

        $course = Course::factory()->create();

        $enrollData = [
            'student_id' => $studentB->id,
        ];

        $this->assertEquals($course->students()->count(), 0);

        $response = $this->post(route('courseStudents.store', $course->id), $enrollData);

        $this->assertEquals($course->students()->count(), 0);
        $response->assertRedirect(route('login'));
    }

    public function test_the_student_id_is_required()
    {
        // $this->withoutExceptionHandling();

        $studentA = Student::factory()->create();
        $studentB = Student::factory()->create();

        $course = Course::factory()->create();

        $enrollData = [
            'student_id' => '',
        ];

        $this->assertEquals($course->students()->count(), 0);

        $response = $this->actingAs($this->user())->post(route('courseStudents.store', $course->id), $enrollData);

        $this->assertEquals($course->students()->count(), 0);

        $response->assertSessionHasErrors('student_id');
        $response->assertRedirect();
    }

    public function test_the_student_id_must_exist()
    {
       // $this->withoutExceptionHandling();

       $studentA = Student::factory()->create();
       $studentB = Student::factory()->create();

       $course = Course::factory()->create();

       $enrollData = [
           'student_id' => rand(1000, 2000),
       ];

       $this->assertEquals($course->students()->count(), 0);

       $response = $this->actingAs($this->user())->post(route('courseStudents.store', $course->id), $enrollData);

       $this->assertEquals($course->students()->count(), 0);

       $response->assertSessionHasErrors('student_id');
       $response->assertRedirect();
    }

}
