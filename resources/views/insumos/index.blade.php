@extends('layouts.app')

@section('title', 'Insumos - Sistema de Lavado de Vehículos')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Listado de Insumos</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('insumos.create') }}" class="btn btn-sm btn-primary">
            <i class="fas fa-plus me-1"></i> Nuevo Insumo
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header bg-white">
        <div class="row">
            <div class="col-md-6">
                <h5 class="mb-0">Todos los insumos registrados</h5>
            </div>
            <div class="col-md-6 text-end">
                <a href="{{ route('insumos.stock-bajo') }}" class="btn btn-sm btn-warning">
                    <i class="fas fa-exclamation-triangle me-1"></i> Ver Stock Bajo
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Stock Actual</th>
                        <th>Stock Mínimo</th>
                        <th>Unidad</th>
                        <th>Costo</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($insumos as $insumo)
                    <tr>
                        <td>{{ $insumo->id }}</td>
                        <td>{{ $insumo->nombre }}</td>
                        <td>{{ $insumo->stock_actual }} {{ $insumo->unidad_medida }}</td>
                        <td>{{ $insumo->stock_minimo }} {{ $insumo->unidad_medida }}</td>
                        <td>{{ $insumo->unidad_medida }}</td>
                        <td>${{ number_format($insumo->costo, 2) }}</td>
                        <td>
                            @if($insumo->stock_actual <= $insumo->stock_minimo)
                                @if($insumo->stock_actual == 0)
                                <span class="badge bg-danger">Agotado</span>
                                @else
                                <span class="badge bg-warning">Stock Bajo</span>
                                @endif
                            @else
                                <span class="badge bg-success">Disponible</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('insumos.show', $insumo->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('insumos.edit', $insumo->id) }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#stockModal{{ $insumo->id }}">
                                    <i class="fas fa-plus-circle"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $insumo->id }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>

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
                                                <p>Stock actual: <strong>{{ $insumo->stock_actual }} {{ $insumo->unidad_medida }}</strong></p>
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

                            <!-- Modal de eliminación -->
                            <div class="modal fade" id="deleteModal{{ $insumo->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $insumo->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteModalLabel{{ $insumo->id }}">Confirmar eliminación</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            ¿Está seguro de que desea eliminar el insumo {{ $insumo->nombre }}?
                                            @if($insumo->usos()->count() > 0)
                                            <div class="alert alert-warning mt-2">
                                                <i class="fas fa-exclamation-triangle me-1"></i> Este insumo ha sido utilizado en lavados. Si lo elimina, podría afectar los registros relacionados.
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
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">No hay insumos registrados</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection