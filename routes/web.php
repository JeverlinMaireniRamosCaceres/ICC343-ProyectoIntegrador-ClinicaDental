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
use Illuminate\Support\Facades\Mail;

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
    Route::resource('procedimientos', ProcedimientoController::class)
        ->middleware('rol:Administrador');

    // Compras
    Route::resource('compras', ComprasController::class)
        ->only(['index', 'show', 'create', 'store'])
        ->middleware('rol:Administrador,Secretaria');

    Route::resource('compras', ComprasController::class)
        ->only(['edit', 'update', 'destroy'])
        ->middleware('rol:Administrador');

    Route::patch('/compras/{id}/anular', [ComprasController::class, 'anular'])
        ->middleware('rol:Administrador')
        ->name('compras.anular');

    Route::patch('/compras/{id}/pagar', [ComprasController::class, 'marcarCompraPagada'])
        ->middleware('rol:Administrador')
        ->name('compras.pagar');

    // Pacientes
    Route::get('/pacientes/buscar-persona', [PacientesController::class, 'buscarPersona'])
        ->name('pacientes.buscar-persona');
    Route::put('/pacientes/{paciente}/informacion-clinica', [PacientesController::class, 'updateInformacionClinica'])
        ->middleware('rol:Administrador,Doctor')
        ->name('pacientes.updateInformacionClinica');
    Route::resource('pacientes', PacientesController::class);

    // Proveedores
    Route::resource('proveedores', ProveedorController::class)
        ->except('destroy')
        ->middleware('rol:Administrador,Secretaria')
        ->parameters([
            'proveedores' => 'proveedor'
        ]);

    Route::delete('/proveedores/{proveedor}', [ProveedorController::class, 'destroy'])
        ->middleware('rol:Administrador')
        ->name('proveedores.destroy');

    Route::put('/proveedores/{id}/activar', [ProveedorController::class, 'activar'])
        ->middleware('rol:Administrador')
        ->name('proveedores.activar');

    // Usuarios
    Route::resource('usuarios', UsuariosController::class)
        ->middleware('rol:Administrador');

    Route::put('/usuarios/{id}/activar', [UsuariosController::class, 'activar'])
        ->middleware('rol:Administrador')
        ->name('usuarios.activar');

    Route::get('/buscar-personas', [UsuariosController::class, 'buscarPersonas'])
        ->middleware('rol:Administrador')
        ->name('usuarios.buscarPersonas');

    // Productos
    Route::resource('productos', ProductoController::class)
        ->except('destroy')
        ->middleware('rol:Administrador,Secretaria');

    Route::delete('/productos/{producto}', [ProductoController::class, 'destroy'])
        ->middleware('rol:Administrador')
        ->name('productos.destroy');

    // Odontólogos
    Route::resource('odontologos', OdontologoController::class)
        ->only(['index', 'show'])
        ->middleware('rol:Administrador,Secretaria');

    Route::resource('odontologos', OdontologoController::class)
        ->only(['create', 'store', 'edit', 'update', 'destroy'])
        ->middleware('rol:Administrador');

    Route::put('/odontologos/{odontologo}/activar', [OdontologoController::class, 'activar'])
        ->middleware('rol:Administrador')
        ->name('odontologos.activar');

    // Citas
    Route::get('citas/por-fecha', [CitaController::class, 'citasPorFecha'])
        ->middleware('rol:Administrador,Secretaria,Doctor')
        ->name('citas.porFecha');

    Route::get('citas/por-mes', [CitaController::class, 'citasPorMes'])
        ->middleware('rol:Administrador,Secretaria,Doctor')
        ->name('citas.porMes');

    Route::get('/buscar-odontologos', [CitaController::class, 'buscarOdontologos'])
        ->middleware('rol:Administrador,Secretaria');

    Route::resource('citas', CitaController::class)
        ->only(['index', 'show'])
        ->middleware('rol:Administrador,Secretaria,Doctor');

    Route::resource('citas', CitaController::class)
        ->except(['index', 'show'])
        ->middleware('rol:Administrador,Secretaria');

    // Caja chica
    // Caja chica
    Route::get('/caja-chica/verificar', [CajaChicaController::class, 'verificar'])
        ->middleware('rol:Administrador,Secretaria')
        ->name('caja-chica.verificar');

    // Rutas exclusivas del administrador
    Route::get('/caja-chica/create', [CajaChicaController::class, 'create'])
        ->middleware('rol:Administrador')
        ->name('caja-chica.create');

    Route::post('/caja-chica', [CajaChicaController::class, 'store'])
        ->middleware('rol:Administrador')
        ->name('caja-chica.store');

    // Rutas compartidas
    Route::get('/caja-chica', [CajaChicaController::class, 'index'])
        ->middleware('rol:Administrador,Secretaria')
        ->name('caja-chica.index');

    Route::get('/caja-chica/{caja_chica}', [CajaChicaController::class, 'show'])
        ->middleware('rol:Administrador,Secretaria')
        ->name('caja-chica.show');

    Route::post('/caja-chica/{caja}/egreso', [CajaChicaController::class, 'registrarEgreso'])
        ->middleware('rol:Administrador,Secretaria')
        ->name('caja-chica.egreso');

    Route::post('/caja-chica/{idCaja}/cerrar', [CajaChicaController::class, 'cerrarCaja'])
        ->middleware('rol:Administrador,Secretaria')
        ->name('caja-chica.cerrar');

    // Facturación
    Route::get('/facturacion/consultas', [FacturacionController::class, 'consultas'])
        ->middleware('rol:Administrador,Secretaria')
        ->name('facturacion.consultas');

    Route::get('/facturacion/{factura}/pdf', [FacturacionController::class, 'pdf'])
        ->middleware('rol:Administrador,Secretaria')
        ->name('facturacion.pdf');

    Route::post('/facturacion/{factura}/correo', [FacturacionController::class, 'enviarCorreo'])
        ->middleware('rol:Administrador,Secretaria')
        ->name('facturacion.correo');

    Route::resource('facturacion', FacturacionController::class)
        ->only(['index', 'show', 'create', 'store'])
        ->middleware('rol:Administrador,Secretaria')
        ->parameters([
            'facturacion' => 'factura',
        ]);

    Route::delete('/facturacion/{factura}', [FacturacionController::class, 'destroy'])
        ->middleware('rol:Administrador')
        ->name('facturacion.destroy');


    // Consultas
    Route::get('/consultas/buscar-odontologos', [ConsultaController::class, 'buscarOdontologos'])
        ->middleware('rol:Administrador,Doctor')
        ->name('consultas.buscarOdontologos');

    Route::get('/consultas/buscar-pacientes', [ConsultaController::class, 'buscarPacientes'])
        ->middleware('rol:Administrador,Doctor')
        ->name('consultas.buscarPacientes');

    Route::get('/consultas/paciente-alergias/{id}', [ConsultaController::class, 'alergiasPaciente'])
        ->middleware('rol:Administrador,Doctor')
        ->name('consultas.alergiasPaciente');

    Route::get('/consultas/paciente-tratamientos/{id}', [ConsultaController::class, 'tratamientosPaciente'])
        ->middleware('rol:Administrador,Doctor')
        ->name('consultas.tratamientosPaciente');

    Route::resource('consultas', ConsultaController::class)
        ->only(['index', 'show', 'create', 'store'])
        ->middleware('rol:Administrador,Doctor');
    Route::get(
        '/tratamientos/{id}/procedimientos',
        [TratamientoController::class, 'procedimientos']
    );


    // Alergias
    Route::resource('alergias', AlergiaController::class)
        ->middleware('rol:Administrador');

    // Especialidades
    Route::resource('especialidades', EspecialidadController::class)
        ->middleware('rol:Administrador');

    // Inventario
    Route::get('inventario/reporte', [InventarioController::class, 'reporte'])
        ->middleware('rol:Administrador,Secretaria')
        ->name('inventario.reporte');

    Route::get('/inventario/reporte-orden-compra', [InventarioController::class, 'reporteOrdenCompra'])
        ->middleware('rol:Administrador,Secretaria')
        ->name('inventario.reporteOrdenCompra');

    Route::post('/inventario/ajuste', [InventarioController::class, 'ajuste'])
        ->middleware('rol:Administrador,Secretaria')
        ->name('inventario.ajuste');

    Route::get('/buscar-productos', [InventarioController::class, 'buscarProductos'])
        ->middleware('rol:Administrador,Secretaria')
        ->name('inventario.buscar-productos');

    Route::get('inventario/{id}/detalle', [InventarioController::class, 'detalle'])
        ->middleware('rol:Administrador,Secretaria')
        ->name('inventario.detalle');

    Route::get('inventario/{id}/lotes', [InventarioController::class, 'lotes'])
        ->middleware('rol:Administrador,Secretaria')
        ->name('inventario.lotes');

    Route::resource('inventario', InventarioController::class)
        ->middleware('rol:Administrador,Secretaria');

    // Tratamientos
    Route::resource('tratamientos', TratamientoController::class);

    // Pagos
    Route::get('/pagos/{pago}/pdf', [PagosController::class, 'pdf'])
        ->middleware('rol:Administrador,Secretaria')
        ->name('pagos.pdf');

    Route::post('/pagos/{pago}/correo', [PagosController::class, 'enviarCorreo'])
        ->middleware('rol:Administrador,Secretaria')
        ->name('pagos.correo');

    Route::patch('/pagos/{codigoRecibo}/anular', [PagosController::class, 'anular'])
        ->middleware('rol:Administrador,Secretaria')
        ->name('pagos.anular');

    Route::resource('pagos', PagosController::class)
        ->only(['index', 'show', 'create', 'store'])
        ->middleware('rol:Administrador,Secretaria');
});

// rutas para confirmar o cancelar citas desde el correo electrónico
Route::get('/citas/{cita}/confirmar', [CitaController::class, 'confirmarPublico'])
    ->name('citas.confirmar.publico')
    ->middleware('signed');

Route::get('/citas/{cita}/cancelar', [CitaController::class, 'cancelarPublico'])
    ->name('citas.cancelar.publico')
    ->middleware('signed');
