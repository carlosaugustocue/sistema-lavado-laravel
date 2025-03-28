<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\Request;

class EmpleadoController extends Controller
{
    public function index()
    {
        $empleados = Empleado::orderBy('apellido')->orderBy('nombre')->get();
        return view('empleados.index', compact('empleados'));
    }

    public function create()
    {
        return view('empleados.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
            'documento' => 'required|string|max:20|unique:empleados',
            'cargo' => 'required|string|max:255',
            'activo' => 'boolean',
        ]);

        if (!isset($validated['activo'])) {
            $validated['activo'] = false;
        }

        Empleado::create($validated);

        return redirect()->route('empleados.index')
            ->with('success', 'Empleado registrado con éxito');
    }

    public function show(Empleado $empleado)
    {
        $lavadosRecibidos = $empleado->lavadosRecibidos()->with('vehiculo', 'servicio')->get();
        $lavadosAsignados = $empleado->lavadosAsignados()->with('vehiculo', 'servicio')->get();
        $turnos = $empleado->turnos()->orderBy('fecha', 'desc')->get();
        
        return view('empleados.show', compact('empleado', 'lavadosRecibidos', 'lavadosAsignados', 'turnos'));
    }

    public function edit(Empleado $empleado)
    {
        return view('empleados.edit', compact('empleado'));
    }

    public function update(Request $request, Empleado $empleado)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
            'documento' => 'required|string|max:20|unique:empleados,documento,' . $empleado->id,
            'cargo' => 'required|string|max:255',
            'activo' => 'boolean',
        ]);

        if (!isset($validated['activo'])) {
            $validated['activo'] = false;
        }

        $empleado->update($validated);

        return redirect()->route('empleados.index')
            ->with('success', 'Empleado actualizado con éxito');
    }

    public function destroy(Empleado $empleado)
    {
        // Verificar si tiene lavados antes de eliminar
        if ($empleado->lavadosRecibidos()->count() > 0 || $empleado->lavadosAsignados()->count() > 0) {
            return redirect()->route('empleados.index')
                ->with('error', 'No se puede eliminar el empleado porque tiene lavados asociados');
        }

        $empleado->delete();

        return redirect()->route('empleados.index')
            ->with('success', 'Empleado eliminado con éxito');
    }

    // RF009 - Carga de trabajo por empleado
    public function cargaTrabajo()
    {
        $empleados = Empleado::where('activo', true)->get();
        $cargaTrabajo = [];

        foreach ($empleados as $empleado) {
            $cargaTrabajo[$empleado->id] = [
                'empleado' => $empleado,
                'pendientes' => $empleado->lavadosAsignados()->whereIn('estado', ['pendiente', 'en_proceso'])->count(),
                'completados_hoy' => $empleado->lavadosAsignados()
                    ->where('estado', 'completado')
                    ->whereDate('updated_at', now()->toDateString())
                    ->count(),
            ];
        }

        return view('empleados.carga_trabajo', compact('cargaTrabajo'));
    }
}