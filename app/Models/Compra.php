<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Compra extends Model
{
    use softDeletes;

    protected $table = 'compras';

    protected $primaryKey = 'idCompras';

    protected $casts = [
        'fecha' => 'date',
    ];

    protected $fillable = [
        'idProveedor',
        'fecha',
        'monto',
        'estado'
    ];

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'idProveedor', 'idProveedor');
    }
}
