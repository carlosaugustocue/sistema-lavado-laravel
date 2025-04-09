<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;
    
    protected $table = 'proveedores';
    
    protected $fillable = [
        'nombre',
        'contacto',
        'telefono',
        'email',
        'direccion',
        'rfc',
        'verificado'
    ];
    
    // Relación con cotizaciones
    public function cotizaciones()
    {
        return $this->hasMany(Cotizacion::class);
    }
    
    // Productos cotizados por el proveedor
    public function productosCotizados()
    {
        return $this->belongsToMany(ProductoCotizable::class, 'cotizaciones')
            ->withPivot('precio', 'cantidad_minima', 'observaciones', 'disponibilidad_inmediata')
            ->withTimestamps();
    }
}