@extends('layouts.app')

@section('title', 'Dashboard - Sistema de Lavado de Vehículos')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Dashboard</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('lavados.create') }}" class="btn btn-sm btn-primary">
            <i class="fas fa-plus me-1"></i> Nuevo Lavado
        </a>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-3 mb-4">
        <div class="card bg-primary text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase">Lavados Pendientes</h6>
                        <h1 class="display-4">{{ $lavadosPendientes }}</h1>
                    </div>
                    <i class="fas fa-car-wash fa-3x opacity-50"></i>
                </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a href="{{ route('lavados.pendientes') }}" class="text-white text-decoration-none">Ver Detalles</a>
                <i class="fas fa-angle-right text-white"></i>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card bg-success text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase">Ingresos Hoy</h6>
                        <h1 class="display-4">${{ number_format($ingresosHoy, 2) }}</h1>
                    </div>
                    <i class="fas fa-dollar-sign fa-3x opacity-50"></i>
                </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a href="{{ route('reportes.ingresos-diarios') }}" class="text-white text-decoration-none">Ver Detalles</a>
                <i class="fas fa-angle-right text-white"></i>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card bg-info text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase">Servicios Hoy</h6>
                        <h1 class="display-4">{{ $lavadosHoy }}</h1>
                    </div>
                    <i class="fas fa-clipboard-list fa-3x opacity-50"></i>
                </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a href="{{ route('lavados.index') }}" class="text-white text-decoration-none">Ver Detalles</a>
                <i class="fas fa-angle-right text-white"></i>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card bg-warning text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase">Insumos Stock Bajo</h6>
                        <h1 class="display-4">{{ $insumosStockBajo }}</h1>
                    </div>
                    <i class="fas fa-exclamation-triangle fa-3x opacity-50"></i>
                </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a href="{{ route('insumos.stock-bajo') }}" class="text-white text-decoration-none">Ver Detalles</a>
                <i class="fas fa-angle-right text-white"></i>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-car me-1"></i> Vehículos Pendientes
            </div>
            <div class="card-body">
                @php
                $pendientes = App\Models\Lavado::with('vehiculo', 'servicio')
                    ->where('estado', 'pendiente')
                    ->orWhere('estado', 'en_proceso')
                    ->orderBy('hora_entrada', 'asc')
                    ->take(5)
                    ->get();
                @endphp

                @if($pendientes->count() > 0)
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Placa</th>
                                <th>Servicio</th>
                                <th>Estado</th>
                                <th>Entrada</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendientes as $lavado)
                            <tr>
                                <td>{{ $lavado->vehiculo->placa }}</td>
                                <td>{{ $lavado->servicio->nombre }}</td>
                                <td>
                                    @if($lavado->estado == 'pendiente')
                                    <span class="badge bg-warning">Pendiente</span>
                                    @elseif($lavado->estado == 'en_proceso')
                                    <span class="badge bg-info">En Proceso</span>
                                    @endif
                                </td>
                                <td>{{ $lavado->hora_entrada->format('H:i') }}</td>
                                <td>
                                    <a href="{{ route('lavados.show', $lavado->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <p class="text-center">No hay vehículos pendientes</p>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-box me-1"></i> Stock Bajo
            </div>
            <div class="card-body">
                @php
                $insumosStockBajo = App\Models\Insumo::whereRaw('stock_actual <= stock_minimo')
                    ->orderBy('stock_actual')
                    ->take(5)
                    ->get();
                @endphp

                @if($insumosStockBajo->count() > 0)
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Insumo</th>
                                <th>Stock Actual</th>
                                <th>Stock Mínimo</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($insumosStockBajo as $insumo)
                            <tr>
                                <td>{{ $insumo->nombre }}</td>
                                <td>{{ $insumo->stock_actual }} {{ $insumo->unidad_medida }}</td>
                                <td>{{ $insumo->stock_minimo }} {{ $insumo->unidad_medida }}</td>
                                <td>
                                    <a href="{{ route('insumos.edit', $insumo->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <p class="text-center">No hay insumos con stock bajo</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection