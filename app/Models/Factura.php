<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Factura extends Model
{
    use SoftDeletes;

    protected $table = 'facturas';

    protected $primaryKey = 'idFactura';

    protected $fillable = [
        'idConsulta',
        'total',
        'cantidadCuotas',
        'tipoDescuento',
        'montoDescuento',
        'porcentajeDescuento',
        'estado',
    ];

    protected $casts = [
        'total' => 'decimal:2',
        'montoDescuento' => 'decimal:2',
        'porcentajeDescuento' => 'decimal:2',
    ];

    public function consulta()
    {
        return $this->belongsTo(Consulta::class, 'idConsulta', 'idConsulta');
    }

    public function getTienePagosRealizadosAttribute()
    {
        return $this->pagos()
            ->where('estado', 'Pagado')
            ->exists();
    }

    public function pagos()
    {
        return $this->hasMany(Pago::class, 'idFactura', 'idFactura');
    }

    public function getTotalPagadoAttribute()
    {
        return $this->pagos()
            ->where('estado', 'Pagado')
            ->sum('monto');
    }

    public function getSaldoPendienteAttribute()
    {
        return $this->total - $this->total_pagado;
    }
}
