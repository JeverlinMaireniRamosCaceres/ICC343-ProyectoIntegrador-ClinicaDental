{{-- Lista consultas --}}
@if ($consultas->count())
    <div class="d-flex flex-column gap-3" id="listaConsultas">
        @foreach ($consultas as $consulta)
            <a href="{{ route('consultas.show', $consulta->idConsulta) }}"
                class="consulta-item border rounded-4 p-3 bg-white text-decoration-none text-reset d-block consulta-link">

                <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">

                    <div>

                        <h6 class="fw-bold mb-1">
                            {{ $consulta->motivo ?: 'Sin motivo registrado' }}
                        </h6>

                        <span class="text-muted small">
                            {{ $consulta->odontologo->persona->nombre }}
                            {{ $consulta->odontologo->persona->apellido }}
                        </span>

                    </div>

                    <span class="badge rounded-pill px-3 py-2"
                        style="background-color: rgba(14,165,233,0.1); color: #0ea5e9;">

                        {{ \Carbon\Carbon::parse($consulta->fecha)->format('d/m/Y') }}

                    </span>

                </div>

                <div class="mt-2">

                    <span class="text-muted small fw-bold">
                        Diagnóstico
                    </span>

                    <p class="mb-0 mt-1 small">
                        {{ $consulta->diagnostico ?: 'Sin diagnóstico registrado.' }}
                    </p>

                </div>

            </a>
        @endforeach
    </div>
@else
    @if (request()->filled('buscar') ||
            request()->filled('doctor') ||
            request()->filled('desde') ||
            request()->filled('hasta'))
        <div class="text-center py-5">
            <i class="bi bi-search display-5 text-muted"></i>
            <h5 class="mt-3">Sin resultados</h5>
            <p class="text-muted mb-0">
                No se encontraron consultas con esos filtros.
            </p>
        </div>
    @else
        <div class="text-center py-5">
            <i class="bi bi-journal-medical display-5 text-muted"></i>
            <h5 class="mt-3">Historial clínico</h5>
            <p class="text-muted mb-0">
                No hay consultas registradas para este paciente.
            </p>
        </div>
    @endif

@endif
@if ($consultas->hasPages())
    <div class="mt-4 d-flex justify-content-center">
        {{ $consultas->links() }}
    </div>
@endif
