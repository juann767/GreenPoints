<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dispositivo extends Model
{
    protected $fillable = [
        'nombre',
        'ubicacion',
        'descripcion',
        'imagen',
        'estado',
        'latitud',
        'longitud',
    ];

    protected $casts = [
        'latitud'  => 'float',
        'longitud' => 'float',
    ];

    public function registros()
    {
        return $this->hasMany(RegistroAccion::class, 'dispositivo_id');
    }

    // Helper: tiene coordenadas válidas
    public function tieneCoordenadas(): bool
    {
        return !is_null($this->latitud) && !is_null($this->longitud);
    }
}
