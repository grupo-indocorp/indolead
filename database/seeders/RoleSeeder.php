<?php

namespace Database\Seeders;

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
        $sistema = Role::firstOrCreate(['name' => 'sistema']);

        // área comercial
        $gerente_general = Role::firstOrCreate(['name' => 'gerente general']);
        $gerente_comercial = Role::firstOrCreate(['name' => 'gerente comercial']);
        $asistente_comercial = Role::firstOrCreate(['name' => 'asistente comercial']);
        $jefe_comercial = Role::firstOrCreate(['name' => 'jefe comercial']);
        $backoffice = Role::firstOrCreate(['name' => 'backoffice']);
        $calidad_comercial = Role::firstOrCreate(['name' => 'calidad comercial']);
        $supervisor = Role::firstOrCreate(['name' => 'supervisor']);
        $ejecutivo = Role::firstOrCreate(['name' => 'ejecutivo']);

        // área administrativa
        $administrador = Role::firstOrCreate(['name' => 'administrador']);
        $asistente_administrador = Role::firstOrCreate(['name' => 'asistente administrador']);
        $recursos_humanos = Role::firstOrCreate(['name' => 'recursos humanos']);
        $asistente_recursos_humanos = Role::firstOrCreate(['name' => 'asistente recursos humanos']);
        $capacitador = Role::firstOrCreate(['name' => 'capacitador']);
        $planificacion = Role::firstOrCreate(['name' => 'planificacion']);
        $soporte_comercial = Role::firstOrCreate(['name' => 'soporte comercial']);
        $soporte_sistemas = Role::firstOrCreate(['name' => 'soporte sistemas']);
        $delivery = Role::firstOrCreate(['name' => 'delivery']);
        $finanzas = Role::firstOrCreate(['name' => 'finanzas']);

        // Crear permisos usando firstOrCreate para evitar duplicados
        Permission::firstOrCreate(['name' => 'sistema.dashboard']);
        Permission::firstOrCreate(['name' => 'sistema.cliente']);
        Permission::firstOrCreate(['name' => 'sistema.funnel']);
        Permission::firstOrCreate(['name' => 'sistema.gestion_cliente']);
        Permission::firstOrCreate(['name' => 'sistema.gestion_cliente.buscar']);
        Permission::firstOrCreate(['name' => 'sistema.gestion_cliente.agregar']);
        Permission::firstOrCreate(['name' => 'sistema.gestion_cliente.asignar']);
        Permission::firstOrCreate(['name' => 'sistema.gestion_cliente.exportar']);
        Permission::firstOrCreate(['name' => 'sistema.gestion_cliente.importar']);
        Permission::firstOrCreate(['name' => 'sistema.lista_usuario']);
        Permission::firstOrCreate(['name' => 'sistema.equipo']);
        Permission::firstOrCreate(['name' => 'sistema.role']);
        Permission::firstOrCreate(['name' => 'sistema.configuracion']);
        Permission::firstOrCreate(['name' => 'sistema.notificacion']);
        Permission::firstOrCreate(['name' => 'sistema.buscar']);
        Permission::firstOrCreate(['name' => 'sistema.reporte']);
        Permission::firstOrCreate(['name' => 'sistema.reporte.cliente']);
        Permission::firstOrCreate(['name' => 'sistema.evaporacion']);
        Permission::firstOrCreate(['name' => 'sistema.evaporacion.subir']);
        Permission::firstOrCreate(['name' => 'sistema.evaporacion-gestion']);
        Permission::firstOrCreate(['name' => 'sistema.files']); // Nuevo permiso para gestión de archivos
        Permission::firstOrCreate(['name' => 'sistema.vista']); // Nuevo permiso para visualización de archivos
        // Asignar todos los permisos al rol 'sistema'
        $sistema->syncPermissions(Permission::all());

        // Asignar permisos específicos a otros roles
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
            'sistema.files', // Asignar permiso de gestión de archivos
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
            'sistema.files', // Asignar permiso de gestión de archivos
        ]);
        $ejecutivo->syncPermissions([
            'sistema.cliente',
            'sistema.gestion_cliente',
            'sistema.gestion_cliente.agregar',
            'sistema.notificacion',
        ]);
    }
}
