<?php

namespace Database\Seeders;

use App\Models\Tipodocumento;
use Illuminate\Database\Seeder;

class TipodocumentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tipodocumento::create([
            'id_name' => 'dni',
            'name' => 'Documento Nacional de Identidad',
            'abbreviation' => 'DNI',
        ]);
        Tipodocumento::create([
            'id_name' => 'ruc',
            'name' => 'Registro Único de Contribuyentes',
            'abbreviation' => 'RUC',
        ]);
        Tipodocumento::create([
            'id_name' => 'ce',
            'name' => 'Carnet de Extranjería',
            'abbreviation' => 'CE',
        ]);
    }
}
