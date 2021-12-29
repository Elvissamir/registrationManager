<?php

namespace App\Models;

use App\Models\Degree;
use App\Models\Section;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Exceptions\CanNotDeleteIfHasEnrolledStudents;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory;

    // Properties
    protected $fillable = ['section_id', 'degree_id', 'title', 'period', 'status'];

    // METHODS

    // RELATIONSHIPS
    public function section() 
    {
        return $this->belongsTo(Section::class);
    }

    public function degree()
    {
        return $this->belongsTo(Degree::class);
    }

    public function students()
    {
        return $this->belongsToMany(Student::class);
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class);
    }

    // EVENTS
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($course) {
            if ($course->students()->count() > 0)
                throw new CanNotDeleteIfHasEnrolledStudents('Can not delete the course ' . $course->section->name . ' ' . $course->degree->title . ', it has enrolled students.'); 
        });
    }
}
