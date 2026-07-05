<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #333;
            margin: 25px;
        }

        h1 {
            text-align: center;
            font-size: 20px;
            margin: 0;
        }

        h2 {
            text-align: center;
            font-size: 13px;
            font-weight: normal;
            color: #666;
            margin-top: 4px;
            margin-bottom: 25px;
        }

        .fecha {
            text-align: right;
            margin-bottom: 15px;
        }

        .resumen {
            border: 1px solid #cfcfcf;
            background: #f7f7f7;
            padding: 12px;
            margin-bottom: 25px;
        }

        .resumen p {
            margin: 4px 0;
        }

        .producto {
            border: 1px solid #bdbdbd;
            padding: 12px;
            margin-bottom: 20px;
            page-break-inside: avoid;
        }

        .producto h3 {
            margin: 0 0 12px;
            font-size: 14px;
            color: #222;
        }

        .info {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .info td {
            border: 1px solid #ddd;
            padding: 6px;
        }

        .info .titulo {
            background: #f1f1f1;
            font-weight: bold;
            width: 25%;
        }

        .titulo-lotes {
            font-weight: bold;
            margin-bottom: 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #ececec;
            border: 1px solid #cfcfcf;
            padding: 7px;
            text-align: left;
        }

        td {
            border: 1px solid #d9d9d9;
            padding: 7px;
        }

        .sin-lotes {
            font-style: italic;
            color: #666;
        }

        .info {
            table-layout: fixed;
        }

        .info td {
            word-wrap: break-word;
            overflow-wrap: break-word;
            vertical-align: middle;
        }

        .info .titulo {
            width: 25%;
        }

        .header {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }

        .header td {
            border: none;
            vertical-align: middle;
        }

        .logo img {
            height: 120px;
        }
    </style>

</head>

<body>

    <table class="header">

        <tr>

            <td class="logo">
                <img src="{{ public_path('images/logo.png') }}" alt="Logo">
            </td>

            <td style="text-align:right;">

                <h1 style="margin:0;">
                    Clínica Dental
                </h1>

                <h2 style="margin-top:4px;">
                    Reporte de Inventario
                </h2>

            </td>

        </tr>

    </table>

    <div class="fecha">
        <strong>Generado:</strong> {{ $fechaReporte }}
    </div>

    <div class="resumen">

        <p>
            <strong>Total de productos:</strong>
            {{ $totalProductos }}
        </p>

        <p>
            <strong>Productos con stock bajo:</strong>
            {{ $stockBajo }}
        </p>

        <p>
            <strong>Productos sin stock:</strong>
            {{ $sinStock }}
        </p>

    </div>

    @foreach($productos as $producto)

        <div class="producto">

            <h3>{{ $producto->nombre }}</h3>

            <table class="info">

                <tr>

                    <td class="titulo">Estado</td>
                    <td>{{ $producto->estadoStock }}</td>

                    <td class="titulo">Unidad</td>
                    <td>{{ $producto->unidadMedida }}</td>

                </tr>

                <tr>

                    <td class="titulo">Stock actual</td>
                    <td>{{ $producto->stockActual }}</td>

                    <td class="titulo">Stock mínimo</td>
                    <td>{{ $producto->stockMinimo }}</td>

                </tr>

                <tr>

                    <td class="titulo">Próximo vencimiento</td>

                    <td colspan="3">
                        {{ $producto->proximoVencimiento ?? 'No disponible' }}
                    </td>

                </tr>

            </table>

            <div class="titulo-lotes">
                Historial de lotes
            </div>

            @if($producto->detallesCompra->count())

                <table>

                    <thead>

                        <tr>

                            <th style="width:14%">Compra</th>

                            <th style="width:12%">Cantidad</th>

                            <th style="width:18%">Costo total</th>

                            <th style="width:20%">Vencimiento</th>

                            <th style="width:16%">Días restantes</th>

                            <th style="width:20%">Estado</th>

                        </tr>

                    </thead>

                    <tbody>

                        @foreach($producto->detallesCompra as $lote)

                            <tr>

                                <td>
                                    #{{ str_pad($lote->idCompras, 4, '0', STR_PAD_LEFT) }}
                                </td>

                                <td>
                                    {{ $lote->cantidad }}
                                </td>

                                <td>
                                    RD$ {{ number_format($lote->costoTotal, 2) }}
                                </td>

                                <td>
                                    {{ $lote->fechaVencimientoFormateada }}
                                </td>

                                <td>

                                    @if(is_null($lote->diasRestantes))

                                        N/A

                                    @elseif($lote->diasRestantes < 0)

                                        Hace {{ abs($lote->diasRestantes) }} días

                                    @elseif($lote->diasRestantes == 0)

                                        Hoy

                                    @elseif($lote->diasRestantes == 1)

                                        Mañana

                                    @else

                                        {{ $lote->diasRestantes }} días

                                    @endif

                                </td>

                                <td>
                                    {{ $lote->estadoLote }}
                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            @else

                <p class="sin-lotes">
                    No existen lotes registrados para este producto.
                </p>

            @endif

        </div>

    @endforeach

</body>

</html>