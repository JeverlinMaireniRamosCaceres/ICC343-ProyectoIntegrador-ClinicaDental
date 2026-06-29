document.addEventListener('DOMContentLoaded', function () {

    // buscador de consultas
    const buscar = document.getElementById('buscarConsulta');

    if (buscar) {
        buscar.addEventListener('keyup', async function () {

            const texto = this.value;

            const porPagina = document.getElementById('porPagina').value;

            const response = await fetch(
                `/consultas?buscar=${encodeURIComponent(texto)}&porPagina=${porPagina}`,
                {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                }
            );

            document.getElementById('contenedorTablaConsultas').innerHTML = await response.text();

        });
    }

    // paginacion de consultas
    document.addEventListener('click', async function (e) {
        const link = e.target.closest('.pagination a');
        if (!link) return;
        e.preventDefault();
        const response = await fetch(link.href, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });
        document.getElementById('contenedorTablaConsultas').innerHTML = await response.text();
    });

    document.addEventListener('change', async function (e) {

        if (e.target.id !== 'porPagina') return;

        const buscar = document.getElementById('buscarConsulta').value;

        const response = await fetch(
            `/consultas?buscar=${encodeURIComponent(buscar)}&porPagina=${e.target.value}`,
            {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            }
        );

        document.getElementById('contenedorTablaConsultas').innerHTML = await response.text();

    });

    // buscador de pacientes

    const inputPaciente = document.getElementById('paciente_nombre');
    const resultadosPacientes = document.getElementById('resultadosPacientes');
    const pacienteId = document.getElementById('paciente_id');

    if (!inputPaciente) return;

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

    };

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

        bootstrap.Modal.getInstance(
            document.getElementById('modalAgregarProcedimiento')
        ).hide();
    });

    // agregar fila a la tabla
    function agregarProcedimiento(id, nombre, precio) {
        const tbody = document.getElementById('cuerpoTablaProc');
        const filaVacia = document.getElementById('filaVaciaProc');

        // evitar duplicados
        if (document.querySelector(`tr[data-proc-id="${id}"]`)) return;

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

    // actualizar subtotal por fila cuando cambia la cantidad
    document.addEventListener('input', function (e) {
        if (!e.target.classList.contains('input-cantidad')) return;
        actualizarSubtotales();
    });

    // eliminar fila
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

    function actualizarSubtotales() {
        let total = 0;

        document.querySelectorAll('#cuerpoTablaProc tr[data-proc-id]').forEach(fila => {
            const cantidad = parseInt(fila.querySelector('.input-cantidad').value) || 1;
            const precio = parseFloat(fila.querySelector('.input-cantidad').getAttribute('data-precio'));
            const subtotal = cantidad * precio;

            fila.querySelector('.subtotal').textContent =
                'RD$ ' + subtotal.toLocaleString('es-DO', { minimumFractionDigits: 2 });

            total += subtotal;
        });

        const totalEl = document.getElementById('totalProcedimientos');
        if (totalEl) {
            totalEl.textContent = 'RD$ ' + total.toLocaleString('es-DO', { minimumFractionDigits: 2 });
        }
    }

    // cuando se abre el modal de tratamiento, cargar el nombre del paciente
    document.getElementById('modalCrearTratamiento')?.addEventListener('show.bs.modal', function () {
        const nombrePaciente = document.getElementById('paciente_nombre').value;
        document.getElementById('tratamientoPacienteNombre').value = nombrePaciente || '';
    });

    // guardar tratamiento via AJAX
    document.getElementById('btnGuardarTratamiento')?.addEventListener('click', async function () {
        const idPaciente = document.getElementById('paciente_id').value;
        const nombre = document.getElementById('tratamientoNombre').value.trim();
        const fechaInicio = document.getElementById('tratamientoFechaInicio').value;
        const estado = document.getElementById('tratamientoEstado').value;

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
            body: JSON.stringify({ idPaciente, nombre, fechaInicio, estado })
        });

        const data = await response.json();

        if (data.success) {
            // cerrar modal
            bootstrap.Modal.getInstance(
                document.getElementById('modalCrearTratamiento')
            ).hide();

            // agregar el nuevo tratamiento a la lista sin recargar
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

            // limpiar campos
            document.getElementById('tratamientoNombre').value = '';
        }
    });


});

window.seleccionarTratamiento = function (el, id) {
    // quitar selección anterior
    document.querySelectorAll('.tratamiento-item').forEach(item => {
        item.style.border = '2px solid #e2e8f0';
        item.style.background = '';
    });

    // marcar el seleccionado
    el.style.border = '2px solid #0ea5e9';
    el.style.background = '#f0f9ff';

    document.getElementById('tratamiento_id').value = id;
};