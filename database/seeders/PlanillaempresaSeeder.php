<?php

namespace Database\Seeders;

use App\Models\Planillaempresa;
use Illuminate\Database\Seeder;

class PlanillaempresaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Planillaempresa::create([
            'id_name' => 'indotech-peru-sac',
            'name' => 'indotech perú sac',
        ]);
        Planillaempresa::create([
            'id_name' => 'indotech-sac',
            'name' => 'indotech sac',
        ]);
        Planillaempresa::create([
            'id_name' => 'interconect-servicios-sac',
            'name' => 'interconect servicios sac',
        ]);
        Planillaempresa::create([
            'id_name' => 'interglobal-sac',
            'name' => 'interglobal sac',
        ]);
        Planillaempresa::create([
            'id_name' => 'security-rocer',
            'name' => 'security rocer',
        ]);
        Planillaempresa::create([
            'id_name' => 'sm-eirl',
            'name' => 'sm eirl',
        ]);
    }
}
