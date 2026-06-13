document.addEventListener("DOMContentLoaded", function () {
    // Cédula RD
    document.querySelectorAll(".mask-cedula").forEach((input) => {
        input.addEventListener("input", function (e) {
            let valor = e.target.value.replace(/\D/g, "");

            valor = valor.substring(0, 11);

            if (valor.length > 10) {
                valor = valor.replace(/(\d{3})(\d{7})(\d{1})/, "$1-$2-$3");
            } else if (valor.length > 3) {
                valor = valor.replace(/(\d{3})(\d+)/, "$1-$2");
            }

            e.target.value = valor;
        });
    });

    // Teléfono RD
    document.querySelectorAll(".mask-telefono-rd").forEach((input) => {
        input.addEventListener("input", function (e) {
            let valor = e.target.value.replace(/\D/g, "");

            valor = valor.substring(0, 10);

            if (valor.length > 6) {
                valor = valor.replace(/(\d{3})(\d{3})(\d{4})/, "$1-$2-$3");
            } else if (valor.length > 3) {
                valor = valor.replace(/(\d{3})(\d+)/, "$1-$2");
            }

            e.target.value = valor;
        });
    });

    // Teléfono internacional
    document.querySelectorAll(".mask-telefono").forEach((input) => {
        input.addEventListener("input", function (e) {
            e.target.value = e.target.value.replace(/[^\d+\-\s()]/g, "");
        });
    });
});
