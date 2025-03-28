<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vehiculo extends Model
{
    use HasFactory;

    protected $fillable = [
        'cliente_id',
        'placa',
        'marca',
        'modelo',
        'color',
        'tipo',
        'año',
    ];

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }

    public function lavados(): HasMany
    {
        return $this->hasMany(Lavado::class);
    }
}