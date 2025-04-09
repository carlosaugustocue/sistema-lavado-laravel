@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Cotizaciones</h1>
        <a href="{{ route('cotizaciones.reporte') }}" class="btn btn-sm btn-primary">
            <i class="fas fa-chart-bar"></i> Ver Reportes
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Lista de Cotizaciones</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Proveedor</th>
                            <th>Producto</th>
                            <th>Precio</th>
                            <th>Cantidad Mínima</th>
                            <th>Disponibilidad</th>
                            <th>Observaciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cotizaciones as $cotizacion)
                            <tr>
                                <td>{{ $cotizacion->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <a href="{{ route('proveedores.show', $cotizacion->proveedor) }}">
                                        {{ $cotizacion->proveedor->nombre }}
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('productos_cotizables.show', $cotizacion->productoCotizable) }}">
                                        {{ $cotizacion->productoCotizable->nombre }}
                                    </a>
                                </td>
                                <td>${{ number_format($cotizacion->precio, 2) }}</td>
                                <td>{{ $cotizacion->cantidad_minima }}</td>
                                <td>
                                    @if($cotizacion->disponibilidad_inmediata)
                                        <span class="badge bg-success text-white">Inmediata</span>
                                    @else
                                        <span class="badge bg-warning text-dark">No inmediata</span>
                                    @endif
                                </td>
                                <td>{{ $cotizacion->observaciones ?? 'N/A' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No hay cotizaciones registradas</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            {{ $cotizaciones->links() }}
        </div>
    </div>
</div>
@endsection