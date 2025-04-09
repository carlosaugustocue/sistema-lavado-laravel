@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Evaluaciones de Servicios</h1>
        <a href="{{ route('evaluaciones.reporte') }}" class="btn btn-sm btn-primary">
            <i class="fas fa-chart-bar"></i> Ver Reportes
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Lista de Evaluaciones</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Cliente</th>
                            <th>Vehículo</th>
                            <th>Servicio</th>
                            <th>Tiempo</th>
                            <th>Amabilidad</th>
                            <th>Calidad</th>
                            <th>Promedio</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($evaluaciones as $evaluacion)
                            <tr>
                                <td>{{ $evaluacion->created_at->format('d/m/Y') }}</td>
                                <td>{{ $evaluacion->lavado->vehiculo->cliente->nombre }}</td>
                                <td>{{ $evaluacion->lavado->vehiculo->marca }} {{ $evaluacion->lavado->vehiculo->modelo }} ({{ $evaluacion->lavado->vehiculo->placa }})</td>
                                <td>{{ $evaluacion->lavado->servicio->nombre }}</td>
                                <td>{{ $evaluacion->tiempo_espera }}/5</td>
                                <td>{{ $evaluacion->amabilidad }}/5</td>
                                <td>{{ $evaluacion->calidad_servicio }}/5</td>
                                <td>{{ $evaluacion->promedio }}/5</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">No hay evaluaciones registradas</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            {{ $evaluaciones->links() }}
        </div>
    </div>
</div>
@endsection