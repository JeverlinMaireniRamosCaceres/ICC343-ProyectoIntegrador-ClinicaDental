<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ajuste extends Model
{
    protected $table = 'ajustes';
    protected $primaryKey = 'idAjuste';

    protected $fillable = [
        'idProducto',
        'idUsuario',
        'stockAnterior',
        'stockNuevo',
        'motivo',
        'observacion',
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'idProducto', 'idProducto');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'idUsuario', 'idUsuario');
    }
}