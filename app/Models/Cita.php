<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cita extends Model
{
    use SoftDeletes;

    protected $table = 'citas';
    protected $primaryKey = 'idCita';

    protected $fillable = [
        'idUsuarioRegistro',
        'idOdontologo',
        'fecha',
        'hora',
        'nombrePersona',
        'telefono',
        'correo',
        'estado',
        'recordatorioWhatsappEnviado',
        'recordatorioWhatsappEnviadoAt',
        'whatsappMessageId',
    ];

    public function odontologo()
    {
        return $this->belongsTo(Odontologo::class, 'idOdontologo', 'idOdontologo');
    }

    public function usuarioRegistro()
    {
        return $this->belongsTo(Usuario::class, 'idUsuarioRegistro', 'idUsuario');
    }
}
