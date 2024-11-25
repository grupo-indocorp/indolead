<?php

namespace Database\Seeders;

use App\Models\Modalidaduser;
use Illuminate\Database\Seeder;

class ModalidaduserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Modalidaduser::create([
            'id_name' => 'full-time',
            'name' => 'tiempo completo',
        ]);
        Modalidaduser::create([
            'id_name' => 'freelance',
            'name' => 'freelance',
        ]);
        Modalidaduser::create([
            'id_name' => 'part-time',
            'name' => 'tiempo parcial',
        ]);
    }
}
