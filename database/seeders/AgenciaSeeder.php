<?php

namespace Database\Seeders;

use App\Models\Agencia;
use Illuminate\Database\Seeder;

class AgenciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Agencia::factory()->create([
            'nombre' => 'INDOTECH',
        ]);

        Agencia::factory()->create([
            'nombre' => 'VACANTE',
        ]);

        Agencia::factory()->create([
            'nombre' => 'OTROS',
        ]);
    }
}
