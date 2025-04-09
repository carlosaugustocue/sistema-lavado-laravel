<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lavado extends Model
{
    use HasFactory;

    protected $fillable = [
        'vehiculo_id',
        'empleado_id',
        'empleado_asignado_id',
        'servicio_id',
        'hora_entrada',
        'hora_salida',
        'estado',
        'costo_total',
        'observaciones',
    ];

    protected $casts = [
        'hora_entrada' => 'datetime',
        'hora_salida' => 'datetime',
    ];

    public function vehiculo(): BelongsTo
    {
        return $this->belongsTo(Vehiculo::class);
    }

    public function empleadoRecibe(): BelongsTo
    {
        return $this->belongsTo(Empleado::class, 'empleado_id');
    }

    public function empleadoAsignado(): BelongsTo
    {
        return $this->belongsTo(Empleado::class, 'empleado_asignado_id');
    }

    public function servicio(): BelongsTo
    {
        return $this->belongsTo(Servicio::class);
    }

    public function usoInsumos(): HasMany
    {
        return $this->hasMany(UsoInsumo::class);
    }

    public function evaluacion()
{
    return $this->hasOne(Evaluacion::class);
}
}