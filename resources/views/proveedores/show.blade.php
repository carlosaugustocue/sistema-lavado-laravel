@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detalles del Proveedor</h1>
        <a href="{{ route('proveedores.index') }}" class="btn btn-sm btn-primary">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Información del Proveedor</h6>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-4">Nombre:</dt>
                        <dd class="col-sm-8">{{ $proveedor->nombre }}</dd>
                        
                        <dt class="col-sm-4">Contacto:</dt>
                        <dd class="col-sm-8">{{ $proveedor->contacto }}</dd>
                        
                        <dt class="col-sm-4">Email:</dt>
                        <dd class="col-sm-8">{{ $proveedor->email }}</dd>
                        
                        <dt class="col-sm-4">Teléfono:</dt>
                        <dd class="col-sm-8">{{ $proveedor->telefono }}</dd>
                        
                        <dt class="col-sm-4">Dirección:</dt>
                        <dd class="col-sm-8">{{ $proveedor->direccion ?? 'N/A' }}</dd>
                        
                        <dt class="col-sm-4">RFC:</dt>
                        <dd class="col-sm-8">{{ $proveedor->rfc ?? 'N/A' }}</dd>
                        
                        <dt class="col-sm-4">Estado:</dt>
                        <dd class="col-sm-8">
                            @if($proveedor->verificado)
                                <span class="badge bg-success text-white">Verificado</span>
                            @else
                                <span class="badge bg-warning text-dark">Pendiente</span>
                                <form action="{{ route('proveedores.verificar', $proveedor) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-success btn-sm">
                                        Verificar Ahora
                                    </button>
                                </form>
                            @endif
                        </dd>
                        
                        <dt class="col-sm-4">Fecha de Registro:</dt>
                        <dd class="col-sm-8">{{ $proveedor->created_at->format('d/m/Y H:i') }}</dd>
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
                        
                        <dt class="col-sm-6">Productos Cotizados:</dt>
                        <dd class="col-sm-6">{{ $proveedor->productosCotizados()->count() }}</dd>
                        
                        <dt class="col-sm-6">Última Cotización:</dt>
                        <dd class="col-sm-6">
                            @if($cotizaciones->count() > 0)
                                {{ $cotizaciones->first()->created_at->format('d/m/Y') }}
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
            <h6 class="m-0 font-weight-bold text-primary">Cotizaciones Realizadas</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Producto</th>
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
                                <td>{{ $cotizacion->updated_at->format('d/m/Y') }}</td>
                                <td>{{ $cotizacion->observaciones ?? 'N/A' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Este proveedor no ha realizado cotizaciones</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection