<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductoCotizable extends Model
{
    use HasFactory;
    
    protected $table = 'productos_cotizables';
    
    protected $fillable = [
        'nombre',
        'descripcion',
        'unidad_medida',
        'activo'
    ];
    
    // Relación con cotizaciones
    public function cotizaciones()
    {
        return $this->hasMany(Cotizacion::class);
    }
    
    // Proveedores que han cotizado este producto
    public function proveedores()
    {
        return $this->belongsToMany(Proveedor::class, 'cotizaciones')
            ->withPivot('precio', 'cantidad_minima', 'observaciones', 'disponibilidad_inmediata')
            ->withTimestamps();
    }
    
    // Obtener la cotización más baja
    public function getMejorPrecioAttribute()
    {
        return $this->cotizaciones()->min('precio');
    }
    
    // Obtener el proveedor con mejor precio
    public function getProveedorMejorPrecioAttribute()
    {
        $cotizacion = $this->cotizaciones()->orderBy('precio', 'asc')->first();
        return $cotizacion ? $cotizacion->proveedor : null;
    }
}