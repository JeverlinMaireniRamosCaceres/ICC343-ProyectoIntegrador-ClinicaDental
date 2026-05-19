<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Odontologo extends Model
{
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
}