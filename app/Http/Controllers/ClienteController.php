<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index()
    {
        $clientes = Cliente::orderBy('apellido')->orderBy('nombre')->get();
        return view('clientes.index', compact('clientes'));
    }

    public function create()
    {
        return view('clientes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
        ]);

        Cliente::create($validated);

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente registrado con éxito');
    }

    public function show(Cliente $cliente)
    {
        $vehiculos = $cliente->vehiculos;
        return view('clientes.show', compact('cliente', 'vehiculos'));
    }

    public function edit(Cliente $cliente)
    {
        return view('clientes.edit', compact('cliente'));
    }

    public function update(Request $request, Cliente $cliente)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
        ]);

        $cliente->update($validated);

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente actualizado con éxito');
    }

    public function destroy(Cliente $cliente)
    {
        // Verificar si tiene vehículos antes de eliminar
        if ($cliente->vehiculos()->count() > 0) {
            return redirect()->route('clientes.index')
                ->with('error', 'No se puede eliminar el cliente porque tiene vehículos registrados');
        }

        $cliente->delete();

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente eliminado con éxito');
    }
}