<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\Turno;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TurnoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $fecha = $request->input('fecha', date('Y-m-d'));
        
        // Obtener los turnos de la fecha seleccionada
        $turnos = Turno::with('empleado')
            ->whereDate('fecha', $fecha)
            ->orderBy('hora_inicio')
            ->get();
            
        // Obtener todos los turnos del mes actual para el calendario
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        
        $turnosDelMes = Turno::with('empleado')
            ->whereBetween('fecha', [$startOfMonth, $endOfMonth])
            ->get();
            
        // Agrupar turnos por día para el calendario
        $turnosPorDia = [];
        foreach($turnosDelMes as $turno) {
            $dia = $turno->fecha->format('Y-m-d');
            if(!isset($turnosPorDia[$dia])) {
                $turnosPorDia[$dia] = [];
            }
            $turnosPorDia[$dia][] = $turno;
        }
        
        return view('turnos.index', compact('turnos', 'turnosPorDia'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $empleados = Empleado::where('activo', true)
            ->orderBy('apellido')
            ->orderBy('nombre')
            ->get();
            
        return view('turnos.create', compact('empleados'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'empleado_id' => 'required|exists:empleados,id',
            'fecha' => 'required|date',
            'hora_inicio' => 'required',
            'hora_fin' => 'required|after:hora_inicio',
        ]);
        
        // Crear el turno
        $turno = new Turno();
        $turno->empleado_id = $validated['empleado_id'];
        $turno->fecha = $validated['fecha'];
        $turno->hora_inicio = $validated['fecha'] . ' ' . $validated['hora_inicio'];
        $turno->hora_fin = $validated['fecha'] . ' ' . $validated['hora_fin'];
        $turno->save();
        
        return redirect()->route('turnos.index')
            ->with('success', 'Turno registrado con éxito');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $turno = Turno::findOrFail($id);
        $empleados = Empleado::where('activo', true)
            ->orderBy('apellido')
            ->orderBy('nombre')
            ->get();
            
        return view('turnos.edit', compact('turno', 'empleados'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $turno = Turno::findOrFail($id);
        
        $validated = $request->validate([
            'empleado_id' => 'required|exists:empleados,id',
            'fecha' => 'required|date',
            'hora_inicio' => 'required',
            'hora_fin' => 'required|after:hora_inicio',
        ]);
        
        // Actualizar el turno
        $turno->empleado_id = $validated['empleado_id'];
        $turno->fecha = $validated['fecha'];
        $turno->hora_inicio = $validated['fecha'] . ' ' . $validated['hora_inicio'];
        $turno->hora_fin = $validated['fecha'] . ' ' . $validated['hora_fin'];
        $turno->save();
        
        return redirect()->route('turnos.index')
            ->with('success', 'Turno actualizado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $turno = Turno::findOrFail($id);
        $turno->delete();
        
        return redirect()->route('turnos.index')
            ->with('success', 'Turno eliminado con éxito');
    }
}