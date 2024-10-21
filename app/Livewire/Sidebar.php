<?php

namespace App\Livewire;

use Livewire\Component;

class Sidebar extends Component
{
    public function render()
    {
        $links = [
            [
                'icon' => 'fa-house',
                'nombre' => 'Dashboard',
                'url' => 'dashboard',
                'can' => 'sistema.dashboard',
            ],
            [
                'icon' => 'fa-user-magnifying-glass',
                'nombre' => 'Consultor Clientes',
                'url' => 'cliente-consultor',
                'can' => 'sistema.cliente',
            ],
            [
                'icon' => 'fa-table',
                'nombre' => 'Funnel',
                'url' => 'funnel',
                'can' => 'sistema.funnel',
            ],
            [
                'icon' => 'fa-users-medical',
                'nombre' => 'Gestión Clientes',
                'url' => 'cliente-gestion',
                'can' => 'sistema.gestion_cliente',
            ],
            [
                'icon' => 'fa-calendar',
                'nombre' => 'Agenda',
                'url' => 'notificacion',
                'can' => 'sistema.notificacion',
            ],
            [
                'icon' => 'fa-users',
                'nombre' => 'Lista de Usuarios',
                'url' => 'lista_usuario',
                'can' => 'sistema.lista_usuario',
            ],
            [
                'icon' => 'fa-users-between-lines',
                'nombre' => 'Equipos',
                'url' => 'equipo',
                'can' => 'sistema.equipo',
            ],
            [
                'icon' => 'fa-tower-control',
                'nombre' => 'Roles',
                'url' => 'role',
                'can' => 'sistema.role',
            ],
            [
                'icon' => 'fa-gear',
                'nombre' => 'Configuración',
                'url' => 'configuracion',
                'can' => 'sistema.configuracion',
            ],
            [
                'icon' => 'fa-chart-user',
                'nombre' => 'Reportes',
                'url' => 'reporte',
                'can' => 'sistema.reporte',
            ],
        ];
        return view('livewire.sidebar', compact('links'));
    }
}
