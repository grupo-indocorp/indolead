<?php

namespace Database\Seeders;

use App\Models\Estadodito;
use Illuminate\Database\Seeder;

class EstadoditoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Estadodito::factory()->create([
            'nombre' => 'FINANCIADO',
        ]);

        Estadodito::factory()->create([
            'nombre' => 'UPFRONT',
        ]);

        Estadodito::factory()->create([
            'nombre' => 'BLOQUEADO',
        ]);
    }
}
