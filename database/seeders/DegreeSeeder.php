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
        $degreeTitles = [
            'Preescolar 1',
            'Preescolar 2',
            'Preescolar 3',
            'Primaria 1', 
            'Primaria 2',
            'Primaria 3',
            'Primaria 4',
            'Primaria 5',
            'Primaria 6',
            'Bachillerato 1',
            'Bachillerato 2',
            'Bachillerato 3',
            'Bachillerato 4',
            'Bachillerato 5',
        ];

        foreach ($degreeTitles as $title)
        {
            Degree::factory()->create(['title' => $title]);
        }
    }
}
