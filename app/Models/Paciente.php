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

    //relacion con alergias
    public function alergias()
    {
        return $this->belongsToMany(
            Alergia::class,
            'paciente_alergia',
            'idPaciente',
            'idAlergia'
        )->withTimestamps();
    }

    public function tratamientos()
    {
        return $this->hasMany(
            Tratamiento::class,
            'idPaciente',
            'idPaciente'
        );
    }

    public function consultas()
    {
        return $this->hasMany(
            Consulta::class,
            'idPaciente',
            'idPaciente'
        );
    }
}
