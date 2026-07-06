<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body style="margin: 0; padding: 0; background-color: #f4f5f7; font-family: Arial, Helvetica, sans-serif;">

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0"
        style="background-color: #f4f5f7; padding: 40px 0;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0"
                    style="max-width: 520px; background-color: #ffffff; border-radius: 8px; overflow: hidden;">

                    <!-- Header -->
                    <tr>
                        <td style="background-color: #0ea5e9; padding: 24px 32px;">
                            <span style="color: #ffffff; font-size: 20px; font-weight: bold;">
                                Clínica Dental Dr. Eddy Paulino
                            </span>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding: 32px;">
                            <p style="margin: 0 0 16px; color: #212529; font-size: 15px;">
                                Estimado(a) <strong>{{ $factura->consulta->paciente->persona->nombre }}
                                    {{ $factura->consulta->paciente->persona->apellido }}</strong>,
                            </p>

                            <p style="margin: 0 0 24px; color: #495057; font-size: 15px; line-height: 1.6;">
                                Adjuntamos la factura correspondiente a su consulta más reciente.
                                Puede encontrar todos los detalles en el documento PDF anexo a este correo.
                            </p>

                            <!-- Invoice summary box -->
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0"
                                style="background-color: #f8f9fa; border-radius: 8px; margin-bottom: 24px;">
                                <tr>
                                    <td style="padding: 16px 20px;">
                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td style="color: #6c757d; font-size: 13px; padding-bottom: 6px;">N.º de
                                                    factura</td>
                                                <td
                                                    style="color: #212529; font-size: 13px; text-align: right; padding-bottom: 6px;">
                                                    FAC-{{ str_pad($factura->idFactura, 6, '0', STR_PAD_LEFT) }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="color: #6c757d; font-size: 13px;">Total</td>
                                                <td
                                                    style="color: #212529; font-size: 15px; font-weight: bold; text-align: right;">
                                                    RD$ {{ number_format($factura->total, 2) }}
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin: 0; color: #495057; font-size: 15px;">
                                Gracias por confiar en nosotros.
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="padding: 20px 32px; background-color: #f8f9fa; text-align: center;">
                            <p style="margin: 0; color: #adb5bd; font-size: 12px;">
                                Este es un correo automático, por favor no responda a este mensaje.
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>

</body>

</html>
