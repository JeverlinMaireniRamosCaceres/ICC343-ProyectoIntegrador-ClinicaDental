document.addEventListener('DOMContentLoaded', function () {

    const inputBuscar = document.getElementById('buscarAlergia');
    const contenedorTabla = document.getElementById('contenedorTablaAlergias');

    if (!inputBuscar || !contenedorTabla) {
        return;
    }

    let timeout = null;

    inputBuscar.addEventListener('input', function () {
        clearTimeout(timeout);

        timeout = setTimeout(function () {
            const buscar = inputBuscar.value.trim();

            fetch(`/alergias?buscar=${encodeURIComponent(buscar)}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.text())
            .then(html => {
                contenedorTabla.innerHTML = html;
            });
        }, 300);
    });


    // paginacion con AJAX
        document.addEventListener('click', async function (e) {

        if (e.target.closest('.pagination a')) {

            e.preventDefault();

            const url = e.target.closest('a').href;

            const response = await fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            const html = await response.text();

            contenedorTabla.innerHTML = html;
        }
    });


});