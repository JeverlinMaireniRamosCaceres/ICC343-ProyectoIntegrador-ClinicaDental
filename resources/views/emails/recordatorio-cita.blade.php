<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recordatorio de cita</title>
</head>
<body style="font-family: Arial, Helvetica, sans-serif; background:#f5f5f5; padding:30px;">

<div style="max-width:600px; margin:auto; background:white; border-radius:10px; padding:30px;">

    <h1 style="color:#198754;">
        📅 Recordatorio de cita
    </h1>

    <p>
        Hola <strong>{{ $cita->nombrePersona }}</strong>.
    </p>

    <p>
        Este es un recordatorio de que tienes una cita programada para mañana.
    </p>

    <table style="width:100%; border-collapse:collapse;">

        <tr>
            <td><strong>Fecha:</strong></td>
            <td>{{ \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') }}</td>
        </tr>

        <tr>
            <td><strong>Hora:</strong></td>
            <td>{{ $cita->hora }}</td>
        </tr>

        <tr>
            <td><strong>Odontólogo:</strong></td>
            <td>
                Dr(a).
                {{ $cita->odontologo->persona->nombre }}
                {{ $cita->odontologo->persona->apellido }}
            </td>
        </tr>

    </table>

    <br>

    <p>
        Si necesitas reprogramar tu cita, comunícate con la clínica.
    </p>

    <hr>

    <p style="font-size:14px;color:#777;">
        Clínica Dental
    </p>

</div>

</body>
</html>