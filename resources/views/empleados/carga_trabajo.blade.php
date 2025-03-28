@extends('layouts.app')

@section('title', 'Carga de Trabajo por Empleado - Sistema de Lavado de Vehículos')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Carga de Trabajo por Empleado</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('empleados.index') }}" class="btn btn-sm btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Volver a Empleados
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header bg-white">
        <h5 class="mb-0">
            <i class="fas fa-tasks me-1"></i> Distribución actual de carga de trabajo
        </h5>
    </div>
    <div class="card-body">
        <div class="row">
            @foreach($cargaTrabajo as $item)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">{{ $item['empleado']->nombre }} {{ $item['empleado']->apellido }}</h5>
                        <small class="text-muted">{{ $item['empleado']->cargo }}</small>
                    </div>
                    <div class="card-body">
                        <div class="row text-center mb-3">
                            <div class="col-6">
                                <h2 class="mb-0 text-primary">{{ $item['pendientes'] }}</h2>
                                <small class="text-muted">Pendientes</small>
                            </div>
                            <div class="col-6">
                                <h2 class="mb-0 text-success">{{ $item['completados_hoy'] }}</h2>
                                <small class="text-muted">Completados hoy</small>
                            </div>
                        </div>
                        
                        @if($item['pendientes'] > 0)
                        <div class="mb-2">
                            <span class="d-block mb-1">Nivel de ocupación</span>
                            @php
                            $ocupacion = min($item['pendientes'] * 20, 100); // Cada lavado ocupa un 20%, max 100%
                            $clase = 'bg-info';
                            if($ocupacion > 60) $clase = 'bg-warning';
                            if($ocupacion > 80) $clase = 'bg-danger';
                            @endphp
                            <div class="progress" style="height: 20px;">
                                <div class="progress-bar {{ $clase }}" role="progressbar" style="width: {{ $ocupacion }}%">
                                    {{ $ocupacion }}%
                                </div>
                            </div>
                        </div>
                        @endif
                        
                        <div class="d-grid gap-2">
                            <a href="{{ route('empleados.show', $item['empleado']->id) }}" class="btn btn-outline-primary">
                                <i class="fas fa-eye me-1"></i> Ver Detalle
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection