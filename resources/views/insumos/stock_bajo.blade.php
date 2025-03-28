@extends('layouts.app')

@section('title', 'Insumos con Stock Bajo - Sistema de Lavado de Vehículos')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Insumos con Stock Bajo</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('insumos.index') }}" class="btn btn-sm btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Volver a Insumos
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header bg-white">
        <h5 class="mb-0">
            <i class="fas fa-exclamation-triangle text-warning me-1"></i> Insumos que necesitan reposición
        </h5>
    </div>
    <div class="card-body">
        @if($insumosStockBajo->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Insumo</th>
                        <th>Descripción</th>
                        <th>Stock Actual</th>
                        <th>Stock Mínimo</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($insumosStockBajo as $insumo)
                    <tr>
                        <td>{{ $insumo->nombre }}</td>
                        <td>{{ $insumo->descripcion }}</td>
                        <td>{{ $insumo->stock_actual }} {{ $insumo->unidad_medida }}</td>
                        <td>{{ $insumo->stock_minimo }} {{ $insumo->unidad_medida }}</td>
                        <td>
                            @php
                            $porcentaje = $insumo->stock_actual / $insumo->stock_minimo * 100;
                            @endphp
                            
                            @if($porcentaje <= 25)
                            <div class="progress" style="height: 20px;">
                                <div class="progress-bar bg-danger" role="progressbar" style="width: {{ $porcentaje }}%">
                                    {{ round($porcentaje) }}%
                                </div>
                            </div>
                            @elseif($porcentaje <= 50)
                            <div class="progress" style="height: 20px;">
                                <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $porcentaje }}%">
                                    {{ round($porcentaje) }}%
                                </div>
                            </div>
                            @elseif($porcentaje <= 100)
                            <div class="progress" style="height: 20px;">
                                <div class="progress-bar bg-info" role="progressbar" style="width: {{ $porcentaje }}%">
                                    {{ round($porcentaje) }}%
                                </div>
                            </div>
                            @endif
                        </td>
                        <td>
                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#stockModal{{ $insumo->id }}">
                                <i class="fas fa-plus-circle"></i> Añadir Stock
                            </button>
                            
                            <!-- Modal de actualización de stock -->
                            <div class="modal fade" id="stockModal{{ $insumo->id }}" tabindex="-1" aria-labelledby="stockModalLabel{{ $insumo->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="stockModalLabel{{ $insumo->id }}">Actualizar Stock: {{ $insumo->nombre }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('insumos.actualizar-stock', $insumo->id) }}" method="POST">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="cantidad{{ $insumo->id }}" class="form-label">Cantidad a añadir ({{ $insumo->unidad_medida }})</label>
                                                    <input type="number" class="form-control" id="cantidad{{ $insumo->id }}" name="cantidad" min="0.01" step="0.01" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                <button type="submit" class="btn btn-primary">Actualizar Stock</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="alert alert-success" role="alert">
            <i class="fas fa-check-circle me-2"></i> No hay insumos con stock bajo. ¡Todo está bien!
        </div>
        @endif
    </div>
</div>
@endsection