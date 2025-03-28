@extends('layouts.app')

@section('title', 'Nuevo Empleado - Sistema de Lavado de Vehículos')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Registrar Nuevo Empleado</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('empleados.index') }}" class="btn btn-sm btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Volver
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Datos del empleado</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('empleados.store') }}" method="POST">
                    @csrf
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="nombre" class="form-label">Nombre <span class="text-danger">*</span></label>
                            <input type="text" id="nombre" name="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre') }}" required>
                            @error('nombre')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="apellido" class="form-label">Apellido <span class="text-danger">*</span></label>
                            <input type="text" id="apellido" name="apellido" class="form-control @error('apellido') is-invalid @enderror" value="{{ old('apellido') }}" required>
                            @error('apellido')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="documento" class="form-label">Documento <span class="text-danger">*</span></label>
                            <input type="text" id="documento" name="documento" class="form-control @error('documento') is-invalid @enderror" value="{{ old('documento') }}" required>
                            @error('documento')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="telefono" class="form-label">Teléfono <span class="text-danger">*</span></label>
                            <input type="text" id="telefono" name="telefono" class="form-control @error('telefono') is-invalid @enderror" value="{{ old('telefono') }}" required>
                            @error('telefono')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="cargo" class="form-label">Cargo <span class="text-danger">*</span></label>
                            <input type="text" id="cargo" name="cargo" class="form-control @error('cargo') is-invalid @enderror" value="{{ old('cargo') }}" required>
                            @error('cargo')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="activo" class="form-label">Estado</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="activo" name="activo" value="1" {{ old('activo') ? 'checked' : '' }}>
                                <label class="form-check-label" for="activo">Activo</label>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Registrar Empleado
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
                <p>El documento debe ser único para cada empleado.</p>
                <p>Por defecto, el estado del empleado es "Activo".</p>
            </div>
        </div>
    </div>
</div>
@endsection