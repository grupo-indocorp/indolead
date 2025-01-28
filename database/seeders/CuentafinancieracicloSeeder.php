<?php

namespace Database\Seeders;

use App\Models\Cuentafinancieraciclo;
use Illuminate\Database\Seeder;

class CuentafinancieracicloSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Cuentafinancieraciclo::create([
            'ciclo' => 5,
            'fecha_emision' => 5,
            'fecha_vencimiento' => 21,
        ]);
        Cuentafinancieraciclo::create([
            'ciclo' => 15,
            'fecha_emision' => 15,
            'fecha_vencimiento' => 1,
        ]);
        Cuentafinancieraciclo::create([
            'ciclo' => 17,
            'fecha_emision' => 18,
            'fecha_vencimiento' => 5,
        ]);
        Cuentafinancieraciclo::create([
            'ciclo' => 23,
            'fecha_emision' => 23,
            'fecha_vencimiento' => 9,
        ]);
        Cuentafinancieraciclo::create([
            'ciclo' => 27,
            'fecha_emision' => 27,
            'fecha_vencimiento' => 13,
        ]);
        Cuentafinancieraciclo::create([
            'ciclo' => 31,
            'fecha_emision' => 1,
            'fecha_vencimiento' => 17,
        ]);
    }
}
