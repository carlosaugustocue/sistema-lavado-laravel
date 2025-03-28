@extends('layouts.app')

@section('title', 'Turnos - Sistema de Lavado de Vehículos')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Gestión de Turnos</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('turnos.create') }}" class="btn btn-sm btn-primary">
            <i class="fas fa-plus me-1"></i> Nuevo Turno
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header bg-white">
        <div class="row">
            <div class="col-md-6">
                <h5 class="mb-0">Turnos programados</h5>
            </div>
            <div class="col-md-6">
                <form action="{{ route('turnos.index') }}" method="GET" class="d-flex">
                    <input type="date" name="fecha" class="form-control form-control-sm me-2" value="{{ request('fecha', date('Y-m-d')) }}">
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="fas fa-filter"></i> Filtrar
                    </button>
                </form>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Empleado</th>
                        <th>Fecha</th>
                        <th>Hora Inicio</th>
                        <th>Hora Fin</th>
                        <th>Duración</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($turnos as $turno)
                    <tr>
                        <td>{{ $turno->id }}</td>
                        <td>{{ $turno->empleado->nombre }} {{ $turno->empleado->apellido }}</td>
                        <td>{{ $turno->fecha->format('d/m/Y') }}</td>
                        <td>{{ $turno->hora_inicio->format('H:i') }}</td>
                        <td>{{ $turno->hora_fin->format('H:i') }}</td>
                        <td>{{ $turno->hora_inicio->diffInHours($turno->hora_fin) }} horas</td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('turnos.edit', $turno->id) }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $turno->id }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>

                            <!-- Modal de eliminación -->
                            <div class="modal fade" id="deleteModal{{ $turno->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $turno->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteModalLabel{{ $turno->id }}">Confirmar eliminación</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            ¿Está seguro de que desea eliminar el turno de {{ $turno->empleado->nombre }} {{ $turno->empleado->apellido }} del {{ $turno->fecha->format('d/m/Y') }}?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                            <form action="{{ route('turnos.destroy', $turno->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Eliminar</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">No hay turnos programados para esta fecha</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Calendario de turnos</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col">
                        <h5>{{ now()->format('F Y') }}</h5>
                    </div>
                </div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Lunes</th>
                            <th>Martes</th>
                            <th>Miércoles</th>
                            <th>Jueves</th>
                            <th>Viernes</th>
                            <th>Sábado</th>
                            <th>Domingo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $startOfMonth = now()->startOfMonth();
                        $endOfMonth = now()->endOfMonth();
                        
                        $startDayOfWeek = $startOfMonth->dayOfWeek;
                        if ($startDayOfWeek == 0) $startDayOfWeek = 7; // Ajustar domingo
                        
                        $daysInMonth = $startOfMonth->daysInMonth;
                        $currentDay = 1;
                        $totalCells = ceil(($daysInMonth + $startDayOfWeek - 1) / 7) * 7;
                        @endphp
                        
                        @for ($i = 1; $i <= $totalCells; $i += 7)
                        <tr>
                            @for ($j = 0; $j < 7; $j++)
                            <td style="height: 100px; width: 14%; vertical-align: top;">
                                @php
                                $cellDay = $i + $j - ($startDayOfWeek - 1);
                                @endphp
                                
                                @if ($cellDay > 0 && $cellDay <= $daysInMonth)
                                <div class="d-flex justify-content-between">
                                    <span class="fw-bold">{{ $cellDay }}</span>
                                    <span>{{ now()->setDay($cellDay)->format('D') }}</span>
                                </div>
                                
                                @php
                                $dayTurnos = $turnosPorDia[now()->format('Y-m-') . str_pad($cellDay, 2, '0', STR_PAD_LEFT)] ?? [];
                                @endphp
                                
                                @foreach($dayTurnos as $turno)
                                <div class="mt-1 p-1 bg-light rounded small">
                                    {{ $turno->empleado->nombre }} {{ substr($turno->empleado->apellido, 0, 1) }}.
                                    <br>
                                    {{ $turno->hora_inicio->format('H:i') }} - {{ $turno->hora_fin->format('H:i') }}
                                </div>
                                @endforeach
                                @endif
                            </td>
                            @endfor
                        </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection