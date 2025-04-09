<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Http\Request;

class ProveedorController extends Controller
{
    // Listar proveedores (admin)
    public function index()
    {
        $proveedores = Proveedor::orderBy('nombre')->paginate(15);
        return view('proveedores.index', compact('proveedores'));
    }
    
    // Formulario de registro público
    public function registroPublico()
    {
        return view('proveedores.registro');
    }
    
    // Procesar registro público
    public function guardarRegistro(Request $request)
    {
        $datos = $request->validate([
            'nombre' => 'required|string|max:255',
            'contacto' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
            'email' => 'required|email|unique:proveedores',
            'direccion' => 'nullable|string',
            'rfc' => 'nullable|string|max:15',
        ]);
        
        // Por defecto los proveedores nuevos no están verificados
        $datos['verificado'] = false;
        
        $proveedor = Proveedor::create($datos);
        
        return redirect()->route('proveedores.confirmacion', $proveedor->id)
            ->with('success', 'Registro completado correctamente');
    }
    
    // Pantalla de confirmación tras registro
    public function confirmacionRegistro($id)
    {
        $proveedor = Proveedor::findOrFail($id);
        return view('proveedores.confirmacion', compact('proveedor'));
    }
    
    // Verificar un proveedor (admin)
    public function verificar(Proveedor $proveedor)
    {
        $proveedor->update(['verificado' => true]);
        
        return redirect()->route('proveedores.index')
            ->with('success', 'Proveedor verificado correctamente');
    }
    
    // Mostrar detalles de proveedor (admin)
    public function show(Proveedor $proveedor)
    {
        $cotizaciones = $proveedor->cotizaciones()
            ->with('productoCotizable')
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('proveedores.show', compact('proveedor', 'cotizaciones'));
    }
    
    // Eliminar proveedor (admin)
    public function destroy(Proveedor $proveedor)
    {
        $proveedor->delete(); // Esto eliminará también sus cotizaciones por la restricción onDelete('cascade')
        
        return redirect()->route('proveedores.index')
            ->with('success', 'Proveedor eliminado correctamente');
    }
}