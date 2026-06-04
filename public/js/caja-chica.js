document.getElementById("filtroFecha").addEventListener("change", filtrarCajas);

// Paginación AJAX
document.addEventListener("click", async function (e) {
    if (e.target.closest(".pagination a")) {
        e.preventDefault();

        const url = e.target.closest("a").href;

        const response = await fetch(url, {
            headers: {
                "X-Requested-With": "XMLHttpRequest",
            },
        });

        const html = await response.text();

        document.getElementById("contenedorTablaCajas").innerHTML = html;
    }
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

let saldoActual = 0;

document.addEventListener("click", function (e) {
    const btn = e.target.closest(".btnCerrarCaja");

    if (!btn) return;

    saldoActual = parseFloat(btn.dataset.monto);

    document.getElementById("idCajaCerrar").value = btn.dataset.id;

    document.getElementById("saldoSistema").textContent =
        `RD$ ${saldoActual.toFixed(2)}`;

    document.getElementById("montoContado").value = "";

    document.getElementById("diferenciaCaja").textContent = "RD$ 0.00";
});

document.addEventListener("input", function (e) {
    if (e.target.id !== "montoContado") return;

    const contado = parseFloat(e.target.value) || 0;

    const diferencia = contado - saldoActual;

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
});
