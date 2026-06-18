<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Paciente extends Model
{
    use SoftDeletes;

    protected $table = 'pacientes';

    protected $primaryKey = 'idPaciente';

    protected $fillable = [
        'idPersona',
        'antecedentes'
    ];

    // relacion con persona
    public function persona()
    {
        return $this->hasOne(
            Persona::class,
            'idPersona',
            'idPersona'
        );
    }
}
