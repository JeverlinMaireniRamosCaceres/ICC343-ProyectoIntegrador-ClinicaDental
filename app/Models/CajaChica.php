<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CajaChica extends Model
{
    protected $table = 'caja_chicas';

    protected $primaryKey = 'idCajaChica';

    protected $fillable = [
        'idUsuarioApertura',
        'fecha',
        'horaApertura',
        'monto',
        'saldoInicial',
        'estado',
        'horaCierre',
        'diferencia'
    ];

    public function usuarioApertura()
    {
        return $this->belongsTo(
            Usuario::class,
            'idUsuarioApertura',
            'idUsuario'
        );
    }

    protected $casts = [
        'fecha' => 'date',
        'horaApertura' => 'datetime:H:i:s',
        'horaCierre' => 'datetime:H:i:s',
    ];
}
