<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
}
