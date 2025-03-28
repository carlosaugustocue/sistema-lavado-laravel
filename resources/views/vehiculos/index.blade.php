@extends('layouts.app')

@section('title', 'Vehículos - Sistema de Lavado')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Listado de Vehículos</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('vehiculos.create') }}" class="btn btn-sm btn-primary">
            <i class="fas fa-plus me-1"></i> Nuevo Vehículo
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header bg-white">
        <div class="row">
            <div class="col-md-8">
                <h5 class="mb-0">Todos los vehículos registrados</h5>
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
                        <th>Placa</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Color</th>
                        <th>Tipo</th>
                        <th>Cliente</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($vehiculos as $vehiculo)
                    <tr>
                        <td>{{ $vehiculo->placa }}</td>
                        <td>{{ $vehiculo->marca }}</td>
                        <td>{{ $vehiculo->modelo }}</td>
                        <td>{{ $vehiculo->color }}</td>
                        <td>{{ ucfirst($vehiculo->tipo) }}</td>
                        <td>{{ $vehiculo->cliente->nombre }} {{ $vehiculo->cliente->apellido }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('vehiculos.show', $vehiculo->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('vehiculos.edit', $vehiculo->id) }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $vehiculo->id }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>

                            <!-- Modal de eliminación -->
                            <div class="modal fade" id="deleteModal{{ $vehiculo->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $vehiculo->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteModalLabel{{ $vehiculo->id }}">Confirmar eliminación</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            ¿Está seguro de que desea eliminar el vehículo con placa {{ $vehiculo->placa }}?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                            <form action="{{ route('vehiculos.destroy', $vehiculo->id) }}" method="POST">
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
                        <td colspan="7" class="text-center">No hay vehículos registrados</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection