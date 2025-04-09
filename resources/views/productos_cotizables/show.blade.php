@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detalles del Producto</h1>
        <div>
            <a href="{{ route('productos_cotizables.edit', $productoCotizable) }}" class="btn btn-sm btn-primary">
                <i class="fas fa-edit"></i> Editar
            </a>
            <a href="{{ route('productos_cotizables.index') }}" class="btn btn-sm btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Información del Producto</h6>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-4">Nombre:</dt>
                        <dd class="col-sm-8">{{ $productoCotizable->nombre }}</dd>
                        
                        <dt class="col-sm-4">Descripción:</dt>
                        <dd class="col-sm-8">{{ $productoCotizable->descripcion ?? 'N/A' }}</dd>
                        
                        <dt class="col-sm-4">Unidad de Medida:</dt>
                        <dd class="col-sm-8">{{ $productoCotizable->unidad_medida }}</dd>
                        
                        <dt class="col-sm-4">Estado:</dt>
                        <dd class="col-sm-8">
                            @if($productoCotizable->activo)
                                <span class="badge bg-success text-white">Activo</span>
                            @else
                                <span class="badge bg-danger text-white">Inactivo</span>
                            @endif
                        </dd>
                        
                        <dt class="col-sm-4">Fecha de Creación:</dt>
                        <dd class="col-sm-8">{{ $productoCotizable->created_at->format('d/m/Y H:i') }}</dd>
                        
                        <dt class="col-sm-4">Última Actualización:</dt>
                        <dd class="col-sm-8">{{ $productoCotizable->updated_at->format('d/m/Y H:i') }}</dd>
                    </dl>
                </div>
            </div>
        </div>
        
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Estadísticas</h6>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-6">Total de Cotizaciones:</dt>
                        <dd class="col-sm-6">{{ $cotizaciones->count() }}</dd>
                        
                        <dt class="col-sm-6">Mejor Precio:</dt>
                        <dd class="col-sm-6">
                            @if($cotizaciones->count() > 0)
                                ${{ number_format($cotizaciones->min('precio'), 2) }}
                            @else
                                N/A
                            @endif
                        </dd>
                        
                        <dt class="col-sm-6">Precio Promedio:</dt>
                        <dd class="col-sm-6">
                            @if($cotizaciones->count() > 0)
                                ${{ number_format($cotizaciones->avg('precio'), 2) }}
                            @else
                                N/A
                            @endif
                        </dd>
                        
                        <dt class="col-sm-6">Precio Más Alto:</dt>
                        <dd class="col-sm-6">
                            @if($cotizaciones->count() > 0)
                                ${{ number_format($cotizaciones->max('precio'), 2) }}
                            @else
                                N/A
                            @endif
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Cotizaciones Recibidas</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Proveedor</th>
                            <th>Precio</th>
                            <th>Cantidad Mínima</th>
                            <th>Disponibilidad</th>
                            <th>Fecha</th>
                            <th>Observaciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cotizaciones as $cotizacion)
                            <tr>
                                <td>
                                    <a href="{{ route('proveedores.show', $cotizacion->proveedor) }}">
                                        {{ $cotizacion->proveedor->nombre }}
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
                                <td>{{ $cotizacion->updated_at->format('d/m/Y') }}</td>
                                <td>{{ $cotizacion->observaciones ?? 'N/A' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No hay cotizaciones para este producto</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection