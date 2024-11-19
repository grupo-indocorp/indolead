<?php

namespace Database\Seeders;

use App\Models\Equipo;
use Illuminate\Database\Seeder;

class EquipoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Equipo::factory()->create([
            'nombre' => 'Senior',
            'sede' => 'Huancayo',
            'user_id' => 5,
        ]);

        Equipo::factory()->create([
            'nombre' => 'Premium 1',
            'sede' => 'Huancayo',
            'user_id' => 6,
        ]);

        Equipo::factory()->create([
            'nombre' => 'Premium 2',
            'sede' => 'Huancayo',
            'user_id' => 7,
        ]);

        Equipo::factory()->create([
            'nombre' => 'Fija Tradicional',
            'sede' => 'Huancayo',
            'user_id' => 8,
        ]);

        Equipo::factory()->create([
            'nombre' => 'Fija Tradicional 2r',
            'sede' => 'Huancayo',
            'user_id' => 9,
        ]);

        Equipo::factory()->create([
            'nombre' => 'Fija Avanzada',
            'sede' => 'Huancayo',
            'user_id' => 10,
        ]);
    }
}
