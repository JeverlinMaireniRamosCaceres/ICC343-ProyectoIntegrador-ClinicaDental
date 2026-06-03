document.addEventListener('DOMContentLoaded', function () {

    const inputBuscar = document.getElementById('buscarProducto');
    const contenedorTabla = document.getElementById('contenedorTablaProductos');

    if (!inputBuscar || !contenedorTabla) {
        return;
    }

    let timeout = null;

    inputBuscar.addEventListener('input', function () {

        clearTimeout(timeout);

        timeout = setTimeout(function () {

            const buscar = inputBuscar.value.trim();

            // Petición AJAX a la ruta de productos
            fetch(`/productos?buscar=${encodeURIComponent(buscar)}`, {
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

    // Control dinámico de la paginación para que no recargue la página
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