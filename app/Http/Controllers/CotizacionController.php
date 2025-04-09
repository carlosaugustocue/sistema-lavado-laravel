<?php

namespace App\Http\Controllers;

use App\Models\Cotizacion;
use App\Models\Proveedor;
use App\Models\ProductoCotizable;
use Illuminate\Http\Request;

class CotizacionController extends Controller
{
    // Formulario para cotizar (vista pública)
    public function formulario()
    {
        $productos = ProductoCotizable::where('activo', true)->orderBy('nombre')->get();
        return view('cotizaciones.formulario', compact('productos'));
    }
    
    // Buscar proveedor para iniciar cotización
    public function buscarProveedor(Request $request)
    {
        $datos = $request->validate([
            'email' => 'required|email',
        ]);
        
        $proveedor = Proveedor::where('email', $datos['email'])->first();
        
        if (!$proveedor) {
            return redirect()->route('proveedores.registro')
                ->with('info', 'No encontramos un proveedor con ese email. Por favor regístrese primero.');
        }
        
        if (!$proveedor->verificado) {
            return redirect()->back()
                ->with('warning', 'Su cuenta de proveedor aún no ha sido verificada. Por favor espere la aprobación del administrador.');
        }
        
        // Generar una sesión temporal para el proveedor
        session(['proveedor_id' => $proveedor->id]);
        
        return redirect()->route('cotizaciones.productos', $proveedor->id);
    }
    
    // Mostrar productos para cotizar
    public function mostrarProductos($proveedor_id)
    {
        // Verificar sesión
        if (session('proveedor_id') != $proveedor_id) {
            return redirect()->route('cotizaciones.formulario')
                ->with('error', 'Acceso denegado. Por favor identifíquese primero.');
        }
        
        $proveedor = Proveedor::findOrFail($proveedor_id);
        $productos = ProductoCotizable::where('activo', true)->orderBy('nombre')->get();
        
        // Obtener cotizaciones existentes de este proveedor
        $cotizacionesExistentes = Cotizacion::where('proveedor_id', $proveedor_id)
            ->pluck('precio', 'producto_cotizable_id')
            ->toArray();
        
        return view('cotizaciones.productos', compact('proveedor', 'productos', 'cotizacionesExistentes'));
    }
    
    // Guardar cotización
    public function guardarCotizacion(Request $request, $proveedor_id)
    {
        // Verificar sesión
        if (session('proveedor_id') != $proveedor_id) {
            return redirect()->route('cotizaciones.formulario')
                ->with('error', 'Acceso denegado. Por favor identifíquese primero.');
        }
        
        $proveedor = Proveedor::findOrFail($proveedor_id);
        
        $datos = $request->validate([
            'producto_id' => 'required|exists:productos_cotizables,id',
            'precio' => 'required|numeric|min:0.01',
            'cantidad_minima' => 'required|integer|min:1',
            'observaciones' => 'nullable|string',
            'disponibilidad_inmediata' => 'required|boolean',
        ]);
        
        // Verificar si ya existe una cotización para este producto y proveedor
        $cotizacion = Cotizacion::where('proveedor_id', $proveedor_id)
            ->where('producto_cotizable_id', $datos['producto_id'])
            ->first();
        
        if ($cotizacion) {
            // Actualizar cotización existente
            $cotizacion->update([
                'precio' => $datos['precio'],
                'cantidad_minima' => $datos['cantidad_minima'],
                'observaciones' => $datos['observaciones'],
                'disponibilidad_inmediata' => $datos['disponibilidad_inmediata'],
            ]);
            
            $mensaje = 'Cotización actualizada correctamente';
        } else {
            // Crear nueva cotización
            Cotizacion::create([
                'proveedor_id' => $proveedor_id,
                'producto_cotizable_id' => $datos['producto_id'],
                'precio' => $datos['precio'],
                'cantidad_minima' => $datos['cantidad_minima'],
                'observaciones' => $datos['observaciones'],
                'disponibilidad_inmediata' => $datos['disponibilidad_inmediata'],
            ]);
            
            $mensaje = 'Cotización enviada correctamente';
        }
        
        return redirect()->route('cotizaciones.productos', $proveedor_id)
            ->with('success', $mensaje);
    }
    
    // Ver todas las cotizaciones (admin)
    public function index()
    {
        $cotizaciones = Cotizacion::with(['proveedor', 'productoCotizable'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);
            
        return view('cotizaciones.index', compact('cotizaciones'));
    }
    
    // Generar reporte de cotizaciones (admin)
    public function reporte()
    {
        // Productos con sus mejores cotizaciones
        $productos = ProductoCotizable::where('activo', true)
            ->withCount('cotizaciones')
            ->having('cotizaciones_count', '>', 0)
            ->get();
            
        foreach ($productos as $producto) {
            $producto->mejor_precio = $producto->getMejorPrecioAttribute();
            $producto->proveedor_mejor_precio = $producto->getProveedorMejorPrecioAttribute();
        }
        
        // Proveedores más activos
        $proveedores = Proveedor::withCount('cotizaciones')
            ->orderByDesc('cotizaciones_count')
            ->limit(10)
            ->get();
        
        return view('cotizaciones.reporte', compact('productos', 'proveedores'));
    }
}