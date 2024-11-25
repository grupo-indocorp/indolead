<?php

namespace Database\Seeders;

use App\Models\Estadowick;
use Illuminate\Database\Seeder;

class EstadowickSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Estadowick::factory()->create([
            'nombre' => 'APROBADO',
        ]);

        Estadowick::factory()->create([
            'nombre' => 'OBSERVADO',
        ]);

        Estadowick::factory()->create([
            'nombre' => 'RECHAZADO',
        ]);
    }
}
