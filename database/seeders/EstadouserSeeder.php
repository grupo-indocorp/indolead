<?php

namespace Database\Seeders;

use App\Models\Estadouser;
use Illuminate\Database\Seeder;

class EstadouserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Estadouser::create([
            'id_name' => 'on',
            'name' => 'activo',
        ]);
        Estadouser::create([
            'id_name' => 'off',
            'name' => 'baja',
        ]);
    }
}
