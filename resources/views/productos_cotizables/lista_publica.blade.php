@extends('layouts.publico')

@section('title', 'Productos para Cotizar')

@section('content')
<div class="container py-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Lista de Productos para Cotizar</h4>
        </div>
        <div class="card-body">
            <p class="mb-4">Estos son los productos para los que actualmente estamos recibiendo cotizaciones de proveedores:</p>
            
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Descripción</th>
                            <th>Unidad de Medida</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($productos as $producto)
                            <tr>
                                <td>{{ $producto->nombre }}</td>
                                <td>{{ $producto->descripcion ?? 'N/A' }}</td>
                                <td>{{ $producto->unidad_medida }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">No hay productos disponibles para cotizar en este momento.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4">
                <p>Si usted es proveedor y desea enviar una cotización, por favor haga clic en el siguiente botón:</p>
                <a href="{{ route('cotizaciones.formulario') }}" class="btn btn-primary">Cotizar Productos</a>
            </div>
        </div>
    </div>
</div>
@endsection