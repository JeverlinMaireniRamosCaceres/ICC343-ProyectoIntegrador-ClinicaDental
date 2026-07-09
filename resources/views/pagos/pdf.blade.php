<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Recibo de Pago</title>
    <style>
        @page {
            size: 8.5in 5.5in;
            margin: 20px 26px
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
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
            height: 120px
        }

        .factura-box {
            text-align: right
        }

        .badge {
            display: inline-block;
            background: #0F4C81;
            color: #fff;
            padding: 4px 14px;
            border-radius: 14px;
            font-weight: bold;
            font-size: 11px
        }

        .numero {
            font-size: 15px;
            font-weight: bold;
            margin: 5px 0 2px;
            color: #263238
        }

        .fecha {
            color: #666;
            font-size: 9px
        }

        .estado {
            display: inline-block;
            font-size: 8.5px;
            font-weight: bold;
            padding: 2px 8px;
            border-radius: 10px;
            margin-top: 3px;
            text-transform: uppercase
        }

        .estado-pagado {
            background: #e3f7e8;
            color: #1e7e34
        }

        .estado-pendiente {
            background: #fff3cd;
            color: #856404
        }

        .estado-vencido {
            background: #fde2e1;
            color: #b02a25
        }

        hr {
            border: none;
            border-top: 1.5px solid #0F4C81;
            margin: 8px 0
        }

        .contact {
            font-size: 8.5px;
            color: #6b7280;
            text-align: center;
            margin-top: 4px
        }

        .contact strong {
            color: #263238
        }

        .cards td {
            width: 50%;
            border: 1px solid #e5e7eb;
            border-left: 3px solid #0F4C81;
            border-radius: 4px;
            padding: 8px 11px;
            vertical-align: top;
            background: #fbfdff
        }

        .cards .spacer {
            width: 3%;
            border: none;
            background: none;
            padding: 0
        }

        .cards h3 {
            margin: 0 0 5px;
            color: #263238;
            font-size: 9.5px;
            text-transform: uppercase;
            letter-spacing: 0.4px
        }

        .cards p {
            margin: 2px 0
        }

        .cuotas {
            margin-top: 8px
        }

        .cuotas th {
            background: #eef2f7;
            color: #263238;
            padding: 5px 8px;
            font-size: 8.5px;
            text-transform: uppercase;
            text-align: left
        }

        .cuotas td {
            padding: 5px 8px;
            border-bottom: 1px solid #ececec;
            font-size: 9.5px
        }

        .right {
            text-align: right
        }

        .center {
            text-align: center
        }

        .monto-box {
            margin-top: 8px;
            color: #000000;
            border-radius: 4px;
            padding: 8px 14px
        }

        .monto-box .t {
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            opacity: 0.85;
            text-align: right;
        }

        .monto-box .m {
            font-size: 18px;
            font-weight: bold;
            margin-top: 2px;
            text-align: right;
        }

        .letras {
            margin-top: 6px;
            font-size: 9px;
            color: #444
        }

        .letras strong {
            color: #263238
        }

        .firma-row {
            margin-top: 14px
        }

        .firma-row td {
            width: 45%;
            text-align: center;
            vertical-align: bottom
        }

        .firma-linea {
            border-top: 1px solid #999;
            margin-bottom: 4px
        }

        .firma-label {
            font-size: 8.5px;
            color: #6b7280
        }

        .firma-nombre {
            font-size: 9px;
            font-weight: bold;
            margin-bottom: 2px
        }

        .footer {
            text-align: center;
            margin-top: 6px;
            color: #6b7280;
            font-size: 8.5px
        }
    </style>
</head>

<body>

    @php
        $primerPago = $pagos->first();
        $totalRecibido = $pagos->sum('monto');
    @endphp

    <table class="header">
        <tr>
            <td class="logo" width="55%">
                <img src="{{ public_path('images/logo.png') }}" alt="Logo">
            </td>
            <td class="factura-box" width="45%">
                <div class="badge">Recibo de Pago</div>
                <br><br>
                <div class="fecha">
                    Fecha:
                    {{ \Carbon\Carbon::parse($primerPago->fechaRealizacion ?? $primerPago->fechaVencimiento)->format('d/m/Y') }}
                </div>
                @if ($primerPago->estado)
                    <div class="estado estado-{{ \Illuminate\Support\Str::slug($primerPago->estado) }}">
                        {{ $primerPago->estado }}
                    </div>
                @endif
            </td>
        </tr>
    </table>

    <div class="contact">
        <strong>Tel:</strong> (809) 612-2003 &nbsp;•&nbsp;
        <strong>WhatsApp:</strong> (829) 707-9767 &nbsp;•&nbsp;
        Calle Principal Las Palomas, Licey Al Medio, Santiago, RD
    </div>

    <hr>

    <table class="cards">
        <tr>
            <td>
                <h3>Recibido de</h3>
                <p><strong>
                        {{ $factura->consulta->paciente->persona->nombre }}
                        {{ $factura->consulta->paciente->persona->apellido }}
                    </strong></p>
                <p>Cédula: {{ $factura->consulta->paciente->persona->cedula ?? 'N/A' }}</p>
            </td>
            <td class="spacer"></td>
            <td>
                <h3>Detalle del pago</h3>
                <p>Factura: FAC-{{ str_pad($factura->idFactura, 6, '0', STR_PAD_LEFT) }}</p>
                <p>Método de pago: {{ $primerPago->metodoPago->descripcion ?? 'N/A' }}</p>
                @if ($primerPago->referenciaPago)
                    <p>Referencia: {{ $primerPago->referenciaPago }}</p>
                @endif
            </td>
        </tr>
    </table>

    <!-- Cuotas cubiertas por este pago -->
    <table class="cuotas">
        <thead>
            <tr>
                <th>Cuota</th>
                <th>Vencimiento</th>
                <th class="right">Monto</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pagos as $p)
                <tr>
                    <td>{{ $p->numeroCuota ? 'Cuota ' . $p->numeroCuota : 'Pago único' }}</td>
                    <td>{{ \Carbon\Carbon::parse($p->fechaVencimiento)->format('d/m/Y') }}</td>
                    <td class="left">RD$ {{ number_format($p->monto, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="monto-box">
        <div class="t">Total recibido</div>
        <div class="m">RD$ {{ number_format($totalRecibido, 2) }}</div>
    </div>

    @if ($primerPago->observacion)
        <div class="letras"><strong>Observación:</strong> {{ $primerPago->observacion }}</div>
    @endif

    <table class="firma-row">
        <tr>
            <td>
                <div class="firma-nombre">
                    @if ($primerPago->usuario?->persona)
                        {{ $primerPago->usuario->persona->nombre }} {{ $primerPago->usuario->persona->apellido }}
                    @endif
                </div>
                <div class="firma-linea"></div>
                <div class="firma-label">Recibido por</div>
            </td>
            <td class="spacer" style="width:10%"></td>
            <td>
                <div class="firma-linea"></div>
                <div class="firma-label">Firma del paciente</div>
            </td>
        </tr>
    </table>

    <div class="footer">Gracias por confiar en nosotros — Tu sonrisa es nuestra prioridad.</div>

</body>

</html>
