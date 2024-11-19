<?php

namespace Database\Seeders;

use App\Models\Producto;
use Illuminate\Database\Seeder;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Producto::factory()->create([
            'nombre' => 'Móvil Alta Nueva',
        ]);
        Producto::factory()->create([
            'nombre' => 'Móvil Portabilidad',
        ]);
        Producto::factory()->create([
            'nombre' => 'Fija',
        ]);
        Producto::factory()->create([
            'nombre' => 'Avanzada',
        ]);
    }
}
