<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// class Asset extends Model
// {
//     use HasFactory;

//     // Agrega los campos que pueden ser llenados por asignación masiva
//     protected $fillable = [
//         'nombre',
//         'codigo_inventario',
//         'codigo_patrimonio',
//         'detalle',
//         'imagen',
//         'tipo',
//         'cantidad',
//         'alta',
//         'observaciones',
//     ];

//     protected $casts = [
//         'alta' => 'date',
//         'baja' => 'date',
//     ];
// }
use Carbon\Carbon;
class Asset extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre', 'codigo_inventario', 'codigo_patrimonio', 'detalle',
        'imagen', 'tipo', 'cantidad', 'alta', 'observaciones'
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
}


