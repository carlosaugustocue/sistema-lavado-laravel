<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Insumo extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'costo',
        'stock_actual',
        'stock_minimo',
        'unidad_medida',
    ];

    public function usos(): HasMany
    {
        return $this->hasMany(UsoInsumo::class);
    }
}