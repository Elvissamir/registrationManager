<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\Degree;
use App\Models\Section;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Course::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'section_id' => Section::factory(),
            'degree_id' => Degree::factory(),
            'period' => Str::random(20),
            'status' => 'active',
        ];
    }
}
