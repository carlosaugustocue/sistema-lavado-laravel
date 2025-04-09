<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluacion extends Model
{
    use HasFactory;
    
    protected $table = 'evaluaciones';
    
    protected $fillable = [
        'lavado_id',
        'tiempo_espera',
        'amabilidad',
        'calidad_servicio',
        'comentarios',
        'token',
        'completada'
    ];
    
    // Relación con lavado
    public function lavado()
    {
        return $this->belongsTo(Lavado::class);
    }
    
    // Método para generar token único
    public static function generarToken()
    {
        return md5(uniqid(rand(), true));
    }
    
    // Método para obtener promedio general
    public function getPromedioAttribute()
    {
        $suma = $this->tiempo_espera + $this->amabilidad + $this->calidad_servicio;
        $total = 3; // Número de criterios
        
        return round($suma / $total, 1);
    }
}