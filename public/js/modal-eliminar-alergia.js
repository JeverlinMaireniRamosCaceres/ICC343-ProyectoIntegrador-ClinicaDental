document.addEventListener('DOMContentLoaded', function () {

    const modalEliminarAlergia = document.getElementById('modalEliminarAlergia');

    if (!modalEliminarAlergia) return;

    modalEliminarAlergia.addEventListener('show.bs.modal', function (event) {

        const button = event.relatedTarget;

        const id = button.getAttribute('data-id');
        const nombre = button.getAttribute('data-nombre');

        document.getElementById('nombreAlergiaEliminar').textContent = nombre;

        const form = document.getElementById('formEliminarAlergia');

        form.action = `/alergias/${id}`;

    });

});