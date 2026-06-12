<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Premio extends Model
{
    protected $fillable = [
        'nombre',
        'descripcion',
        'puntos_requeridos',
        'imagen',
        'stock',
        'activo',
    ];

    protected $casts = ['activo' => 'boolean'];

    public function canjes()
    {
        return $this->hasMany(Canje::class);
    }
}
