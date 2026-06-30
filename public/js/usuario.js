document
    .getElementById("buscarUsuario")
    .addEventListener("keyup", async function () {
        const texto = this.value;
        const porPagina = document.getElementById("porPagina")?.value ?? 6;

        const url = `/usuarios?buscar=${encodeURIComponent(
            texto,
        )}&porPagina=${porPagina}`;

        const response = await fetch(url, {
            headers: {
                "X-Requested-With": "XMLHttpRequest",
            },
        });

        const html = await response.text();

        document.getElementById("contenedorTablaUsuarios").innerHTML = html;

        window.history.pushState({}, "", url);
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

    document.getElementById("contenedorTablaUsuarios").innerHTML = html;

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

    document.getElementById("contenedorTablaUsuarios").innerHTML = html;

    window.history.pushState({}, "", url);
});

const modalActivarUsuario = document.getElementById("modalActivarUsuario");

if (modalActivarUsuario) {
    modalActivarUsuario.addEventListener("show.bs.modal", function (e) {
        const btn = e.relatedTarget;

        const id = btn.getAttribute("data-id");
        const nombre = btn.getAttribute("data-nombre");

        document.getElementById("nombreUsuarioActivar").textContent = nombre;

        document.getElementById("formActivarUsuario").action =
            `/usuarios/${id}/activar`;
    });
}

const modalEliminarUsuario = document.getElementById("modalEliminarUsuario");

if (modalEliminarUsuario) {
    modalEliminarUsuario.addEventListener("show.bs.modal", function (e) {
        const btn = e.relatedTarget;

        const id = btn.getAttribute("data-id");
        const nombre = btn.getAttribute("data-nombre");

        document.getElementById("nombreUsuarioEliminar").textContent = nombre;

        document.getElementById("formEliminarUsuario").action =
            `/usuarios/${id}`;
    });
}
