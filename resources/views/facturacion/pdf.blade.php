<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Factura #{{ $factura->idFactura }}</title>
    <style>
        @page {
            margin: 32px
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #263238
        }

        * {
            box-sizing: border-box
        }

        table {
            border-collapse: collapse;
            width: 100%
        }

        .header td {
            vertical-align: middle
        }

        .logo img {
            height: 200px
        }

        .factura-box {
            text-align: right
        }

        .badge {
            display: inline-block;
            background: #0F4C81;
            color: #fff;
            padding: 8px 20px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 14px
        }

        .numero {
            font-size: 26px;
            font-weight: bold;
            margin: 10px 0;
            color: #263238
        }

        .fecha {
            color: #666
        }

        hr {
            border: none;
            border-top: 2px solid #0F4C81;
            margin: 18px 0
        }

        .contact td {
            width: 33.33%;
            padding: 10px;
            border: 1px solid #e8edf5;
            background: #f8fbff
        }

        .contact .t {
            font-size: 10px;
            color: #6b7280;
            text-transform: uppercase
        }

        .contact .v {
            font-weight: bold;
            margin-top: 3px
        }

        .address {
            margin-top: 8px;
            border: 1px solid #e8edf5;
            background: #f8fbff;
            padding: 10px;
            font-size: 11px
        }

        .address .t {
            font-size: 10px;
            color: #6b7280;
            text-transform: uppercase
        }

        .address .v {
            font-weight: bold;
            margin-top: 3px
        }

        .cards td {
            width: 50%;
            border: 1px solid #e5e7eb;
            border-left: 3px solid #0F4C81;
            border-radius: 4px;
            padding: 14px;
            vertical-align: top;
            background: #fbfdff
        }

        .cards td:first-child {
            margin-right: 3%
        }

        .cards .spacer {
            width: 3%;
            border: none;
            background: none;
            padding: 0
        }

        .cards h3 {
            margin: 0 0 10px;
            color: #263238;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.4px
        }

        .details {
            margin-top: 20px
        }

        .details th {
            background: #eef2f7;
            color: #263238;
            padding: 10px;
            font-size: 11px;
            text-transform: uppercase;
            text-align: left
        }

        .details td {
            padding: 10px;
            border-bottom: 1px solid #ececec
        }

        .center {
            text-align: center
        }

        .right {
            text-align: right
        }

        .totals {
            width: 42%;
            margin-left: auto;
            margin-top: 20px
        }

        .totals td {
            padding: 10px;
            border-bottom: 1px solid #eee;
            color: #555
        }

        .total-row td {
            background: #0F4C81;
            color: #fff;
            font-weight: bold;
            font-size: 15px;
            border-bottom: none
        }

        .footer {
            text-align: center;
            margin-top: 70px;
            color: #6b7280
        }

        .footer h4 {
            margin: 0;
            color: #0F4C81
        }
    </style>
</head>

<body>

    <table class="header">
        <tr>
            <td class="logo" width="85%">
                <img src="{{ public_path('images/logo.png') }}" alt="Logo">
            </td>
            <td class="factura-box" width="45%">
                <div class="badge">Factura</div>
                <div class="numero">FAC-{{ str_pad($factura->idFactura, 6, '0', STR_PAD_LEFT) }}</div>
                <div class="text-left">
                    Fecha de emisión
                    <div class="fecha">{{ \Carbon\Carbon::parse($factura->consulta->fecha)->format('d/m/Y') }}
                    </div>
                </div>
            </td>
        </tr>
    </table>

    <table class="contact">
        <tr>
            <td>
                <div class="t">Teléfono</div>
                <div class="v">(809) 612-2003</div>
            </td>
            <td>
                <div class="t">WhatsApp</div>
                <div class="v">(829) 707-9767</div>
            </td>
            <td>
                <div class="t">Instagram</div>
                <div class="v">@eddypaulinoorto</div>
            </td>
        </tr>
    </table>

    <div class="address">
        <div class="t">Dirección</div>
        <div class="v">Calle Principal Las Palomas, Licey Al Medio, Santiago, República Dominicana</div>
    </div>

    <hr>

    <table class="cards">
        <tr>
            <td>
                <h3>Datos del paciente</h3>
                <strong>{{ $factura->consulta->paciente->persona->nombre }}
                    {{ $factura->consulta->paciente->persona->apellido }}</strong><br><br>
                Cédula: {{ $factura->consulta->paciente->persona->cedula ?? 'N/A' }}<br>
                Teléfono: {{ $factura->consulta->paciente->persona->telefono }}
            </td>
            <td class="spacer"></td>
            <td>
                <h3>Odontólogo</h3>
                <strong>
                    {{ $factura->consulta->odontologo->persona->sexo === 'Femenino' ? 'Dra.' : 'Dr.' }}
                    {{ $factura->consulta->odontologo->persona->nombre }}
                    {{ $factura->consulta->odontologo->persona->apellido }}
                </strong>
            </td>
        </tr>
    </table>

    <table class="details">
        <thead>
            <tr>
                <th>Procedimiento</th>
                <th width="90" style="text-align: center;">Cantidad</th>
                <th width="120">Precio</th>
                <th width="120">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @php($subtotal = 0)
            @foreach ($factura->consulta->detalles as $detalle)
                @php($subtotal += $detalle->subtotal)
                <tr>
                    <td>{{ $detalle->procedimiento->nombre }}</td>
                    <td class="center">{{ $detalle->cantidadProcedimiento }}</td>
                    <td>RD$ {{ number_format($detalle->procedimiento->precio, 2) }}</td>
                    <td>RD$ {{ number_format($detalle->subtotal, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table class="totals">
        <tr>
            <td>Subtotal</td>
            <td class="right">RD$ {{ number_format($subtotal, 2) }}</td>
        </tr>

        @if ($factura->tipoDescuento === 'Monto')
            <tr>
                <td>Descuento</td>
                <td class="right">RD$ {{ number_format($factura->montoDescuento, 2) }}</td>
            </tr>
        @elseif($factura->tipoDescuento === 'Porcentaje')
            <tr>
                <td>Descuento</td>
                <td class="right">{{ number_format($factura->porcentajeDescuento, 2) }} %</td>
            </tr>
        @endif

        <tr class="total-row">
            <td>TOTAL</td>
            <td class="right">RD$ {{ number_format($factura->total, 2) }}</td>
        </tr>
    </table>

    <div class="footer">
        <h4>Gracias por confiar en nosotros</h4>
        <div>Tu sonrisa es nuestra prioridad.</div>
    </div>

</body>

</html>
