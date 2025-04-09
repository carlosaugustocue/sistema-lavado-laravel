<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cotizacion extends Model
{
    use HasFactory;
    
    protected $table = 'cotizaciones';
    
    protected $fillable = [
        'proveedor_id',
        'producto_cotizable_id',
        'precio',
        'cantidad_minima',
        'observaciones',
        'disponibilidad_inmediata'
    ];
    
    // Relación con proveedor
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }
    
    // Relación con producto cotizable
    public function productoCotizable()
    {
        return $this->belongsTo(ProductoCotizable::class);
    }
}