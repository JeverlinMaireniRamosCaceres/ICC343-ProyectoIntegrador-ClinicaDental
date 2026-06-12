<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">

    <style>

        body{
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #000;
            margin: 20px;
        }

        h1{
            font-size: 18px;
            margin-bottom: 5px;
        }

        h2{
            font-size: 14px;
            margin-bottom: 10px;
        }

        .fecha{
            margin-bottom: 20px;
        }

        .resumen{
            margin-bottom: 25px;
        }

        .resumen p{
            margin: 4px 0;
        }

        .producto{
            margin-bottom: 25px;
            page-break-inside: avoid;
        }

        .producto-info{
            margin-bottom: 10px;
        }

        .producto-info p{
            margin: 3px 0;
        }

        table{
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td{
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
        }

        th{
            font-weight: bold;
        }

        .sin-lotes{
            font-style: italic;
            margin-top: 10px;
        }

        hr{
            margin: 20px 0;
        }

    </style>
</head>
<body>

    <h1>Reporte de inventario</h1>

    <div class="fecha">
        Generado el: {{ $fechaReporte }}
    </div>

    <div class="resumen">

        <h2>Resumen general</h2>

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

            <h2>{{ $producto->nombre }}</h2>

            <div class="producto-info">

                <p>
                    <strong>Stock actual:</strong>
                    {{ $producto->stockActual }}
                </p>

                <p>
                    <strong>Stock mínimo:</strong>
                    {{ $producto->stockMinimo }}
                </p>

                <p>
                    <strong>Estado:</strong>
                    {{ $producto->estadoStock }}
                </p>

                <p>
                    <strong>Próximo vencimiento:</strong>
                    {{ $producto->proximoVencimiento ?? 'N/A' }}
                </p>

            </div>

            @if($producto->detallesCompra->count())

                <table>

                    <thead>
                        <tr>
                            <th>Compra</th>
                            <th>Cantidad</th>
                            <th>Costo total</th>
                            <th>Vencimiento</th>
                            <th>Estado</th>
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
                                    {{ $lote->estadoLote }}
                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            @else

                <p class="sin-lotes">
                    Este producto no tiene lotes registrados.
                </p>

            @endif

        </div>

        @if(!$loop->last)
            <hr>
        @endif

    @endforeach

</body>
</html>