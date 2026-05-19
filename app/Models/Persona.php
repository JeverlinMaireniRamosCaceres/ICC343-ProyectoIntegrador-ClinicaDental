<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $table = 'personas';

    protected $primaryKey = 'idPersona';

    protected $fillable = [
        'cedula',
        'nombre',
        'apellido',
        'fechaNacimiento',
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
}