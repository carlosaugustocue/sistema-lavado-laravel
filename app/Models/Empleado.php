<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Empleado extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'apellido',
        'telefono',
        'documento',
        'cargo',
        'activo',
    ];

    public function turnos(): HasMany
    {
        return $this->hasMany(Turno::class);
    }

    public function lavadosRecibidos(): HasMany
    {
        return $this->hasMany(Lavado::class, 'empleado_id');
    }

    public function lavadosAsignados(): HasMany
    {
        return $this->hasMany(Lavado::class, 'empleado_asignado_id');
    }
}