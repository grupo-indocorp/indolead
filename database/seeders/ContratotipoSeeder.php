<?php

namespace Database\Seeders;

use App\Models\Contratotipo;
use Illuminate\Database\Seeder;

class ContratotipoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Contratotipo::create([
            'id_name' => 'location',
            'name' => 'locación',
        ]);
        Contratotipo::create([
            'id_name' => 'freelance',
            'name' => 'freelance',
        ]);
        Contratotipo::create([
            'id_name' => 'payroll',
            'name' => 'planilla',
        ]);
    }
}
