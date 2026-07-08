// Buscador con ajax
document
    .getElementById("buscarPago")
    .addEventListener("keyup", async function () {
        const params = new URLSearchParams();

        params.append("buscar", this.value);
        params.append(
            "vista",
            document.querySelector(".btn-filtro.active").dataset.vista,
        );
        params.append(
            "fecha_desde",
            document.getElementById("filtroFechaDesde").value,
        );
        params.append(
            "fecha_hasta",
            document.getElementById("filtroFechaHasta").value,
        );

        const porPagina = document.getElementById("porPagina");
        if (porPagina) {
            params.append("porPagina", porPagina.value);
        }

        const url = `/pagos?${params.toString()}`;

        const response = await fetch(url, {
            headers: {
                "X-Requested-With": "XMLHttpRequest",
            },
        });

        const html = await response.text();

        document.getElementById("contenedorTablaPagos").innerHTML = html;

        window.history.pushState({}, "", url);
    });

// Cambiar vista
document.addEventListener("click", async function (e) {
    const boton = e.target.closest(".btn-filtro");

    if (!boton) return;

    document.querySelectorAll(".btn-filtro").forEach((b) => {
        b.classList.remove("active");
        b.classList.add("text-muted");
    });

    boton.classList.add("active");
    boton.classList.remove("text-muted");

    const params = new URLSearchParams();

    params.append("buscar", document.getElementById("buscarPago").value);
    params.append("vista", boton.dataset.vista);
    params.append(
        "fecha_desde",
        document.getElementById("filtroFechaDesde").value,
    );
    params.append(
        "fecha_hasta",
        document.getElementById("filtroFechaHasta").value,
    );

    const porPagina = document.getElementById("porPagina");
    if (porPagina) {
        params.append("porPagina", porPagina.value);
    }

    const url = `/pagos?${params.toString()}`;

    const response = await fetch(url, {
        headers: {
            "X-Requested-With": "XMLHttpRequest",
        },
    });

    const html = await response.text();

    document.getElementById("contenedorTablaPagos").innerHTML = html;

    window.history.pushState({}, "", url);
});

// Paginación
document.addEventListener("click", async function (e) {
    const enlace = e.target.closest(".pagination a");

    if (!enlace) return;

    e.preventDefault();

    const response = await fetch(enlace.href, {
        headers: {
            "X-Requested-With": "XMLHttpRequest",
        },
    });

    const html = await response.text();

    document.getElementById("contenedorTablaPagos").innerHTML = html;

    window.history.pushState({}, "", enlace.href);
});

// Cantidad de filas
document.addEventListener("change", async function (e) {
    if (e.target.id !== "porPagina") return;

    const form = e.target.form;

    const params = new URLSearchParams(new FormData(form));

    params.set(
        "vista",
        document.querySelector(".btn-filtro.active").dataset.vista,
    );

    params.set("buscar", document.getElementById("buscarPago").value);

    params.set(
        "fecha_desde",
        document.getElementById("filtroFechaDesde").value,
    );

    params.set(
        "fecha_hasta",
        document.getElementById("filtroFechaHasta").value,
    );

    const url = `${form.action}?${params.toString()}`;

    const response = await fetch(url, {
        headers: {
            "X-Requested-With": "XMLHttpRequest",
        },
    });

    const html = await response.text();

    document.getElementById("contenedorTablaPagos").innerHTML = html;

    window.history.pushState({}, "", url);
});

// Filtros por fecha
document
    .getElementById("filtroFechaDesde")
    .addEventListener("change", cargarFiltros);

document
    .getElementById("filtroFechaHasta")
    .addEventListener("change", cargarFiltros);

async function cargarFiltros() {
    const params = new URLSearchParams();

    params.append("buscar", document.getElementById("buscarPago").value);
    params.append(
        "vista",
        document.querySelector(".btn-filtro.active").dataset.vista,
    );
    params.append(
        "fecha_desde",
        document.getElementById("filtroFechaDesde").value,
    );
    params.append(
        "fecha_hasta",
        document.getElementById("filtroFechaHasta").value,
    );

    const porPagina = document.getElementById("porPagina");
    if (porPagina) {
        params.append("porPagina", porPagina.value);
    }

    const url = `/pagos?${params.toString()}`;

    const response = await fetch(url, {
        headers: {
            "X-Requested-With": "XMLHttpRequest",
        },
    });

    const html = await response.text();

    document.getElementById("contenedorTablaPagos").innerHTML = html;

    window.history.pushState({}, "", url);
}
