@extends('layouts.app')

@section('title', 'Detalle de Lavado - Sistema de Lavado de Vehículos')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Detalle de Lavado #{{ $lavado->id }}</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="{{ route('lavados.edit', $lavado->id) }}" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-edit me-1"></i> Editar
            </a>
            <a href="{{ route('lavados.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Volver
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">Información del Lavado</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p class="mb-1 text-muted">Vehículo:</p>
                        <p class="mb-0"><strong>{{ $lavado->vehiculo->marca }} {{ $lavado->vehiculo->modelo }}</strong></p>
                        <p class="mb-0"><strong>Placa:</strong> {{ $lavado->vehiculo->placa }}</p>
                        <p class="mb-0"><strong>Color:</strong> {{ $lavado->vehiculo->color }}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-1 text-muted">Cliente:</p>
                        <p class="mb-0"><strong>{{ $lavado->vehiculo->cliente->nombre }} {{ $lavado->vehiculo->cliente->apellido }}</strong></p>
                        <p class="mb-0"><strong>Teléfono:</strong> {{ $lavado->vehiculo->cliente->telefono }}</p>
                        @if($lavado->vehiculo->cliente->email)
                        <p class="mb-0"><strong>Email:</strong> {{ $lavado->vehiculo->cliente->email }}</p>
                        @endif
                    </div>
                </div>
                <hr>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p class="mb-1 text-muted">Servicio:</p>
                        <p class="mb-0"><strong>{{ $lavado->servicio->nombre }}</strong></p>
                        <p class="mb-0"><strong>Precio:</strong> ${{ number_format($lavado->costo_total, 2) }}</p>
                        <p class="mb-0"><strong>Tiempo estimado:</strong> {{ $lavado->servicio->tiempo_estimado }} minutos</p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-1 text-muted">Estado:</p>
                        <p class="mb-0">
                            @if($lavado->estado == 'pendiente')
                            <span class="badge bg-warning">Pendiente</span>
                            @elseif($lavado->estado == 'en_proceso')
                            <span class="badge bg-info">En Proceso</span>
                            @elseif($lavado->estado == 'completado')
                            <span class="badge bg-success">Completado</span>
                            @elseif($lavado->estado == 'entregado')
                            <span class="badge bg-secondary">Entregado</span>
                            @endif
                        </p>
                        <p class="mb-0"><strong>Hora entrada:</strong> {{ $lavado->hora_entrada->format('d/m/Y H:i') }}</p>
                        @if($lavado->hora_salida)
                        <p class="mb-0"><strong>Hora salida:</strong> {{ $lavado->hora_salida->format('d/m/Y H:i') }}</p>
                        @endif
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <p class="mb-1 text-muted">Empleado que recibe:</p>
                        <p class="mb-0"><strong>{{ $lavado->empleadoRecibe->nombre }} {{ $lavado->empleadoRecibe->apellido }}</strong></p>
                        <p class="mb-0"><strong>Cargo:</strong> {{ $lavado->empleadoRecibe->cargo }}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-1 text-muted">Empleado asignado:</p>
                        @if($lavado->empleado_asignado_id)
                        <p class="mb-0"><strong>{{ $lavado->empleadoAsignado->nombre }} {{ $lavado->empleadoAsignado->apellido }}</strong></p>
                        <p class="mb-0"><strong>Cargo:</strong> {{ $lavado->empleadoAsignado->cargo }}</p>
                        @else
                        <p class="mb-0"><em>No asignado</em></p>
                        @endif
                    </div>
                </div>
                
                @if($lavado->observaciones)
                <hr>
                <div class="row">
                    <div class="col-12">
                        <p class="mb-1 text-muted">Observaciones:</p>
                        <p class="mb-0">{{ $lavado->observaciones }}</p>
                    </div>
                </div>
                @endif
            </div>
            <div class="card-footer bg-white">
                <div class="row">
                    <div class="col-12">
                        <div class="d-flex justify-content-between">
                            @if($lavado->estado == 'pendiente')
                            <form action="{{ route('lavados.cambiar-estado', $lavado->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="estado" value="en_proceso">
                                <button type="submit" class="btn btn-info">
                                    <i class="fas fa-play me-1"></i> Iniciar Proceso
                                </button>
                            </form>
                            @elseif($lavado->estado == 'en_proceso')
                            <form action="{{ route('lavados.cambiar-estado', $lavado->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="estado" value="completado">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-check me-1"></i> Marcar como Completado
                                </button>
                            </form>
                            @elseif($lavado->estado == 'completado')
                            <form action="{{ route('lavados.cambiar-estado', $lavado->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="estado" value="entregado">
                                <button type="submit" class="btn btn-secondary">
                                    <i class="fas fa-car me-1"></i> Marcar como Entregado
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">Insumos Utilizados</h5>
            </div>
            <div class="card-body">
                @if($usoInsumos->count() > 0)
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Insumo</th>
                                <th>Cantidad</th>
                                <th>Unidad</th>
                                <th>Costo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($usoInsumos as $uso)
                            <tr>
                                <td>{{ $uso->insumo->nombre }}</td>
                                <td>{{ $uso->cantidad }}</td>
                                <td>{{ $uso->insumo->unidad_medida }}</td>
                                <td>${{ number_format($uso->cantidad * $uso->insumo->costo, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <p class="text-center">No se han registrado insumos utilizados</p>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <!-- RF003 - Registro de Insumos Utilizados -->
        <div class="card mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">Registrar Insumo Utilizado</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('lavados.registrar-insumo', $lavado->id) }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="insumo_id" class="form-label">Insumo</label>
                        <select id="insumo_id" name="insumo_id" class="form-select @error('insumo_id') is-invalid @enderror" required>
                            <option value="">Seleccionar insumo</option>
                            @foreach($insumos as $insumo)
                            <option value="{{ $insumo->id }}">
                                {{ $insumo->nombre }} ({{ $insumo->stock_actual }} {{ $insumo->unidad_medida }} disponibles)
                            </option>
                            @endforeach
                        </select>
                        @error('insumo_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="cantidad" class="form-label">Cantidad</label>
                        <input type="number" id="cantidad" name="cantidad" class="form-control @error('cantidad') is-invalid @enderror" min="0.01" step="0.01" required>
                        @error('cantidad')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-plus me-1"></i> Registrar Insumo
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Historial del Vehículo</h5>
            </div>
            <div class="card-body">
                @php
                $historial = $lavado->vehiculo->lavados()
                    ->where('id', '!=', $lavado->id)
                    ->orderBy('created_at', 'desc')
                    ->take(5)
                    ->get();
                @endphp

                @if($historial->count() > 0)
                <div class="list-group">
                    @foreach($historial as $item)
                    <a href="{{ route('lavados.show', $item->id) }}" class="list-group-item list-group-item-action">
                        <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-1">{{ $item->servicio->nombre }}</h6>
                            <small>{{ $item->created_at->format('d/m/Y') }}</small>
                        </div>
                        <p class="mb-1">${{ number_format($item->costo_total, 2) }}</p>
                        <small>
                            @if($item->estado == 'pendiente')
                            <span class="badge bg-warning">Pendiente</span>
                            @elseif($item->estado == 'en_proceso')
                            <span class="badge bg-info">En Proceso</span>
                            @elseif($item->estado == 'completado')
                            <span class="badge bg-success">Completado</span>
                            @elseif($item->estado == 'entregado')
                            <span class="badge bg-secondary">Entregado</span>
                            @endif
                        </small>
                    </a>
                    @endforeach
                </div>
                <div class="mt-2 text-center">
                    <a href="{{ route('vehiculos.show', $lavado->vehiculo->id) }}" class="btn btn-sm btn-outline-primary">
                        Ver historial completo
                    </a>
                </div>
                @else
                <p class="text-center">No hay historial previo para este vehículo</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection