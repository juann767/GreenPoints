<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'role_id',
        'nombre',
        'email',
        'password',
        'puntos',
        'avatar',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = ['password' => 'hashed'];

    // Relaciones
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function registrosAcciones()
    {
        return $this->hasMany(RegistroAccion::class, 'user_id');
    }

    public function canjes()
    {
        return $this->hasMany(Canje::class, 'user_id');
    }

    // Helper
    public function esAdmin(): bool
    {
        return $this->role?->nombre === 'admin';
    }
}
