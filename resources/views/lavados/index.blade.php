@extends('layouts.app')

@section('title', 'Lavados - Sistema de Lavado de Vehículos')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Listado de Lavados</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('lavados.create') }}" class="btn btn-sm btn-primary">
            <i class="fas fa-plus me-1"></i> Nuevo Lavado
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header bg-white">
        <div class="row">
            <div class="col-md-8">
                <h5 class="mb-0">Todos los lavados registrados</h5>
            </div>
            <div class="col-md-4">
                <form action="{{ route('vehiculos.buscar') }}" method="GET" class="d-flex">
                    <input type="text" name="placa" class="form-control form-control-sm me-2" placeholder="Buscar por placa" required>
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Placa</th>
                        <th>Servicio</th>
                        <th>Estado</th>
                        <th>Entrada</th>
                        <th>Salida</th>
                        <th>Costo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($lavados as $lavado)
                    <tr>
                        <td>{{ $lavado->id }}</td>
                        <td>{{ $lavado->vehiculo->placa }}</td>
                        <td>{{ $lavado->servicio->nombre }}</td>
                        <td>
                            @if($lavado->estado == 'pendiente')
                            <span class="badge bg-warning">Pendiente</span>
                            @elseif($lavado->estado == 'en_proceso')
                            <span class="badge bg-info">En Proceso</span>
                            @elseif($lavado->estado == 'completado')
                            <span class="badge bg-success">Completado</span>
                            @elseif($lavado->estado == 'entregado')
                            <span class="badge bg-secondary">Entregado</span>
                            @endif
                        </td>
                        <td>{{ $lavado->hora_entrada->format('d/m/Y H:i') }}</td>
                        <td>{{ $lavado->hora_salida ? $lavado->hora_salida->format('d/m/Y H:i') : 'Pendiente' }}</td>
                        <td>${{ number_format($lavado->costo_total, 2) }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('lavados.show', $lavado->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('lavados.edit', $lavado->id) }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $lavado->id }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>

                            <!-- Modal de eliminación -->
                            <div class="modal fade" id="deleteModal{{ $lavado->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $lavado->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteModalLabel{{ $lavado->id }}">Confirmar eliminación</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            ¿Está seguro de que desea eliminar el registro de lavado #{{ $lavado->id }} del vehículo {{ $lavado->vehiculo->placa }}?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                            <form action="{{ route('lavados.destroy', $lavado->id) }}" method="POST">
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
                        <td colspan="8" class="text-center">No hay lavados registrados</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection