<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'ticket',
        'estado',
        'imagen',
        'comentario',
        'fecha',
        'telefono',
        'email',
        'direccion',
    ];

    // Relación con Ticket
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}