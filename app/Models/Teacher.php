<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Exceptions\CanNotDeleteAssignedTeacher;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Teacher extends Model
{
    use HasFactory;

    // Properties
    protected $fillable = ['first_name', 'last_name', 'age', 'ci', 'phone_mobile', 'phone_house'];

    // Relationships
    public function subjects() 
    {
       return $this->belongsToMany(Subject::class);
    }

    // Events
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($teacher) {
            if ($teacher->subjects()->count() > 0)
                throw new CanNotDeleteAssignedTeacher('Could not delete. The teacher is assigned to a subject or has taught subjects in the past.');
        });
    }
}
