<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MetodoPago extends Model
{
    protected $table = 'metodo_pagos';

    protected $primaryKey = 'idMetodoPago';

    protected $fillable = [
        'descripcion',
    ];

    public function pagos()
    {
        return $this->hasMany(Pago::class, 'idMetodoPago', 'idMetodoPago');
    }
}
