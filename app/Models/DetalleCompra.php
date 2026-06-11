<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleCompra extends Model
{
    protected $table = 'detalle_compras';

    protected $primaryKey = 'idDetalleCompra';

    protected $fillable = [
        'idCompras',
        'idProducto',
        'cantidad',
        'costoTotal',
        'fechaVencimiento'
    ];

    public function producto()
    {
        return $this->belongsTo(
            Producto::class,
            'idProducto',
            'idProducto'
        );
    }

    public function compra()
    {
        return $this->belongsTo(Compra::class, 'idCompras', 'idCompras');
    }

}
