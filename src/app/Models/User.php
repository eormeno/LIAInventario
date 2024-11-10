<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Laravel\Jetstream\HasProfilePhoto;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Intervention\Image\Laravel\Facades\Image;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable {
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_photo',
        'registro',
        'apellidos',
        'nombres',
        'cuil',
        'nacimiento',
        'telefono',
        'domicilio',
        'area',
        'coordinador',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Obtiene la URL de la foto de perfil del usuario (en formato base64).
     *
     * @return string
     */
    public function getProfilePhotoUrlAttribute(): string {
        // Si el usuario tiene una foto de perfil en base64, devuélvela.
        if ($this->profile_photo) {
            return 'data:image/png;base64,' . $this->profile_photo;
        }
        // Si no tiene foto de perfil, genera una imagen predeterminada con Image::canvas.
        $image = Image::canvas(200, 200, '#ccc'); // Fondo gris claro
        $image64 = $image->encode('data-url');

        return $image64;
    }
}
