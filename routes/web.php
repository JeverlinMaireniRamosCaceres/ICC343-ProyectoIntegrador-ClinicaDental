<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CajaChicaController;
use App\Http\Controllers\ComprasController;
use App\Http\Controllers\ProcedimientoController;
use App\Http\Controllers\PacientesController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\OdontologoController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\FacturacionController;
use App\Http\Controllers\ConsultaController;
use App\Http\Controllers\AlergiaController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\EspecialidadController;
use App\Http\Controllers\TratamientoController;
use App\Http\Controllers\DashboardController;
use App\Services\WhatsAppService;
use App\Http\Controllers\WhatsAppWebhookController;
use App\Http\Controllers\PagosController;

// Webhook de WhatsApp
Route::get('/webhook/whatsapp', [WhatsAppWebhookController::class, 'verify']);
Route::post('/webhook/whatsapp', [WhatsAppWebhookController::class, 'receive']);


// Rutas para invitados
Route::middleware('guest')->group(function () {

    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.post');
});


// Rutas protegidas
Route::middleware('auth')->group(function () {

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Procedimientos
    Route::resource('procedimientos', ProcedimientoController::class);

    // Compras
    Route::resource('compras', ComprasController::class);

    Route::patch('/compras/{id}/anular', [ComprasController::class, 'anular'])
        ->name('compras.anular');

    Route::patch('/compras/{id}/pagar', [ComprasController::class, 'marcarCompraPagada'])
        ->name('compras.pagar');

    // Pacientes
    Route::get('/pacientes/buscar-persona', [PacientesController::class, 'buscarPersona'])
        ->name('pacientes.buscar-persona');
    Route::resource('pacientes', PacientesController::class);

    // Proveedores
    Route::resource('proveedores', ProveedorController::class)
        ->parameters([
            'proveedores' => 'proveedor'
        ]);

    Route::put('/proveedores/{id}/activar', [ProveedorController::class, 'activar'])
        ->name('proveedores.activar');

    // Usuarios
    Route::resource('usuarios', UsuariosController::class);

    Route::put('/usuarios/{id}/activar', [UsuariosController::class, 'activar'])
        ->name('usuarios.activar');

    Route::get('/buscar-personas', [UsuariosController::class, 'buscarPersonas'])
        ->name('usuarios.buscarPersonas');

    // Productos
    Route::resource('productos', ProductoController::class);

    // Odontólogos
    Route::resource('odontologos', OdontologoController::class);
    Route::put('/odontologos/{odontologo}/activar', [OdontologoController::class, 'activar'])
        ->name('odontologos.activar');

    // Citas
    Route::get('citas/por-fecha', [CitaController::class, 'citasPorFecha'])->name('citas.porFecha');
    Route::get('citas/por-mes', [CitaController::class, 'citasPorMes'])->name('citas.porMes');
    Route::get('/buscar-odontologos', [CitaController::class, 'buscarOdontologos']);
    Route::resource('citas', CitaController::class);


    // Caja chica
    Route::resource('caja-chica', CajaChicaController::class);

    Route::post('/caja-chica/{caja}/egreso', [CajaChicaController::class, 'registrarEgreso'])
        ->name('caja-chica.egreso');

    Route::post('/caja-chica/{idCaja}/cerrar', [CajaChicaController::class, 'cerrarCaja'])
        ->name('caja-chica.cerrar');

    // Facturación
    Route::get('/facturacion/consultas', [FacturacionController::class, 'consultas'])
        ->name('facturacion.consultas');
    Route::resource('facturacion', FacturacionController::class)
        ->parameters([
            'facturacion' => 'factura',
        ]);

    // Consultas
    Route::get('/consultas/buscar-odontologos', [ConsultaController::class, 'buscarOdontologos'])
        ->name('consultas.buscarOdontologos');
    Route::get('/consultas/buscar-pacientes', [ConsultaController::class, 'buscarPacientes'])
        ->name('consultas.buscarPacientes');
    Route::get('/consultas/paciente-alergias/{id}', [ConsultaController::class, 'alergiasPaciente'])
        ->name('consultas.alergiasPaciente');
    Route::get('/consultas/paciente-tratamientos/{id}', [ConsultaController::class, 'tratamientosPaciente'])
        ->name('consultas.tratamientosPaciente');
    Route::resource('consultas', ConsultaController::class);


    // Alergias
    Route::resource('alergias', AlergiaController::class);

    // Especialidades
    Route::resource('especialidades', EspecialidadController::class);

    // Inventario
    Route::get('inventario/reporte', [InventarioController::class, 'reporte'])
        ->name('inventario.reporte');

    Route::post('/inventario/ajuste', [InventarioController::class, 'ajuste'])
        ->name('inventario.ajuste');

    Route::get('/buscar-productos', [InventarioController::class, 'buscarProductos'])
        ->name('inventario.buscar-productos');

    Route::get('inventario/{id}/detalle', [InventarioController::class, 'detalle'])
        ->name('inventario.detalle');

    Route::get('inventario/{id}/lotes', [InventarioController::class, 'lotes'])
        ->name('inventario.lotes');

    Route::resource('inventario', InventarioController::class);

    // Tratamientos
    Route::resource('tratamientos', TratamientoController::class);

    //Pagos
    Route::resource('pagos', PagosController::class);
});
