document.addEventListener("DOMContentLoaded", function () {
    // Barra de búsqueda AJAX
    const buscarProveedor = document.getElementById("buscarProveedor");

    if (buscarProveedor) {
        buscarProveedor.addEventListener("keyup", async function () {
            const texto = this.value;
            const porPagina = document.getElementById("porPagina")?.value ?? 6;

            const url = `/proveedores?buscar=${encodeURIComponent(
                texto,
            )}&porPagina=${porPagina}`;

            const response = await fetch(url, {
                headers: {
                    "X-Requested-With": "XMLHttpRequest",
                },
            });

            const html = await response.text();

            document.getElementById("contenedorTablaProveedores").innerHTML =
                html;

            window.history.pushState({}, "", url);
        });
    }

    // Paginación con AJAX
    document.addEventListener("click", async function (e) {
        if (!e.target.closest(".pagination a")) return;

        e.preventDefault();

        const url = e.target.closest("a").href;

        const response = await fetch(url, {
            headers: {
                "X-Requested-With": "XMLHttpRequest",
            },
        });

        const html = await response.text();

        document.getElementById("contenedorTablaProveedores").innerHTML = html;

        window.history.pushState({}, "", url);
    });

    // Cambio de cantidad de filas con AJAX
    document.addEventListener("change", async function (e) {
        if (e.target.id !== "porPagina") return;

        const form = e.target.form;

        const params = new URLSearchParams(new FormData(form));

        const url = `${form.action}?${params.toString()}`;

        const response = await fetch(url, {
            headers: {
                "X-Requested-With": "XMLHttpRequest",
            },
        });

        const html = await response.text();

        document.getElementById("contenedorTablaProveedores").innerHTML = html;

        window.history.pushState({}, "", url);
    });

    // Modal activar
    const modalActivarProveedor = document.getElementById(
        "modalActivarProveedor",
    );

    if (modalActivarProveedor) {
        modalActivarProveedor.addEventListener("show.bs.modal", function (e) {
            const btn = e.relatedTarget;

            const id = btn.getAttribute("data-id");
            const nombre = btn.getAttribute("data-nombre");

            document.getElementById("nombreProveedorActivar").textContent =
                nombre;

            document.getElementById("formActivarProveedor").action =
                `/proveedores/${id}/activar`;
        });
    }

    // Modal eliminar
    const modalEliminarProveedor = document.getElementById(
        "modalEliminarProveedor",
    );

    if (modalEliminarProveedor) {
        modalEliminarProveedor.addEventListener("show.bs.modal", function (e) {
            const btn = e.relatedTarget;

            const id = btn.getAttribute("data-id");
            const nombre = btn.getAttribute("data-nombre");

            document.getElementById("nombreProveedorEliminar").textContent =
                nombre;

            document.getElementById("formEliminarProveedor").action =
                `/proveedores/${id}`;
        });
    }

    // Formato teléfono
    const telefono = document.getElementById("telefono");

    if (telefono) {
        telefono.addEventListener("input", function (e) {
            let valor = e.target.value.replace(/\D/g, "");

            valor = valor.substring(0, 10);

            if (valor.length > 6) {
                valor = valor.replace(/(\d{3})(\d{3})(\d{0,4})/, "$1-$2-$3");
            } else if (valor.length > 3) {
                valor = valor.replace(/(\d{3})(\d+)/, "$1-$2");
            }

            e.target.value = valor;
        });
    }
});
