<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegistroAccion extends Model
{
    protected $table = 'registros_acciones';

    protected $fillable = [
        'user_id',
        'accion_id',
        'dispositivo_id',
        'cantidad_kg',
        'fecha',
        'observaciones',
    ];

    protected $casts = [
        'fecha' => 'datetime',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function accion()
    {
        return $this->belongsTo(AccionEcologica::class, 'accion_id');
    }

    public function dispositivo()
    {
        return $this->belongsTo(Dispositivo::class, 'dispositivo_id');
    }
}
