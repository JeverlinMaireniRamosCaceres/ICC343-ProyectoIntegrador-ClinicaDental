<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Consulta extends Model
{
    use SoftDeletes;

    protected $table = 'consultas';
    protected $primaryKey = 'idConsulta';

    protected $fillable = [
        'idPaciente',
        'idOdontologo',
        'fecha',
        'motivo',
        'diagnostico',
        'receta',
        'estado',
    ];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'idPaciente', 'idPaciente');
    }

    public function odontologo()
    {
        return $this->belongsTo(Odontologo::class, 'idOdontologo', 'idOdontologo');
    }

    public function detallesTratamiento()
    {
        return $this->hasMany(DetalleTratamiento::class, 'idConsulta', 'idConsulta');
    }
}