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
            margin-top: 4px;
            margin-bottom: 25px;
            color: #666;
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
            margin: 0 0 12px 0;
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

        .proveedores-titulo {
            margin-top: 10px;
            margin-bottom: 8px;
            font-weight: bold;
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

        .sin-proveedores {
            font-style: italic;
            color: #666;
            margin-top: 8px;
        }

        .firma {
            margin-top: 60px;
        }

        .linea {
            width: 250px;
            border-top: 1px solid #000;
            margin-top: 40px;
        }

        .texto-firma {
            margin-top: 5px;
            font-size: 10px;
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
                    Reporte de orden de compra
                </h2>

            </td>

        </tr>

    </table>

    <div class="fecha">
        <strong>Generado:</strong> {{ $fechaReporte }}
    </div>

    <div class="resumen">

        <p><strong>Total de productos a reabastecer:</strong> {{ $totalProductos }}</p>

        <p><strong>Productos con stock bajo:</strong> {{ $stockBajo }}</p>

        <p><strong>Productos sin stock:</strong> {{ $sinStock }}</p>

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
                    <td class="titulo">Cantidad a comprar</td>
                    <td colspan="3">
                        <strong>{{ $producto->cantidadComprar }}</strong>
                    </td>
                </tr>

            </table>

            <div class="proveedores-titulo">
                Historial de proveedores
            </div>

            @if($producto->proveedores->count())

                <table>

                    <thead>
                        <tr>
                            <th style="width:70%">Proveedor</th>
                            <th>Última compra</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($producto->proveedores as $proveedor)

                            <tr>

                                <td>{{ $proveedor->nombre }}</td>

                                <td>{{ $proveedor->fechaUltimaCompra }}</td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            @else

                <p class="sin-proveedores">
                    No existen proveedores registrados para este producto.
                </p>

            @endif

        </div>

    @endforeach


</body>

</html>