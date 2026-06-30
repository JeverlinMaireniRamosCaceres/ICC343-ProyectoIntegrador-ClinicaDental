// Buscador asíncrono con AJAX
document
    .getElementById("buscarProcedimiento")
    .addEventListener("keyup", async function () {
        const texto = this.value;
        const porPagina = document.getElementById("porPagina")?.value ?? 6;

        const url = `/procedimientos?buscar=${encodeURIComponent(
            texto,
        )}&porPagina=${porPagina}`;

        const response = await fetch(url, {
            headers: {
                "X-Requested-With": "XMLHttpRequest",
            },
        });

        const html = await response.text();

        document.getElementById("contenedorTablaProcedimientos").innerHTML =
            html;

        window.history.pushState({}, "", url);
    });

// Paginación asíncrona con AJAX
document.addEventListener("click", async function (e) {
    if (!e.target.closest("#contenedorTablaProcedimientos .pagination a"))
        return;

    e.preventDefault();

    const url = e.target.closest("a").href;

    const response = await fetch(url, {
        headers: {
            "X-Requested-With": "XMLHttpRequest",
        },
    });

    const html = await response.text();

    document.getElementById("contenedorTablaProcedimientos").innerHTML = html;

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

    document.getElementById("contenedorTablaProcedimientos").innerHTML = html;

    window.history.pushState({}, "", url);
});

// Modal eliminar procedimiento
document.addEventListener("click", function (e) {
    const boton = e.target.closest(
        '[data-bs-target="#modalEliminarProcedimiento"]',
    );

    if (!boton) return;

    const id = boton.dataset.id;
    const nombre = boton.dataset.nombre;

    document.getElementById("nombreProcedimientoEliminar").textContent = nombre;

    document.getElementById("formEliminarProcedimiento").action =
        `/procedimientos/${id}`;
});
