@extends('layouts.app')

@section('title', 'Reporte de Ingresos Diarios - Sistema de Lavado de Vehículos')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Reporte de Ingresos Diarios</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <button class="btn btn-sm btn-outline-secondary" onclick="window.print()">
            <i class="fas fa-print me-1"></i> Imprimir
        </button>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header bg-white">
        <div class="row">
            <div class="col-md-6">
                <h5 class="mb-0">
                    <i class="fas fa-dollar-sign me-1"></i> Ingresos del día
                </h5>
            </div>
            <div class="col-md-6">
                <form action="{{ route('reportes.ingresos-diarios') }}" method="GET" class="d-flex">
                    <input type="date" name="fecha" class="form-control form-control-sm me-2" value="{{ $fecha }}" required>
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="fas fa-filter"></i> Filtrar
                    </button>
                </form>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card bg-success text-white">
                    <div class="card-body text-center">
                        <h5 class="card-title">Total de Ingresos</h5>
                        <h2 class="display-4">${{ number_format($totalIngresos, 2) }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-primary text-white">
                    <div class="card-body text-center">
                        <h5 class="card-title">Servicios Realizados</h5>
                        <h2 class="display-4">{{ $totalServicios }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-info text-white">
                    <div class="card-body text-center">
                        <h5 class="card-title">Promedio por Servicio</h5>
                        <h2 class="display-4">
                            ${{ $totalServicios > 0 ? number_format($totalIngresos / $totalServicios, 2) : '0.00' }}
                        </h2>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Ingresos por Tipo de Servicio</h5>
                    </div>
                    <div class="card-body">
                        @if($ingresosPorServicio->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Servicio</th>
                                        <th>Cantidad</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($ingresosPorServicio as $item)
                                    <tr>
                                        <td>{{ $item['servicio'] }}</td>
                                        <td>{{ $item['cantidad'] }}</td>
                                        <td>${{ number_format($item['total'], 2) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <p class="text-center">No hay datos para mostrar</p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Resumen del Día</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Fecha del reporte
                                <span class="badge bg-primary rounded-pill">{{ date('d/m/Y', strtotime($fecha)) }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Total de servicios completados
                                <span class="badge bg-primary rounded-pill">{{ $totalServicios }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Ingresos totales
                                <span class="badge bg-success rounded-pill">${{ number_format($totalIngresos, 2) }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Promedio por servicio
                                <span class="badge bg-info rounded-pill">
                                    ${{ $totalServicios > 0 ? number_format($totalIngresos / $totalServicios, 2) : '0.00' }}
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Detalle de Servicios</h5>
            </div>
            <div class="card-body">
                @if($ingresos->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Vehículo</th>
                                <th>Servicio</th>
                                <th>Hora Entrada</th>
                                <th>Hora Salida</th>
                                <th>Empleado</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ingresos as $ingreso)
                            <tr>
                                <td>{{ $ingreso->id }}</td>
                                <td>{{ $ingreso->vehiculo->placa }}</td>
                                <td>{{ $ingreso->servicio->nombre }}</td>
                                <td>{{ $ingreso->hora_entrada->format('H:i') }}</td>
                                <td>{{ $ingreso->hora_salida ? $ingreso->hora_salida->format('H:i') : 'N/A' }}</td>
                                <td>{{ $ingreso->empleadoAsignado ? $ingreso->empleadoAsignado->nombre . ' ' . $ingreso->empleadoAsignado->apellido : 'Sin asignar' }}</td>
                                <td>${{ number_format($ingreso->costo_total, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <p class="text-center">No hay datos para mostrar</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection