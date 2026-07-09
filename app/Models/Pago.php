<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pago extends Model
{
    use SoftDeletes;

    protected $table = 'pagos';

    protected $primaryKey = 'idPago';

    protected $fillable = [
        'idFactura',
        'idMetodoPago',
        'codigoRecibo',
        'idUsuario',
        'fechaVencimiento',
        'monto',
        'numeroCuota',
        'fechaRealizacion',
        'referenciaPago',
        'observacion',
        'estado',
    ];

    protected $casts = [
        'fechaVencimiento' => 'date',
        'fechaRealizacion' => 'date',
        'monto' => 'decimal:2',
    ];

    public function factura()
    {
        return $this->belongsTo(Factura::class, 'idFactura', 'idFactura');
    }

    public function metodoPago()
    {
        return $this->belongsTo(MetodoPago::class, 'idMetodoPago', 'idMetodoPago');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'idUsuario', 'idUsuario');
    }

    public function getEstadoVisualAttribute()
    {
        if (
            $this->estado === 'Pendiente' &&
            $this->fechaVencimiento < now()->toDateString()
        ) {
            return 'Vencido';
        }

        return $this->estado;
    }
}
