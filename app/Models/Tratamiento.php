<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tratamiento extends Model
{
    use SoftDeletes;

    protected $table = 'tratamientos';

    protected $primaryKey = 'idTratamiento';

    protected $fillable = [
        'idPaciente',
        'nombre',
        'fechaInicio',
        'estado'
    ];

    public function paciente()
    {
        return $this->belongsTo(
            Paciente::class,
            'idPaciente',
            'idPaciente'
        );
    }

    public function detalles()
    {
        return $this->hasMany(
            DetalleTratamiento::class,
            'idTratamiento',
            'idTratamiento'
        );
    }
}
