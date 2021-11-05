<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
