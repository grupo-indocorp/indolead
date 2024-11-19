<?php

namespace Database\Seeders;

use App\Models\Etapa;
use Illuminate\Database\Seeder;

class EtapaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Etapa::factory()->create([
            'nombre' => 'Sin Gestión',
            'color' => '#f97516',
            'opacity' => '#f975164d',
        ]);

        Etapa::factory()->create([
            'nombre' => 'Interesado 25%',
            'color' => '#f97516',
            'opacity' => '#f975164d',
        ]);

        Etapa::factory()->create([
            'nombre' => 'Prospecto 50%',
            'color' => '#f59e0b',
            'opacity' => '#f59e0b4d',
        ]);

        Etapa::factory()->create([
            'nombre' => 'Oportunidad 75%',
            'color' => '#facc15',
            'opacity' => '#facc154d',
        ]);

        Etapa::factory()->create([
            'nombre' => 'Ganado 100%',
            'color' => '#84cc16',
            'opacity' => '#84cc164d',
        ]);

        Etapa::factory()->create([
            'nombre' => 'Perdido',
            'color' => '#dc2626',
            'opacity' => '#dc26264d',
        ]);
    }
}
