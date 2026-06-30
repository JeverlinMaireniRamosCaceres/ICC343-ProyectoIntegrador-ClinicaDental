const params = new URLSearchParams(window.location.search);
let filtroEstadoActual = params.get("estado") ?? "";

// Para manejar los botones de filtro
document.querySelectorAll(".btn-filtro").forEach((btn) => {
    if (btn.dataset.filtro === filtroEstadoActual) {
        btn.classList.add("active");
    }

    btn.addEventListener("click", function () {
        document
            .querySelectorAll(".btn-filtro")
            .forEach((b) => b.classList.remove("active"));

        this.classList.add("active");
        filtroEstadoActual = this.dataset.filtro;

        filtrarCompras();
    });
});

document
    .getElementById("buscarCompra")
    .addEventListener("keyup", filtrarCompras);

document
    .getElementById("filtroFecha")
    .addEventListener("change", filtrarCompras);

// Paginación AJAX
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

    document.getElementById("contenedorTablaCompras").innerHTML = html;

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

    document.getElementById("contenedorTablaCompras").innerHTML = html;

    window.history.pushState({}, "", url);
});

// Función para filtrar compras
async function filtrarCompras() {
    const buscar = document.getElementById("buscarCompra").value;
    const estado = filtroEstadoActual;
    const fecha = document.getElementById("filtroFecha").value;
    const porPagina = document.getElementById("porPagina")?.value ?? 6;

    const url = `/compras?buscar=${encodeURIComponent(
        buscar,
    )}&estado=${encodeURIComponent(estado)}&fecha=${encodeURIComponent(
        fecha,
    )}&porPagina=${porPagina}`;

    const response = await fetch(url, {
        headers: {
            "X-Requested-With": "XMLHttpRequest",
        },
    });

    const html = await response.text();

    document.getElementById("contenedorTablaCompras").innerHTML = html;

    window.history.pushState({}, "", url);
}

// Modal eliminar compra
document.addEventListener("click", function (e) {
    const btn = e.target.closest(".btnAnularCompra");

    if (!btn) return;

    const idCompra = btn.dataset.id;

    document.getElementById("formAnularCompra").action =
        `/compras/${idCompra}/anular`;
});

function abrirModalMarcarPagada(url) {
    document.getElementById("formMarcarPagada").action = url;

    const modal = new bootstrap.Modal(
        document.getElementById("modalMarcarPagada"),
    );

    modal.show();
}
