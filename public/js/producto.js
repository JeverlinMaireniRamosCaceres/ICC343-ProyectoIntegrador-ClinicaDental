document.addEventListener("DOMContentLoaded", function () {
    const inputBuscar = document.getElementById("buscarProducto");
    const contenedorTabla = document.getElementById("contenedorTablaProductos");

    if (!inputBuscar || !contenedorTabla) {
        return;
    }

    let timeout = null;

    // Buscador con AJAX
    inputBuscar.addEventListener("input", function () {
        clearTimeout(timeout);

        timeout = setTimeout(async function () {
            const buscar = inputBuscar.value.trim();
            const porPagina = document.getElementById("porPagina")?.value ?? 6;

            const url = `/productos?buscar=${encodeURIComponent(
                buscar,
            )}&porPagina=${porPagina}`;

            const response = await fetch(url, {
                headers: {
                    "X-Requested-With": "XMLHttpRequest",
                },
            });

            const html = await response.text();

            contenedorTabla.innerHTML = html;

            window.history.pushState({}, "", url);
        }, 300);
    });

    // Paginación con AJAX
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

        contenedorTabla.innerHTML = html;

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

        contenedorTabla.innerHTML = html;

        window.history.pushState({}, "", url);
    });
});
