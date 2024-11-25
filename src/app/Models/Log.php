<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon; // Para manejar fechas si es necesario

// 

class Log extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'ticket_id', 'estado', 'comentario', 'fecha',
        'telefono', 'email', 'direccion'
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

