<?php

namespace App\Http\Controllers;

use App\Models\ProductoCotizable;
use Illuminate\Http\Request;

class ProductoCotizableController extends Controller
{
    // Listar productos cotizables (admin)
    public function index()
    {
        $productos = ProductoCotizable::orderBy('nombre')->paginate(15);
        return view('productos_cotizables.index', compact('productos'));
    }
    
    // Formulario para crear producto
    public function create()
    {
        return view('productos_cotizables.create');
    }
    
    // Guardar nuevo producto
    public function store(Request $request)
    {
        $datos = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'unidad_medida' => 'required|string|max:50',
            'activo' => 'boolean',
        ]);
        
        ProductoCotizable::create($datos);
        
        return redirect()->route('productos_cotizables.index')
            ->with('success', 'Producto creado correctamente');
    }
    
    // Mostrar producto
    public function show(ProductoCotizable $productoCotizable)
    {
        $cotizaciones = $productoCotizable->cotizaciones()
            ->with('proveedor')
            ->orderBy('precio')
            ->get();
            
        return view('productos_cotizables.show', compact('productoCotizable', 'cotizaciones'));
    }
    
    // Formulario para editar producto
    public function edit(ProductoCotizable $productoCotizable)
    {
        return view('productos_cotizables.edit', compact('productoCotizable'));
    }
    
    // Actualizar producto
    public function update(Request $request, ProductoCotizable $productoCotizable)
    {
        $datos = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'unidad_medida' => 'required|string|max:50',
            'activo' => 'boolean',
        ]);
        
        $productoCotizable->update($datos);
        
        return redirect()->route('productos_cotizables.index')
            ->with('success', 'Producto actualizado correctamente');
    }
    
    // Eliminar producto
    public function destroy(ProductoCotizable $productoCotizable)
    {
        // Verificar si tiene cotizaciones
        if ($productoCotizable->cotizaciones()->count() > 0) {
            return redirect()->route('productos_cotizables.index')
                ->with('error', 'No se puede eliminar el producto porque tiene cotizaciones asociadas');
        }
        
        $productoCotizable->delete();
        
        return redirect()->route('productos_cotizables.index')
            ->with('success', 'Producto eliminado correctamente');
    }
    
    // Lista pública de productos cotizables activos
    public function listaPublica()
    {
        $productos = ProductoCotizable::where('activo', true)
            ->orderBy('nombre')
            ->get();
            
        return view('productos_cotizables.lista_publica', compact('productos'));
    }
}