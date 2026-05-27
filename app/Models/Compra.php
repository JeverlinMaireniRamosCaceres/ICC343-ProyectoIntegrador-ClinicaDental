<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    protected $table = 'compras';

    protected $primaryKey = 'idCompras';

    protected $fillable = [
        'idProveedor',
        'fecha',
        'monto',
        'estado'
    ];

    /*public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'idProveedor', 'idProveedor');
    }*/
}
