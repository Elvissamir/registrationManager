<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 14; $i++)
        {
            Course::factory()->create([
                'section_id' => rand(1, 3),
                'degree_id' => $i,
                'period' => '2021 - II'
            ]);
        }

    }
}
