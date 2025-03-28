@extends('layouts.app')

@section('title', 'Tiempo Promedio por Tipo de Lavado - Sistema de Lavado de Vehículos')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Tiempo Promedio por Tipo de Lavado</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <button class="btn btn-sm btn-outline-secondary" onclick="window.print()">
            <i class="fas fa-print me-1"></i> Imprimir
        </button>
    </div>
</div>

<div class="card">
    <div class="card-header bg-white">
        <h5 class="mb-0">
            <i class="fas fa-clock me-1"></i> Análisis de tiempos de servicio
        </h5>
    </div>
    <div class="card-body">
        @if($tiemposPromedio->count() > 0)
        <div class="row mb-4">
            @foreach($tiemposPromedio as $item)
            <div class="col-md-4 mb-3">
                <div class="card h-100">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">{{ $item->nombre }}</h5>
                    </div>
                    <div class="card-body text-center">
                        <h2 class="display-4">{{ round($item->promedio_minutos) }}</h2>
                        <p class="mb-0">minutos en promedio</p>
                        <p class="text-muted">(basado en {{ $item->total_lavados }} servicios)</p>
                        
                        @php
                        $servicio = App\Models\Servicio::find($item->id);
                        $diferencia = $servicio ? round($item->promedio_minutos) - $servicio->tiempo_estimado : 0;
                        @endphp
                        
                        @if($servicio)
                        <div class="alert {{ $diferencia <= 0 ? 'alert-success' : 'alert-warning' }} mt-3">
                            @if($diferencia <= 0)
                            <i class="fas fa-check-circle me-1"></i> {{ abs($diferencia) }} minutos menos que lo estimado
                            @else
                            <i class="fas fa-exclamation-circle me-1"></i> {{ $diferencia }} minutos más que lo estimado
                            @endif
                        </div>
                        @endif
                    </div>
                    <div class="card-footer bg-white">
                        <div class="progress" style="height: 20px;">
                            @php
                            $porcentaje = $servicio ? ($item->promedio_minutos / $servicio->tiempo_estimado) * 100 : 100;
                            $colorClase = 'bg-success';
                            if($porcentaje > 100 && $porcentaje <= 120) $colorClase = 'bg-info';
                            if($porcentaje > 120 && $porcentaje <= 150) $colorClase = 'bg-warning';
                            if($porcentaje > 150) $colorClase = 'bg-danger';
                            @endphp
                            <div class="progress-bar {{ $colorClase }}" role="progressbar" style="width: {{ min($porcentaje, 200) }}%">
                                {{ round($porcentaje) }}% del tiempo estimado
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Tipo de Servicio</th>
                        <th>Tiempo Promedio (min)</th>
                        <th>Tiempo Estimado (min)</th>
                        <th>Diferencia</th>
                        <th>Total Servicios</th>
                        <th>Eficiencia</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tiemposPromedio as $item)
                    @php
                    $servicio = App\Models\Servicio::find($item->id);
                    $diferencia = $servicio ? round($item->promedio_minutos) - $servicio->tiempo_estimado : 0;
                    @endphp
                    <tr>
                        <td>{{ $item->nombre }}</td>
                        <td>{{ round($item->promedio_minutos) }}</td>
                        <td>{{ $servicio ? $servicio->tiempo_estimado : 'N/A' }}</td>
                        <td>
                            @if($servicio)
                                @if($diferencia <= 0)
                                <span class="text-success">{{ $diferencia }} min</span>
                                @else
                                <span class="text-danger">+{{ $diferencia }} min</span>
                                @endif
                            @else
                                N/A
                            @endif
                        </td>
                        <td>{{ $item->total_lavados }}</td>
                        <td>
                            @if($servicio)
                                @php
                                $porcentaje = ($item->promedio_minutos / $servicio->tiempo_estimado) * 100;
                                @endphp
                                
                                @if($porcentaje <= 100)
                                <span class="badge bg-success">{{ round(100 - $porcentaje + 100) }}%</span>
                                @else
                                <span class="badge bg-warning">{{ round(200 - $porcentaje) }}%</span>
                                @endif
                            @else
                                N/A
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="alert alert-info">
            <i class="fas fa-info-circle me-2"></i> No hay suficientes datos para calcular los tiempos promedio. Se requieren servicios completados para generar este reporte.
        </div>
        @endif
    </div>
</div>
@endsection