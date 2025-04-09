@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Reporte de Evaluaciones</h1>
        <a href="{{ route('evaluaciones.index') }}" class="btn btn-sm btn-primary">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>

    <div class="row">
        <!-- Promedio Tiempo de Espera -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Tiempo de Espera</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($promedioTiempoEspera, 1) }}/5</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Promedio Amabilidad -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Amabilidad</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($promedioAmabilidad, 1) }}/5</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-smile fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Promedio Calidad -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Calidad del Servicio</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($promedioCalidadServicio, 1) }}/5</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-star fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Evaluaciones -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Total Evaluaciones</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalEvaluaciones }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de evaluaciones por servicio -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Evaluaciones por Servicio</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Servicio</th>
                            <th>Tiempo Espera</th>
                            <th>Amabilidad</th>
                            <th>Calidad</th>
                            <th>Promedio</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($evaluacionesPorServicio as $eval)
                        <tr>
                            <td>{{ $eval->nombre }}</td>
                            <td>{{ number_format($eval->prom_tiempo, 1) }}</td>
                            <td>{{ number_format($eval->prom_amabilidad, 1) }}</td>
                            <td>{{ number_format($eval->prom_calidad, 1) }}</td>
                            <td>{{ number_format(($eval->prom_tiempo + $eval->prom_amabilidad + $eval->prom_calidad) / 3, 1) }}</td>
                            <td>{{ $eval->total }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection