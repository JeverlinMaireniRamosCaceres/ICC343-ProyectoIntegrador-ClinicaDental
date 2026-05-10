document.addEventListener('DOMContentLoaded', function () {

    const modalEliminarCitaElement = document.getElementById('modalEliminarCita');

    if (!modalEliminarCitaElement) return;

    const modalEliminarCita = new bootstrap.Modal(modalEliminarCitaElement, {
        backdrop: true,
        keyboard: true
    });

    document.querySelectorAll('.btn-eliminar-cita').forEach(function (button) {

        button.addEventListener('click', function () {

            const id = this.getAttribute('data-id');
            const nombre = this.getAttribute('data-nombre');

            document.getElementById('nombreCitaEliminar').textContent = nombre;

            const form = document.getElementById('formEliminarCita');
            form.action = `/citas/${id}`;

            modalEliminarCita.show();

            setTimeout(function () {

                const backdrops = document.querySelectorAll('.modal-backdrop');
                const lastBackdrop = backdrops[backdrops.length - 1];

                if (lastBackdrop) {
                    lastBackdrop.classList.add('backdrop-eliminar-cita');
                }

            }, 10);

        });

    });

    modalEliminarCitaElement.addEventListener('hidden.bs.modal', function () {

        const modalCitasDia = document.getElementById('modalCitasDia');

        if (modalCitasDia && modalCitasDia.classList.contains('show')) {
            document.body.classList.add('modal-open');
        }

    });

});