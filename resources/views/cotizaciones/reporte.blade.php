@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Reporte de Cotizaciones</h1>
        <a href="{{ route('cotizaciones.index') }}" class="btn btn-sm btn-primary">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>

    <!-- Productos con Mejor Precio -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Productos con sus Mejores Cotizaciones</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Mejor Precio</th>
                            <th>Proveedor</th>
                            <th>Total Cotizaciones</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($productos as $producto)
                            <tr>
                                <td>{{ $producto->nombre }}</td>
                                <td>${{ number_format($producto->mejor_precio, 2) }}</td>
                                <td>{{ $producto->proveedor_mejor_precio->nombre ?? 'N/A' }}</td>
                                <td>{{ $producto->cotizaciones_count }}</td>
                                <td>
                                    <a href="{{ route('productos_cotizables.show', $producto) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i> Ver Detalles
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Proveedores más activos -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Proveedores más Activos</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Proveedor</th>
                            <th>Cotizaciones</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($proveedores as $proveedor)
                            <tr>
                                <td>{{ $proveedor->nombre }}</td>
                                <td>{{ $proveedor->cotizaciones_count }}</td>
                                <td>
                                    <a href="{{ route('proveedores.show', $proveedor) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i> Ver Detalles
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection