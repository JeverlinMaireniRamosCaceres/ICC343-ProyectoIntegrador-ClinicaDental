<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Odontologo extends Model
{
    use SoftDeletes;

    protected $table = 'odontologos';

    protected $primaryKey = 'idOdontologo';

    protected $fillable = [
        'idPersona',
        'exequatur'
    ];

    // relacion con persona
    public function persona()
    {
        return $this->belongsTo(
            Persona::class,
            'idPersona',
            'idPersona'
        );
    }

    // relacion con usuario
    public function usuario()
    {
        return $this->hasOne(
            Usuario::class,
            'idPersona',
            'idPersona'
        );
    }

    //relacion con especialidades
    public function especialidades()
    {
        return $this->belongsToMany(
            Especialidad::class,
            'odontologo_especialidad',
            'idOdontologo',
            'idEspecialidad'
        );
    }
}
