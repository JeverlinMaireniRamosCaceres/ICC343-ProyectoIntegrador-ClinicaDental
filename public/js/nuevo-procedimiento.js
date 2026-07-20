document.addEventListener("DOMContentLoaded", function () {
    const detalleBody = document.getElementById("detalleBody");
    const btnAgregarFila = document.getElementById("btnAgregarFila");
    const filaVaciaInsumos = document.getElementById("filaVaciaInsumos");

    let filaProductoActual = null;
    let productoSeleccionadoActual = null;

    function agregarFila(id = "", nombre = "", unidad = "-", cantidad = 1) {
        if (filaVaciaInsumos) {
            filaVaciaInsumos.style.display = "none";
        }

        let fila = `
            <tr>
                <td>
                    <input type="text"
                           class="form-control form-control-sm producto-input"
                           placeholder="Buscar producto..."
                           readonly
                           data-bs-toggle="modal"
                           data-bs-target="#modalProductos"
                           value="${nombre}">

                    <input type="hidden"
                           name="idProducto[]"
                           class="id-producto"
                           value="${id}">

                    <input type="hidden"
                           name="nombreProducto[]"
                           class="nombre-producto"
                           value="${nombre}">

                    <input type="hidden"
                           name="unidadProducto[]"
                           class="unidad-hidden"
                           value="${unidad}">
                </td>

                <td>
                    <input type="number"
                           class="form-control form-control-sm cantidad text-center"
                           min="1"
                           step="1"
                           value="${cantidad}"
                           name="cantidad[]"
                           required>
                </td>

                <td class="unidad-producto text-center text-muted small">
                    ${unidad}
                </td>

                <td class="text-end">
                    <button type="button"
                            class="btn btn-sm btn-link text-danger p-0 btnEliminarFila"
                            title="Eliminar">
                        <i class="bi bi-trash fs-5"></i>
                    </button>
                </td>
            </tr>
        `;

        detalleBody.insertAdjacentHTML("beforeend", fila);
    }

    if (btnAgregarFila) {
        btnAgregarFila.addEventListener("click", () => {
            agregarFila();
        });
    }

    // ELIMINAR FILA
    detalleBody.addEventListener("click", function (e) {
        const btnEliminar = e.target.closest(".btnEliminarFila");

        if (!btnEliminar) return;

        btnEliminar.closest("tr").remove();

        const filasActuales = detalleBody.querySelectorAll(
            "tr:not(#filaVaciaInsumos)",
        );

        if (filasActuales.length === 0 && filaVaciaInsumos) {
            filaVaciaInsumos.style.display = "";
        }

        actualizarEstadoProductos();
    });

    // ABRIR MODAL
    document.addEventListener("click", function (e) {
        const inputProducto = e.target.closest(".producto-input");

        if (!inputProducto) return;

        filaProductoActual = inputProducto.closest("tr");

        actualizarEstadoProductos();

        productoSeleccionadoActual =
            filaProductoActual.querySelector(".id-producto").value;

        actualizarSeleccionVisual(productoSeleccionadoActual);
    });

    // SELECCIONAR PRODUCTO
    document.addEventListener("click", function (e) {
        const btnSeleccionar = e.target.closest(".btnSeleccionarProducto");

        if (!btnSeleccionar || !filaProductoActual) return;

        filaProductoActual.querySelector(".producto-input").value =
            btnSeleccionar.dataset.nombre;

        filaProductoActual.querySelector(".id-producto").value =
            btnSeleccionar.dataset.id;

        filaProductoActual.querySelector(".nombre-producto").value =
            btnSeleccionar.dataset.nombre;

        filaProductoActual.querySelector(".unidad-hidden").value =
            btnSeleccionar.dataset.unidad;

        filaProductoActual.querySelector(".unidad-producto").textContent =
            btnSeleccionar.dataset.unidad;

        actualizarSeleccionVisual(btnSeleccionar.dataset.id);
        actualizarEstadoProductos();

        const modal = bootstrap.Modal.getInstance(
            document.getElementById("modalProductos"),
        );

        modal.hide();
    });

    // BUSCAR PRODUCTO
    const buscarProductoModal = document.getElementById("buscarProductoModal");

    if (buscarProductoModal) {
        buscarProductoModal.addEventListener("keyup", function () {
            const texto = this.value.toLowerCase();

            const filas = document.querySelectorAll(
                "#tablaProductosModal tbody tr:not(#sinResultadosProductosModal)",
            );

            let encontrados = 0;

            filas.forEach((fila) => {
                const nombre = fila.children[0].textContent.toLowerCase();

                const visible = nombre.includes(texto);

                fila.style.display = visible ? "" : "none";

                if (visible) encontrados++;
            });

            const sinResultados = document.getElementById(
                "sinResultadosProductosModal",
            );

            if (sinResultados) {
                sinResultados.style.display = encontrados === 0 ? "" : "none";
            }
        });
    }

    // RESTAURAR DATOS DESPUÉS DE VALIDACIÓN
    if (typeof productosOld !== "undefined" && productosOld.length > 0) {
        productosOld.forEach((idProducto, index) => {
            agregarFila(
                idProducto,
                nombresOld[index] ?? "",
                unidadesOld[index] ?? "-",
                cantidadesOld[index] ?? 1,
            );
        });
    }

    // ACTUALIZAR PRODUCTOS DISPONIBLES
    function actualizarEstadoProductos() {
        const productosSeleccionados = [];

        document.querySelectorAll(".id-producto").forEach((input) => {
            if (input.value) {
                productosSeleccionados.push(input.value);
            }
        });

        document.querySelectorAll(".btnSeleccionarProducto").forEach((btn) => {
            const idActual =
                filaProductoActual?.querySelector(".id-producto")?.value;

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

    // BOTÓN VERDE DEL PRODUCTO ACTUAL
    function actualizarSeleccionVisual(idSeleccionado) {
        document.querySelectorAll(".btnSeleccionarProducto").forEach((btn) => {
            if (btn.disabled) return;

            if (btn.dataset.id == idSeleccionado) {
                btn.classList.remove("btn-primary");
                btn.classList.add("btn-success");

                btn.innerHTML = '<i class="bi bi-check-circle-fill"></i>';
            } else {
                btn.classList.remove("btn-success");
                btn.classList.add("btn-primary");

                btn.innerHTML = '<i class="bi bi-circle"></i>';
            }
        });
    }
});
