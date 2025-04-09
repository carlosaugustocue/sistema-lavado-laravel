@extends('layouts.publico')

@section('title', 'Cotizar Productos')

@section('content')
<div class="container py-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Cotizar Productos</h4>
        </div>
        <div class="card-body">
            <div class="alert alert-info">
                <p class="mb-0">Proveedor: <strong>{{ $proveedor->nombre }}</strong> ({{ $proveedor->email }})</p>
            </div>
            
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            
            <p class="mb-4">Seleccione un producto y proporcione su cotización:</p>
            
            <form action="{{ route('cotizaciones.guardar', $proveedor->id) }}" method="POST" class="mb-5">
                @csrf
                
                <div class="mb-3">
                    <label for="producto_id" class="form-label">Producto *</label>
                    <select class="form-select @error('producto_id') is-invalid @enderror" id="producto_id" name="producto_id" required>
                        <option value="">Seleccione un producto</option>
                        @foreach($productos as $producto)
                            <option value="{{ $producto->id }}">{{ $producto->nombre }} ({{ $producto->unidad_medida }})</option>
                        @endforeach
                    </select>
                    @error('producto_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="precio" class="form-label">Precio *</label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" step="0.01" min="0.01" class="form-control @error('precio') is-invalid @enderror" id="precio" name="precio" required value="{{ old('precio') }}">
                    </div>
                    @error('precio')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="cantidad_minima" class="form-label">Cantidad Mínima de Compra *</label>
                    <input type="number" min="1" class="form-control @error('cantidad_minima') is-invalid @enderror" id="cantidad_minima" name="cantidad_minima" required value="{{ old('cantidad_minima', 1) }}">
                    @error('cantidad_minima')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input @error('disponibilidad_inmediata') is-invalid @enderror" type="checkbox" value="1" id="disponibilidad_inmediata" name="disponibilidad_inmediata" checked>
                        <label class="form-check-label" for="disponibilidad_inmediata">
                            Disponibilidad Inmediata
                        </label>
                    </div>
                    @error('disponibilidad_inmediata')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="observaciones" class="form-label">Observaciones</label>
                    <textarea class="form-control @error('observaciones') is-invalid @enderror" id="observaciones" name="observaciones" rows="3">{{ old('observaciones') }}</textarea>
                    @error('observaciones')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Enviar Cotización</button>
                </div>
            </form>
            
            <h5 class="mb-3">Sus Cotizaciones Actuales</h5>
            
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Precio</th>
                            <th>Cantidad Mínima</th>
                            <th>Disponibilidad</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($proveedor->cotizaciones as $cotizacion)
                            <tr>
                                <td>{{ $cotizacion->productoCotizable->nombre }}</td>
                                <td>${{ number_format($cotizacion->precio, 2) }}</td>
                                <td>{{ $cotizacion->cantidad_minima }}</td>
                                <td>{{ $cotizacion->disponibilidad_inmediata ? 'Inmediata' : 'No inmediata' }}</td>
                                <td>{{ $cotizacion->updated_at->format('d/m/Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Aún no ha enviado ninguna cotización.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4 text-center">
                <a href="{{ route('cotizaciones.formulario') }}" class="btn btn-outline-primary">Finalizar Sesión</a>
            </div>
        </div>
    </div>
</div>
@endsection