<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleConsulta extends Model
{
    protected $table = 'detalle_consultas';

    protected $primaryKey = 'idDetalleConsulta';

    protected $fillable = [
        'idConsulta',
        'idProcedimiento',
        'idDetalleTratamiento',
        'cantidadProcedimiento',
        'subtotal',
    ];

    public function consulta()
    {
        return $this->belongsTo(
            Consulta::class,
            'idConsulta',
            'idConsulta'
        );
    }

    public function procedimiento()
    {
        return $this->belongsTo(
            Procedimiento::class,
            'idProcedimiento',
            'idProcedimiento'
        );
    }

    public function detalleTratamiento()
    {
        return $this->belongsTo(
            DetalleTratamiento::class,
            'idDetalleTratamiento',
            'idDetalleTratamiento'
        );
    }
}
