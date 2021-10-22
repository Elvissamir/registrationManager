<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\StudentSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            StudentSeeder::class,
            TeacherSeeder::class,
            DegreeSeeder::class,
            SectionSeeder::class,
            SubjectSeeder::class,
            CourseSeeder::class,
            UserSeeder::class,
        ]);
    }
}
