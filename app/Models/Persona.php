<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Persona extends Model
{
    use softDeletes;

    protected $table = 'personas';

    protected $primaryKey = 'idPersona';

    protected $fillable = [
        'cedula',
        'nombre',
        'apellido',
        'fechaNacimiento',
        'sexo',
        'telefono',
        'correo'
    ];

    // relacion con odontologo
    public function odontologo()
    {
        return $this->hasOne(
            Odontologo::class,
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
}
