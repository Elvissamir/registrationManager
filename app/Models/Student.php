<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Exceptions\CanNotDeleteEnrolledStudent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Exceptions\CanNotDeleteStudentWithFinishedCourses;

class Student extends Model
{
    use HasFactory;

    // Properties
    protected $fillable = ['first_name', 'last_name', 'age', 'phone_mobile', 'phone_house'];

    // Methods
    public static function notEnrolledInCourse($courseId)
    {
        return Student::whereDoesntHave('courses', function (Builder $query) use ($courseId) {
            $query->where('course_id', $courseId);
        })->get();
    }

    public function currentCourse()
    {
        $studentId = $this->id;

        $currentCourse = Course::where('status', 'active')->whereHas('students', function ($query) use($studentId) {
            $query->where('students.id', $studentId);
        })->with(['degree', 'section', 'subjects'])->get();

        if ($currentCourse->count() == 0)
            return Null;
        else 
            return $currentCourse[0];
    }

    // Relationships
    public function courses()
    {
        return $this->belongsToMany(Course::class);
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class)->withPivot('first', 'second', 'third', 'fourth');
    }

    // Events
    protected static function boot()
    {
        parent::boot();

        return static::deleting(function ($student) {
            if ($student->courses()->where('status', 'active')->count() > 0)
                throw new CanNotDeleteEnrolledStudent('Could not delete student. The student is currently enrolled on a course.');

            if ($student->courses()->where('status', 'finished')->count() > 0)
                throw new CanNotDeleteStudentWithFinishedCourses('Could not delete student. The student has some finished courses.');
        });
    }
}
