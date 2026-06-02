document
    .getElementById("buscarUsuario")
    .addEventListener("keyup", async function () {
        const texto = this.value;

        const response = await fetch(`/usuarios?buscar=${texto}`, {
            headers: {
                "X-Requested-With": "XMLHttpRequest",
            },
        });

        const html = await response.text();

        document.getElementById("contenedorTablaUsuarios").innerHTML = html;
    });

// paginacion con ajax
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

        document.getElementById("contenedorTablaUsuarios").innerHTML = html;
    }
});

const modalActivarUsuario = document.getElementById("modalActivarUsuario");

modalActivarUsuario.addEventListener("show.bs.modal", function (e) {
    const btn = e.relatedTarget;

    const id = btn.getAttribute("data-id");
    const nombre = btn.getAttribute("data-nombre");

    document.getElementById("nombreUsuarioActivar").textContent = nombre;

    document.getElementById("formActivarUsuario").action =
        `/usuarios/${id}/activar`;
});

const modalEliminarUsuario = document.getElementById("modalEliminarUsuario");

modalEliminarUsuario.addEventListener("show.bs.modal", function (e) {
    const btn = e.relatedTarget;

    const id = btn.getAttribute("data-id");
    const nombre = btn.getAttribute("data-nombre");

    document.getElementById("nombreUsuarioEliminar").textContent = nombre;

    document.getElementById("formEliminarUsuario").action = `/usuarios/${id}`;
});
