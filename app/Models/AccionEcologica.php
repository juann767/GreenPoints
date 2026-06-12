<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccionEcologica extends Model
{
    protected $table = 'acciones_ecologicas';

    protected $fillable = [
        'nombre',
        'descripcion',
        'puntos_otorgados',
        'imagen',
    ];

    public function registros()
    {
        return $this->hasMany(RegistroAccion::class, 'accion_id');
    }
}
