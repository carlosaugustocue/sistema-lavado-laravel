@extends('layouts.app')

@section('title', 'Nuevo Servicio - Sistema de Lavado de Vehículos')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Registrar Nuevo Servicio</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('servicios.index') }}" class="btn btn-sm btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Volver
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Datos del servicio</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('servicios.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre <span class="text-danger">*</span></label>
                        <input type="text" id="nombre" name="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre') }}" required>
                        @error('nombre')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción <span class="text-danger">*</span></label>
                        <textarea id="descripcion" name="descripcion" class="form-control @error('descripcion') is-invalid @enderror" rows="3" required>{{ old('descripcion') }}</textarea>
                        @error('descripcion')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="precio" class="form-label">Precio <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" id="precio" name="precio" class="form-control @error('precio') is-invalid @enderror" value="{{ old('precio') }}" min="0" step="0.01" required>
                                @error('precio')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="tiempo_estimado" class="form-label">Tiempo Estimado (minutos) <span class="text-danger">*</span></label>
                            <input type="number" id="tiempo_estimado" name="tiempo_estimado" class="form-control @error('tiempo_estimado') is-invalid @enderror" value="{{ old('tiempo_estimado') }}" min="1" required>
                            @error('tiempo_estimado')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="activo" name="activo" value="1" {{ old('activo') ? 'checked' : '' }}>
                            <label class="form-check-label" for="activo">Servicio Activo</label>
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Registrar Servicio
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
                <p>El precio debe ser un valor numérico positivo.</p>
                <p>El tiempo estimado es en minutos y ayuda a calcular la duración promedio de cada servicio.</p>
                <p>Si desactiva un servicio, no estará disponible para nuevos lavados.</p>
            </div>
        </div>
    </div>
</div>
@endsection