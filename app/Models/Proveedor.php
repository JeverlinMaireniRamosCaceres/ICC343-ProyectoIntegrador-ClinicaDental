<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{

    use SoftDeletes;

    protected $table = 'proveedores';

    protected $primaryKey = 'idProveedor';

    protected $fillable = [
        'nombre',
        'correo',
        'telefono',
        'estado'
    ];
}