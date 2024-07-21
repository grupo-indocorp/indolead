<?php

use App\Http\Controllers\ClienteConsultorController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ClienteGestionController;
use App\Http\Controllers\ConfiguracionCategoriaController;
use App\Http\Controllers\ConfiguracionController;
use App\Http\Controllers\ConfiguracionEtapaController;
use App\Http\Controllers\ConfiguracionExcelController;
use App\Http\Controllers\ConfiguracionFichaClienteController;
use App\Http\Controllers\ConfiguracionProductoController;
use App\Http\Controllers\ConfiguracionSistemaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EquipoController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\FunnelController;
use App\Http\Controllers\GestionClienteController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ListaUsuarioController;
use App\Http\Controllers\NotificacionController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ReporteClienteController;
use App\Http\Controllers\ReporteClienteNuevoController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;

Route::get('/', [HomeController::class, 'home']);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resources([
        // 'gestion_cliente' => GestionClienteController::class,
        'lista_usuario' => ListaUsuarioController::class,
        'equipo' => EquipoController::class,
        'funnel' => FunnelController::class,
        'role' => RoleController::class,
        'notificacion' => NotificacionController::class,
        'reporte' => ReporteController::class,
        'reporte_cliente' => ReporteClienteController::class,
        'reporte_cliente_nuevo' => ReporteClienteNuevoController::class,
        'producto' => ProductoController::class,
        // Cliente
        'cliente' => ClienteController::class,
        'cliente-consultor' => ClienteConsultorController::class,
        'cliente-gestion' => ClienteGestionController::class,
        // Configuraciones
        'configuracion' => ConfiguracionController::class,
        'configuracion-sistema' => ConfiguracionSistemaController::class,
        'configuracion-etapa' => ConfiguracionEtapaController::class,
        'configuracion-categoria' => ConfiguracionCategoriaController::class,
        'configuracion-producto' => ConfiguracionProductoController::class,
        'configuracion-excel' => ConfiguracionExcelController::class,
        'configuracion-ficha-cliente' => ConfiguracionFichaClienteController::class,
    ]);
    Route::get('clientes/export/', [GestionClienteController::class, 'export']);
    Route::post('clientes/import/', [GestionClienteController::class, 'import']);

    // Actualizar datos de clientes a la nueva tabla export_cliente
    Route::get('update_export_cliente', [ConfiguracionController::class, 'updateExportCliente']);
    Route::get('update_uno', [ConfiguracionController::class, 'updateUno']);
    Route::get('update_dos', [ConfiguracionController::class, 'updateDos']);
    Route::get('update_tres', [ConfiguracionController::class, 'updateTres']);
    Route::get('update_cuatro', [ConfiguracionController::class, 'updateCuatro']);
    Route::get('update_cinco', [ConfiguracionController::class, 'updateCinco']);
    Route::get('update_seis', [ConfiguracionController::class, 'updateSeis']);

    // Export
    Route::get('export/secodi/funnel', [ExportController::class, 'secodiFunnel']);
    Route::get('export/indotech/funnel', [ExportController::class, 'indotechFunnel']);
});

Livewire::setScriptRoute(function ($handle) {
    return Route::get('/indotech/vendor/livewire/livewire/dist/livewire.js', $handle);
});
