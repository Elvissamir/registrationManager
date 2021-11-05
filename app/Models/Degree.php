<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Exceptions\CanNotDeleteAssignedDegree;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Degree extends Model
{
    use HasFactory;

    // Properties
    protected $fillable = ['title', 'level'];

    // Relationships
    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    // Events
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($degree) {
            if ($degree->courses()->count() > 0)
                throw new CanNotDeleteAssignedDegree('Can not delete the degree of id ' . $degree->id . ', it has been assigned to some courses.');
        });
    }
}
