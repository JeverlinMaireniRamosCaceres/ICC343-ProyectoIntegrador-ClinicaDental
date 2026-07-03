<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Feliz cumpleaños</title>
</head>
<body style="font-family: Arial, Helvetica, sans-serif; background:#f5f5f5; padding:30px;">

<div style="max-width:600px; margin:auto; background:white; border-radius:10px; padding:30px;">

    <h1 style="color:#0d6efd;">
        🎉 ¡Feliz cumpleaños!
    </h1>

    <p>Hola <strong>{{ $persona->nombre }} {{ $persona->apellido }}</strong>.</p>

    <p>
        Todo el equipo de <strong>Clínica Dental</strong> te desea un excelente día.
    </p>

    <p>
        Esperamos que disfrutes mucho este cumpleaños y que tengas un año lleno de salud y felicidad.
    </p>

    <hr>

    <p style="font-size:14px;color:#777;">
        Clínica Dental
    </p>

</div>

</body>
</html>