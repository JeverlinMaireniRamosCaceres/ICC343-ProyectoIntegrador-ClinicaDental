<div class="modal fade" id="modalConsultas" tabindex="-1" aria-hidden="true" data-bs-backdrop="static"
    data-bs-keyboard="false">

    <div class="modal-dialog modal-lg modal-dialog-centered">

        <div class="modal-content border-0 shadow rounded-4">

            <div class="modal-header border-0 pb-0">

                <div class="d-flex align-items-center gap-2">

                    <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center"
                        style="width:42px;height:42px;">

                        <i class="bi bi-receipt text-primary"></i>

                    </div>

                    <div>

                        <h5 class="fw-bold mb-0">
                            Seleccionar consulta
                        </h5>

                        <small class="text-muted">
                            Consultas pendientes de facturar
                        </small>

                    </div>

                </div>

            </div>

            <div class="modal-body pt-4">

                <div class="row g-3 mb-4">

                    <div class="col-md-8">

                        <div class="position-relative">

                            <i
                                class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>

                            <input type="text" id="buscarConsulta" class="form-control rounded-pill ps-5"
                                placeholder="Buscar por paciente...">

                        </div>

                    </div>

                    <div class="col-md-4">

                        <input type="date" id="fechaConsulta" class="form-control rounded-pill"
                            value="{{ $fecha }}">

                    </div>

                </div>

                <div class="border rounded-4 overflow-hidden">

                    <div style="height:430px;overflow-y:auto;">

                        <table class="table table-hover-custom align-middle mb-0">

                            <thead class="table-light sticky-top">

                                <tr>

                                    <th style="width:18%">
                                        Fecha
                                    </th>

                                    <th style="width:42%">
                                        Paciente
                                    </th>

                                    <th style="width:40%">
                                        Odontólogo
                                    </th>

                                </tr>

                            </thead>

                            <tbody id="tablaConsultas">

                                @include('facturacion.partials.tabla-consultas', [
                                    'consultas' => $consultas,
                                    'fecha' => $fecha,
                                ])

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

            <div class="modal-footer border-0">

                @if ($consulta)
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">

                        Cancelar

                    </button>
                @else
                    <a href="{{ $return }}" class="btn btn-light rounded-pill px-4">

                        Cancelar

                    </a>
                @endif

            </div>

        </div>

    </div>

</div>

<style>
    .fila-consulta {
        cursor: pointer;
        transition: background-color .15s ease;
    }

    .fila-consulta:hover {
        background-color: #f1f7ff !important;
    }

    .sticky-top {
        z-index: 2;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        const buscador = document.getElementById('buscarConsulta');
        const fecha = document.getElementById('fechaConsulta');
        const tabla = document.getElementById('tablaConsultas');

        let timeout;

        async function cargarConsultas() {

            try {

                const url = new URL('{{ route('facturacion.consultas') }}', window.location.origin);

                url.searchParams.set('fecha', fecha.value);
                url.searchParams.set('buscar', buscador.value);
                url.searchParams.set('return', '{{ $return }}');

                const response = await fetch(url);

                tabla.innerHTML = await response.text();

            } catch (e) {

                console.error(e);

                tabla.innerHTML = `
                <tr>
                    <td colspan="3" class="text-center py-5 text-danger">
                        Error al cargar las consultas.
                    </td>
                </tr>
            `;

            }

        }

        buscador.addEventListener('input', function() {

            clearTimeout(timeout);

            timeout = setTimeout(cargarConsultas, 300);

        });

        fecha.addEventListener('change', cargarConsultas);

    });
</script>
