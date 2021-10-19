<?php

namespace Tests\Feature\SubjectTeacher;

use Tests\TestCase;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostSubjectTeacherTest extends TestCase
{
   use RefreshDatabase;

   public function test_a_user_can_assign_a_teacher_to_a_subject()
   {
      //$this->withoutExceptionHandling();

      $subject = Subject::factory()->create();

      $teacherA = Teacher::factory()->create();
      $teacherB = Teacher::factory()->create();
      $teacherC = Teacher::factory()->create();

      $teacherData = [
         'teacher_id' => $teacherA->id,
      ];

      $this->assertEquals(0, $subject->teachers()->count());

      $response = $this->actingAs($this->user())->post(route('subjectTeachers.store', $subject->id), $teacherData);

      $this->assertEquals(1, $subject->teachers()->count());
      $this->assertEquals($teacherA->id, $subject->teachers[0]->id);
      $this->assertEquals($teacherA->first_name, $subject->teachers[0]->first_name);

      $response->assertRedirect(route('subjectTeachers.show', $subject->id));
   }

   public function test_guests_can_not_assign_a_teacher_to_a_subject()
   {
      //$this->withoutExceptionHandling();

      $subject = Subject::factory()->create();

      $teacherA = Teacher::factory()->create();
      $teacherB = Teacher::factory()->create();
      $teacherC = Teacher::factory()->create();

      $teacherData = [
         'teacher_id' => $teacherA->id,
      ];

      $this->assertEquals(0, $subject->teachers()->count());

      $response = $this->post(route('subjectTeachers.store', $subject->id), $teacherData);

      $this->assertEquals(0, $subject->teachers()->count());

      $response->assertRedirect(route('login'));
   }


   public function test_the_teacher_id_is_required()
   {
      //$this->withoutExceptionHandling();

      $subject = Subject::factory()->create();

      $teacherA = Teacher::factory()->create();
      $teacherB = Teacher::factory()->create();
      $teacherC = Teacher::factory()->create();

      $teacherData = [
         'teacher_id' => '',
      ];

      $this->assertEquals(0, $subject->teachers()->count());

      $response = $this->actingAs($this->user())->post(route('subjectTeachers.store', $subject->id), $teacherData);

      $this->assertEquals(0, $subject->teachers()->count());
   
      $response->assertSessionHasErrors('teacher_id');
      $response->assertRedirect();
   }

   public function test_the_teacher_id_must_exist()
   {
      //$this->withoutExceptionHandling();

      $subject = Subject::factory()->create();

      $teacherA = Teacher::factory()->create();
      $teacherB = Teacher::factory()->create();
      $teacherC = Teacher::factory()->create();

      $teacherData = [
         'teacher_id' => rand(1000, 2000),
      ];

      $this->assertEquals(0, $subject->teachers()->count());

      $response = $this->actingAs($this->user())->post(route('subjectTeachers.store', $subject->id), $teacherData);

      $this->assertEquals(0, $subject->teachers()->count());
   
      $response->assertSessionHasErrors('teacher_id');
      $response->assertRedirect();
   }
}
