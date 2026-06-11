<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Especialidad extends Model
{
    protected $table = 'especialidades';

    protected $primaryKey = 'idEspecialidad';

    public $incrementing = true;

    protected $keyType = 'int';

    protected $fillable = [
        'nombre'
    ];

    public function odontologos()
    {
        return $this->belongsToMany(
            Odontologo::class,
            'odontologo_especialidad',
            'idEspecialidad',
            'idOdontologo'
        );
    }
}
