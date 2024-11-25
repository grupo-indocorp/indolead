<?php

namespace Database\Seeders;

use App\Models\Etiqueta;
use Illuminate\Database\Seeder;

class EtiquetaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Etiqueta::create(['nombre' => 'nuevo']);
        Etiqueta::create(['nombre' => 'asignado']);
        Etiqueta::create(['nombre' => 'solicitado']);
        Etiqueta::create(['nombre' => 'gestionado']);
    }
}
