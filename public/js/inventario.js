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

    // cargar movimientos
    async function cargarMovimientos(url = null) {
        let ruta = url || `/inventario?tipo=movimientos`;

        if (url) {
            const separador = ruta.includes("?") ? "&" : "?";
            ruta += `${separador}tipo=movimientos`;
        }

        const response = await fetch(ruta, {
            headers: { "X-Requested-With": "XMLHttpRequest" },
        });

        document.getElementById("contenedorTablaMovimientos").innerHTML = await response.text();
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
        if (!link) return;
        e.preventDefault();

        const tabActivoBtn = document.querySelector(".nav-link.active[data-bs-target]");
        const tabActivo = tabActivoBtn ? tabActivoBtn.getAttribute("data-bs-target") : null;
        console.log('Tab activo:', tabActivo);

        if (tabActivo === "#tab-productos") {
            cargarProductos(link.href);
        } else if (tabActivo === "#tab-movimientos") {
            cargarMovimientos(link.href);
        }

    });

    const hash = window.location.hash;
    if (hash) {
        const tabBtn = document.querySelector(`[data-bs-target="${hash}"]`);
        if (tabBtn) {
            bootstrap.Tab.getOrCreateInstance(tabBtn).show();
        }
    }
});