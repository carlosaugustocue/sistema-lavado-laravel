@extends('layouts.app')

@section('title', 'Detalle de Servicio - Sistema de Lavado de Vehículos')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Detalle de Servicio</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="{{ route('servicios.edit', $servicio->id) }}" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-edit me-1"></i> Editar
            </a>
            <a href="{{ route('servicios.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Volver
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-5">
        <div class="card mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">Información del Servicio</h5>
            </div>
            <div class="card-body">
                <h3 class="mb-3">{{ $servicio->nombre }}</h3>
                <p class="mb-3">{{ $servicio->descripcion }}</p>
                
                <ul class="list-group list-group-flush mb-3">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Precio
                        <span class="badge bg-primary rounded-pill">${{ number_format($servicio->precio, 2) }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Tiempo Estimado
                        <span class="badge bg-info rounded-pill">{{ $servicio->tiempo_estimado }} minutos</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Estado
                        @if($servicio->activo)
                        <span class="badge bg-success">Activo</span>
                        @else
                        <span class="badge bg-danger">Inactivo</span>
                        @endif
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Lavados realizados
                        <span class="badge bg-secondary">{{ $servicio->lavados()->count() }}</span>
                    </li>
                </ul>
            </div>
            <div class="card-footer bg-white d-grid gap-2">
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                    <i class="fas fa-trash me-1"></i> Eliminar Servicio
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
                                ¿Está seguro de que desea eliminar el servicio {{ $servicio->nombre }}?
                                @if($servicio->lavados()->count() > 0)
                                <div class="alert alert-warning mt-2">
                                    <i class="fas fa-exclamation-triangle me-1"></i> Este servicio tiene {{ $servicio->lavados()->count() }} lavados asociados. Si lo elimina, podría afectar los registros relacionados.
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
            </div>
        </div>
    </div>
    
    <div class="col-md-7">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Estadísticas del Servicio</h5>
            </div>
            <div class="card-body">
                @php
                $totalLavados = $servicio->lavados()->count();
                $tiempoPromedio = $servicio->lavados()
                    ->whereNotNull('hora_salida')
                    ->selectRaw('AVG(TIMESTAMPDIFF(MINUTE, hora_entrada, hora_salida)) as promedio')
                    ->first();
                $ingresos = $servicio->lavados()
                    ->whereIn('estado', ['completado', 'entregado'])
                    ->sum('costo_total');
                $ultimoMes = $servicio->lavados()
                    ->where('created_at', '>=', now()->subMonth())
                    ->count();
                @endphp
                
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card bg-light">
                            <div class="card-body text-center">
                                <h5 class="card-title">Tiempo Promedio Real</h5>
                                <h3 class="mb-0">
                                    @if($tiempoPromedio && $tiempoPromedio->promedio)
                                    {{ round($tiempoPromedio->promedio) }} minutos
                                    @else
                                    N/A
                                    @endif
                                </h3>
                                
                                @if($tiempoPromedio && $tiempoPromedio->promedio)
                                <div class="mt-2">
                                    @php
                                    $diferencia = round($tiempoPromedio->promedio) - $servicio->tiempo_estimado;
                                    @endphp
                                    
                                    @if($diferencia <= 0)
                                    <span class="text-success">
                                        <i class="fas fa-check-circle me-1"></i> {{ abs($diferencia) }} minutos menos que lo estimado
                                    </span>
                                    @else
                                    <span class="text-danger">
                                        <i class="fas fa-exclamation-circle me-1"></i> {{ $diferencia }} minutos más que lo estimado
                                    </span>
                                    @endif
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card bg-light">
                            <div class="card-body text-center">
                                <h5 class="card-title">Ingresos Generados</h5>
                                <h3 class="mb-0">${{ number_format($ingresos, 2) }}</h3>
                                <p class="text-muted">{{ $totalLavados }} servicios realizados</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <h5 class="mb-3">Últimos Lavados con este Servicio</h5>
                @php
                $ultimosLavados = $servicio->lavados()->with('vehiculo')->latest()->take(5)->get();
                @endphp
                
                @if($ultimosLavados->count() > 0)
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Vehículo</th>
                                <th>Fecha</th>
                                <th>Estado</th>
                                <th>Duración</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ultimosLavados as $lavado)
                            <tr>
                                <td>{{ $lavado->id }}</td>
                                <td>{{ $lavado->vehiculo->placa }}</td>
                                <td>{{ $lavado->created_at->format('d/m/Y') }}</td>
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
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i> No hay lavados registrados para este servicio.
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection