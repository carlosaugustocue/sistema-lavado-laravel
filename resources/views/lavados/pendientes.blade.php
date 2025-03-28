@extends('layouts.app')

@section('title', 'Lavados Pendientes - Sistema de Lavado de Vehículos')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Lavados Pendientes</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('lavados.create') }}" class="btn btn-sm btn-primary">
            <i class="fas fa-plus me-1"></i> Nuevo Lavado
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header bg-white">
        <h5 class="mb-0">Vehículos pendientes de entrega</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Placa</th>
                        <th>Cliente</th>
                        <th>Servicio</th>
                        <th>Estado</th>
                        <th>Entrada</th>
                        <th>Empleado Asignado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pendientes as $lavado)
                    <tr>
                        <td>{{ $lavado->vehiculo->placa }}</td>
                        <td>{{ $lavado->vehiculo->cliente->nombre }} {{ $lavado->vehiculo->cliente->apellido }}</td>
                        <td>{{ $lavado->servicio->nombre }}</td>
                        <td>
                            @if($lavado->estado == 'pendiente')
                            <span class="badge bg-warning">Pendiente</span>
                            @elseif($lavado->estado == 'en_proceso')
                            <span class="badge bg-info">En Proceso</span>
                            @endif
                        </td>
                        <td>{{ $lavado->hora_entrada->format('d/m/Y H:i') }}</td>
                        <td>{{ $lavado->empleado_asignado_id ? $lavado->empleadoAsignado->nombre . ' ' . $lavado->empleadoAsignado->apellido : 'Sin asignar' }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('lavados.show', $lavado->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye"></i>
                                </a>
                                
                                @if($lavado->estado == 'pendiente')
                                <form action="{{ route('lavados.cambiar-estado', $lavado->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="estado" value="en_proceso">
                                    <button type="submit" class="btn btn-sm btn-outline-info" title="Iniciar Proceso">
                                        <i class="fas fa-play"></i>
                                    </button>
                                </form>
                                @elseif($lavado->estado == 'en_proceso')
                                <form action="{{ route('lavados.cambiar-estado', $lavado->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="estado" value="completado">
                                    <button type="submit" class="btn btn-sm btn-outline-success" title="Marcar como Completado">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">No hay lavados pendientes</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection