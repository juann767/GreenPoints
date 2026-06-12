<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Canje extends Model
{
    protected $fillable = [
        'user_id',
        'premio_id',
        'fecha_canje',
    ];

    protected $casts = ['fecha_canje' => 'datetime'];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function premio()
    {
        return $this->belongsTo(Premio::class);
    }
}
