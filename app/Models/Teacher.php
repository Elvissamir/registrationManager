<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
