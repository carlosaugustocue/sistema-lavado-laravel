@extends('layouts.app')

@section('title', 'Detalle de Empleado - Sistema de Lavado de Vehículos')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Detalle de Empleado</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="{{ route('empleados.edit', $empleado->id) }}" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-edit me-1"></i> Editar
            </a>
            <a href="{{ route('empleados.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Volver
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">Información del Empleado</h5>
            </div>
            <div class="card-body">
                <h3 class="mb-3">{{ $empleado->nombre }} {{ $empleado->apellido }}</h3>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Documento
                        <span class="badge bg-primary rounded-pill">{{ $empleado->documento }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Teléfono
                        <span>{{ $empleado->telefono }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Cargo
                        <span>{{ $empleado->cargo }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Estado
                        @if($empleado->activo)
                        <span class="badge bg-success">Activo</span>
                        @else
                        <span class="badge bg-danger">Inactivo</span>
                        @endif
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Fecha de registro
                        <span>{{ $empleado->created_at->format('d/m/Y') }}</span>
                    </li>
                </ul>
            </div>
            <div class="card-footer bg-white d-grid gap-2">
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                    <i class="fas fa-trash me-1"></i> Eliminar Empleado
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
                                ¿Está seguro de que desea eliminar al empleado {{ $empleado->nombre }} {{ $empleado->apellido }}?
                                @if($lavadosRecibidos->count() > 0 || $lavadosAsignados->count() > 0)
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
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header bg-white">
                <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="lavados-recibidos-tab" data-bs-toggle="tab" data-bs-target="#lavados-recibidos" type="button" role="tab" aria-controls="lavados-recibidos" aria-selected="true">Lavados Recibidos</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="lavados-asignados-tab" data-bs-toggle="tab" data-bs-target="#lavados-asignados" type="button" role="tab" aria-controls="lavados-asignados" aria-selected="false">Lavados Asignados</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="turnos-tab" data-bs-toggle="tab" data-bs-target="#turnos" type="button" role="tab" aria-controls="turnos" aria-selected="false">Turnos</button>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="lavados-recibidos" role="tabpanel" aria-labelledby="lavados-recibidos-tab">
                        @if($lavadosRecibidos->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Vehículo</th>
                                        <th>Servicio</th>
                                        <th>Fecha</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($lavadosRecibidos as $lavado)
                                    <tr>
                                        <td>{{ $lavado->id }}</td>
                                        <td>{{ $lavado->vehiculo->placa }}</td>
                                        <td>{{ $lavado->servicio->nombre }}</td>
                                        <td>{{ $lavado->created_at->format('d/m/Y H:i') }}</td>
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
                                        <td>
                                            <a href="{{ route('lavados.show', $lavado->id) }}" class="btn btn-sm btn-outline-primary">
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
                            <i class="fas fa-info-circle me-2"></i> Este empleado no ha recibido lavados.
                        </div>
                        @endif
                    </div>
                    <div class="tab-pane fade" id="lavados-asignados" role="tabpanel" aria-labelledby="lavados-asignados-tab">
                        @if($lavadosAsignados->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Vehículo</th>
                                        <th>Servicio</th>
                                        <th>Fecha</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($lavadosAsignados as $lavado)
                                    <tr>
                                        <td>{{ $lavado->id }}</td>
                                        <td>{{ $lavado->vehiculo->placa }}</td>
                                        <td>{{ $lavado->servicio->nombre }}</td>
                                        <td>{{ $lavado->created_at->format('d/m/Y H:i') }}</td>
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
                                        <td>
                                            <a href="{{ route('lavados.show', $lavado->id) }}" class="btn btn-sm btn-outline-primary">
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
                            <i class="fas fa-info-circle me-2"></i> Este empleado no tiene lavados asignados.
                        </div>
                        @endif
                    </div>
                    <div class="tab-pane fade" id="turnos" role="tabpanel" aria-labelledby="turnos-tab">
                        @if($turnos->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Fecha</th>
                                        <th>Hora Inicio</th>
                                        <th>Hora Fin</th>
                                        <th>Duración</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($turnos as $turno)
                                    <tr>
                                        <td>{{ $turno->id }}</td>
                                        <td>{{ $turno->fecha->format('d/m/Y') }}</td>
                                        <td>{{ $turno->hora_inicio->format('H:i') }}</td>
                                        <td>{{ $turno->hora_fin->format('H:i') }}</td>
                                        <td>{{ $turno->hora_inicio->diffInHours($turno->hora_fin) }} horas</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i> Este empleado no tiene turnos registrados.
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection