document.addEventListener('DOMContentLoaded', function () {

    const buscar = document.getElementById('buscarConsulta');

    if (buscar) {
        buscar.addEventListener('keyup', async function () {

            const texto = this.value;

            const porPagina = document.getElementById('porPagina').value;

            const response = await fetch(
                `/consultas?buscar=${encodeURIComponent(texto)}&porPagina=${porPagina}`,
                {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                }
            );

            document.getElementById('contenedorTablaConsultas').innerHTML = await response.text();

        });
    }

    document.addEventListener('click', async function (e) {
        const link = e.target.closest('.pagination a');
        if (!link) return;
        e.preventDefault();
        const response = await fetch(link.href, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });
        document.getElementById('contenedorTablaConsultas').innerHTML = await response.text();
    });

    document.addEventListener('change', async function (e) {

        if (e.target.id !== 'porPagina') return;

        const buscar = document.getElementById('buscarConsulta').value;

        const response = await fetch(
            `/consultas?buscar=${encodeURIComponent(buscar)}&porPagina=${e.target.value}`,
            {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            }
        );

        document.getElementById('contenedorTablaConsultas').innerHTML = await response.text();

    });


});