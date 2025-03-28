@extends('layouts.app')

@section('title', 'Nuevo Vehículo - Sistema de Lavado de Vehículos')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Registrar Nuevo Vehículo</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('vehiculos.index') }}" class="btn btn-sm btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Volver
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Datos del vehículo</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('vehiculos.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="cliente_id" class="form-label">Cliente <span class="text-danger">*</span></label>
                        <select id="cliente_id" name="cliente_id" class="form-select @error('cliente_id') is-invalid @enderror" required>
                            <option value="">Seleccione un cliente</option>
                            @foreach($clientes as $cliente)
                            <option value="{{ $cliente->id }}" {{ old('cliente_id') == $cliente->id ? 'selected' : '' }}>
                                {{ $cliente->nombre }} {{ $cliente->apellido }} - {{ $cliente->telefono }}
                            </option>
                            @endforeach
                        </select>
                        @error('cliente_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="placa" class="form-label">Placa <span class="text-danger">*</span></label>
                            <input type="text" id="placa" name="placa" class="form-control @error('placa') is-invalid @enderror" value="{{ old('placa') }}" required>
                            @error('placa')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="tipo" class="form-label">Tipo de Vehículo <span class="text-danger">*</span></label>
                            <select id="tipo" name="tipo" class="form-select @error('tipo') is-invalid @enderror" required>
                                <option value="">Seleccione un tipo</option>
                                <option value="automovil" {{ old('tipo') == 'automovil' ? 'selected' : '' }}>Automóvil</option>
                                <option value="camioneta" {{ old('tipo') == 'camioneta' ? 'selected' : '' }}>Camioneta</option>
                                <option value="motocicleta" {{ old('tipo') == 'motocicleta' ? 'selected' : '' }}>Motocicleta</option>
                                <option value="otro" {{ old('tipo') == 'otro' ? 'selected' : '' }}>Otro</option>
                            </select>
                            @error('tipo')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="marca" class="form-label">Marca <span class="text-danger">*</span></label>
                            <input type="text" id="marca" name="marca" class="form-control @error('marca') is-invalid @enderror" value="{{ old('marca') }}" required>
                            @error('marca')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="modelo" class="form-label">Modelo <span class="text-danger">*</span></label>
                            <input type="text" id="modelo" name="modelo" class="form-control @error('modelo') is-invalid @enderror" value="{{ old('modelo') }}" required>
                            @error('modelo')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="color" class="form-label">Color <span class="text-danger">*</span></label>
                            <input type="text" id="color" name="color" class="form-control @error('color') is-invalid @enderror" value="{{ old('color') }}" required>
                            @error('color')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="año" class="form-label">Año</label>
                            <input type="number" id="año" name="año" class="form-control @error('año') is-invalid @enderror" value="{{ old('año') }}" min="1900" max="{{ date('Y') + 1 }}">
                            @error('año')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Registrar Vehículo
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
                <p>La placa debe ser única en el sistema.</p>
                <p>Si el cliente no está registrado, primero debe registrarlo:</p>
                <div class="d-grid gap-2">
                    <a href="{{ route('clientes.create') }}" class="btn btn-outline-primary">
                        <i class="fas fa-user-plus me-1"></i> Registrar Cliente
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection