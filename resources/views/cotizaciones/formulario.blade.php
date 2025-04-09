@extends('layouts.publico')

@section('title', 'Formulario de Cotización')

@section('content')
<div class="container py-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Formulario de Cotización</h4>
        </div>
        <div class="card-body">
            <p class="mb-4">Por favor ingrese su correo electrónico para comenzar a cotizar. Si aún no está registrado como proveedor, será redirigido al formulario de registro.</p>
            
            @if(session('info'))
                <div class="alert alert-info">{{ session('info') }}</div>
            @endif
            
            @if(session('warning'))
                <div class="alert alert-warning">{{ session('warning') }}</div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            
            <form action="{{ route('cotizaciones.buscar_proveedor') }}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label for="email" class="form-label">Correo Electrónico</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" required value="{{ old('email') }}">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Continuar</button>
                </div>
            </form>
            
            <div class="mt-4 text-center">
                <p>¿No está registrado como proveedor? <a href="{{ route('proveedores.registro') }}">Regístrese aquí</a></p>
            </div>
        </div>
    </div>
</div>
@endsection