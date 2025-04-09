<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistema de Lavado de Vehículos')</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .sidebar {
            min-height: calc(100vh - 56px);
            background-color: #f8f9fa;
        }
        .main-content {
            padding: 20px;
        }
        .btn-circle {
            width: 30px;
            height: 30px;
            padding: 6px 0px;
            border-radius: 15px;
            text-align: center;
            font-size: 12px;
            line-height: 1.42857;
        }
    </style>
    @yield('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                <i class="fas fa-car-wash me-2"></i> Sistema de Lavado
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dashboard') }}">
                            <i class="fas fa-tachometer-alt me-1"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('lavados.pendientes') }}">
                            <i class="fas fa-clipboard-list me-1"></i> Pendientes
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block sidebar collapse">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('dashboard') }}">
                                <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('lavados.index') }}">
                                <i class="fas fa-car-wash me-2"></i> Lavados
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('vehiculos.index') }}">
                                <i class="fas fa-car me-2"></i> Vehículos
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('clientes.index') }}">
                                <i class="fas fa-users me-2"></i> Clientes
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('empleados.index') }}">
                                <i class="fas fa-user-tie me-2"></i> Empleados
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('servicios.index') }}">
                                <i class="fas fa-tools me-2"></i> Servicios
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('insumos.index') }}">
                                <i class="fas fa-box me-2"></i> Insumos
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('insumos.stock-bajo') }}">
                                <i class="fas fa-exclamation-triangle me-2"></i> Stock Bajo
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('empleados.carga-trabajo') }}">
                                <i class="fas fa-tasks me-2"></i> Carga de Trabajo
                            </a>
                        </li>

                        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                            <span>Reportes</span>
                        </h6>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('reportes.ingresos-diarios') }}">
                                <i class="fas fa-dollar-sign me-2"></i> Ingresos Diarios
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('reportes.tiempo-promedio') }}">
                                <i class="fas fa-clock me-2"></i> Tiempo Promedio
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('turnos.index') }}">
                                <i class="fas fa-calendar-alt me-2"></i> Turnos
                            </a>
                        </li>
                        
                        <!-- NUEVOS MÓDULOS -->
                        <!-- Evaluaciones -->
                        <li class="nav-item">
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseEvaluaciones" aria-expanded="false">
                                <i class="fas fa-star me-2"></i> Evaluaciones
                            </a>
                            <div class="collapse" id="collapseEvaluaciones">
                                <ul class="nav flex-column ms-3">
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('evaluaciones.index') }}">
                                            <i class="fas fa-list me-2"></i> Listado
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('evaluaciones.reporte') }}">
                                            <i class="fas fa-chart-bar me-2"></i> Reportes
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <!-- Proveedores y Cotizaciones -->
                        <li class="nav-item">
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseProveedores" aria-expanded="false">
                                <i class="fas fa-truck me-2"></i> Proveedores
                            </a>
                            <div class="collapse" id="collapseProveedores">
                                <ul class="nav flex-column ms-3">
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('proveedores.index') }}">
                                            <i class="fas fa-building me-2"></i> Proveedores
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('productos_cotizables.index') }}">
                                            <i class="fas fa-boxes me-2"></i> Productos
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('cotizaciones.index') }}">
                                            <i class="fas fa-file-invoice-dollar me-2"></i> Cotizaciones
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('cotizaciones.reporte') }}">
                                            <i class="fas fa-chart-pie me-2"></i> Reportes
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 main-content">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>