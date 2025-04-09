@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Evaluación del Servicio</h4>
        </div>
        <div class="card-body">
            <div class="mb-4">
                <h5>Detalles del servicio:</h5>
                <p><strong>Vehículo:</strong> {{ $lavado->vehiculo->marca }} {{ $lavado->vehiculo->modelo }} ({{ $lavado->vehiculo->placa }})</p>
                <p><strong>Servicio:</strong> {{ $lavado->servicio->nombre }}</p>
                <p><strong>Fecha:</strong> {{ $lavado->hora_entrada->format('d/m/Y') }}</p>
            </div>
            
            <form action="{{ route('evaluaciones.guardar', $evaluacion->token) }}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label class="form-label">Tiempo de espera</label>
                    <div class="rating">
                        @for ($i = 1; $i <= 5; $i++)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="tiempo_espera" id="tiempo_{{ $i }}" value="{{ $i }}" required>
                                <label class="form-check-label" for="tiempo_{{ $i }}">{{ $i }}</label>
                            </div>
                        @endfor
                    </div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Amabilidad del personal</label>
                    <div class="rating">
                        @for ($i = 1; $i <= 5; $i++)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="amabilidad" id="amabilidad_{{ $i }}" value="{{ $i }}" required>
                                <label class="form-check-label" for="amabilidad_{{ $i }}">{{ $i }}</label>
                            </div>
                        @endfor
                    </div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Calidad del servicio recibido</label>
                    <div class="rating">
                        @for ($i = 1; $i <= 5; $i++)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="calidad_servicio" id="calidad_{{ $i }}" value="{{ $i }}" required>
                                <label class="form-check-label" for="calidad_{{ $i }}">{{ $i }}</label>
                            </div>
                        @endfor
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="comentarios" class="form-label">Comentarios adicionales (opcional)</label>
                    <textarea class="form-control" id="comentarios" name="comentarios" rows="3"></textarea>
                </div>
                
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Enviar evaluación</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection