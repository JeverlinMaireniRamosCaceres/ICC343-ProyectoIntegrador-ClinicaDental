// Filtro fecha

const filtroFecha = document.getElementById("filtroFecha");

if (filtroFecha) {
    filtroFecha.addEventListener("change", filtrarCajas);
}

// Paginación AJAX

document.addEventListener("click", async function (e) {
    const link = e.target.closest(".pagination a");

    if (!link) return;

    e.preventDefault();

    const response = await fetch(link.href, {
        headers: {
            "X-Requested-With": "XMLHttpRequest",
        },
    });

    const html = await response.text();

    document.getElementById("contenedorTablaCajas").innerHTML = html;
});

// Filtrar cajas

async function filtrarCajas() {
    const fecha = document.getElementById("filtroFecha").value;

    const response = await fetch(`/caja-chica?fecha=${fecha}`, {
        headers: {
            "X-Requested-With": "XMLHttpRequest",
        },
    });

    const html = await response.text();

    document.getElementById("contenedorTablaCajas").innerHTML = html;
}

document.addEventListener("input", function (e) {
    if (e.target.id !== "montoContado") return;

    const saldo = parseFloat(
        document.getElementById("saldoSistema").dataset.saldo,
    );

    const contado = parseFloat(e.target.value) || 0;

    const diferencia = contado - saldo;

    const span = document.getElementById("diferenciaCaja");

    span.textContent = `RD$ ${diferencia.toFixed(2)}`;

    span.classList.remove("text-success", "text-danger", "text-secondary");

    if (diferencia > 0) {
        span.classList.add("text-success");
    } else if (diferencia < 0) {
        span.classList.add("text-danger");
    } else {
        span.classList.add("text-secondary");
    }

    document.getElementById("btnConfirmarCierre").disabled =
        e.target.value.trim() === "";
});

// Modal egreso

document.addEventListener("input", function () {
    const montoInput = document.getElementById("montoEgreso");

    const descripcionInput = document.getElementById("descripcionEgreso");

    const btnGuardar = document.getElementById("btnGuardarEgreso");

    if (!montoInput || !descripcionInput || !btnGuardar) return;

    const monto = parseFloat(montoInput.value) || 0;

    const descripcion = descripcionInput.value.trim();

    btnGuardar.disabled = monto <= 0 || descripcion === "";
});

const modalEgreso = document.getElementById("modalEgreso");

if (modalEgreso) {
    modalEgreso.addEventListener("show.bs.modal", function () {
        document.getElementById("montoEgreso").value = "";

        document.getElementById("descripcionEgreso").value = "";

        document.getElementById("btnGuardarEgreso").disabled = true;
    });
}
