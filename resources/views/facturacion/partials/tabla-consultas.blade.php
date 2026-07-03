@forelse($consultas as $consulta)
    <tr class="fila-consulta"
        onclick="window.location='{{ route('facturacion.create', [
            'consulta' => $consulta->idConsulta,
            'fecha' => $fecha,
            'return' => request('return'),
        ]) }}'">

        <td>
            {{ \Carbon\Carbon::parse($consulta->fecha)->format('d/m/Y') }}
        </td>

        <td>
            {{ $consulta->paciente->persona->nombre }}
            {{ $consulta->paciente->persona->apellido }}
        </td>

        <td>
            {{ $consulta->odontologo->persona->nombre }}
            {{ $consulta->odontologo->persona->apellido }}
        </td>

    </tr>

@empty

    <tr>

        <td colspan="3" class="text-center py-5 text-muted">

            No hay consultas pendientes.

        </td>

    </tr>
@endforelse
