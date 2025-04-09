@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Editar Producto Cotizable</h1>
        <a href="{{ route('productos_cotizables.index') }}" class="btn btn-sm btn-primary">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Datos del Producto</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('productos_cotizables.update', $productoCotizable) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre *</label>
                    <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre" required value="{{ old('nombre', $productoCotizable->nombre) }}">
                    @error('nombre')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea class="form-control @error('descripcion') is-invalid @enderror" id="descripcion" name="descripcion" rows="3">{{ old('descripcion', $productoCotizable->descripcion) }}</textarea>
                    @error('descripcion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="unidad_medida" class="form-label">Unidad de Medida *</label>
                    <input type="text" class="form-control @error('unidad_medida') is-invalid @enderror" id="unidad_medida" name="unidad_medida" required value="{{ old('unidad_medida', $productoCotizable->unidad_medida) }}">
                    @error('unidad_medida')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input @error('activo') is-invalid @enderror" type="checkbox" value="1" id="activo" name="activo" {{ $productoCotizable->activo ? 'checked' : '' }}>
                        <label class="form-check-label" for="activo">
                            Activo
                        </label>
                    </div>
                    @error('activo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <button type="submit" class="btn btn-primary">Actualizar Producto</button>
            </form>
        </div>
    </div>
</div>
@endsection