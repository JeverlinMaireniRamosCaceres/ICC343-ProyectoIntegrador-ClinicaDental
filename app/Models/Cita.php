<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{

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
        'medioRecordatorio',
        'recordatorioCorreoEnviadoAt',
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
