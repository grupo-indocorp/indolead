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
        // área de sistemas
        $sistema = Role::create(['name' => 'sistema']);

        // área comercial
        $gerente_general = Role::create(['name' => 'gerente general']);
        $gerente_comercial = Role::create(['name' => 'gerente comercial']);
        $asistente_comercial = Role::create(['name' => 'asistente comercial']);
        $jefe_comercial = Role::create(['name' => 'jefe comercial']);
        $backoffice = Role::create(['name' => 'backoffice']);
        $calidad_comercial = Role::create(['name' => 'calidad comercial']);
        $supervisor = Role::create(['name' => 'supervisor']);
        $ejecutivo = Role::create(['name' => 'ejecutivo']);

        // área administrativa
        $administrador = Role::create(['name' => 'administrador']);
        $asistente_administrador = Role::create(['name' => 'asistente administrador']);
        $recursos_humanos = Role::create(['name' => 'recursos humanos']);
        $asistente_recursos_humanos = Role::create(['name' => 'asistente recursos humanos']);
        $capacitador = Role::create(['name' => 'capacitador']);
        $planificacion = Role::create(['name' => 'planificacion']);
        $soporte_comercial = Role::create(['name' => 'soporte comercial']);
        $soporte_sistemas = Role::create(['name' => 'soporte sistemas']);
        $delivery = Role::create(['name' => 'delivery']);
        $finanzas = Role::create(['name' => 'finanzas']);

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
        Permission::create(['name' => 'sistema.evaporacion']);
        Permission::create(['name' => 'sistema.evaporacion.subir']);
        Permission::create(['name' => 'sistema.evaporacion-gestion']);

        $sistema->syncPermissions(Permission::all());
        $gerente_general->syncPermissions([
            'sistema.cliente',
        ]);
        $gerente_comercial->syncPermissions([
            'sistema.dashboard',
            'sistema.cliente',
            'sistema.gestion_cliente',
            'sistema.gestion_cliente.exportar',
            'sistema.notificacion',
            'sistema.reporte',
            'sistema.reporte.cliente',
        ]);
        $asistente_comercial->syncPermissions([
            'sistema.cliente',
        ]);
        $jefe_comercial->syncPermissions([
            'sistema.cliente',
        ]);
        $backoffice->syncPermissions([
            'sistema.cliente',
        ]);
        $calidad_comercial->syncPermissions([
            'sistema.cliente',
        ]);
        $supervisor->syncPermissions([
            'sistema.cliente',
            'sistema.gestion_cliente',
            'sistema.gestion_cliente.exportar',
            'sistema.notificacion',
            'sistema.gestion_cliente.asignar',
        ]);
        $ejecutivo->syncPermissions([
            'sistema.cliente',
            'sistema.gestion_cliente',
            'sistema.gestion_cliente.agregar',
            'sistema.notificacion',
        ]);
    }
}
