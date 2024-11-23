<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = ['subject', 'description', 'status', 'created_at', 'updated_at'];


    // Relación de Ticket con Logs
    public function logs()
    {
        return $this->hasMany(Log::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($ticket) {
            // Asigna el usuario autenticado al crear un ticket
            $ticket->created_by = Auth::id();
        });

        static::updating(function ($ticket) {
            // Asigna el usuario autenticado al actualizar un ticket
            $ticket->updated_by = Auth::id();
        });
    }

        public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

}

