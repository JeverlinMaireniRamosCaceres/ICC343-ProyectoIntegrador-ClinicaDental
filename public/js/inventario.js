let filtroActual = "";

document.addEventListener("DOMContentLoaded", function () {

    const buscarProducto = document.getElementById("buscarProducto");

    async function cargarProductos(url = null) {

        const texto = buscarProducto ? buscarProducto.value : "";

        let ruta =
            url ||
            `/inventario?buscar=${encodeURIComponent(texto)}&filtro=${filtroActual}`;

        if (url) {

            const separador = ruta.includes("?") ? "&" : "?";

            ruta += `${separador}buscar=${encodeURIComponent(texto)}&filtro=${filtroActual}`;
        }

        const response = await fetch(ruta, {
            headers: {
                "X-Requested-With": "XMLHttpRequest",
            },
        });

        const html = await response.text();

        document.getElementById(
            "contenedorTablaProductos"
        ).innerHTML = html;
    }

    // busqueda AJAX

    if (buscarProducto) {

        buscarProducto.addEventListener("keyup", function () {
            cargarProductos();
        });

    }

    // filtros

    document.querySelectorAll(".btn-filtro").forEach(btn => {

        btn.addEventListener("click", function () {

            document
                .querySelectorAll(".btn-filtro")
                .forEach(b => b.classList.remove("active"));

            this.classList.add("active");

            filtroActual = this.dataset.filtro;

            cargarProductos();
        });

    });

    // paginacion AJAX

    document.addEventListener("click", function (e) {

        const link = e.target.closest(".pagination a");

        if (link) {

            e.preventDefault();

            cargarProductos(link.href);
        }

    });

});