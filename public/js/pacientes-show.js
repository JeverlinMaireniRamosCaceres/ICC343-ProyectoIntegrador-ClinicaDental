(function () {
    const busqueda = document.getElementById("filtroBusqueda");
    const doctor = document.getElementById("filtroDoctor");
    const desde = document.getElementById("filtroDesde");
    const hasta = document.getElementById("filtroHasta");
    const porPagina = document.getElementById("porPagina");
    const limpiar = document.getElementById("filtroLimpiar");

    async function cargarConsultas(url = null) {
        const params = new URLSearchParams();

        if (busqueda.value) {
            params.append("buscar", busqueda.value);
        }

        if (doctor.value) {
            params.append("doctor", doctor.value);
        }

        if (desde.value) {
            params.append("desde", desde.value);
        }

        if (hasta.value) {
            params.append("hasta", hasta.value);
        }

        if (porPagina.value) {
            params.append("porPagina", porPagina.value);
        }

        const destino =
            url ?? `${window.location.pathname}?${params.toString()}`;

        const response = await fetch(destino, {
            headers: {
                "X-Requested-With": "XMLHttpRequest",
            },
        });

        const html = await response.text();

        document.getElementById("contenedorConsultas").innerHTML = html;

        // Mantener el hash (#historial) al actualizar la URL
        window.history.replaceState({}, "", destino + window.location.hash);
    }

    busqueda.addEventListener("input", () => cargarConsultas());

    doctor.addEventListener("change", () => cargarConsultas());

    desde.addEventListener("change", () => cargarConsultas());

    hasta.addEventListener("change", () => cargarConsultas());

    porPagina.addEventListener("change", () => cargarConsultas());

    limpiar.addEventListener("click", () => {
        busqueda.value = "";
        doctor.value = "";
        desde.value = "";
        hasta.value = "";
        porPagina.value = "10";

        cargarConsultas();
    });

    // Paginación AJAX
    document.addEventListener("click", async function (e) {
        const enlace = e.target.closest(".pagination a");

        if (!enlace) return;

        e.preventDefault();

        await cargarConsultas(enlace.href);
    });
})();

// Restaurar pestaña según el hash de la URL
document.addEventListener("DOMContentLoaded", function () {
    if (window.location.hash) {
        const trigger = document.querySelector(
            `button[data-bs-target="${window.location.hash}"]`,
        );

        if (trigger) {
            bootstrap.Tab.getOrCreateInstance(trigger).show();
        }
    }
});

// Guardar la pestaña activa en la URL
document.querySelectorAll("#pacienteTab button").forEach((tab) => {
    tab.addEventListener("shown.bs.tab", function (e) {
        history.replaceState(
            null,
            null,
            window.location.pathname +
                window.location.search +
                e.target.dataset.bsTarget,
        );
    });
});

// Agregar automáticamente el parámetro return a tratamientos y consultas
document.addEventListener("click", function (e) {
    const link = e.target.closest(".tratamiento-link, .consulta-link");

    if (!link) return;

    e.preventDefault();

    const url = new URL(link.href);

    url.searchParams.set("return", window.location.href);

    window.location.href = url.toString();
});
