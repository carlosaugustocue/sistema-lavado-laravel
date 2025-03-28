<?php

namespace App\Http\Controllers;

use App\Models\Servicio;
use Illuminate\Http\Request;

class ServicioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $servicios = Servicio::orderBy('nombre')->get();
        return view('servicios.index', compact('servicios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('servicios.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'precio' => 'required|numeric|min:0',
            'tiempo_estimado' => 'required|integer|min:1',
            'activo' => 'boolean',
        ]);

        // Si activo no está presente en el request, establecerlo como false
        if (!isset($validated['activo'])) {
            $validated['activo'] = false;
        }

        Servicio::create($validated);

        return redirect()->route('servicios.index')
            ->with('success', 'Servicio registrado con éxito');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $servicio = Servicio::findOrFail($id);
        return view('servicios.show', compact('servicio'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $servicio = Servicio::findOrFail($id);
        return view('servicios.edit', compact('servicio'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $servicio = Servicio::findOrFail($id);
        
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'precio' => 'required|numeric|min:0',
            'tiempo_estimado' => 'required|integer|min:1',
            'activo' => 'boolean',
        ]);

        // Si activo no está presente en el request, establecerlo como false
        if (!isset($validated['activo'])) {
            $validated['activo'] = false;
        }

        $servicio->update($validated);

        return redirect()->route('servicios.show', $servicio->id)
            ->with('success', 'Servicio actualizado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $servicio = Servicio::findOrFail($id);
        
        // Verificar si tiene lavados asociados
        if ($servicio->lavados()->count() > 0) {
            return redirect()->back()
                ->with('error', 'No se puede eliminar el servicio porque tiene lavados asociados');
        }
        
        $servicio->delete();

        return redirect()->route('servicios.index')
            ->with('success', 'Servicio eliminado con éxito');
    }
}