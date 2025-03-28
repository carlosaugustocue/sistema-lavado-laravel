@extends('layouts.app')

@section('title', 'Servicios - Sistema de Lavado de Vehículos')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Listado de Servicios</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('servicios.create') }}" class="btn btn-sm btn-primary">
            <i class="fas fa-plus me-1"></i> Nuevo Servicio
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header bg-white">
        <h5 class="mb-0">Todos los servicios disponibles</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Precio</th>
                        <th>Tiempo Estimado</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($servicios as $servicio)
                    <tr>
                        <td>{{ $servicio->id }}</td>
                        <td>{{ $servicio->nombre }}</td>
                        <td>{{ Str::limit($servicio->descripcion, 50) }}</td>
                        <td>${{ number_format($servicio->precio, 2) }}</td>
                        <td>{{ $servicio->tiempo_estimado }} minutos</td>
                        <td>
                            @if($servicio->activo)
                            <span class="badge bg-success">Activo</span>
                            @else
                            <span class="badge bg-danger">Inactivo</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('servicios.show', $servicio->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('servicios.edit', $servicio->id) }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $servicio->id }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>

                            <!-- Modal de eliminación -->
                            <div class="modal fade" id="deleteModal{{ $servicio->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $servicio->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteModalLabel{{ $servicio->id }}">Confirmar eliminación</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            ¿Está seguro de que desea eliminar el servicio {{ $servicio->nombre }}?
                                            @if($servicio->lavados()->count() > 0)
                                            <div class="alert alert-warning mt-2">
                                                <i class="fas fa-exclamation-triangle me-1"></i> Este servicio tiene lavados asociados. Si lo elimina, podría afectar los registros relacionados.
                                            </div>
                                            @endif
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                            <form action="{{ route('servicios.destroy', $servicio->id) }}" method="POST">
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
                        <td colspan="7" class="text-center">No hay servicios registrados</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection