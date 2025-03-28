@extends('layouts.app')

@section('title', 'Historial de Vehículo - Sistema de Lavado de Vehículos')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Historial de Vehículo</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('vehiculos.index') }}" class="btn btn-sm btn-outline-secondary me-2">
            <i class="fas fa-arrow-left me-1"></i> Volver
        </a>
        <a href="{{ route('lavados.create') }}" class="btn btn-sm btn-primary">
            <i class="fas fa-plus me-1"></i> Nuevo Lavado
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">Información del Vehículo</h5>
            </div>
            <div class="card-body">
                <h3 class="mb-3">{{ $vehiculo->marca }} {{ $vehiculo->modelo }}</h3>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Placa
                        <span class="badge bg-primary rounded-pill">{{ $vehiculo->placa }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Color
                        <span>{{ $vehiculo->color }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Tipo
                        <span>{{ ucfirst($vehiculo->tipo) }}</span>
                    </li>
                    @if($vehiculo->año)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Año
                        <span>{{ $vehiculo->año }}</span>
                    </li>
                    @endif
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Registrado
                        <span>{{ $vehiculo->created_at->format('d/m/Y') }}</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">Información del Cliente</h5>
            </div>
            <div class="card-body">
                <h4>{{ $vehiculo->cliente->nombre }} {{ $vehiculo->cliente->apellido }}</h4>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Teléfono
                        <span>{{ $vehiculo->cliente->telefono }}</span>
                    </li>
                    @if($vehiculo->cliente->email)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Email
                        <span>{{ $vehiculo->cliente->email }}</span>
                    </li>
                    @endif
                </ul>
                <div class="mt-3">
                    <a href="{{ route('clientes.show', $vehiculo->cliente->id) }}" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-user me-1"></i> Ver cliente
                    </a>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Estadísticas</h5>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Total de visitas
                        <span class="badge bg-primary rounded-pill">{{ $lavados->count() }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Última visita
                        <span>{{ $lavados->count() > 0 ? $lavados->sortByDesc('created_at')->first()->created_at->format('d/m/Y') : 'N/A' }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Servicio más solicitado
                        @php
                        $servicios = $lavados->groupBy('servicio_id')->map->count();
                        $masUsado = $servicios->count() > 0 ? $servicios->sortDesc()->keys()->first() : null;
                        $nombreServicio = $masUsado ? App\Models\Servicio::find($masUsado)->nombre : 'N/A';
                        @endphp
                        <span>{{ $nombreServicio }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Total gastado
                        <span class="text-success">${{ number_format($lavados->sum('costo_total'), 2) }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Historial de Lavados</h5>
            </div>
            <div class="card-body">
                @if($lavados->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Servicio</th>
                                <th>Empleado</th>
                                <th>Estado</th>
                                <th>Duración</th>
                                <th>Costo</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($lavados->sortByDesc('created_at') as $lavado)
                            <tr>
                                <td>{{ $lavado->created_at->format('d/m/Y') }}</td>
                                <td>{{ $lavado->servicio->nombre }}</td>
                                <td>{{ $lavado->empleadoAsignado ? $lavado->empleadoAsignado->nombre . ' ' . $lavado->empleadoAsignado->apellido : 'Sin asignar' }}</td>
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
                                    @if($lavado->hora_salida)
                                    {{ $lavado->hora_entrada->diffInMinutes($lavado->hora_salida) }} min
                                    @else
                                    En curso
                                    @endif
                                </td>
                                <td>${{ number_format($lavado->costo_total, 2) }}</td>
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
                    <i class="fas fa-info-circle me-2"></i> Este vehículo aún no tiene lavados registrados.
                </div>
                <div class="text-center">
                    <a href="{{ route('lavados.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i> Registrar Primer Lavado
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection