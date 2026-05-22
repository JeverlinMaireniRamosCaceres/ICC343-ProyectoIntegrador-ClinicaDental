document.addEventListener('click', function (e) {

    const boton = e.target.closest('.btnEliminarAlergia');

    if(!boton) return;

    const id = boton.dataset.id;
    const nombre = boton.dataset.nombre;

    document.getElementById('nombreAlergiaEliminar')
        .textContent = nombre;

    document.getElementById('formEliminarAlergia')
        .action = `/alergias/${id}`;

});