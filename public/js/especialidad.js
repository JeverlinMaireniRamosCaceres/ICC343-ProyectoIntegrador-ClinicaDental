document.addEventListener('DOMContentLoaded', function () {

    const inputBuscar = document.getElementById('buscarEspecialidad');
    const contenedorTabla = document.getElementById('contenedorTablaEspecialidades');

    if (!inputBuscar || !contenedorTabla) {
        return;
    }

    let timeout = null;

    inputBuscar.addEventListener('input', function () {

        clearTimeout(timeout);

        timeout = setTimeout(function () {

            const buscar = inputBuscar.value.trim();

            fetch(`/especialidades?buscar=${encodeURIComponent(buscar)}`, {
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

});