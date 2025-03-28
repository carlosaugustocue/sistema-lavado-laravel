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