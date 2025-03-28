@extends('layouts.app')

@section('title', 'Empleados - Sistema de Lavado de Vehículos')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Listado de Empleados</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('empleados.create') }}" class="btn btn-sm btn-primary">
            <i class="fas fa-plus me-1"></i> Nuevo Empleado
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header bg-white">
        <h5 class="mb-0">Todos los empleados registrados</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Documento</th>
                        <th>Teléfono</th>
                        <th>Cargo</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($empleados as $empleado)
                    <tr>
                        <td>{{ $empleado->id }}</td>
                        <td>{{ $empleado->nombre }}</td>
                        <td>{{ $empleado->apellido }}</td>
                        <td>{{ $empleado->documento }}</td>
                        <td>{{ $empleado->telefono }}</td>
                        <td>{{ $empleado->cargo }}</td>
                        <td>
                            @if($empleado->activo)
                            <span class="badge bg-success">Activo</span>
                            @else
                            <span class="badge bg-danger">Inactivo</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('empleados.show', $empleado->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('empleados.edit', $empleado->id) }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $empleado->id }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>

                            <!-- Modal de eliminación -->
                            <div class="modal fade" id="deleteModal{{ $empleado->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $empleado->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteModalLabel{{ $empleado->id }}">Confirmar eliminación</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            ¿Está seguro de que desea eliminar al empleado {{ $empleado->nombre }} {{ $empleado->apellido }}?
                                            @if($empleado->lavadosRecibidos()->count() > 0 || $empleado->lavadosAsignados()->count() > 0)
                                            <div class="alert alert-warning mt-2">
                                                <i class="fas fa-exclamation-triangle me-1"></i> Este empleado tiene lavados asociados. Si lo elimina, podría afectar los registros relacionados.
                                            </div>
                                            @endif
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                            <form action="{{ route('empleados.destroy', $empleado->id) }}" method="POST">
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
                        <td colspan="8" class="text-center">No hay empleados registrados</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection