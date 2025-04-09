<?php

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\InsumoController;
use App\Http\Controllers\LavadoController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\VehiculoController;
use App\Http\Controllers\TurnoController;
use App\Http\Controllers\EvaluacionController;
use App\Http\Controllers\ProductoCotizableController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\CotizacionController;

use Illuminate\Support\Facades\Route;

// Ruta principal redirige al dashboard
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Rutas de recursos básicos
Route::resource('clientes', ClienteController::class);
Route::resource('vehiculos', VehiculoController::class);
Route::resource('empleados', EmpleadoController::class);
Route::resource('servicios', ServicioController::class);
Route::resource('lavados', LavadoController::class);
Route::resource('insumos', InsumoController::class);

// Rutas específicas para los requisitos funcionales
// RF001 y RF002 - Registro de Vehículos y Asignación de Servicios (implementado en LavadoController)

// RF003 - Registro de Insumos Utilizados
Route::post('/lavados/{lavado}/insumos', [LavadoController::class, 'registrarInsumo'])->name('lavados.registrar-insumo');

// RF004 - Listado de Servicios Pendientes
Route::get('/lavados-pendientes', [LavadoController::class, 'pendientes'])->name('lavados.pendientes');

// RF005 - Historial de Servicios
Route::get('/buscar-vehiculo', [VehiculoController::class, 'buscarPorPlaca'])->name('vehiculos.buscar');

// RF006 - Cálculo de Tiempo Promedio por Tipo de Lavado
Route::get('/reportes/tiempo-promedio', [ReporteController::class, 'tiempoPromedio'])->name('reportes.tiempo-promedio');

// RF007 - Reporte de Ingresos Diarios
Route::get('/reportes/ingresos-diarios', [ReporteController::class, 'ingresosDiarios'])->name('reportes.ingresos-diarios');

// RF008 - Identificación de Insumos con Stock Bajo
Route::get('/insumos-stock-bajo', [InsumoController::class, 'stockBajo'])->name('insumos.stock-bajo');
Route::post('/insumos/{insumo}/actualizar-stock', [InsumoController::class, 'actualizarStock'])->name('insumos.actualizar-stock');

// RF009 - Carga de Trabajo por Empleado
Route::get('/empleados-carga-trabajo', [EmpleadoController::class, 'cargaTrabajo'])->name('empleados.carga-trabajo');

// RF010 - Registro de Empleados y Turnos (implementado en EmpleadoController)

// Cambiar estado de lavado
Route::patch('/lavados/{lavado}/cambiar-estado', [LavadoController::class, 'cambiarEstado'])->name('lavados.cambiar-estado');

// RF010 - Registro de Empleados y Turnos
Route::resource('turnos', TurnoController::class);

Route::get('/evaluaciones', [EvaluacionController::class, 'index'])->name('evaluaciones.index');
Route::get('/evaluaciones/generar/{lavado_id}', [EvaluacionController::class, 'generarEnlace'])->name('evaluaciones.generar');
Route::get('/evaluaciones/reporte', [EvaluacionController::class, 'reporte'])->name('evaluaciones.reporte');

Route::get('/evaluar/{token}', [EvaluacionController::class, 'mostrarFormulario'])->name('evaluaciones.formulario');
Route::post('/evaluar/{token}', [EvaluacionController::class, 'guardar'])->name('evaluaciones.guardar');

// Rutas públicas para módulo de cotizaciones
Route::get('/cotizar', [CotizacionController::class, 'formulario'])->name('cotizaciones.formulario');
Route::post('/cotizar/buscar-proveedor', [CotizacionController::class, 'buscarProveedor'])->name('cotizaciones.buscar_proveedor');
Route::get('/cotizar/proveedor/{proveedor}', [CotizacionController::class, 'mostrarProductos'])->name('cotizaciones.productos');
Route::post('/cotizar/proveedor/{proveedor}', [CotizacionController::class, 'guardarCotizacion'])->name('cotizaciones.guardar');

// Registro de proveedores público
Route::get('/proveedores/registro', [ProveedorController::class, 'registroPublico'])->name('proveedores.registro');
Route::post('/proveedores/registro', [ProveedorController::class, 'guardarRegistro'])->name('proveedores.guardar_registro');
Route::get('/proveedores/confirmacion/{proveedor}', [ProveedorController::class, 'confirmacionRegistro'])->name('proveedores.confirmacion');

// Lista pública de productos cotizables
Route::get('/productos-cotizables', [ProductoCotizableController::class, 'listaPublica'])->name('productos_cotizables.lista_publica');

// Rutas admin (sin protección por ahora)
// Route::resource('productos_cotizables', ProductoCotizableController::class);
Route::resource('productos_cotizables', ProductoCotizableController::class)->parameters([
    'productos_cotizables' => 'producto_cotizable',
]);

// Route::resource('proveedores', ProveedorController::class);
Route::resource('proveedores', ProveedorController::class)->parameters([
    'proveedores' => 'proveedor',
]); 
Route::patch('/proveedores/{proveedor}/verificar', [ProveedorController::class, 'verificar'])->name('proveedores.verificar');
Route::get('/cotizaciones', [CotizacionController::class, 'index'])->name('cotizaciones.index');
Route::get('/cotizaciones/reporte', [CotizacionController::class, 'reporte'])->name('cotizaciones.reporte');