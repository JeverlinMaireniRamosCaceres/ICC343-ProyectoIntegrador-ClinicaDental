// Buscador con ajax
document
    .getElementById("buscarPaciente")
    .addEventListener("keyup", async function () {
        const texto = this.value;

        const response = await fetch(`/pacientes?buscar=${texto}`, {
            headers: {
                "X-Requested-With": "XMLHttpRequest",
            },
        });

        const html = await response.text();

        document.getElementById("contenedorTablaPacientes").innerHTML = html;
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
});

// Cantidad de paginado con ajax
document.addEventListener("change", async function (e) {
    if (e.target.id !== "porPagina") return;

    const form = e.target.form;

    const params = new URLSearchParams(new FormData(form));

    const response = await fetch(`${form.action}?${params.toString()}`, {
        headers: {
            "X-Requested-With": "XMLHttpRequest",
        },
    });

    const html = await response.text();

    document.getElementById("contenedorTablaPacientes").innerHTML = html;
});
