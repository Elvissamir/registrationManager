<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Exceptions\CanNotDeleteAssignedSection;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Section extends Model
{
    use HasFactory;

    // Properties
    protected $fillable = ['name'];

    // Relationships
    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    // Events
    protected static function boot() 
    {
        parent::boot();

        static::deleting(function ($section) {
            if ($section->courses()-> count() > 0)
            {
                throw new CanNotDeleteAssignedSection('Can not delete the section of id ' . $section->id . ' , it has been assigned to some courses.');
            }
        });
    }
}
