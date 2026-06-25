<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleTratamiento extends Model
{
    protected $table = 'detalle_tratamientos';

    protected $primaryKey = 'idDetalleTratamiento';

    protected $fillable = [
        'idConsulta',
        'idTratamiento',
        'idProcedimiento',
        'cantidadProcedimiento',
        'observacion',
        'estado'
    ];

    public function tratamiento()
    {
        return $this->belongsTo(
            Tratamiento::class,
            'idTratamiento',
            'idTratamiento'
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
}
