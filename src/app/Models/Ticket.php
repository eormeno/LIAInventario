<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

// class Ticket extends Model
// {
//     use HasFactory;

//     // Campos asignables en la creación o actualización del modelo
//     protected $fillable = ['subject', 'description', 'status', 'created_by', 'updated_by'];

//     // Relación de Ticket con Logs
//     public function logs()
//     {
//         return $this->hasMany(Log::class);
//     }

//     // Relación con el creador del ticket
//     public function creator()
//     {
//         return $this->belongsTo(User::class, 'created_by');
//     }

//     // Relación con el usuario que actualizó el ticket
//     public function updater()
//     {
//         return $this->belongsTo(User::class, 'updated_by');
//     }

//     // Sobrescribir el método boot para manejar eventos del modelo
//     protected static function boot()
//     {
//         parent::boot();

//         // Antes de crear un ticket, asigna el usuario autenticado
//         static::creating(function ($ticket) {
//             $ticket->created_by = Auth::id();
//         });

//         // Antes de actualizar un ticket, asigna el usuario autenticado
//         static::updating(function ($ticket) {
//             $ticket->updated_by = Auth::id();
//         });

//         // Después de crear un ticket, crea automáticamente el log inicial
//         static::created(function ($ticket) {
//             $ticket->logs()->create([
//                 'user_id' => Auth::id(),
//                 'estado' => 'Creado', // Estado inicial del ticket
//                 'comentario' => 'Ticket creado automáticamente.',
//                 'fecha' => now(), // Asegúrate de que este campo exista en tu base de datos
//             ]);
//         });
//     }
// }

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = ['subject', 'created_by', 'asset_id'];

    public function logs()
    {
        return $this->hasMany(Log::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }
}



