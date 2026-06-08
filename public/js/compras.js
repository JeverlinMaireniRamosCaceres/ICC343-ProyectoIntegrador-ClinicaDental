document
    .getElementById("buscarCompra")
    .addEventListener("keyup", filtrarCompras);

document
    .getElementById("filtroEstado")
    .addEventListener("change", filtrarCompras);

document
    .getElementById("filtroFecha")
    .addEventListener("change", filtrarCompras);

// Paginacion AJAX
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

        document.getElementById("contenedorTablaCompras").innerHTML = html;
    }
});

// Función para filtrar compras

async function filtrarCompras() {
    const buscar = document.getElementById("buscarCompra").value;
    const estado = document.getElementById("filtroEstado").value;
    const fecha = document.getElementById("filtroFecha").value;

    const response = await fetch(
        `/compras?buscar=${buscar}&estado=${estado}&fecha=${fecha}`,
        {
            headers: {
                "X-Requested-With": "XMLHttpRequest",
            },
        },
    );

    const html = await response.text();

    document.getElementById("contenedorTablaCompras").innerHTML = html;
}

// Modal eliminar compra

const modalEliminarCompra = document.getElementById("modalEliminarCompra");

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
