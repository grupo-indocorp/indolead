<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sistema = Role::create(['name' => 'sistema']);
        $administrador = Role::create(['name' => 'administrador']);
        $gerente = Role::create(['name' => 'gerente comercial']);
        $supervisor = Role::create(['name' => 'supervisor']);
        $ejecutivo = Role::create(['name' => 'ejecutivo']);
        $invitado = Role::create(['name' => 'invitado']);
        Permission::create(['name' => 'sistema.dashboard']);
        Permission::create(['name' => 'sistema.cliente']);
        Permission::create(['name' => 'sistema.funnel']);
        Permission::create(['name' => 'sistema.gestion_cliente']);
        Permission::create(['name' => 'sistema.gestion_cliente.buscar']);
        Permission::create(['name' => 'sistema.gestion_cliente.agregar']);
        Permission::create(['name' => 'sistema.gestion_cliente.asignar']);
        Permission::create(['name' => 'sistema.gestion_cliente.exportar']);
        Permission::create(['name' => 'sistema.gestion_cliente.importar']);
        Permission::create(['name' => 'sistema.lista_usuario']);
        Permission::create(['name' => 'sistema.equipo']);
        Permission::create(['name' => 'sistema.role']);
        Permission::create(['name' => 'sistema.configuracion']);
        Permission::create(['name' => 'sistema.notificacion']);

        Permission::create(['name' => 'sistema.buscar']);

        Permission::create(['name' => 'sistema.reporte']);
        Permission::create(['name' => 'sistema.reporte.cliente']);

        $sistema->syncPermissions(Permission::all());
        $administrador->syncPermissions(Permission::all());
        $gerente->syncPermissions([
            'sistema.cliente',
            'sistema.gestion_cliente',
        ]);
        $supervisor->syncPermissions([
            'sistema.cliente',
            'sistema.gestion_cliente'
        ]);
        $ejecutivo->syncPermissions([
            'sistema.cliente',
            'sistema.gestion_cliente',
            'sistema.gestion_cliente.buscar',
            'sistema.gestion_cliente.agregar',
            'sistema.gestion_cliente.agregar',
            'sistema.notificacion',
        ]);
    }
}
