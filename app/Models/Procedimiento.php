<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Procedimiento extends Model
{
    use SoftDeletes;
    
    protected $table = 'procedimientos';

    protected $primaryKey = 'idProcedimiento';

    public $incrementing = true;

    protected $keyType = 'int';

    protected $fillable = [
        'nombre',
        'precio'
    ];
}
