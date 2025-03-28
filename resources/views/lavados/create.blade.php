@extends('layouts.app')

@section('title', 'Nuevo Lavado - Sistema de Lavado de Vehículos')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Registrar Nuevo Lavado</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('lavados.index') }}" class="btn btn-sm btn-outline-secondary">
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
                <form action="{{ route('lavados.store') }}" method="POST">
                    @csrf
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="vehiculo_id" class="form-label">Vehículo <span class="text-danger">*</span></label>
                            <select id="vehiculo_id" name="vehiculo_id" class="form-select @error('vehiculo_id') is-invalid @enderror" required>
                                <option value="">Seleccione un vehículo</option>
                                @foreach($vehiculos as $vehiculo)
                                <option value="{{ $vehiculo->id }}" {{ old('vehiculo_id') == $vehiculo->id ? 'selected' : '' }}>
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
                                <option value="{{ $empleado->id }}" {{ old('empleado_id') == $empleado->id ? 'selected' : '' }}>
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
                                <option value="{{ $servicio->id }}" {{ old('servicio_id') == $servicio->id ? 'selected' : '' }}>
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
                                <option value="{{ $empleado->id }}" {{ old('empleado_asignado_id') == $empleado->id ? 'selected' : '' }}>
                                    {{ $empleado->nombre }} {{ $empleado->apellido }}
                                </option>
                                @endforeach
                            </select>
                            @error('empleado_asignado_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="observaciones" class="form-label">Observaciones</label>
                        <textarea id="observaciones" name="observaciones" class="form-control @error('observaciones') is-invalid @enderror" rows="3">{{ old('observaciones') }}</textarea>
                        @error('observaciones')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Registrar Lavado
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
                <p>El registro de lavado permite:</p>
                <ul>
                    <li>Iniciar un nuevo servicio de lavado</li>
                    <li>Asignar un empleado para realizar el lavado</li>
                    <li>Establecer el tipo de servicio a aplicar</li>
                </ul>
                <p>Podrá registrar los insumos utilizados después de crear el registro del lavado.</p>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">
                    <i class="fas fa-search me-1"></i> Buscar vehículo
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('vehiculos.buscar') }}" method="GET">
                    <div class="mb-3">
                        <label for="placa" class="form-label">Placa del vehículo</label>
                        <input type="text" id="placa" name="placa" class="form-control" placeholder="Ingrese la placa" required>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-outline-primary">
                            <i class="fas fa-search me-1"></i> Buscar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection