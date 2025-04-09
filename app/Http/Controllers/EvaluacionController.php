<?php

namespace App\Http\Controllers;

use App\Models\Evaluacion;
use App\Models\Lavado;
use Illuminate\Http\Request;

class EvaluacionController extends Controller
{
    // Generar token de evaluación para un lavado
    public function generarEnlace($lavado_id)
    {
        $lavado = Lavado::findOrFail($lavado_id);
        
        // Validar que el lavado esté completado
        if ($lavado->estado != 'completado' && $lavado->estado != 'entregado') {
            return redirect()->back()->with('error', 'Solo se pueden evaluar servicios completados');
        }
        
        // Verificar si ya existe una evaluación
        if ($lavado->evaluacion) {
            // Si existe pero no está completada, devolvemos el token existente
            if (!$lavado->evaluacion->completada) {
                return redirect()->back()->with('info', 'Ya existe un enlace de evaluación para este servicio')->with('token', $lavado->evaluacion->token);
            }
            return redirect()->back()->with('error', 'Este servicio ya fue evaluado');
        }
        
        // Crear nueva evaluación con token
        $token = Evaluacion::generarToken();
        $evaluacion = Evaluacion::create([
            'lavado_id' => $lavado->id,
            'token' => $token,
            'completada' => false,
        ]);
        
        return redirect()->back()->with('success', 'Enlace de evaluación generado correctamente')->with('token', $token);
    }
    
    // Mostrar formulario de evaluación a partir del token
    public function mostrarFormulario($token)
    {
        $evaluacion = Evaluacion::where('token', $token)->firstOrFail();
        
        // Validar que no haya sido completada
        if ($evaluacion->completada) {
            return abort(403, 'Este servicio ya fue evaluado');
        }
        
        // Validar que el lavado exista y esté completado
        $lavado = $evaluacion->lavado;
        if (!$lavado || ($lavado->estado != 'completado' && $lavado->estado != 'entregado')) {
            return abort(403, 'El servicio no puede ser evaluado');
        }
        
        return view('evaluaciones.formulario', compact('evaluacion', 'lavado'));
    }
    
    // Guardar la evaluación
    public function guardar(Request $request, $token)
    {
        $evaluacion = Evaluacion::where('token', $token)->firstOrFail();
        
        // Validar que no haya sido completada
        if ($evaluacion->completada) {
            return abort(403, 'Este servicio ya fue evaluado');
        }
        
        // Validar datos
        $datos = $request->validate([
            'tiempo_espera' => 'required|integer|min:1|max:5',
            'amabilidad' => 'required|integer|min:1|max:5',
            'calidad_servicio' => 'required|integer|min:1|max:5',
            'comentarios' => 'nullable|string|max:500',
        ]);
        
        // Actualizar evaluación
        $evaluacion->update([
            'tiempo_espera' => $datos['tiempo_espera'],
            'amabilidad' => $datos['amabilidad'],
            'calidad_servicio' => $datos['calidad_servicio'],
            'comentarios' => $datos['comentarios'],
            'completada' => true,
        ]);
        
        return view('evaluaciones.agradecimiento');
    }
    
    // Listar todas las evaluaciones (admin)
    public function index()
    {
        $evaluaciones = Evaluacion::where('completada', true)
            ->with('lavado.vehiculo.cliente')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
            
        return view('evaluaciones.index', compact('evaluaciones'));
    }
    
    // Generar reporte
    public function reporte()
    {
        // Estadísticas generales
        $totalEvaluaciones = Evaluacion::where('completada', true)->count();
        $promedioTiempoEspera = Evaluacion::where('completada', true)->avg('tiempo_espera');
        $promedioAmabilidad = Evaluacion::where('completada', true)->avg('amabilidad');
        $promedioCalidadServicio = Evaluacion::where('completada', true)->avg('calidad_servicio');
        
        // Evaluaciones por servicio
        $evaluacionesPorServicio = Lavado::select('servicios.nombre', \DB::raw('AVG(evaluaciones.tiempo_espera) as prom_tiempo'), 
                                  \DB::raw('AVG(evaluaciones.amabilidad) as prom_amabilidad'),
                                  \DB::raw('AVG(evaluaciones.calidad_servicio) as prom_calidad'),
                                  \DB::raw('COUNT(*) as total'))
                            ->join('evaluaciones', 'lavados.id', '=', 'evaluaciones.lavado_id')
                            ->join('servicios', 'lavados.servicio_id', '=', 'servicios.id')
                            ->where('evaluaciones.completada', true)
                            ->groupBy('servicios.nombre')
                            ->get();
        
        return view('evaluaciones.reporte', compact(
            'totalEvaluaciones', 
            'promedioTiempoEspera', 
            'promedioAmabilidad', 
            'promedioCalidadServicio',
            'evaluacionesPorServicio'
        ));
    }
}