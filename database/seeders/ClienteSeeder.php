<?php

namespace Database\Seeders;

use App\Models\Cliente;
use Illuminate\Database\Seeder;

class ClienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clientes = Cliente::factory(5)->create();

        foreach ($clientes as $cliente) {
            $cliente->etapas()->attach([
                rand(1, 6),
            ]);
            $cliente->usersHistorial()->attach(2);
        }
    }
}
