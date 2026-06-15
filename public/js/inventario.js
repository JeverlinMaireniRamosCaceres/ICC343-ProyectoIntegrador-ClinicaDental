let filtroActual = "";

document.addEventListener("DOMContentLoaded", function () {

    const buscarProducto = document.getElementById("buscarProducto");

    async function cargarProductos(url = null) {

        const texto = buscarProducto ? buscarProducto.value : "";

        let ruta =
            url ||
            `/inventario?buscar=${encodeURIComponent(texto)}&filtro=${filtroActual}`;

        if (url) {

            const separador = ruta.includes("?") ? "&" : "?";

            ruta += `${separador}buscar=${encodeURIComponent(texto)}&filtro=${filtroActual}`;
        }

        const response = await fetch(ruta, {
            headers: {
                "X-Requested-With": "XMLHttpRequest",
            },
        });

        const html = await response.text();

        document.getElementById(
            "contenedorTablaProductos"
        ).innerHTML = html;
    }

    // cargar movimientos
    async function cargarMovimientos(url = null) {
        let ruta = url || `/inventario?tipo=movimientos`;

        if (url) {
            const separador = ruta.includes("?") ? "&" : "?";
            ruta += `${separador}tipo=movimientos`;
        }

        const response = await fetch(ruta, {
            headers: { "X-Requested-With": "XMLHttpRequest" },
        });

        document.getElementById("contenedorTablaMovimientos").innerHTML = await response.text();
    }

    // busqueda AJAX

    if (buscarProducto) {

        buscarProducto.addEventListener("keyup", function () {
            cargarProductos();
        });

    }

    // filtros

    document.querySelectorAll(".btn-filtro").forEach(btn => {

        btn.addEventListener("click", function () {

            document
                .querySelectorAll(".btn-filtro")
                .forEach(b => b.classList.remove("active"));

            this.classList.add("active");

            filtroActual = this.dataset.filtro;

            cargarProductos();
        });

    });

    // paginacion AJAX

    document.addEventListener("click", function (e) {

        const link = e.target.closest(".pagination a");
        if (!link) return;
        e.preventDefault();

        const tabActivoBtn = document.querySelector(".nav-link.active[data-bs-target]");
        const tabActivo = tabActivoBtn ? tabActivoBtn.getAttribute("data-bs-target") : null;
        console.log('Tab activo:', tabActivo);

        if (tabActivo === "#tab-productos") {
            cargarProductos(link.href);
        } else if (tabActivo === "#tab-movimientos") {
            cargarMovimientos(link.href);
        }

    });

    const hash = window.location.hash;
    if (hash) {
        const tabBtn = document.querySelector(`[data-bs-target="${hash}"]`);
        if (tabBtn) {
            bootstrap.Tab.getOrCreateInstance(tabBtn).show();
        }
    }

    // buscar producto en el modal de ajuste
    const inputProductoAjuste = document.getElementById("producto_nombre");

    const resultadosProductosAjuste = document.getElementById("resultadosProductos");

    const productoIdAjuste = document.getElementById("producto_id");

    const stockActualAjuste = document.getElementById("stockActualAjuste");

    const unidadAjuste = document.getElementById("unidadAjuste");

    if (inputProductoAjuste) {

        inputProductoAjuste.addEventListener("keyup", async function () {

            const texto = this.value;

            if (texto.length < 2) {
                resultadosProductosAjuste.innerHTML = "";
                return;
            }

            const response = await fetch(
                `/buscar-productos?texto=${encodeURIComponent(texto)}`
            );

            const productos = await response.json();

            resultadosProductosAjuste.innerHTML = "";

            productos.forEach(producto => {

                resultadosProductosAjuste.innerHTML += `
                <button
                    type="button"
                    class="list-group-item list-group-item-action"
                    data-id="${producto.idProducto}"
                    data-nombre="${producto.nombre}"
                    data-stock="${producto.stockActual}"
                    data-unidad="${producto.unidadMedida}">

                    <div class="fw-semibold">
                        ${producto.nombre}
                    </div>

                    <small class="text-muted">
                        Stock actual: ${producto.stockActual} ${producto.unidadMedida}
                    </small>

                </button>
            `;
            });

        });


    }

    // lotes del producto seleccionado
    const contenedorLote = document.getElementById('contenedorLote');
    const inputLoteDescripcion = document.getElementById('lote_descripcion');
    const resultadosLotes = document.getElementById('resultadosLotes');
    const loteId = document.getElementById('lote_id');

    // cuando se selecciona un producto, cargar sus lotes
    resultadosProductosAjuste.addEventListener("click", async function (e) {
        const boton = e.target.closest(".list-group-item");
        if (!boton) return;

        // rellenar datos del producto
        inputProductoAjuste.value = boton.dataset.nombre;
        productoIdAjuste.value = boton.dataset.id;
        stockActualAjuste.value = `${boton.dataset.stock} ${boton.dataset.unidad}`;
        unidadAjuste.textContent = boton.dataset.unidad;


        // resetear lote
        inputLoteDescripcion.value = '';
        loteId.value = '';
        resultadosLotes.innerHTML = '';
        contenedorLote.style.display = 'none';

        // cargar lotes del producto
        const idProducto = boton.dataset.id;
        const response = await fetch(`/inventario/${idProducto}/lotes`);
        const lotes = await response.json();

        if (lotes.length > 0) {
            contenedorLote.style.display = 'block';
            lotes.forEach(lote => {
                resultadosLotes.innerHTML += `
                <button type="button"
                    class="list-group-item list-group-item-action"
                    data-id="${lote.idDetalleCompra}"
                    data-cantidad="${lote.cantidad}"
                    data-descripcion="${lote.compra} | ${lote.cantidad} uds. | Vence: ${lote.fechaVencimiento}">
                    <div class="fw-semibold">${lote.compra}</div>
                    <small class="text-muted">
                        ${lote.cantidad} uds. — Vence: ${lote.fechaVencimiento}
                    </small>
                </button>
            `;
            });
        }
    });

    if (resultadosLotes) {
        resultadosLotes.addEventListener("click", function (e) {
            const boton = e.target.closest(".list-group-item");
            if (!boton) return;

            inputLoteDescripcion.value = boton.dataset.descripcion;
            loteId.value = boton.dataset.id;
            stockActualAjuste.value = `${boton.dataset.cantidad} ${unidadAjuste.textContent}`;
            resultadosLotes.innerHTML = '';
        });
    }


});