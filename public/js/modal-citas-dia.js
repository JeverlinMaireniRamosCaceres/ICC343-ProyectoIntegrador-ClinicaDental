document.addEventListener("DOMContentLoaded", function () {
    const modalEliminarCitaElement =
        document.getElementById("modalEliminarCita");

    if (!modalEliminarCitaElement) return;

    const modalEliminarCita = new bootstrap.Modal(modalEliminarCitaElement, {
        backdrop: true,
        keyboard: true,
    });

    document.addEventListener("click", function (e) {
        const button = e.target.closest(".btn-eliminar-cita");
        if (!button) return;

        const id = button.getAttribute("data-id");
        const nombre = button.getAttribute("data-nombre");

        document.getElementById("nombreCitaEliminar").textContent = nombre;
        document.getElementById("formEliminarCita").action = `/citas/${id}`;

        modalEliminarCita.show();

        setTimeout(function () {
            const backdrops = document.querySelectorAll(".modal-backdrop");
            const lastBackdrop = backdrops[backdrops.length - 1];
            if (lastBackdrop) {
                lastBackdrop.classList.add("backdrop-eliminar-cita");
            }
        }, 10);
    });

    modalEliminarCitaElement.addEventListener("hidden.bs.modal", function () {
        const modalCitasDia = document.getElementById("modalCitasDia");

        if (modalCitasDia && modalCitasDia.classList.contains("show")) {
            document.body.classList.add("modal-open");
        }
    });
});
