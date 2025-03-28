@extends('layouts.app')

@section('title', 'Clientes - Sistema de Lavado de Vehículos')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Listado de Clientes</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('clientes.create') }}" class="btn btn-sm btn-primary">
            <i class="fas fa-plus me-1"></i> Nuevo Cliente
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header bg-white">
        <h5 class="mb-0">Todos los clientes registrados</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Teléfono</th>
                        <th>Email</th>
                        <th>Vehículos</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($clientes as $cliente)
                    <tr>
                        <td>{{ $cliente->id }}</td>
                        <td>{{ $cliente->nombre }}</td>
                        <td>{{ $cliente->apellido }}</td>
                        <td>{{ $cliente->telefono }}</td>
                        <td>{{ $cliente->email ?? 'N/A' }}</td>
                        <td>{{ $cliente->vehiculos->count() }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('clientes.show', $cliente->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('clientes.edit', $cliente->id) }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $cliente->id }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>

                            <!-- Modal de eliminación -->
                            <div class="modal fade" id="deleteModal{{ $cliente->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $cliente->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteModalLabel{{ $cliente->id }}">Confirmar eliminación</h5>
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
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">No hay clientes registrados</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection