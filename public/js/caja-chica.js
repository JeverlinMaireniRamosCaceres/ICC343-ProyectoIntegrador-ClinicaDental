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

    window.history.pushState({}, "", link.href);
});

// Cambio de cantidad de filas con AJAX
document.addEventListener("change", async function (e) {
    if (e.target.id !== "porPagina") return;

    const form = e.target.form;

    const params = new URLSearchParams(new FormData(form));

    const url = `${form.action}?${params.toString()}`;

    const response = await fetch(url, {
        headers: {
            "X-Requested-With": "XMLHttpRequest",
        },
    });

    const html = await response.text();

    document.getElementById("contenedorTablaCajas").innerHTML = html;

    window.history.pushState({}, "", url);
});

// Filtrar cajas
async function filtrarCajas() {
    const fecha = document.getElementById("filtroFecha").value;
    const porPagina = document.getElementById("porPagina")?.value ?? 6;

    const url = `/caja-chica?fecha=${encodeURIComponent(
        fecha,
    )}&porPagina=${porPagina}`;

    const response = await fetch(url, {
        headers: {
            "X-Requested-With": "XMLHttpRequest",
        },
    });

    const html = await response.text();

    document.getElementById("contenedorTablaCajas").innerHTML = html;

    window.history.pushState({}, "", url);
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
