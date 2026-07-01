<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovimientoInventario extends Model
{
    protected $table = 'movimientos_inventario';

    protected $primaryKey = 'idMovimiento';

    protected $fillable = [
        'idProducto',
        'tipo',
        'cantidad',
        'motivo',
        'idConsulta',
        'idProcedimiento'
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'idProducto', 'idProducto');
    }

    public function consulta()
    {
        return $this->belongsTo(Consulta::class, 'idConsulta', 'idConsulta');
    }

    public function procedimiento()
    {
        return $this->belongsTo(Procedimiento::class, 'idProcedimiento', 'idProcedimiento');
    }
}
