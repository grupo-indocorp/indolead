<?php

namespace Database\Seeders;

use App\Models\Estadoproducto;
use Illuminate\Database\Seeder;

class EstadoproductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Estadoproducto::create([
            'id_name' => 'activo',
            'name' => 'activo',
        ]);
        Estadoproducto::create([
            'id_name' => 'baja_apc',
            'name' => 'baja apc',
        ]);
        Estadoproducto::create([
            'id_name' => 'baja_portabilidad',
            'name' => 'baja portabilidad',
        ]);
        Estadoproducto::create([
            'id_name' => 'corte_deuda_parcial',
            'name' => 'corte deuda parcial',
        ]);
        Estadoproducto::create([
            'id_name' => 'corte_deuda_total',
            'name' => 'corte deuda total',
        ]);
        Estadoproducto::create([
            'id_name' => 'prepago',
            'name' => 'prepago',
        ]);
        Estadoproducto::create([
            'id_name' => 'suspendido_apc',
            'name' => 'suspendido apc',
        ]);

    }
}
