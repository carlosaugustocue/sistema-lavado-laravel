<?php

namespace App\Http\Controllers;

use App\Models\Insumo;
use Illuminate\Http\Request;

class InsumoController extends Controller
{
    public function index()
    {
        $insumos = Insumo::orderBy('nombre')->get();
        return view('insumos.index', compact('insumos'));
    }

    public function create()
    {
        return view('insumos.create');
    }

    /**
 * Store a newly created resource in storage.
 */
public function store(Request $request)
{
    $validated = $request->validate([
        'nombre' => 'required|string|max:255|unique:insumos,nombre',
        'descripcion' => 'nullable|string|max:1000',
        'costo' => 'required|numeric|min:0.01|max:999999.99',
        'stock_actual' => 'required|numeric|min:0|max:999999.99',
        'stock_minimo' => 'required|numeric|min:0|max:999999.99',
        'unidad_medida' => [
            'required',
            'string',
            'max:50',
            'regex:/^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\s]+$/'
        ],
    ], [
        'nombre.required' => 'El nombre del insumo es obligatorio',
        'nombre.unique' => 'Ya existe un insumo con este nombre',
        'costo.required' => 'El costo del insumo es obligatorio',
        'costo.numeric' => 'El costo debe ser un valor numérico',
        'costo.min' => 'El costo debe ser mayor que 0',
        'stock_actual.required' => 'El stock actual es obligatorio',
        'stock_actual.numeric' => 'El stock actual debe ser un valor numérico',
        'stock_actual.min' => 'El stock actual no puede ser negativo',
        'stock_minimo.required' => 'El stock mínimo es obligatorio',
        'stock_minimo.numeric' => 'El stock mínimo debe ser un valor numérico',
        'stock_minimo.min' => 'El stock mínimo no puede ser negativo',
        'unidad_medida.required' => 'La unidad de medida es obligatoria',
        'unidad_medida.regex' => 'La unidad de medida contiene caracteres no permitidos',
    ]);

    // Verificar que el stock mínimo no sea mayor que el stock actual
    if ($validated['stock_minimo'] > $validated['stock_actual']) {
        return redirect()->back()
            ->withInput()
            ->withErrors(['stock_minimo' => 'El stock mínimo no debe ser mayor que el stock actual']);
    }

    // Normalizar unidad de medida (primera letra mayúscula)
    $validated['unidad_medida'] = ucfirst(strtolower($validated['unidad_medida']));

    // Redondear valores numéricos a 2 decimales
    $validated['costo'] = round($validated['costo'], 2);
    $validated['stock_actual'] = round($validated['stock_actual'], 2);
    $validated['stock_minimo'] = round($validated['stock_minimo'], 2);

    Insumo::create($validated);

    return redirect()->route('insumos.index')
        ->with('success', 'Insumo registrado con éxito');
}

    public function show(Insumo $insumo)
    {
        $usos = $insumo->usos()->with('lavado.vehiculo')->orderBy('created_at', 'desc')->get();
        return view('insumos.show', compact('insumo', 'usos'));
    }

    public function edit(Insumo $insumo)
    {
        return view('insumos.edit', compact('insumo'));
    }

    /**
 * Update the specified resource in storage.
 */
public function update(Request $request, string $id)
{
    $insumo = Insumo::findOrFail($id);
    
    $validated = $request->validate([
        'nombre' => 'required|string|max:255|unique:insumos,nombre,'.$insumo->id,
        'descripcion' => 'nullable|string|max:1000',
        'costo' => 'required|numeric|min:0.01|max:999999.99',
        'stock_actual' => 'required|numeric|min:0|max:999999.99',
        'stock_minimo' => 'required|numeric|min:0|max:999999.99',
        'unidad_medida' => [
            'required',
            'string',
            'max:50',
            'regex:/^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\s]+$/'
        ],
    ], [
        'nombre.required' => 'El nombre del insumo es obligatorio',
        'nombre.unique' => 'Ya existe un insumo con este nombre',
        'costo.required' => 'El costo del insumo es obligatorio',
        'costo.numeric' => 'El costo debe ser un valor numérico',
        'costo.min' => 'El costo debe ser mayor que 0',
        'stock_actual.required' => 'El stock actual es obligatorio',
        'stock_actual.numeric' => 'El stock actual debe ser un valor numérico',
        'stock_actual.min' => 'El stock actual no puede ser negativo',
        'stock_minimo.required' => 'El stock mínimo es obligatorio',
        'stock_minimo.numeric' => 'El stock mínimo debe ser un valor numérico',
        'stock_minimo.min' => 'El stock mínimo no puede ser negativo',
        'unidad_medida.required' => 'La unidad de medida es obligatoria',
        'unidad_medida.regex' => 'La unidad de medida contiene caracteres no permitidos',
    ]);

    // Verificación adicional para stock_minimo
    if ($validated['stock_minimo'] > $validated['stock_actual']) {
        return redirect()->back()
            ->withInput()
            ->withErrors(['stock_minimo' => 'El stock mínimo no debe ser mayor que el stock actual']);
    }

    // Normalizar unidad de medida (primera letra mayúscula)
    $validated['unidad_medida'] = ucfirst(strtolower($validated['unidad_medida']));

    // Redondear valores numéricos a 2 decimales
    $validated['costo'] = round($validated['costo'], 2);
    $validated['stock_actual'] = round($validated['stock_actual'], 2);
    $validated['stock_minimo'] = round($validated['stock_minimo'], 2);

    // Si el stock ha cambiado, registrar el cambio
    if ($insumo->stock_actual != $validated['stock_actual']) {
        // Aquí podrías registrar el cambio en una tabla de historial si lo deseas
        // Ejemplo: StockMovimiento::create([...]);
    }

    $insumo->update($validated);

    return redirect()->route('insumos.show', $insumo->id)
        ->with('success', 'Insumo actualizado con éxito');
}

    public function destroy(Insumo $insumo)
    {
        // Verificar si tiene usos registrados
        if ($insumo->usos()->count() > 0) {
            return redirect()->route('insumos.index')
                ->with('error', 'No se puede eliminar el insumo porque ha sido utilizado en lavados');
        }

        $insumo->delete();

        return redirect()->route('insumos.index')
            ->with('success', 'Insumo eliminado con éxito');
    }

    // RF008 - Identificación de insumos con stock bajo
    public function stockBajo()
    {
        $insumosStockBajo = Insumo::whereRaw('stock_actual <= stock_minimo')->get();
        return view('insumos.stock_bajo', compact('insumosStockBajo'));
    }

    // Función para actualizar stock
    /**
 * Update stock for a specific insumo.
 */
public function actualizarStock(Request $request, string $id)
{
    $insumo = Insumo::findOrFail($id);
    
    $validated = $request->validate([
        'cantidad' => 'required|numeric|min:0.01|max:999999.99',
    ], [
        'cantidad.required' => 'Debe ingresar la cantidad a añadir',
        'cantidad.numeric' => 'La cantidad debe ser un valor numérico',
        'cantidad.min' => 'La cantidad debe ser mayor que 0',
    ]);

    // Redondear la cantidad a 2 decimales
    $cantidad = round($validated['cantidad'], 2);
    
    // Registrar el stock anterior
    $stockAnterior = $insumo->stock_actual;
    
    // Actualizar el stock
    $insumo->stock_actual += $cantidad;
    
    // Asegurarse de que el stock no tenga más de 2 decimales
    $insumo->stock_actual = round($insumo->stock_actual, 2);
    $insumo->save();

    // Aquí podrías registrar el movimiento de stock si tienes una tabla para ello
    // StockMovimiento::create([
    //     'insumo_id' => $insumo->id,
    //     'cantidad' => $cantidad,
    //     'tipo' => 'ingreso',
    //     'stock_anterior' => $stockAnterior,
    //     'stock_nuevo' => $insumo->stock_actual,
    //     'usuario_id' => auth()->id(),
    //     'fecha' => now(),
    // ]);

    return redirect()->back()
        ->with('success', 'Stock actualizado correctamente. Se añadieron ' . $cantidad . ' ' . $insumo->unidad_medida . ' al inventario.');
}
}