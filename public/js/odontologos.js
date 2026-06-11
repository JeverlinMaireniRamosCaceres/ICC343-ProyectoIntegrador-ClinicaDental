// Buscador con ajax
document
    .getElementById("buscarOdontologo")
    .addEventListener("keyup", async function () {
        const texto = this.value;

        const response = await fetch(`/odontologos?buscar=${texto}`, {
            headers: {
                "X-Requested-With": "XMLHttpRequest",
            },
        });

        const html = await response.text();

        document.getElementById("contenedorTablaOdontologos").innerHTML = html;
    });

// Paginacion con ajax
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

        document.getElementById("contenedorTablaOdontologos").innerHTML = html;
    }
});

// Modal desactivar odontólogo
document.addEventListener("click", function (e) {
    const boton = e.target.closest(
        '[data-bs-target="#modalEliminarOdontologo"]',
    );

    if (!boton) return;

    const id = boton.dataset.id;
    const nombre = boton.dataset.nombre;

    document.getElementById("nombreOdontologoEliminar").textContent = nombre;

    document.getElementById("formEliminarOdontologo").action =
        `/odontologos/${id}`;
});

// Modal activar odontólogo
document.addEventListener("click", function (e) {
    const boton = e.target.closest(
        '[data-bs-target="#modalActivarOdontologo"]',
    );

    if (!boton) return;

    const id = boton.dataset.id;
    const nombre = boton.dataset.nombre;

    document.getElementById("nombreOdontologoActivar").textContent = nombre;

    document.getElementById("formActivarOdontologo").action =
        `/odontologos/${id}/activar`;
});
