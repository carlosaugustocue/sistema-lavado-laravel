@extends('layouts.app')

@section('title', 'Editar Turno - Sistema de Lavado de Vehículos')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Editar Turno</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('turnos.index') }}" class="btn btn-sm btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Volver
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Datos del turno</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('turnos.update', $turno->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="empleado_id" class="form-label">Empleado <span class="text-danger">*</span></label>
                        <select id="empleado_id" name="empleado_id" class="form-select @error('empleado_id') is-invalid @enderror" required>
                            <option value="">Seleccione un empleado</option>
                            @foreach($empleados as $empleado)
                            <option value="{{ $empleado->id }}" {{ old('empleado_id', $turno->empleado_id) == $empleado->id ? 'selected' : '' }}>
                                {{ $empleado->nombre }} {{ $empleado->apellido }} ({{ $empleado->cargo }})
                            </option>
                            @endforeach
                        </select>
                        @error('empleado_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="fecha" class="form-label">Fecha <span class="text-danger">*</span></label>
                        <input type="date" id="fecha" name="fecha" class="form-control @error('fecha') is-invalid @enderror" value="{{ old('fecha', $turno->fecha->format('Y-m-d')) }}" required>
                        @error('fecha')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="hora_inicio" class="form-label">Hora de inicio <span class="text-danger">*</span></label>
                            <input type="time" id="hora_inicio" name="hora_inicio" class="form-control @error('hora_inicio') is-invalid @enderror" value="{{ old('hora_inicio', $turno->hora_inicio->format('H:i')) }}" required>
                            @error('hora_inicio')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="hora_fin" class="form-label">Hora de fin <span class="text-danger">*</span></label>
                            <input type="time" id="hora_fin" name="hora_fin" class="form-control @error('hora_fin') is-invalid @enderror" value="{{ old('hora_fin', $turno->hora_fin->format('H:i')) }}" required>
                            @error('hora_fin')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Actualizar Turno
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">
                    <i class="fas fa-info-circle me-1"></i> Información
                </h5>
            </div>
            <div class="card-body">
                <p>Complete todos los campos marcados con <span class="text-danger">*</span></p>
                <p>Solo puede asignar turnos a empleados activos.</p>
                <p>Asegúrese de que la hora de fin sea posterior a la hora de inicio.</p>
                <p>Al cambiar el empleado, esta modificación afectará la planificación de trabajo.</p>
            </div>
        </div>
    </div>
</div>
@endsection