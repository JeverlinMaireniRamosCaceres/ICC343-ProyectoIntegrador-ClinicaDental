document.addEventListener("DOMContentLoaded", () => {
    const inputBuscar = document.getElementById("buscarFactura");
    const selectPorPagina = document.getElementById("porPagina");
    const filtroEstado = document.querySelectorAll(".btn-filtro");
    const fechaDesde = document.getElementById("filtroFechaDesde");
    const fechaHasta = document.getElementById("filtroFechaHasta");

    let estado = "";

    function cargarFacturas(url = null) {
        const params = new URLSearchParams();

        params.append("buscar", inputBuscar.value);
        params.append("porPagina", selectPorPagina.value);
        params.append("estado", estado);
        params.append("fecha_desde", fechaDesde.value);
        params.append("fecha_hasta", fechaHasta.value);

        const ruta = url || `${window.location.pathname}?${params.toString()}`;

        fetch(ruta, {
            headers: {
                "X-Requested-With": "XMLHttpRequest",
            },
        })
            .then((response) => response.text())
            .then((html) => {
                document.getElementById("contenedorTablaFacturas").innerHTML =
                    html;
                enlazarPaginacion();
            });
    }

    let timeout;
    inputBuscar.addEventListener("input", () => {
        clearTimeout(timeout);
        timeout = setTimeout(() => cargarFacturas(), 300);
    });

    selectPorPagina.addEventListener("change", () => {
        cargarFacturas();
    });

    fechaDesde.addEventListener("change", () => {
        cargarFacturas();
    });

    fechaHasta.addEventListener("change", () => {
        cargarFacturas();
    });

    filtroEstado.forEach((boton) => {
        boton.addEventListener("click", () => {
            filtroEstado.forEach((b) => {
                b.classList.remove("active");
                b.classList.add("text-muted");
            });

            boton.classList.add("active");
            boton.classList.remove("text-muted");

            estado = boton.dataset.filtro;

            cargarFacturas();
        });
    });

    function enlazarPaginacion() {
        document.querySelectorAll(".pagination a").forEach((link) => {
            link.addEventListener("click", function (e) {
                e.preventDefault();
                cargarFacturas(this.href);
            });
        });
    }

    enlazarPaginacion();
});

document.querySelectorAll(".btnAnularFactura").forEach((boton) => {
    boton.addEventListener("click", function () {
        const id = this.dataset.id;

        document.getElementById("formAnularFactura").action =
            `/facturacion/${id}/anular`;
    });
});
