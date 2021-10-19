<?php

namespace Tests\Feature\Courses;

use Tests\TestCase;
use App\Models\Course;
use App\Models\Degree;
use App\Models\Section;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CourseModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_course_belongs_to_a_section()
    {
        $section = Section::factory()->create();
        $degree = Degree::factory()->create();

        $course = Course::factory()->create([
            'section_id' => $section->id, 
            'degree_id' => $degree->id,    
        ]);

        $this->assertEquals($course->section->name, $section->name);
    }

    public function test_a_course_belongs_to_a_degree()
    {
        $section = Section::factory()->create();
        $degree = Degree::factory()->create();

        $course = Course::factory()->create([
            'section_id' => $section->id, 
            'degree_id' => $degree->id,    
        ]);

        $this->assertEquals($course->degree->title, $degree->title);
    }

    public function test_a_course_has_many_students()
    {
        $studentA = Student::factory()->create();
        $studentB = Student::factory()->create();

        $course = Course::factory()->create();

        $course->students()->attach($studentA->id);
        $course->students()->attach($studentB->id);

        $this->assertEquals($course->students()->count(), 2);
        $this->assertEquals($course->students[0]->id, $studentA->id);
        $this->assertEquals($course->students[0]->first_name, $studentA->first_name);

        $this->assertEquals($course->students[1]->id, $studentB->id);
        $this->assertEquals($course->students[1]->first_name, $studentB->first_name);
    }

    public function test_a_course_has_many_subjects()
    {
        $subjectA = Subject::factory()->create();
        $subjectB = Subject::factory()->create();

        $course = Course::factory()->create();

        $course->subjects()->attach($subjectA->id);
        $course->subjects()->attach($subjectB->id);

        $this->assertEquals($course->subjects()->count(), 2);
        $this->assertEquals($course->subjects[0]->id, $subjectA->id);
        $this->assertEquals($course->subjects[0]->title, $subjectA->title);

        $this->assertEquals($course->subjects[1]->id, $subjectB->id);
        $this->assertEquals($course->subjects[1]->title, $subjectB->title);
    }

}
