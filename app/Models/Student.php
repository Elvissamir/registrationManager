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

    // Relationships
    public function courses()
    {
        return $this->belongsToMany(Course::class);
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
