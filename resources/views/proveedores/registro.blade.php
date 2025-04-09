@extends('layouts.publico')

@section('title', 'Registro de Proveedor')

@section('content')
<div class="container py-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Registro de Proveedor</h4>
        </div>
        <div class="card-body">
            <p class="mb-4">Complete el siguiente formulario para registrarse como proveedor. Una vez verificada su cuenta, podrá enviar cotizaciones.</p>
            
            @if(session('info'))
                <div class="alert alert-info">{{ session('info') }}</div>
            @endif
            
            <form action="{{ route('proveedores.guardar_registro') }}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre de la Empresa *</label>
                    <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre" required value="{{ old('nombre') }}">
                    @error('nombre')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="contacto" class="form-label">Nombre de Contacto *</label>
                    <input type="text" class="form-control @error('contacto') is-invalid @enderror" id="contacto" name="contacto" required value="{{ old('contacto') }}">
                    @error('contacto')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="telefono" class="form-label">Teléfono *</label>
                    <input type="text" class="form-control @error('telefono') is-invalid @enderror" id="telefono" name="telefono" required value="{{ old('telefono') }}">
                    @error('telefono')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="email" class="form-label">Correo Electrónico *</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" required value="{{ old('email') }}">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="direccion" class="form-label">Dirección</label>
                    <textarea class="form-control @error('direccion') is-invalid @enderror" id="direccion" name="direccion" rows="3">{{ old('direccion') }}</textarea>
                    @error('direccion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="rfc" class="form-label">RFC</label>
                    <input type="text" class="form-control @error('rfc') is-invalid @enderror" id="rfc" name="rfc" value="{{ old('rfc') }}">
                    @error('rfc')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Registrarse</button>
                </div>
            </form>
            
            <div class="mt-4 text-center">
                <p>¿Ya está registrado? <a href="{{ route('cotizaciones.formulario') }}">Volver al formulario de cotización</a></p>
            </div>
        </div>
    </div>
</div>
@endsection