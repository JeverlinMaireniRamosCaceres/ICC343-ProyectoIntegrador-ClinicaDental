<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Model;

class ProductoProcedimiento extends Model
{
    protected $table = 'producto_procedimiento';

    public $incrementing = false;

    protected $fillable = [
        'idProducto',
        'idProcedimiento',
        'cantidad',
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'idProducto', 'idProducto');
    }

    public function procedimiento()
    {
        return $this->belongsTo(Procedimiento::class, 'idProcedimiento', 'idProcedimiento');
    }
}