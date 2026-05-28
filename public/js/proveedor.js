document.addEventListener("DOMContentLoaded", function () {

    document
        .getElementById("buscarProveedor")
        .addEventListener("keyup", async function () {

            const texto = this.value;

            const response = await fetch(`/proveedores?buscar=${texto}`, {
                headers: {
                    "X-Requested-With": "XMLHttpRequest",
                },
            });

            const html = await response.text();

            document.getElementById("contenedorTablaProveedores").innerHTML = html;
        });

    document.addEventListener("click", async function (e) {

        if (e.target.closest(".pagination a")) {

            e.preventDefault();

            const url = e.target.closest("a").href;

            const response = await fetch(url, {
                headers: {
                    "X-Requested-With": "XMLHttpRequest",
                },
            });

            const html = await response.text();

            document.getElementById("contenedorTablaProveedores").innerHTML = html;
        }
    });

    const modalActivarProveedor = document.getElementById("modalActivarProveedor");

    if (modalActivarProveedor) {

        modalActivarProveedor.addEventListener("show.bs.modal", function (e) {

            const btn = e.relatedTarget;

            const id = btn.getAttribute("data-id");
            const nombre = btn.getAttribute("data-nombre");

            document.getElementById("nombreProveedorActivar").textContent = nombre;

            document.getElementById("formActivarProveedor").action =
                `/proveedores/${id}/activar`;
        });
    }

    const modalEliminarProveedor = document.getElementById("modalEliminarProveedor");

    if (modalEliminarProveedor) {

        modalEliminarProveedor.addEventListener("show.bs.modal", function (e) {

            const btn = e.relatedTarget;

            const id = btn.getAttribute("data-id");
            const nombre = btn.getAttribute("data-nombre");

            document.getElementById("nombreProveedorEliminar").textContent = nombre;

            document.getElementById("formEliminarProveedor").action =
                `/proveedores/${id}`;
        });
    }

});