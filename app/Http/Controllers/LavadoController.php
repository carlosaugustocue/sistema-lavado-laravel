<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\Insumo;
use App\Models\Lavado;
use App\Models\Servicio;
use App\Models\UsoInsumo;
use App\Models\Vehiculo;
use Illuminate\Http\Request;

class LavadoController extends Controller
{
    public function index()
    {
        $lavados = Lavado::with(['vehiculo', 'servicio', 'empleadoRecibe', 'empleadoAsignado'])
            ->orderBy('created_at', 'desc')
            ->get();
        return view('lavados.index', compact('lavados'));
    }

    // RF004 - Listado de servicios pendientes
    public function pendientes()
    {
        $pendientes = Lavado::with(['vehiculo', 'servicio', 'empleadoRecibe', 'empleadoAsignado'])
            ->whereIn('estado', ['pendiente', 'en_proceso'])
            ->orderBy('hora_entrada', 'asc')
            ->get();
        return view('lavados.pendientes', compact('pendientes'));
    }

    // RF001 - Registro de vehículos (llegada)
    public function create()
    {
        $vehiculos = Vehiculo::orderBy('placa')->get();
        $servicios = Servicio::where('activo', true)->get();
        $empleados = Empleado::where('activo', true)->get();
        return view('lavados.create', compact('vehiculos', 'servicios', 'empleados'));
    }

    // RF001 y RF002 - Registro de vehículos y asignación de servicios
    public function store(Request $request)
    {
        $validated = $request->validate([
            'vehiculo_id' => 'required|exists:vehiculos,id',
            'empleado_id' => 'required|exists:empleados,id',
            'empleado_asignado_id' => 'nullable|exists:empleados,id',
            'servicio_id' => 'required|exists:servicios,id',
            'observaciones' => 'nullable|string',
        ]);

        // Obtener precio del servicio
        $servicio = Servicio::findOrFail($validated['servicio_id']);
        
        $lavado = new Lavado();
        $lavado->vehiculo_id = $validated['vehiculo_id'];
        $lavado->empleado_id = $validated['empleado_id'];
        $lavado->empleado_asignado_id = $validated['empleado_asignado_id'];
        $lavado->servicio_id = $validated['servicio_id'];
        $lavado->hora_entrada = now();
        $lavado->estado = 'pendiente';
        $lavado->costo_total = $servicio->precio;
        $lavado->observaciones = $validated['observaciones'];
        $lavado->save();

        return redirect()->route('lavados.index')
            ->with('success', 'Lavado registrado con éxito');
    }

    public function show(Lavado $lavado)
    {
        $insumos = Insumo::orderBy('nombre')->get();
        $usoInsumos = $lavado->usoInsumos()->with('insumo')->get();
        return view('lavados.show', compact('lavado', 'insumos', 'usoInsumos'));
    }

    public function edit(Lavado $lavado)
    {
        $vehiculos = Vehiculo::orderBy('placa')->get();
        $servicios = Servicio::where('activo', true)->get();
        $empleados = Empleado::where('activo', true)->get();
        return view('lavados.edit', compact('lavado', 'vehiculos', 'servicios', 'empleados'));
    }

    public function update(Request $request, Lavado $lavado)
    {
        $validated = $request->validate([
            'vehiculo_id' => 'required|exists:vehiculos,id',
            'empleado_id' => 'required|exists:empleados,id',
            'empleado_asignado_id' => 'nullable|exists:empleados,id',
            'servicio_id' => 'required|exists:servicios,id',
            'estado' => 'required|in:pendiente,en_proceso,completado,entregado',
            'observaciones' => 'nullable|string',
        ]);

        // Actualizar precio si cambia el servicio
        if ($lavado->servicio_id != $validated['servicio_id']) {
            $servicio = Servicio::findOrFail($validated['servicio_id']);
            $lavado->costo_total = $servicio->precio;
        }

        // Si cambia a completado, registrar hora de finalización
        if ($validated['estado'] == 'completado' && $lavado->estado != 'completado') {
            $lavado->hora_salida = now();
        }

        $lavado->update($validated);

        return redirect()->route('lavados.index')
            ->with('success', 'Lavado actualizado con éxito');
    }

    public function destroy(Lavado $lavado)
    {
        // Eliminar registros relacionados de uso_insumos
        $lavado->usoInsumos()->delete();
        
        $lavado->delete();

        return redirect()->route('lavados.index')
            ->with('success', 'Lavado eliminado con éxito');
    }

    // RF003 - Registro de insumos utilizados
    public function registrarInsumo(Request $request, Lavado $lavado)
    {
        $validated = $request->validate([
            'insumo_id' => 'required|exists:insumos,id',
            'cantidad' => 'required|numeric|min:0.01',
        ]);

        // Verificar stock disponible
        $insumo = Insumo::findOrFail($validated['insumo_id']);
        if ($insumo->stock_actual < $validated['cantidad']) {
            return redirect()->route('lavados.show', $lavado->id)
                ->with('error', 'No hay suficiente stock del insumo seleccionado');
        }

        // Registrar uso de insumo
        UsoInsumo::create([
            'lavado_id' => $lavado->id,
            'insumo_id' => $validated['insumo_id'],
            'cantidad' => $validated['cantidad'],
        ]);

        // Actualizar stock
        $insumo->stock_actual -= $validated['cantidad'];
        $insumo->save();

        return redirect()->route('lavados.show', $lavado->id)
            ->with('success', 'Insumo registrado correctamente');
    }

    // Cambiar estado de lavado
    public function cambiarEstado(Request $request, Lavado $lavado)
    {
        $validated = $request->validate([
            'estado' => 'required|in:pendiente,en_proceso,completado,entregado',
        ]);

        // Si cambia a completado, registrar hora de finalización
        if ($validated['estado'] == 'completado' && $lavado->estado != 'completado') {
            $lavado->hora_salida = now();
        }

        $lavado->estado = $validated['estado'];
        $lavado->save();

        return redirect()->back()->with('success', 'Estado actualizado correctamente');
    }
}