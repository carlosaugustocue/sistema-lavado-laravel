@extends('layouts.app')

@section('title', 'Editar Insumo - Sistema de Lavado de Vehículos')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Editar Insumo</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('insumos.show', $insumo->id) }}" class="btn btn-sm btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Volver
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Datos del insumo</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('insumos.update', $insumo->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre <span class="text-danger">*</span></label>
                        <input type="text" id="nombre" name="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre', $insumo->nombre) }}" required>
                        @error('nombre')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <textarea id="descripcion" name="descripcion" class="form-control @error('descripcion') is-invalid @enderror" rows="3">{{ old('descripcion', $insumo->descripcion) }}</textarea>
                        @error('descripcion')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="costo" class="form-label">Costo <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" id="costo" name="costo" class="form-control @error('costo') is-invalid @enderror" value="{{ old('costo', $insumo->costo) }}" min="0" step="0.01" required>
                                @error('costo')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="unidad_medida" class="form-label">Unidad de Medida <span class="text-danger">*</span></label>
                            <input type="text" id="unidad_medida" name="unidad_medida" class="form-control @error('unidad_medida') is-invalid @enderror" value="{{ old('unidad_medida', $insumo->unidad_medida) }}" required>
                            @error('unidad_medida')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="stock_actual" class="form-label">Stock Actual <span class="text-danger">*</span></label>
                            <input type="number" id="stock_actual" name="stock_actual" class="form-control @error('stock_actual') is-invalid @enderror" value="{{ old('stock_actual', $insumo->stock_actual) }}" min="0" step="0.01" required>
                            @error('stock_actual')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="stock_minimo" class="form-label">Stock Mínimo <span class="text-danger">*</span></label>
                            <input type="number" id="stock_minimo" name="stock_minimo" class="form-control @error('stock_minimo') is-invalid @enderror" value="{{ old('stock_minimo', $insumo->stock_minimo) }}" min="0" step="0.01" required>
                            @error('stock_minimo')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Actualizar Insumo
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
                <p>La unidad de medida define cómo se medirá el stock (litros, unidades, etc.)</p>
                <p>El stock mínimo es el umbral que activará alertas de stock bajo.</p>
                <p>Para actualizar el stock con una cantidad específica, use este formulario.</p>
                <p>Para añadir más stock, puede usar el botón "Actualizar Stock" en la página de detalles.</p>
            </div>
        </div>
    </div>
</div>
@endsection