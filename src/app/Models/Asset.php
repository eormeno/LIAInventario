<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Asset extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre', 'codigo_inventario', 'codigo_patrimonio', 'detalle',
        'imagen', 'tipo', 'cantidad', 'alta', 'baja', 'observaciones', 'place_id',
    ];

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function getAltaAttribute($value)
    {
        return Carbon::parse($value);  // Esto convierte el valor a una instancia de Carbon
    }

    // Método para obtener 'baja' como una instancia de Carbon
    public function getBajaAttribute($value)
    {
        return $value ? Carbon::parse($value) : null;
    }

    public function place()
    {
        return $this->belongsTo(Place::class);
    }

}


