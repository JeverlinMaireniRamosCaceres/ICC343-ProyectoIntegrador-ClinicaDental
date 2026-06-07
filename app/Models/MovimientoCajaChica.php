<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovimientoCajaChica extends Model
{
    protected $table = 'movimiento_caja_chicas';

    protected $primaryKey = 'idMovimientoCajaChica';

    protected $fillable = [
        'idUsuario',
        'idCajaChica',
        'hora',
        'monto',
        'tipo',
        'descripcion'
    ];

    public function caja()
    {
        return $this->belongsTo(
            CajaChica::class,
            'idCajaChica',
            'idCajaChica'
        );
    }

    public function usuario()
    {
        return $this->belongsTo(
            Usuario::class,
            'idUsuario',
            'idUsuario'
        );
    }
}
