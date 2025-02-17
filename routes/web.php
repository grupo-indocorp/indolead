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
use App\Http\Controllers\CuentafinancieraController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EquipoController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\FacturaController;
use App\Http\Controllers\FileController; // Importa el FileController
use App\Http\Controllers\FileViewController;
use App\Http\Controllers\FunnelController;
use App\Http\Controllers\GestionClienteController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\ListaUsuarioController;
use App\Http\Controllers\NotificacionController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ReporteClienteController;
use App\Http\Controllers\ReporteClienteNuevoController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire; // Importa el FileViewController

// Ruta para la página de componentes
Route::get('/components', function () {
    return view('components');
});

// Ruta de inicio
Route::get('/', [HomeController::class, 'home']);

// Redirigir registro a la página de inicio
Route::get('/register', function () {
    return redirect('/');
});

// Rutas protegidas por autenticación
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Rutas de recursos
    Route::resources([
        'lista_usuario' => ListaUsuarioController::class,
        'equipo' => EquipoController::class,
        'funnel' => FunnelController::class,
        'role' => RoleController::class,
        'notificacion' => NotificacionController::class,
        'reporte' => ReporteController::class,
        'reporte_cliente' => ReporteClienteController::class,
        'reporte_cliente_nuevo' => ReporteClienteNuevoController::class,
        'producto' => ProductoController::class,
        'cliente' => ClienteController::class,
        'cliente-consultor' => ClienteConsultorController::class,
        'cliente-gestion' => ClienteGestionController::class,
        'cuentas-financieras' => CuentafinancieraController::class,
        'facturas' => FacturaController::class,
        'configuracion' => ConfiguracionController::class,
        'configuracion-sistema' => ConfiguracionSistemaController::class,
        'configuracion-etapa' => ConfiguracionEtapaController::class,
        'configuracion-categoria' => ConfiguracionCategoriaController::class,
        'configuracion-producto' => ConfiguracionProductoController::class,
        'configuracion-excel' => ConfiguracionExcelController::class,
        'configuracion-ficha-cliente' => ConfiguracionFichaClienteController::class,
        'files' => FileController::class, // Ruta para la gestión de archivos
        'files-view' => FileViewController::class, // Ruta para la visualización de archivos
    ]);

    // Ruta adicional para la descarga de archivos
    Route::get('/files/{id}/download', [FileController::class, 'download'])
        ->name('files.download');

    // Ruta para la visualización de archivos
    Route::get('/documentos', [FileViewController::class, 'index'])->name('files.view');

    // Exportación e importación de clientes
    Route::get('clientes/export/', [GestionClienteController::class, 'export']);
    Route::post('clientes/import/', [GestionClienteController::class, 'import']);

    // Actualización de datos de clientes
    Route::get('update-cuentafinanciera', [ConfiguracionController::class, 'updateCuentaFinanciera'])
        ->name('update.cuentafinanciera');
    Route::get('update-facturas', [ConfiguracionController::class, 'updateFactura'])
        ->name('update.factura');

    // Exportación de datos
    Route::get('export/secodi/funnel', [ExportController::class, 'secodiFunnel']);
    Route::get('export/indotech/funnel', [ExportController::class, 'indotechFunnel']);

    // Importación de datos
    Route::post('import/evaporacion', [ImportController::class, 'evaporacion'])
        ->name('import.evaporacion');
});

// Configuración de Livewire
Livewire::setScriptRoute(function ($handle) {
    return Route::get('/indotech/vendor/livewire/livewire/dist/livewire.js', $handle);
});
