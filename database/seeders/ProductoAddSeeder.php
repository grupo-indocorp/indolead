<?php

namespace Database\Seeders;

use App\Models\Producto;
use Illuminate\Database\Seeder;

class ProductoAddSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Producto::factory()->create([
            'nombre' => 'Avanzada 2',
        ]);
        Producto::factory()->create([
            'nombre' => 'Avanzada 3',
        ]);
    }
}
