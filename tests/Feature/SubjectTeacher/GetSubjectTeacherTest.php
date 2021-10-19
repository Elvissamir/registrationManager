<?php

namespace Tests\Feature\SubjectTeacher;

use Tests\TestCase;
use App\Models\Subject;
use App\Models\Teacher;
use Inertia\Testing\Assert;
use App\Http\Resources\SubjectResource;
use App\Http\Resources\TeacherResource;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GetSubjectTeacherTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_show_page_exists_and_has_the_subject_and_list_of_the_assigned_teachers()
    {
        $this->withoutExceptionHandling();

        $subject = Subject::factory()->create();

        $teacherA = Teacher::factory()->create();
        $teacherB = Teacher::factory()->create();
        $teacherC = Teacher::factory()->create();

        $subject->teachers()->attach($teacherA->id);
        $subject->teachers()->attach($teacherB->id);

        $assignedTeachers = $subject->teachers;

        $response = $this->actingAs($this->user())->get(route('subjectTeachers.show', $subject->id));

        $response->assertInertia(fn (Assert $page) => 
                 $page->component('SubjectTeachers/Show')
                      ->where('subject', new SubjectResource($subject))
                      ->where('teachers', TeacherResource::collection($assignedTeachers)));
    }


    public function test_guests_can_not_access_the_show_page()
    {
        // $this->withoutExceptionHandling();

        $subject = Subject::factory()->create();

        $response = $this->get(route('subjectTeachers.show', $subject->id));

        $response->assertRedirect(route('login'));
    }



}
