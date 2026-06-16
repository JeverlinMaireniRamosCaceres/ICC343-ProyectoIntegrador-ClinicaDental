// Buscador asíncrono con AJAX
document
    .getElementById("buscarProcedimiento")
    .addEventListener("keyup", async function () {
        const texto = this.value;

        const response = await fetch(`/procedimientos?buscar=${texto}`, {
            headers: {
                "X-Requested-With": "XMLHttpRequest",
            },
        });

        const html = await response.text();

        document.getElementById("contenedorTablaProcedimientos").innerHTML = html;
    });

// Paginación asíncrona con AJAX
document.addEventListener("click", async function (e) {
    if (e.target.closest("#contenedorTablaProcedimientos .pagination a")) {
        e.preventDefault();

        const url = e.target.closest("a").href;

        const response = await fetch(url, {
            headers: {
                "X-Requested-With": "XMLHttpRequest",
            },
        });

        const html = await response.text();

        document.getElementById("contenedorTablaProcedimientos").innerHTML = html;
    }
});