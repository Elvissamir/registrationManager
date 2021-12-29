<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subjectTitles = [
            'Matematica', 
            'Quimica', 
            'Historia',
            'Educacion Fisica',
            'Fisica',
            'Lenguaje y Comunicacion',
            'Ingles'
        ];

        foreach ($subjectTitles as $title)
        {
            Subject::factory()->create(['title' => $title]);
        }

    }
}
