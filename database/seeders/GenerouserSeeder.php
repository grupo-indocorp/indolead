<?php

namespace Database\Seeders;

use App\Models\Generouser;
use Illuminate\Database\Seeder;

class GenerouserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Generouser::create([
            'id_name' => 'masculino',
            'name' => 'masculino',
            'abbreviation' => 'm',
        ]);
        Generouser::create([
            'id_name' => 'femenino',
            'name' => 'femenino',
            'abbreviation' => 'f',
        ]);
    }
}
