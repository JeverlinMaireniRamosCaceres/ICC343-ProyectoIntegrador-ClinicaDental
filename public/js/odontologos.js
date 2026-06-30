// Buscador con ajax
document
    .getElementById("buscarOdontologo")
    .addEventListener("keyup", async function () {
        const texto = this.value;
        const porPagina = document.getElementById("porPagina")?.value ?? 6;

        const url = `/odontologos?buscar=${encodeURIComponent(texto)}&porPagina=${porPagina}`;

        const response = await fetch(url, {
            headers: {
                "X-Requested-With": "XMLHttpRequest",
            },
        });

        const html = await response.text();

        document.getElementById("contenedorTablaOdontologos").innerHTML = html;

        window.history.pushState({}, "", url);
    });

// Paginación con ajax
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

        window.history.pushState({}, "", url);
    }
});

// Cantidad de filas con ajax
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

    document.getElementById("contenedorTablaOdontologos").innerHTML = html;

    window.history.pushState({}, "", url);
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
