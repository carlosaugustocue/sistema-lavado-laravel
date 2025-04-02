@extends('layouts.app')

@section('title', 'Editar Lavado - Sistema de Lavado de Vehículos')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Editar Lavado #{{ $lavado->id }}</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('lavados.show', $lavado->id) }}" class="btn btn-sm btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Volver
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Datos del lavado</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('lavados.update', $lavado->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="vehiculo_id" class="form-label">Vehículo <span class="text-danger">*</span></label>
                            <select id="vehiculo_id" name="vehiculo_id" class="form-select @error('vehiculo_id') is-invalid @enderror" required>
                                <option value="">Seleccione un vehículo</option>
                                @foreach($vehiculos as $vehiculo)
                                <option value="{{ $vehiculo->id }}" {{ old('vehiculo_id', $lavado->vehiculo_id) == $vehiculo->id ? 'selected' : '' }}>
                                    {{ $vehiculo->placa }} - {{ $vehiculo->marca }} {{ $vehiculo->modelo }}
                                </option>
                                @endforeach
                            </select>
                            @error('vehiculo_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="empleado_id" class="form-label">Empleado que recibe <span class="text-danger">*</span></label>
                            <select id="empleado_id" name="empleado_id" class="form-select @error('empleado_id') is-invalid @enderror" required>
                                <option value="">Seleccione un empleado</option>
                                @foreach($empleados as $empleado)
                                <option value="{{ $empleado->id }}" {{ old('empleado_id', $lavado->empleado_id) == $empleado->id ? 'selected' : '' }}>
                                    {{ $empleado->nombre }} {{ $empleado->apellido }}
                                </option>
                                @endforeach
                            </select>
                            @error('empleado_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="servicio_id" class="form-label">Servicio <span class="text-danger">*</span></label>
                            <select id="servicio_id" name="servicio_id" class="form-select @error('servicio_id') is-invalid @enderror" required>
                                <option value="">Seleccione un servicio</option>
                                @foreach($servicios as $servicio)
                                <option value="{{ $servicio->id }}" {{ old('servicio_id', $lavado->servicio_id) == $servicio->id ? 'selected' : '' }}>
                                    {{ $servicio->nombre }} - ${{ number_format($servicio->precio, 2) }}
                                </option>
                                @endforeach
                            </select>
                            @error('servicio_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="empleado_asignado_id" class="form-label">Empleado asignado</label>
                            <select id="empleado_asignado_id" name="empleado_asignado_id" class="form-select @error('empleado_asignado_id') is-invalid @enderror">
                                <option value="">Asignar después</option>
                                @foreach($empleados as $empleado)
                                <option value="{{ $empleado->id }}" {{ old('empleado_asignado_id', $lavado->empleado_asignado_id) == $empleado->id ? 'selected' : '' }}>
                                    {{ $empleado->nombre }} {{ $empleado->apellido }}
                                </option>
                                @endforeach
                            </select>
                            @error('empleado_asignado_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="estado" class="form-label">Estado <span class="text-danger">*</span></label>
                            <select id="estado" name="estado" class="form-select @error('estado') is-invalid @enderror" required>
                                <option value="pendiente" {{ old('estado', $lavado->estado) == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                <option value="en_proceso" {{ old('estado', $lavado->estado) == 'en_proceso' ? 'selected' : '' }}>En Proceso</option>
                                <option value="completado" {{ old('estado', $lavado->estado) == 'completado' ? 'selected' : '' }}>Completado</option>
                                <option value="entregado" {{ old('estado', $lavado->estado) == 'entregado' ? 'selected' : '' }}>Entregado</option>
                            </select>
                            @error('estado')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="observaciones" class="form-label">Observaciones</label>
                        <textarea id="observaciones" name="observaciones" class="form-control @error('observaciones') is-invalid @enderror" rows="3">{{ old('observaciones', $lavado->observaciones) }}</textarea>
                        @error('observaciones')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Actualizar Lavado
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">
                    <i class="fas fa-info-circle me-1"></i> Información
                </h5>
            </div>
            <div class="card-body">
                <p>Complete todos los campos marcados con <span class="text-danger">*</span></p>
                <p>Si cambia el servicio, el precio se actualizará automáticamente.</p>
                <p>Si cambia el estado a "Completado", la hora de salida se registrará automáticamente.</p>
                
                <div class="alert alert-info mt-3">
                    <p class="mb-1"><strong>Fecha de entrada:</strong> {{ $lavado->hora_entrada->format('d/m/Y H:i') }}</p>
                    @if($lavado->hora_salida)
                    <p class="mb-1"><strong>Fecha de salida:</strong> {{ $lavado->hora_salida->format('d/m/Y H:i') }}</p>
                    <p class="mb-0"><strong>Duración:</strong> {{ $lavado->hora_entrada->diffInMinutes($lavado->hora_salida) }} minutos</p>
                    @endif
                </div>
                
                <div class="alert alert-warning mt-3">
                    <p class="mb-0">Al cambiar el estado del lavado, se actualizarán automáticamente los registros relacionados.</p>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Insumos Utilizados</h5>
            </div>
            <div class="card-body">
                @if($lavado->usoInsumos()->count() > 0)
                <ul class="list-group list-group-flush">
                    @foreach($lavado->usoInsumos as $uso)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{ $uso->insumo->nombre }}
                        <span class="badge bg-primary rounded-pill">{{ $uso->cantidad }} {{ $uso->insumo->unidad_medida }}</span>
                    </li>
                    @endforeach
                </ul>
                <div class="d-grid gap-2 mt-3">
                    <a href="{{ route('lavados.show', $lavado->id) }}" class="btn btn-sm btn-outline-primary">
                        Administrar Insumos
                    </a>
                </div>
                @else
                <p class="text-center mb-0">No se han registrado insumos utilizados</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection