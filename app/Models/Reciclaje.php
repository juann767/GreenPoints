<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Reciclaje extends Model
{
    protected $fillable = [
        'dispositivo_id',
        'user_id',
        'codigo_usado',
        'tipo_material',
        'peso_kg',
        'cantidad',
        'foto',
        'nombre',
        'apellido',
        'correo',
        'telefono',
        'puntos',
        'codigo_canje',
        'codigo_canje_usado',
    ];

    protected $casts = [
        'codigo_canje_usado' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::creating(function (Reciclaje $reciclaje) {
            if (empty($reciclaje->codigo_canje)) {
                $reciclaje->codigo_canje = strtoupper(Str::random(8));
            }
            if (empty($reciclaje->puntos)) {
                $reciclaje->puntos = rand(15, 60);
            }
        });
    }

    public function dispositivo()
    {
        return $this->belongsTo(Dispositivo::class);
    }

    public function usuario()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}
