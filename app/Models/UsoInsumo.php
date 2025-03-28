<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UsoInsumo extends Model
{
    use HasFactory;

    protected $table = 'uso_insumos';

    protected $fillable = [
        'lavado_id',
        'insumo_id',
        'cantidad',
    ];

    public function lavado(): BelongsTo
    {
        return $this->belongsTo(Lavado::class);
    }

    public function insumo(): BelongsTo
    {
        return $this->belongsTo(Insumo::class);
    }
}