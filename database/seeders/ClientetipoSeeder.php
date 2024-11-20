<?php

namespace Database\Seeders;

use App\Models\Clientetipo;
use Illuminate\Database\Seeder;

class ClientetipoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Clientetipo::factory()->create([
            'nombre' => 'NCP',
        ]);

        Clientetipo::factory()->create([
            'nombre' => 'NAT',
        ]);

        Clientetipo::factory()->create([
            'nombre' => 'VACANTE',
        ]);
    }
}
