<?php

namespace Database\Seeders;

use App\Models\Estadofactura;
use Illuminate\Database\Seeder;

class EstadofacturaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Estadofactura::create([
            'id_name' => 'pagado',
            'name' => 'pagado',
        ]);
        Estadofactura::create([
            'id_name' => 'pagado_ajuste',
            'name' => 'pago parcial con ajuste',
        ]);
        Estadofactura::create([
            'id_name' => 'pagado_reclamo',
            'name' => 'pago parcial con reclamo',
        ]);
        Estadofactura::create([
            'id_name' => 'pendiente',
            'name' => 'pendiente',
        ]);
        Estadofactura::create([
            'id_name' => 'reclamo',
            'name' => 'reclamo total',
        ]);
    }
}
