// Buscador con ajax
document
    .getElementById("buscarPaciente")
    .addEventListener("keyup", async function () {
        const texto = this.value;

        const url = `/pacientes?buscar=${encodeURIComponent(texto)}`;

        const response = await fetch(url, {
            headers: {
                "X-Requested-With": "XMLHttpRequest",
            },
        });

        const html = await response.text();

        document.getElementById("contenedorTablaPacientes").innerHTML = html;

        window.history.pushState({}, "", url);
    });

// Paginacion con ajax
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

    document.getElementById("contenedorTablaPacientes").innerHTML = html;

    window.history.pushState({}, "", enlace.href);
});

// Cantidad de paginado con ajax
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

    document.getElementById("contenedorTablaPacientes").innerHTML = html;

    window.history.pushState({}, "", url);
});
