@extends('layouts.app')

@section('title', 'Detalle de Insumo - Sistema de Lavado de Vehículos')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Detalle de Insumo</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="{{ route('insumos.edit', $insumo->id) }}" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-edit me-1"></i> Editar
            </a>
            <a href="{{ route('insumos.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Volver
            </a>
        </div>
        <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#stockModal">
            <i class="fas fa-plus-circle me-1"></i> Actualizar Stock
        </button>
    </div>
</div>

<div class="row">
    <div class="col-md-5">
        <div class="card mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">Información del Insumo</h5>
            </div>
            <div class="card-body">
                <h3 class="mb-3">{{ $insumo->nombre }}</h3>
                
                @if($insumo->descripcion)
                <p class="mb-3">{{ $insumo->descripcion }}</p>
                @endif
                
                <ul class="list-group list-group-flush mb-3">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Costo
                        <span class="badge bg-primary rounded-pill">${{ number_format($insumo->costo, 2) }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Unidad de medida
                        <span class="badge bg-info rounded-pill">{{ $insumo->unidad_medida }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Stock actual
                        <span class="badge bg-secondary rounded-pill">{{ $insumo->stock_actual }} {{ $insumo->unidad_medida }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Stock mínimo
                        <span class="badge bg-secondary rounded-pill">{{ $insumo->stock_minimo }} {{ $insumo->unidad_medida }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Estado
                        @if($insumo->stock_actual <= $insumo->stock_minimo)
                            @if($insumo->stock_actual == 0)
                            <span class="badge bg-danger">Agotado</span>
                            @else
                            <span class="badge bg-warning">Stock Bajo</span>
                            @endif
                        @else
                            <span class="badge bg-success">Disponible</span>
                        @endif
                    </li>
                </ul>
                
                <div class="mb-3">
                    <h6>Nivel de stock</h6>
                    @php
                    $porcentaje = $insumo->stock_minimo > 0 ? min(($insumo->stock_actual / $insumo->stock_minimo) * 100, 100) : 100;
                    $clase = 'bg-success';
                    if($porcentaje <= 25) $clase = 'bg-danger';
                    elseif($porcentaje <= 75) $clase = 'bg-warning';
                    @endphp
                    <div class="progress" style="height: 20px;">
                        <div class="progress-bar {{ $clase }}" role="progressbar" style="width: {{ $porcentaje }}%">
                            {{ round($porcentaje) }}%
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-white d-grid gap-2">
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                    <i class="fas fa-trash me-1"></i> Eliminar Insumo
                </button>
                
                <!-- Modal de eliminación -->
                <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteModalLabel">Confirmar eliminación</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                ¿Está seguro de que desea eliminar el insumo {{ $insumo->nombre }}?
                                @if($usos->count() > 0)
                                <div class="alert alert-warning mt-2">
                                    <i class="fas fa-exclamation-triangle me-1"></i> Este insumo ha sido utilizado en {{ $usos->count() }} lavados. Si lo elimina, podría afectar los registros relacionados.
                                </div>
                                @endif
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <form action="{{ route('insumos.destroy', $insumo->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Eliminar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Modal de actualización de stock -->
                <div class="modal fade" id="stockModal" tabindex="-1" aria-labelledby="stockModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="stockModalLabel">Actualizar Stock: {{ $insumo->nombre }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ route('insumos.actualizar-stock', $insumo->id) }}" method="POST">
                                @csrf
                                <div class="modal-body">
                                    <p>Stock actual: <strong>{{ $insumo->stock_actual }} {{ $insumo->unidad_medida }}</strong></p>
                                    <div class="mb-3">
                                        <label for="cantidad" class="form-label">Cantidad a añadir ({{ $insumo->unidad_medida }})</label>
                                        <input type="number" class="form-control" id="cantidad" name="cantidad" min="0.01" step="0.01" required>
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
            </div>
        </div>
    </div>
    
    <div class="col-md-7">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Historial de Uso</h5>
            </div>
            <div class="card-body">
                @if($usos->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID Lavado</th>
                                <th>Vehículo</th>
                                <th>Fecha</th>
                                <th>Cantidad</th>
                                <th>Costo</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($usos as $uso)
                            <tr>
                                <td>{{ $uso->lavado->id }}</td>
                                <td>{{ $uso->lavado->vehiculo->placa }}</td>
                                <td>{{ $uso->created_at->format('d/m/Y H:i') }}</td>
                                <td>{{ $uso->cantidad }} {{ $insumo->unidad_medida }}</td>
                                <td>${{ number_format($uso->cantidad * $insumo->costo, 2) }}</td>
                                <td>
                                    <a href="{{ route('lavados.show', $uso->lavado->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i> Este insumo aún no ha sido utilizado en ningún lavado.
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection