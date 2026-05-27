document
    .getElementById("buscarCompra")
    .addEventListener("keyup", filtrarCompras);

document
    .getElementById("filtroEstado")
    .addEventListener("change", filtrarCompras);

document
    .getElementById("filtroFecha")
    .addEventListener("change", filtrarCompras);

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
        }
    );

    const html = await response.text();

    document.getElementById("contenedorTablaCompras").innerHTML = html;
}

const modalEliminarCompra = document.getElementById("modalEliminarCompra");

modalEliminarCompra.addEventListener("show.bs.modal", function (e) {
    const btn = e.relatedTarget;

    const id = btn.getAttribute("data-id");
    const nombre = btn.getAttribute("data-nombre");

    document.getElementById("nombreCompraEliminar").textContent = nombre;

    document.getElementById("formEliminarCompra").action = `/compras/${id}`;
});
