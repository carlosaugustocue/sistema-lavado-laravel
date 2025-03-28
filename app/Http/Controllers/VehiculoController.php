<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Vehiculo;
use Illuminate\Http\Request;

class VehiculoController extends Controller
{
    public function index()
    {
        $vehiculos = Vehiculo::with('cliente')->orderBy('placa')->get();
        return view('vehiculos.index', compact('vehiculos'));
    }

    public function create()
    {
        $clientes = Cliente::orderBy('apellido')->orderBy('nombre')->get();
        return view('vehiculos.create', compact('clientes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'placa' => 'required|string|max:10|unique:vehiculos',
            'marca' => 'required|string|max:255',
            'modelo' => 'required|string|max:255',
            'color' => 'required|string|max:255',
            'tipo' => 'required|in:automovil,camioneta,motocicleta,otro',
            'año' => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
        ]);

        Vehiculo::create($validated);

        return redirect()->route('vehiculos.index')
            ->with('success', 'Vehículo registrado con éxito');
    }

    public function show(Vehiculo $vehiculo)
    {
        $lavados = $vehiculo->lavados()->with(['servicio', 'empleadoRecibe', 'empleadoAsignado'])->get();
        return view('vehiculos.show', compact('vehiculo', 'lavados'));
    }

    public function edit(Vehiculo $vehiculo)
    {
        $clientes = Cliente::orderBy('apellido')->orderBy('nombre')->get();
        return view('vehiculos.edit', compact('vehiculo', 'clientes'));
    }

    public function update(Request $request, Vehiculo $vehiculo)
    {
        $validated = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'placa' => 'required|string|max:10|unique:vehiculos,placa,' . $vehiculo->id,
            'marca' => 'required|string|max:255',
            'modelo' => 'required|string|max:255',
            'color' => 'required|string|max:255',
            'tipo' => 'required|in:automovil,camioneta,motocicleta,otro',
            'año' => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
        ]);

        $vehiculo->update($validated);

        return redirect()->route('vehiculos.index')
            ->with('success', 'Vehículo actualizado con éxito');
    }

    public function destroy(Vehiculo $vehiculo)
    {
        // Verificar si tiene lavados antes de eliminar
        if ($vehiculo->lavados()->count() > 0) {
            return redirect()->route('vehiculos.index')
                ->with('error', 'No se puede eliminar el vehículo porque tiene lavados registrados');
        }

        $vehiculo->delete();

        return redirect()->route('vehiculos.index')
            ->with('success', 'Vehículo eliminado con éxito');
    }

    // RF005 - Historial de Servicios por placa
    public function buscarPorPlaca(Request $request)
    {
        $placa = $request->input('placa');
        $vehiculo = Vehiculo::where('placa', $placa)->first();
        
        if (!$vehiculo) {
            return redirect()->route('vehiculos.index')
                ->with('error', 'No se encontró ningún vehículo con la placa ' . $placa);
        }
        
        return redirect()->route('vehiculos.show', $vehiculo->id);
    }
}