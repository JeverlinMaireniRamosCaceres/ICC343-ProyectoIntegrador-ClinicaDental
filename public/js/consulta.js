let destinoProcedimiento = 'independiente';

document.addEventListener('DOMContentLoaded', function () {

    // buscador de consultas
    const buscar = document.getElementById('buscarConsulta');
    const porPagina = document.getElementById('porPagina');
    const fechaDesde = document.getElementById('filtroFechaDesde');
    const fechaHasta = document.getElementById('filtroFechaHasta');

    async function cargarConsultas(url = null) {

        const params = new URLSearchParams();

        params.append('buscar', buscar?.value || '');
        params.append('porPagina', porPagina?.value || 10);
        params.append('fecha_desde', fechaDesde?.value || '');
        params.append('fecha_hasta', fechaHasta?.value || '');

        const ruta = url || `/consultas?${params.toString()}`;

        const response = await fetch(ruta, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        document.getElementById('contenedorTablaConsultas').innerHTML =
            await response.text();
    }

    // buscador
    let timeout;

    buscar?.addEventListener('input', () => {

        clearTimeout(timeout);

        timeout = setTimeout(() => {
            cargarConsultas();
        }, 300);

    });

    // cambiar cantidad por página
    porPagina?.addEventListener('change', () => {
        cargarConsultas();
    });

    // filtro fecha desde
    fechaDesde?.addEventListener('change', () => {
        cargarConsultas();
    });

    // filtro fecha hasta
    fechaHasta?.addEventListener('change', () => {
        cargarConsultas();
    });

    // paginación
    document.addEventListener('click', function (e) {

        const link = e.target.closest('.pagination a');

        if (!link) return;

        e.preventDefault();

        cargarConsultas(link.href);

    });

    // buscador de pacientes (solo existe en create) 
    const inputPaciente = document.getElementById('paciente_nombre');
    const resultadosPacientes = document.getElementById('resultadosPacientes');
    const pacienteId = document.getElementById('paciente_id');

    if (inputPaciente) {

        inputPaciente.addEventListener('keyup', async function () {
            const texto = this.value;

            if (texto.length < 2) {
                resultadosPacientes.innerHTML = '';
                return;
            }

            const response = await fetch(
                `/consultas/buscar-pacientes?texto=${encodeURIComponent(texto)}`
            );

            const pacientes = await response.json();

            resultadosPacientes.innerHTML = '';

            pacientes.forEach(paciente => {
                resultadosPacientes.innerHTML += `
                    <button type="button"
                        class="list-group-item list-group-item-action"
                        onclick="seleccionarPaciente(
                            ${paciente.idPaciente},
                            '${paciente.persona.nombre} ${paciente.persona.apellido}'
                        )">
                        ${paciente.persona.nombre} ${paciente.persona.apellido}
                    </button>
                `;
            });
        });

        window.seleccionarPaciente = async function (id, nombre) {
            inputPaciente.value = nombre;
            pacienteId.value = id;
            resultadosPacientes.innerHTML = '';

            const response = await fetch(`/consultas/paciente-alergias/${id}`);
            const data = await response.json();

            // alergias
            const contenedor = document.getElementById('contenedorAlergias');
            const lista = document.getElementById('listaAlergias');

            if (data.alergias.length > 0) {
                contenedor.style.display = 'block';
                lista.style.background = '#fdecea';
                lista.style.border = '1px solid #f5c2c7';
                lista.innerHTML = data.alergias.map(a => `
                    <span class="badge rounded-pill px-3 py-2"
                        style="background:#fee2e2; color:#991b1b; font-size:13px;">
                        <i class="bi bi-exclamation-triangle-fill me-1"></i>
                        ${a.nombre}
                    </span>
                `).join('');
            } else {
                contenedor.style.display = 'block';
                lista.style.background = '#f8fafc';
                lista.style.border = '1px solid #e2e8f0';
                lista.innerHTML = `<span class="text-muted small">Sin alergias registradas</span>`;
            }

            // antecedentes
            const contenedorAnt = document.getElementById('contenedorAntecedentes');
            const textoAnt = document.getElementById('textoAntecedentes');

            if (contenedorAnt && textoAnt) {
                contenedorAnt.style.display = 'block';
                textoAnt.textContent = data.antecedentes ?? 'Sin antecedentes registrados';
            }

            // cargar tratamientos
            const respTrat = await fetch(`/consultas/paciente-tratamientos/${id}`);
            const tratamientos = await respTrat.json();

            const sinPaciente = document.getElementById('tratamientoSinPaciente');
            const contenidoTrat = document.getElementById('tratamientoContenido');
            const vacioTrat = document.getElementById('tratamientoVacio');
            const listaTrat = document.getElementById('listaTratamientos');

            sinPaciente.style.display = 'none';
            contenidoTrat.style.display = 'block';

            if (tratamientos.length === 0) {
                vacioTrat.style.display = 'block';
                listaTrat.innerHTML = '';
            } else {
                vacioTrat.style.display = 'none';
                listaTrat.innerHTML = tratamientos.map(t => `
                    <div class="d-flex align-items-center justify-content-between p-3 rounded-4 tratamiento-item"
                        style="border: 2px solid #e2e8f0; cursor:pointer; transition: all 0.2s;"
                        data-id="${t.idTratamiento}"
                        onclick="seleccionarTratamiento(this, ${t.idTratamiento})">
                        <div>
                            <p class="fw-semibold mb-0">${t.nombre}</p>
                            <small class="text-muted">Desde: ${t.fechaInicio}</small>
                        </div>
                        <span class="badge rounded-pill px-3 py-2 bg-success-subtle text-success">
                            ${t.estado}
                        </span>
                    </div>
                `).join('');
            }

            const resumenPac = document.getElementById('resumenPaciente');
            if (resumenPac) resumenPac.textContent = nombre;
        };

    }


    function agregarProcedimiento(id, nombre, precio) {

        if (destinoProcedimiento === 'tratamiento') {

            agregarProcedimientoTratamiento(id, nombre, precio);

        } else if (destinoProcedimiento === 'planTratamiento') {

            agregarProcedimientoPlanTratamiento(id, nombre, precio);

        } else {

            agregarProcedimientoIndependiente(id, nombre, precio);

        }


        const modalAgregar = bootstrap.Modal.getInstance(
            document.getElementById('modalAgregarProcedimiento')
        );

        modalAgregar.hide();

    }

    // buscador dentro del modal de procedimientos
    const buscarProc = document.getElementById('buscarProcedimiento');
    if (buscarProc) {
        buscarProc.addEventListener('keyup', function () {
            const texto = this.value.toLowerCase();
            document.querySelectorAll('.item-procedimiento').forEach(item => {
                const nombre = item.getAttribute('data-nombre').toLowerCase();
                item.style.display = nombre.includes(texto) ? '' : 'none';
            });
        });
    }

    // seleccionar procedimiento del modal
    document.addEventListener('click', function (e) {
        const item = e.target.closest('.item-procedimiento');
        if (!item) return;

        const id = item.getAttribute('data-id');
        const nombre = item.getAttribute('data-nombre');
        const precio = parseFloat(item.getAttribute('data-precio'));

        agregarProcedimiento(id, nombre, precio);
    });

    // agregar fila a la tabla de procedimientos independientes
    function agregarProcedimientoIndependiente(id, nombre, precio) {
        const tbody = document.getElementById('cuerpoTablaProc');
        const filaVacia = document.getElementById('filaVaciaProc');

        if (document.querySelector(`#cuerpoTablaProc tr[data-proc-id="${id}"]`)) return;

        if (filaVacia) filaVacia.remove();

        const fila = document.createElement('tr');
        fila.setAttribute('data-proc-id', id);
        fila.innerHTML = `
            <td class="fw-medium">${nombre}
                <input type="hidden" name="idProcedimiento[]" value="${id}">
            </td>
            <td width="130">
                <input type="number" name="cantidadProcedimiento[]"
                    class="form-control consulta-input input-cantidad"
                    value="1" min="1"
                    data-precio="${precio}">
            </td>
            <td>RD$ ${Number(precio).toLocaleString('es-DO', { minimumFractionDigits: 2 })}</td>
            <td class="fw-semibold subtotal">
                RD$ ${Number(precio).toLocaleString('es-DO', { minimumFractionDigits: 2 })}
            </td>
            <td class="text-center">
                <button type="button" class="btn btn-sm btn-danger rounded-pill px-3 btn-eliminar-proc">
                    <i class="bi bi-x-lg"></i>
                </button>
            </td>
        `;

        tbody.appendChild(fila);
        actualizarSubtotales();
    }

    // agregar fila a la tabla de procedimientos del tratamiento
    function agregarProcedimientoTratamiento(id, nombre, precio) {
        const tbody = document.getElementById('cuerpoProcTratamiento');
        const filaVacia = document.getElementById('filaVaciaTrat');

        if (document.querySelector(`#cuerpoProcTratamiento tr[data-proc-id="${id}"]`)) return;

        if (filaVacia) filaVacia.remove();

        const fila = document.createElement('tr');
        fila.setAttribute('data-proc-id', id);
        fila.innerHTML = `
            <td class="fw-medium">${nombre}
                <input type="hidden" name="idProcedimientoTrat[]" value="${id}">
            </td>
            <td width="130">
                <input type="number" name="cantidadProcedimientoTrat[]"
                    class="form-control consulta-input input-cantidad-trat"
                    value="1" min="1" data-precio="${precio}">
            </td>
            <td>RD$ ${Number(precio).toLocaleString('es-DO', { minimumFractionDigits: 2 })}</td>
            <td class="fw-semibold subtotal-trat">
                RD$ ${Number(precio).toLocaleString('es-DO', { minimumFractionDigits: 2 })}
            </td>
            <td>
                <input type="text" name="observacionTrat[]"
                    class="form-control consulta-input"
                    placeholder="Observación...">
            </td>
            <td class="text-center">
                <button type="button" class="btn btn-sm btn-danger rounded-pill px-3 btn-eliminar-proc-trat">
                    <i class="bi bi-x-lg"></i>
                </button>
            </td>
        `;

        tbody.appendChild(fila);
        actualizarSubtotales();
    }

    // agregar fila a la tabla de procedimientos del plan de tratamiento
    function agregarProcedimientoPlanTratamiento(id, nombre, precio) {

        const tbody = document.getElementById('cuerpoPlanTratamiento');
        const filaVacia = document.getElementById('filaVaciaPlan');

        if (document.querySelector(`#cuerpoPlanTratamiento tr[data-proc-id="${id}"]`)) return;

        if (filaVacia) filaVacia.remove();

        const fila = document.createElement('tr');
        fila.setAttribute('data-proc-id', id);

        fila.innerHTML = `
        <td class="fw-medium">
            ${nombre}
            <input type="hidden" name="idProcedimientoPlan[]" value="${id}">
        </td>

        <td width="130">
        <input
            type="number"
            name="cantidadProcedimientoPlan[]"
            class="form-control consulta-input input-cantidad-plan"
            value="1"
            min="1"
            data-precio="${precio}">
        </td>

        <td>
            <input
                type="text"
                name="observacionPlan[]"
                class="form-control consulta-input"
                placeholder="Observación...">
        </td>

        <td class="text-center">
            <button
                type="button"
                class="btn btn-sm btn-danger rounded-pill px-3 btn-eliminar-plan">
                <i class="bi bi-x-lg"></i>
            </button>
        </td>
    `;

        tbody.appendChild(fila);
        actualizarTotalPlanTratamiento();
    }

    // actualizar total del plan de tratamiento
    function actualizarTotalPlanTratamiento() {

        let total = 0;

        document.querySelectorAll('#cuerpoPlanTratamiento tr[data-proc-id]').forEach(fila => {

            const cantidad = parseInt(
                fila.querySelector('.input-cantidad-plan').value
            ) || 1;

            const precio = parseFloat(
                fila.querySelector('.input-cantidad-plan').dataset.precio
            ) || 0;

            total += cantidad * precio;
        });

        document.getElementById('totalPlanTratamiento').textContent =
            `RD$ ${total.toLocaleString('es-DO', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            })}`;
    }

    // actualizar subtotal cuando cambia la cantidad (independientes)
    document.addEventListener('input', function (e) {
        if (!e.target.classList.contains('input-cantidad')) return;
        actualizarSubtotales();
    });

    // actualizar subtotal cuando cambia la cantidad (tratamiento)
    document.addEventListener('input', function (e) {
        if (!e.target.classList.contains('input-cantidad-trat')) return;
        actualizarSubtotales();
    });

    // eliminar fila independiente
    document.addEventListener('click', function (e) {
        const btn = e.target.closest('.btn-eliminar-proc');
        if (!btn) return;
        btn.closest('tr').remove();

        actualizarSubtotales();

        const tbody = document.getElementById('cuerpoTablaProc');
        if (tbody.querySelectorAll('tr').length === 0) {
            tbody.innerHTML = `
                <tr id="filaVaciaProc">
                    <td colspan="5" class="text-center py-4 text-muted">
                        <i class="bi bi-clipboard2-x fs-3 d-block mb-2"></i>
                        No hay procedimientos agregados.
                    </td>
                </tr>
            `;
        }
    });

    // eliminar fila del tratamiento
    document.addEventListener('click', function (e) {
        const btn = e.target.closest('.btn-eliminar-proc-trat');
        if (!btn) return;
        btn.closest('tr').remove();

        actualizarSubtotales();

        const tbody = document.getElementById('cuerpoProcTratamiento');
        if (tbody.querySelectorAll('tr').length === 0) {
            tbody.innerHTML = `
                <tr id="filaVaciaTrat">
                    <td colspan="6" class="text-center py-4 text-muted">
                        <i class="bi bi-clipboard2-x fs-3 d-block mb-2"></i>
                        No hay procedimientos del tratamiento.
                    </td>
                </tr>
            `;
        }
    });

    // eliminar fila del plan de tratamiento
    document.addEventListener('click', function (e) {
        const btn = e.target.closest('.btn-eliminar-plan');
        if (!btn) return;

        btn.closest('tr').remove();
        actualizarTotalPlanTratamiento();

        const tbody = document.getElementById('cuerpoPlanTratamiento');

        if (tbody.querySelectorAll('tr').length === 0) {
            tbody.innerHTML = `
            <tr id="filaVaciaPlan">
                <td colspan="4" class="text-center text-muted">
                    No hay procedimientos agregados.
                </td>
            </tr>
        `;
        }
    });

    document.addEventListener('input', function (e) {

        if (e.target.classList.contains('input-cantidad-plan')) {
            actualizarTotalPlanTratamiento();
        }

    });

    // toggle entre tipo de procedimientos
    document.querySelectorAll('.btn-tipo-proc').forEach(btn => {
        btn.addEventListener('click', function () {
            document.querySelectorAll('.btn-tipo-proc').forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            const tipo = this.dataset.tipo;
            document.getElementById('seccionProcIndependientes').style.display =
                tipo === 'independiente' ? 'block' : 'none';
            document.getElementById('seccionProcTratamiento').style.display =
                tipo === 'tratamiento' ? 'block' : 'none';
        });
    });

    // cuando se abre el modal de tratamiento, cargar el nombre del paciente
    document.getElementById('modalCrearTratamiento')?.addEventListener('show.bs.modal', function () {
        const nombreEl = document.getElementById('paciente_nombre');
        const nombrePaciente = nombreEl ? nombreEl.value : '';
        document.getElementById('tratamientoPacienteNombre').value = nombrePaciente || '';
    });

    // guardar tratamiento via AJAX
    document.getElementById('btnGuardarTratamiento')?.addEventListener('click', async function () {
        const idPaciente = document.getElementById('paciente_id').value;
        const nombre = document.getElementById('tratamientoNombre').value.trim();
        const fechaInicio = document.getElementById('tratamientoFechaInicio').value;
        const estado = document.getElementById('tratamientoEstado').value;

        const procedimientos = [];

        document.querySelectorAll('#cuerpoPlanTratamiento tr[data-proc-id]')
            .forEach(fila => {

                procedimientos.push({
                    idProcedimiento: fila.dataset.procId,
                    cantidad: fila.querySelector('[name="cantidadProcedimientoPlan[]"]').value,
                    observacion: fila.querySelector('[name="observacionPlan[]"]').value
                });

            });


        if (!idPaciente) {
            alert('Debes seleccionar un paciente primero.');
            return;
        }

        if (!nombre) {
            alert('El nombre del tratamiento es obligatorio.');
            return;
        }

        const response = await fetch('/tratamientos', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest',
            },
            body: JSON.stringify({ idPaciente, nombre, fechaInicio, estado, procedimientos })
        });

        const data = await response.json();

        if (data.success) {
            bootstrap.Modal.getInstance(
                document.getElementById('modalCrearTratamiento')
            ).hide();

            const listaTrat = document.getElementById('listaTratamientos');
            const vacioTrat = document.getElementById('tratamientoVacio');

            if (vacioTrat) vacioTrat.style.display = 'none';

            listaTrat.innerHTML += `
                <div class="d-flex align-items-center justify-content-between p-3 rounded-4 tratamiento-item"
                    style="border: 2px solid #e2e8f0; cursor:pointer; transition: all 0.2s;"
                    data-id="${data.tratamiento.idTratamiento}"
                    onclick="seleccionarTratamiento(this, ${data.tratamiento.idTratamiento})">
                    <div>
                        <p class="fw-semibold mb-0">${data.tratamiento.nombre}</p>
                        <small class="text-muted">Desde: ${data.tratamiento.fechaInicio}</small>
                    </div>
                    <span class="badge rounded-pill px-3 py-2 bg-success-subtle text-success">
                        ${data.tratamiento.estado}
                    </span>
                </div>
            `;

            document.getElementById('tratamientoNombre').value = '';
        }
    });

    // detectar a qué tabla destina el modal de agregar procedimiento
    document.querySelectorAll('[data-bs-target="#modalAgregarProcedimiento"]').forEach(btn => {
        btn.addEventListener('click', function () {
            destinoProcedimiento = this.dataset.destino || 'independiente';
        });
    });

    // actualizar subtotales
    function actualizarSubtotales() {

        let totalIndependientes = 0;
        let totalTrat = 0;

        // Procedimientos independientes
        document.querySelectorAll('#cuerpoTablaProc tr[data-proc-id]').forEach(fila => {

            const cantidad = parseInt(fila.querySelector('.input-cantidad').value) || 1;
            const precio = parseFloat(
                fila.querySelector('.input-cantidad').getAttribute('data-precio')
            );

            const subtotal = cantidad * precio;

            fila.querySelector('.subtotal').textContent =
                'RD$ ' + subtotal.toLocaleString('es-DO', {
                    minimumFractionDigits: 2
                });

            totalIndependientes += subtotal;
        });

        // Procedimientos del tratamiento
        document.querySelectorAll(
            '#cuerpoProcTratamiento .proc-checkbox:checked:not(:disabled)'
        ).forEach(check => {

            const fila = check.closest('tr');

            const cantidad = parseInt(fila.dataset.cantidad);
            const precio = parseFloat(fila.dataset.precio);

            const subtotal = cantidad * precio;

            totalTrat += subtotal;
        });

        // Total de procedimientos independientes
        const totalEl = document.getElementById('totalProcedimientos');
        if (totalEl) {
            totalEl.textContent =
                'RD$ ' + totalIndependientes.toLocaleString('es-DO', {
                    minimumFractionDigits: 2
                });
        }

        // Total de procedimientos del tratamiento
        const totalTratEl = document.getElementById('totalProcTratamiento');
        if (totalTratEl) {
            totalTratEl.textContent =
                'RD$ ' + totalTrat.toLocaleString('es-DO', {
                    minimumFractionDigits: 2
                });
        }

        // Resumen
        const filas = document.querySelectorAll('#cuerpoTablaProc tr[data-proc-id]');
        const filasTrat = document.querySelectorAll(
            '#cuerpoProcTratamiento .proc-checkbox:checked:not(:disabled)'
        );

        const resumenProc = document.getElementById('resumenProcedimientos');
        if (resumenProc) {
            resumenProc.textContent = filas.length + filasTrat.length;
        }

        const totalGeneral = totalIndependientes + totalTrat;

        const resumenTotal = document.getElementById('resumenTotal');
        if (resumenTotal) {
            resumenTotal.textContent =
                'RD$ ' + totalGeneral.toLocaleString('es-DO', {
                    minimumFractionDigits: 2
                });
        }
    }

    window.seleccionarTratamiento = function (el, id) {

        document.querySelectorAll('.tratamiento-item').forEach(item => {
            item.style.border = '2px solid #e2e8f0';
            item.style.background = '';
        });

        el.style.border = '2px solid #0ea5e9';
        el.style.background = '#f0f9ff';


        document.getElementById('tratamiento_id').value = id;


        document.getElementById('procTratSinTratamiento').style.display = 'none';
        document.getElementById('procTratConTratamiento').style.display = 'block';


        cargarProcedimientosTratamiento(id);

    };

    function cargarProcedimientosTratamiento(id) {

        console.log("Cargando procedimientos del tratamiento:", id);

        fetch(`/tratamientos/${id}/procedimientos`)
            .then(response => response.json())
            .then(procedimientos => {

                console.log(procedimientos);

                const tbody = document.getElementById('cuerpoProcTratamiento');

                tbody.innerHTML = '';

                procedimientos.forEach(proc => {

                    tbody.innerHTML += `

                <tr
                    data-precio="${proc.procedimiento.precio}"
                    data-cantidad="${proc.cantidadProcedimiento}">

                    <td>
                        ${proc.procedimiento.nombre}
                    </td>

                    <td>
                        ${proc.cantidadProcedimiento}
                    </td>

                    <td>
                        <span class="badge ${proc.estado === 'Realizado'
                            ? 'bg-success'
                            : 'bg-warning'
                        }">
                            ${proc.estado}
                        </span>
                    </td>

                    <td>
                        ${proc.observacion ?? '-'}
                    </td>

                    <td class="text-center">

                    <input
                        type="checkbox"
                        class="form-check-input proc-checkbox"
                        name="procedimientos_realizados[]"
                        value="${proc.idDetalleTratamiento}"
                        ${proc.estado === 'Realizado' ? 'checked disabled' : ''}>

                    </td>

                </tr>

                `;

                });

                document.querySelectorAll('.proc-checkbox').forEach(check => {
                    check.addEventListener('change', actualizarSubtotales);
                });

                actualizarSubtotales();

            });

    }

});

window.abrirAgregarProcedimiento = function (destino) {

    destinoProcedimiento = destino;

    const modalElemento = document.getElementById('modalAgregarProcedimiento');

    const modal = new bootstrap.Modal(modalElemento);

    modalElemento.style.zIndex = "1060";

    modal.show();

    setTimeout(() => {

        const backdrop = document.querySelector('.modal-backdrop:last-child');

        if (backdrop) {
            backdrop.style.zIndex = "1055";
        }

    }, 100);
};
