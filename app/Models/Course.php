<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory;

    // Properties
    protected $fillable = ['section_id', 'degree_id', 'title', 'period', 'status'];

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
}
