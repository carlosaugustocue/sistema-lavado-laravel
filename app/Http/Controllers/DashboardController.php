<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\Insumo;
use App\Models\Lavado;
use App\Models\Vehiculo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Resumen de lavados pendientes
        $lavadosPendientes = Lavado::whereIn('estado', ['pendiente', 'en_proceso'])->count();
        
        // Lavados completados hoy
        $lavadosHoy = Lavado::whereDate('created_at', now()->toDateString())->count();
        
        // Ingresos del día
        $ingresosHoy = Lavado::whereDate('created_at', now()->toDateString())
            ->whereIn('estado', ['completado', 'entregado'])
            ->sum('costo_total');
        
        // Insumos con stock bajo
        $insumosStockBajo = Insumo::whereRaw('stock_actual <= stock_minimo')->count();
        
        // Empleados activos
        $empleadosActivos = Empleado::where('activo', true)->count();
        
        // Total de vehículos registrados
        $totalVehiculos = Vehiculo::count();
        
        // Gráfico de lavados por día (últimos 7 días)
        $lavadosPorDia = DB::table('lavados')
            ->select(DB::raw('DATE(created_at) as fecha'), DB::raw('COUNT(*) as total'))
            ->whereDate('created_at', '>=', now()->subDays(7)->toDateString())
            ->groupBy('fecha')
            ->orderBy('fecha')
            ->get();
        
        return view('dashboard', compact(
            'lavadosPendientes',
            'lavadosHoy',
            'ingresosHoy',
            'insumosStockBajo',
            'empleadosActivos',
            'totalVehiculos',
            'lavadosPorDia'
        ));
    }
}