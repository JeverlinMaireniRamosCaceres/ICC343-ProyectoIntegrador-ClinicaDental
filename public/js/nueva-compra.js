const detalleBody = document.getElementById("detalleBody");
const btnAgregarFila = document.getElementById("btnAgregarFila");

// AGREGAR FILA

btnAgregarFila.addEventListener("click", () => {
    let fila = `
                <tr>

                    <td>
                        <input type="text"
                        class="form-control form-control-sm producto-input"
                        placeholder="Buscar producto..."
                        readonly
                        data-bs-toggle="modal"
                        data-bs-target="#modalProductos">

                        <input type="hidden" name="idProducto[]" class="id-producto">
                    </td>

                    <td>
                        <input type="number"
                        class="form-control form-control-sm cantidad"
                        min="1"
                        step="1"
                        value="1"
                        name="cantidad[]">
                    </td>

                    <td class="unidad-producto text-center text-muted">
                        -
                    </td>

                    <td>
                        <input type="number"
                        class="form-control form-control-sm costo-total"
                        min="0"
                        step="0.01"
                        value="0"
                        name="costoTotal[]">
                    </td>

                    <td>
                        <input type="date"
                        class="form-control form-control-sm"
                        name="fechaVencimiento[]">
                    </td>

                    <td class="text-center">
                        <button type="button"
                        class="btn btn-sm btn-danger rounded-pill px-3 btnEliminarFila">
                        <i class="bi bi-trash"></i>
                        </button>
                    </td>

                </tr>
            `;

    detalleBody.insertAdjacentHTML("beforeend", fila);

    actualizarMontoTotal();
});

// ELIMINAR FILA

detalleBody.addEventListener("click", function (e) {
    if (e.target.closest(".btnEliminarFila")) {
        const fila = e.target.closest("tr");

        if (detalleBody.rows.length > 1) {
            fila.remove();
            actualizarMontoTotal();
            actualizarEstadoProductos();
        }
    }
});

// BUSCAR PROVEEDOR

const buscarProveedor = document.getElementById("buscarProveedor");

buscarProveedor.addEventListener("keyup", function () {
    const texto = this.value.toLowerCase();

    const filas = document.querySelectorAll(
        "#tablaProveedores tr:not(#sinResultados)",
    );

    let encontrados = 0;

    filas.forEach((fila) => {
        const nombre = fila.children[0].textContent.toLowerCase();

        if (nombre.includes(texto)) {
            fila.style.display = "";
            encontrados++;
        } else {
            fila.style.display = "none";
        }
    });

    document.getElementById("sinResultados").style.display =
        encontrados === 0 ? "" : "none";
});

// SELECCIONAR PROVEEDOR

document.addEventListener("click", function (e) {
    const btn = e.target.closest(".btnSeleccionarProveedor");

    if (!btn) return;

    document.getElementById("idProveedor").value = btn.dataset.id;

    document.getElementById("nombreProveedor").value = btn.dataset.nombre;

    bootstrap.Modal.getInstance(
        document.getElementById("modalProveedores"),
    ).hide();
});

const modalProveedores = document.getElementById("modalProveedores");

// AL MOSTRAR EL MODAL, ACTUALIZAR ESTILO DE LOS BOTONES
modalProveedores.addEventListener("show.bs.modal", function () {
    const idSeleccionado = document.getElementById("idProveedor").value;

    document.querySelectorAll(".btnSeleccionarProveedor").forEach((btn) => {
        if (btn.dataset.id === idSeleccionado) {
            btn.classList.remove("btn-primary");
            btn.classList.add("btn-success");

            btn.innerHTML = '<i class="bi bi-check-circle-fill"></i>';
        } else {
            btn.classList.remove("btn-success");
            btn.classList.add("btn-primary");

            btn.innerHTML = '<i class="bi bi-check-lg"></i>';
        }
    });
});

// BUSCAR PRODUCTO

const buscarProducto = document.getElementById("buscarProducto");

buscarProducto.addEventListener("keyup", function () {
    const texto = this.value.toLowerCase();

    const filas = document.querySelectorAll(
        "#tablaProductos tr:not(#sinResultadosProductos)",
    );

    let encontrados = 0;

    filas.forEach((fila) => {
        const nombre = fila.children[0].textContent.toLowerCase();

        if (nombre.includes(texto)) {
            fila.style.display = "";
            encontrados++;
        } else {
            fila.style.display = "none";
        }
    });

    document.getElementById("sinResultadosProductos").style.display =
        encontrados === 0 ? "" : "none";
});

let filaProductoActual = null;
let productoSeleccionadoActual = null;

function actualizarEstadoProductos() {
    const productosSeleccionados = [];

    document.querySelectorAll(".id-producto").forEach((input) => {
        if (input.value) {
            productosSeleccionados.push(input.value);
        }
    });

    document.querySelectorAll(".btnSeleccionarProducto").forEach((btn) => {
        const idActual = filaProductoActual
            ?.closest("td")
            ?.querySelector(".id-producto")?.value;

        if (
            productosSeleccionados.includes(btn.dataset.id) &&
            btn.dataset.id !== idActual
        ) {
            btn.disabled = true;

            btn.classList.remove("btn-primary", "btn-success");
            btn.classList.add("btn-secondary");

            btn.innerHTML = '<i class="bi bi-ban"></i>';
        } else {
            btn.disabled = false;
        }
    });
}

document.addEventListener("click", function (e) {
    const input = e.target.closest(".producto-input");

    if (!input) return;

    filaProductoActual = input;

    actualizarEstadoProductos();

    productoSeleccionadoActual = input
        .closest("td")
        .querySelector(".id-producto").value;

    document.querySelectorAll(".btnSeleccionarProducto").forEach((btn) => {
        if (btn.dataset.id === productoSeleccionadoActual) {
            btn.classList.remove("btn-primary");
            btn.classList.add("btn-success");

            btn.innerHTML = '<i class="bi bi-check-circle-fill"></i>';
        } else {
            btn.classList.remove("btn-success");
            btn.classList.add("btn-primary");

            btn.innerHTML = '<i class="bi bi-check-lg"></i>';
        }
    });
});

document.addEventListener("click", function (e) {
    const btn = e.target.closest(".btnSeleccionarProducto");

    if (!btn) return;

    document.querySelectorAll(".btnSeleccionarProducto").forEach((b) => {
        b.classList.remove("btn-success");
        b.classList.add("btn-primary");

        b.innerHTML = '<i class="bi bi-check-lg"></i>';
    });

    btn.classList.remove("btn-primary");
    btn.classList.add("btn-success");

    btn.innerHTML = '<i class="bi bi-check-circle-fill"></i>';

    if (filaProductoActual) {
        filaProductoActual.value = btn.dataset.nombre;

        const fila = filaProductoActual.closest("tr");

        fila.querySelector(".id-producto").value = btn.dataset.id;

        fila.querySelector(".unidad-producto").textContent = btn.dataset.unidad;

        actualizarEstadoProductos();
    }

    bootstrap.Modal.getInstance(
        document.getElementById("modalProductos"),
    ).hide();
});

detalleBody.addEventListener("input", function (e) {
    if (
        e.target.classList.contains("cantidad") ||
        e.target.classList.contains("costo-total")
    ) {
        actualizarMontoTotal();
    }
});

function actualizarMontoTotal() {
    let subtotal = 0;

    document.querySelectorAll(".costo-total").forEach((input) => {
        subtotal += parseFloat(input.value) || 0;
    });

    const aplicaItbis = document.getElementById("aplicarItbis").checked;

    const itbis = aplicaItbis ? subtotal * 0.18 : 0;

    const total = subtotal + itbis;

    document.getElementById("lblSubtotal").textContent =
        "RD$ " + subtotal.toFixed(2);

    document.getElementById("lblItbis").textContent = "RD$ " + itbis.toFixed(2);

    document.getElementById("lblTotal").textContent = "RD$ " + total.toFixed(2);
}

document
    .getElementById("aplicarItbis")
    .addEventListener("change", actualizarMontoTotal);

actualizarMontoTotal();
