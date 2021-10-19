<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subject extends Model
{
    use HasFactory;

    // Properties
    protected $fillable = ['title', 'credits'];

    // Methods
    public static function notAddedToCourse ($courseId)
    {
        return Subject::whereDoesntHave('courses', function (Builder $query) use($courseId) {
            $query->where('course_id', $courseId);
        })->get();
    }

    // Relationships
    public function teachers()
    {
        return $this->belongsToMany(Teacher::class);
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class);
    }
}
