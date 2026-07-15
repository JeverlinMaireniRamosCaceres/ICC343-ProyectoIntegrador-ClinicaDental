document.addEventListener("DOMContentLoaded", function () {
    const calendarGrid = document.getElementById("calendarGrid");
    const calendarTitle = document.getElementById("calendarTitle");
    const modalFechaTexto = document.getElementById("modalFechaTexto");
    const modalFechaInput = document.getElementById("modalFechaInput");

    // buscar odontologo
    const inputOdontologo = document.getElementById("odontologo_nombre");
    const resultadosOdontologos = document.getElementById(
        "resultadosOdontologos",
    );
    const odontologoId = document.getElementById("odontologo_id");

    if (inputOdontologo) {
        inputOdontologo.addEventListener("keyup", async function () {
            let texto = this.value;

            if (texto.length < 2) {
                resultadosOdontologos.innerHTML = "";
                return;
            }

            const response = await fetch(`/buscar-odontologos?texto=${texto}`);

            const odontologos = await response.json();

            resultadosOdontologos.innerHTML = "";

            odontologos.forEach((odontologo) => {
                resultadosOdontologos.innerHTML += `
            <button
                type="button"
                class="list-group-item list-group-item-action"
                onclick="seleccionarOdontologo(
                    ${odontologo.idOdontologo},
                    '${odontologo.persona.nombre} ${odontologo.persona.apellido}'
                )">

                ${odontologo.persona.nombre}
                ${odontologo.persona.apellido}

            </button>
        `;
            });
        });
    }

    window.seleccionarOdontologo = function (id, nombre) {
        inputOdontologo.value = nombre;
        odontologoId.value = id;
        resultadosOdontologos.innerHTML = "";
    };

    if (!calendarGrid || !calendarTitle) return;

    const today = new Date();

    let currentDate = new Date(today.getFullYear(), today.getMonth(), 1);
    let selectedDate = new Date(today);
    let fechaModalCitas = null;

    const months = [
        "Enero",
        "Febrero",
        "Marzo",
        "Abril",
        "Mayo",
        "Junio",
        "Julio",
        "Agosto",
        "Septiembre",
        "Octubre",
        "Noviembre",
        "Diciembre",
    ];

    const days = [
        "Domingo",
        "Lunes",
        "Martes",
        "Miércoles",
        "Jueves",
        "Viernes",
        "Sábado",
    ];

    let citasPorDia = {};

    function formatearHora12(hora) {
        const [h, m] = hora.split(":");

        let horas = parseInt(h, 10);
        const periodo = horas >= 12 ? "PM" : "AM";

        horas = horas % 12;
        horas = horas === 0 ? 12 : horas;

        return `${horas}:${m} ${periodo}`;
    }

    async function cargarCitasMes(year, month) {
        const response = await fetch(
            `/citas/por-mes?year=${year}&month=${month + 1}`,
            {
                headers: { "X-Requested-With": "XMLHttpRequest" },
            },
        );
        citasPorDia = await response.json();
        renderCalendar();
    }

    function formatDateKey(date) {
        const y = date.getFullYear();
        const m = String(date.getMonth() + 1).padStart(2, "0");
        const d = String(date.getDate()).padStart(2, "0");

        return `${y}-${m}-${d}`;
    }

    function formatSelectedDate(date) {
        const dayName = days[date.getDay()];
        const day = String(date.getDate()).padStart(2, "0");
        const monthName = months[date.getMonth()].toLowerCase();
        const year = date.getFullYear();

        return `${dayName}, ${day} ${monthName} ${year}`;
    }

    function getCalendarStartDate(year, month) {
        const firstDay = new Date(year, month, 1);

        let dayOfWeek = firstDay.getDay();

        if (dayOfWeek === 0) {
            dayOfWeek = 7;
        }

        const daysBack = dayOfWeek - 1;

        return new Date(year, month, 1 - daysBack);
    }

    function openCreateModal(date) {
        const today = new Date();
        today.setHours(0, 0, 0, 0);
        date.setHours(0, 0, 0, 0);

        if (date < today) {
            return;
        }

        selectedDate = date;

        const dateKey = formatDateKey(date);
        const readableDate = formatSelectedDate(date);

        if (modalFechaTexto) modalFechaTexto.textContent = readableDate;
        if (modalFechaInput) modalFechaInput.value = dateKey;

        const modal = new bootstrap.Modal(
            document.getElementById("modalNuevaCita"),
        );
        modal.show();
    }

    async function openDayAppointmentsModal(date) {
        fechaModalCitas = new Date(date);

        const modalFecha = document.getElementById("modalCitasDiaFecha");
        const modalCuerpo = document.getElementById("modalCitasDiaContenido");

        if (modalFecha) {
            modalFecha.textContent = formatSelectedDate(date);
        }

        if (modalCuerpo) {
            modalCuerpo.innerHTML = `
            <div class="text-center py-4 text-muted">
                <div class="spinner-border spinner-border-sm me-2"></div>
                Cargando citas...
            </div>
        `;
        }

        const modal = new bootstrap.Modal(
            document.getElementById("modalCitasDia"),
        );
        modal.show();

        const dateKey = formatDateKey(date);
        const response = await fetch(`/citas/por-fecha?fecha=${dateKey}`, {
            headers: { "X-Requested-With": "XMLHttpRequest" },
        });
        const citas = await response.json();

        if (modalCuerpo) {
            if (citas.length === 0) {
                modalCuerpo.innerHTML = `
                <div class="text-center py-4 text-muted">
                    <i class="bi bi-calendar-x fs-1 d-block mb-2"></i>
                    No hay citas para este día.
                </div>
            `;
            } else {
                modalCuerpo.innerHTML = citas
                    .map(
                        (cita) => `
                    <div class="appointment-modal-card">
                        <div class="d-flex align-items-center gap-3">
                            <div class="appointment-time-pill">
                                ${formatearHora12(cita.hora)}
                            </div>
                            <div>
                                <div class="fw-semibold text-dark">${cita.nombrePersona}</div>
                                <small class="text-muted">
                                    ${cita.odontologo?.persona?.nombre ?? "—"} ${cita.odontologo?.persona?.apellido ?? ""}
                                </small>
                            </div>
                        </div>

                        <div class="d-flex align-items-center gap-2">
                            <span class="appointment-status
                                ${cita.estado === "Pendiente" ? "appointment-status-pending" : ""}
                                ${cita.estado === "Confirmada" ? "appointment-status-confirmed" : ""}
                                ${cita.estado === "Cancelada" ? "appointment-status-cancelled" : ""}">
                                ${cita.estado}
                            </span>

                            ${
                                window.puedeGestionarCitas && !cita.esPasada && cita.estado !== "Cancelada"
                                    ? `
                                        <a href="/citas/${cita.idCita}/edit"
                                            class="btn btn-sm btn-warning rounded-pill px-3 text-white">
                                            <i class="bi bi-pencil"></i>
                                        </a>

                                        <button type="button"
                                            class="btn btn-sm btn-danger rounded-pill px-3 btn-eliminar-cita"
                                            data-id="${cita.idCita}"
                                            data-nombre="${cita.nombrePersona}">
                                            <i class="bi bi-x-lg"></i>
                                        </button>
                                    `
                                    : ""
                            }
                        </div>
                    </div>
                `,
                    )
                    .join("");
            }
        }
    }

    function renderCalendar() {
        calendarGrid.innerHTML = "";

        const year = currentDate.getFullYear();
        const month = currentDate.getMonth();

        calendarTitle.textContent = `${months[month]} ${year}`;

        let date = getCalendarStartDate(year, month);
        let renderedDays = 0;

        while (renderedDays < 36) {
            if (date.getDay() !== 0) {
                const dateKey = formatDateKey(date);
                const isCurrentMonth = date.getMonth() === month;
                const isSelected = dateKey === formatDateKey(selectedDate);
                const today = new Date();
                const isToday = dateKey === formatDateKey(today);
                const appointmentCount = citasPorDia[dateKey] || 0;
                const esPasado = (() => {
                    const hoy = new Date();
                    hoy.setHours(0, 0, 0, 0);
                    const d = new Date(date);
                    d.setHours(0, 0, 0, 0);
                    return d < hoy;
                })();

                const dayButton = document.createElement("div");
                dayButton.className = "calendar-day";

                if (!isCurrentMonth) dayButton.classList.add("other-month");
                if (isSelected) dayButton.classList.add("active");
                if (isToday) dayButton.classList.add("today");

                dayButton.innerHTML = `
                    <div class="d-flex justify-content-between align-items-start">
                        <span class="calendar-day-number">${date.getDate()}</span>

                        ${
                            !esPasado && window.puedeGestionarCitas
                                ? `
                                <button type="button" class="calendar-add-btn" title="Registrar cita">
                                    <i class="bi bi-plus-lg"></i>
                                </button>
                        `
                                : ""
                        }
                    </div>

                    <div class="calendar-day-info">
                        ${
                            appointmentCount > 0
                                ? `<span class="calendar-dot"></span><span>${appointmentCount} cita${appointmentCount > 1 ? "s" : ""}</span>`
                                : `<span>Sin citas</span>`
                        }
                    </div>
                `;

                const clickedDate = new Date(date);

                dayButton.addEventListener("click", function () {
                    selectedDate = clickedDate;
                    renderCalendar();

                    if (appointmentCount > 0) {
                        openDayAppointmentsModal(clickedDate);
                    }
                });

                const addButton = dayButton.querySelector(".calendar-add-btn");
                if (addButton) {
                    addButton.addEventListener("click", function (event) {
                        event.stopPropagation();
                        openCreateModal(clickedDate);
                    });
                }

                calendarGrid.appendChild(dayButton);
                renderedDays++;
            }

            date.setDate(date.getDate() + 1);
        }
    }

    document
        .getElementById("prevMonth")
        ?.addEventListener("click", function () {
            currentDate.setMonth(currentDate.getMonth() - 1);
            cargarCitasMes(currentDate.getFullYear(), currentDate.getMonth());
        });

    document
        .getElementById("btnNuevaCitaDesdeModal")
        ?.addEventListener("click", function () {
            if (!fechaModalCitas) return;

            const modalCitas = bootstrap.Modal.getInstance(
                document.getElementById("modalCitasDia"),
            );

            modalCitas.hide();

            setTimeout(() => {
                openCreateModal(new Date(fechaModalCitas));
            }, 250);
        });

    document
        .getElementById("nextMonth")
        ?.addEventListener("click", function () {
            currentDate.setMonth(currentDate.getMonth() + 1);
            cargarCitasMes(currentDate.getFullYear(), currentDate.getMonth());
        });

    document.getElementById("todayBtn")?.addEventListener("click", function () {
        const today = new Date();
        currentDate = new Date(today.getFullYear(), today.getMonth(), 1);
        selectedDate = today;
        cargarCitasMes(currentDate.getFullYear(), currentDate.getMonth());
    });

    document
        .getElementById("btnNuevaCitaGeneral")
        ?.addEventListener("click", function () {
            openCreateModal(selectedDate);
        });

    cargarCitasMes(currentDate.getFullYear(), currentDate.getMonth());
});
