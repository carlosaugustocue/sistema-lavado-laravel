@extends('layouts.publico')

@section('title', 'Registro Completado')

@section('content')
<div class="container py-5">
    <div class="card shadow">
        <div class="card-body text-center py-5">
            <div class="mb-4">
                <i class="fas fa-check-circle text-success" style="font-size: 64px;"></i>
            </div>
            <h2 class="mb-4">¡Registro Completado!</h2>
            <p class="lead">Gracias por registrarse como proveedor.</p>
            <p>Su solicitud ha sido enviada y será revisada por nuestro equipo. Una vez verificada su cuenta, podrá empezar a enviar cotizaciones.</p>
            <p><strong>Por favor guarde su correo electrónico para futuros accesos:</strong> {{ $proveedor->email }}</p>
            
            <div class="mt-4">
                <a href="{{ route('cotizaciones.formulario') }}" class="btn btn-primary">Volver al Inicio</a>
            </div>
        </div>
    </div>
</div>
@endsection