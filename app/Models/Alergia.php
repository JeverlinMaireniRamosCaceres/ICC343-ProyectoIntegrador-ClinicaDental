<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alergia extends Model
{
    protected $table = 'alergias';

    protected $primaryKey = 'idAlergia';

    public $incrementing = true;

    protected $keyType = 'int';

    protected $fillable = [
        'nombre'
    ];
}
