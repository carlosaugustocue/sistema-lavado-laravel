<?php

namespace App\Http\Controllers;

use App\Models\Lavado;
use App\Models\Servicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReporteController extends Controller
{
    // RF006 - Cálculo de tiempo promedio por tipo de lavado
    public function tiempoPromedio()
    {
        $tiemposPromedio = DB::table('lavados')
            ->join('servicios', 'lavados.servicio_id', '=', 'servicios.id')
            ->select(
                'servicios.id',
                'servicios.nombre',
                DB::raw('AVG(TIMESTAMPDIFF(MINUTE, hora_entrada, hora_salida)) as promedio_minutos'),
                DB::raw('COUNT(lavados.id) as total_lavados')
            )
            ->whereNotNull('hora_salida')
            ->where('estado', 'completado')
            ->groupBy('servicios.id', 'servicios.nombre')
            ->get();

        return view('reportes.tiempo_promedio', compact('tiemposPromedio'));
    }

    // RF007 - Reporte de ingresos diarios
    public function ingresosDiarios(Request $request)
    {
        $fecha = $request->input('fecha', now()->toDateString());
        
        $ingresos = Lavado::whereDate('created_at', $fecha)
            ->where('estado', 'completado')
            ->orWhere('estado', 'entregado')
            ->with(['vehiculo', 'servicio', 'empleadoAsignado'])
            ->get();
        
        $totalIngresos = $ingresos->sum('costo_total');
        $totalServicios = $ingresos->count();
        
        $ingresosPorServicio = $ingresos->groupBy('servicio_id')
            ->map(function ($items, $key) {
                $servicio = Servicio::find($key);
                return [
                    'servicio' => $servicio->nombre,
                    'cantidad' => $items->count(),
                    'total' => $items->sum('costo_total'),
                ];
            });
        
        return view('reportes.ingresos_diarios', compact('ingresos', 'totalIngresos', 'totalServicios', 'ingresosPorServicio', 'fecha'));
    }
}