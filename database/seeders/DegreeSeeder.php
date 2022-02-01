<?php

namespace Database\Seeders;

use App\Models\Degree;
use Illuminate\Database\Seeder;

class DegreeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $degrees = [
            ['title' => 'Preescolar', 'level' => '1'],
            ['title' => 'Preescolar', 'level' => '2'],
            ['title' => 'Preescolar', 'level' => '3'],
            ['title' => 'Primaria', 'level' => '1'],
            ['title' => 'Primaria', 'level' => '2'],
            ['title' => 'Primaria', 'level' => '3'],
            ['title' => 'Primaria', 'level' => '4'],
            ['title' => 'Primaria', 'level' => '5'],
            ['title' => 'Primaria', 'level' => '6'],
            ['title' => 'Bachillerato', 'level' => '1'],
            ['title' => 'Bachillerato', 'level' => '2'],
            ['title' => 'Bachillerato', 'level' => '3'],
            ['title' => 'Bachillerato', 'level' => '4'],
            ['title' => 'Bachillerato', 'level' => '5'],
            ['title' => 'Bachillerato', 'level' => '6'],
        ];

        foreach ($degrees as $degree)
        {
            Degree::factory()->create(['title' => $degree['title'], 'level' => $degree['level']]);
        }
    }
}
