<?php

namespace Database\Seeders;

use App\Models\Notificaciontipo;
use Illuminate\Database\Seeder;

class NotificaciontipoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Notificaciontipo::factory()->create([
            'nombre' => 'General',
        ]);

        Notificaciontipo::factory()->create([
            'nombre' => 'Cita',
        ]);

        Notificaciontipo::factory()->create([
            'nombre' => 'Llamada',
        ]);
    }
}
