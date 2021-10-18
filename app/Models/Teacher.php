<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    // PROPERTIES
    protected $fillable = ['first_name', 'last_name', 'age', 'ci', 'phone_mobile', 'phone_house'];
}
