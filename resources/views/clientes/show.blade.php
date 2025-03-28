@extends('layouts.app')

@section('title', 'Detalle de Cliente - Sistema de Lavado de Vehículos')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Detalle de Cliente</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="{{ route('clientes.edit', $cliente->id) }}" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-edit me-1"></i> Editar
            </a>
            <a href="{{ route('clientes.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Volver
            </a>
        </div>
        <a href="{{ route('vehiculos.create') }}" class="btn btn-sm btn-primary">
            <i class="fas fa-car me-1"></i> Añadir Vehículo
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">Información del Cliente</h5>
            </div>
            <div class="card-body">
                <h3 class="mb-3">{{ $cliente->nombre }} {{ $cliente->apellido }}</h3>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Teléfono
                        <span class="badge bg-primary rounded-pill">{{ $cliente->telefono }}</span>
                    </li>
                    @if($cliente->email)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Email
                        <span>{{ $cliente->email }}</span>
                    </li>
                    @endif
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Vehículos registrados
                        <span class="badge bg-info rounded-pill">{{ $cliente->vehiculos->count() }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Fecha de registro
                        <span>{{ $cliente->created_at->format('d/m/Y') }}</span>
                    </li>
                </ul>
            </div>
            <div class="card-footer bg-white d-grid gap-2">
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                    <i class="fas fa-trash me-1"></i> Eliminar Cliente
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
                                ¿Está seguro de que desea eliminar al cliente {{ $cliente->nombre }} {{ $cliente->apellido }}?
                                @if($cliente->vehiculos->count() > 0)
                                <div class="alert alert-warning mt-2">
                                    <i class="fas fa-exclamation-triangle me-1"></i> Este cliente tiene {{ $cliente->vehiculos->count() }} vehículo(s) registrado(s). Si lo elimina, también se eliminarán sus vehículos asociados.
                                </div>
                                @endif
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <form action="{{ route('clientes.destroy', $cliente->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Eliminar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-white">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Vehículos del Cliente</h5>
                    <a href="{{ route('vehiculos.create') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus me-1"></i> Nuevo Vehículo
                    </a>
                </div>
            </div>
            <div class="card-body">
                @if($vehiculos->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Placa</th>
                                <th>Marca</th>
                                <th>Modelo</th>
                                <th>Color</th>
                                <th>Tipo</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($vehiculos as $vehiculo)
                            <tr>
                                <td>{{ $vehiculo->placa }}</td>
                                <td>{{ $vehiculo->marca }}</td>
                                <td>{{ $vehiculo->modelo }}</td>
                                <td>{{ $vehiculo->color }}</td>
                                <td>{{ ucfirst($vehiculo->tipo) }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('vehiculos.show', $vehiculo->id) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('vehiculos.edit', $vehiculo->id) }}" class="btn btn-sm btn-outline-secondary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="{{ route('lavados.create') }}?vehiculo_id={{ $vehiculo->id }}" class="btn btn-sm btn-outline-success">
                                            <i class="fas fa-car-wash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i> Este cliente aún no tiene vehículos registrados.
                </div>
                <div class="text-center">
                    <a href="{{ route('vehiculos.create') }}" class="btn btn-primary">
                        <i class="fas fa-car me-1"></i> Registrar Vehículo
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection