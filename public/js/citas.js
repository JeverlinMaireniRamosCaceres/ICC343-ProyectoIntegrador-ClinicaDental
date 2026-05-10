document.addEventListener('DOMContentLoaded', function () {
    const calendarGrid = document.getElementById('calendarGrid');
    const calendarTitle = document.getElementById('calendarTitle');
    const modalFechaTexto = document.getElementById('modalFechaTexto');
    const modalFechaInput = document.getElementById('modalFechaInput');

    if (!calendarGrid || !calendarTitle) return;

    let currentDate = new Date(2026, 4, 1);
    let selectedDate = new Date(2026, 4, 2);

    const months = [
        'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
        'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
    ];

    const days = [
        'Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'
    ];

    const fakeAppointments = {
        '2026-05-01': 2,
        '2026-05-06': 4,
        '2026-05-12': 1,
        '2026-05-18': 3,
        '2026-05-25': 2
    };

    function formatDateKey(date) {
        const y = date.getFullYear();
        const m = String(date.getMonth() + 1).padStart(2, '0');
        const d = String(date.getDate()).padStart(2, '0');

        return `${y}-${m}-${d}`;
    }

    function formatSelectedDate(date) {
        const dayName = days[date.getDay()];
        const day = String(date.getDate()).padStart(2, '0');
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
        selectedDate = date;

        const dateKey = formatDateKey(date);
        const readableDate = formatSelectedDate(date);

        if (modalFechaTexto) modalFechaTexto.textContent = readableDate;
        if (modalFechaInput) modalFechaInput.value = dateKey;

        const modal = new bootstrap.Modal(document.getElementById('modalNuevaCita'));
        modal.show();
    }

    function openDayAppointmentsModal(date) {
        const modalFecha = document.getElementById('modalCitasDiaFecha');

        if (modalFecha) {
            modalFecha.textContent = formatSelectedDate(date);
        }

        const modal = new bootstrap.Modal(document.getElementById('modalCitasDia'));
        modal.show();
    }

    function renderCalendar() {
        calendarGrid.innerHTML = '';

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
                const appointmentCount = fakeAppointments[dateKey] || 0;

                const dayButton = document.createElement('div');
                dayButton.className = 'calendar-day';

                if (!isCurrentMonth) dayButton.classList.add('other-month');
                if (isSelected) dayButton.classList.add('active');
                if (isToday) dayButton.classList.add('today');

                dayButton.innerHTML = `
                    <div class="d-flex justify-content-between align-items-start">
                        <span class="calendar-day-number">${date.getDate()}</span>

                        <button type="button" class="calendar-add-btn" title="Registrar cita">
                            <i class="bi bi-plus-lg"></i>
                        </button>
                    </div>

                    <div class="calendar-day-info">
                        ${
                            appointmentCount > 0
                                ? `<span class="calendar-dot"></span><span>${appointmentCount} cita${appointmentCount > 1 ? 's' : ''}</span>`
                                : `<span>Sin citas</span>`
                        }
                    </div>

                    ${
                        appointmentCount > 0
                            ? `<div class="mt-3">
                                   <button type="button" class="calendar-view-btn">
                                       Ver citas
                                   </button>
                               </div>`
                            : ''
                    }
                `;

                const clickedDate = new Date(date);

                dayButton.addEventListener('click', function () {
                    selectedDate = clickedDate;
                    renderCalendar();
                });

                const addButton = dayButton.querySelector('.calendar-add-btn');
                addButton.addEventListener('click', function (event) {
                    event.stopPropagation();
                    openCreateModal(clickedDate);
                });

                const viewButton = dayButton.querySelector('.calendar-view-btn');

                if (viewButton) {
                    viewButton.addEventListener('click', function (event) {
                        event.stopPropagation();
                        openDayAppointmentsModal(clickedDate);
                    });
                }

                calendarGrid.appendChild(dayButton);
                renderedDays++;
            }

            date.setDate(date.getDate() + 1);
        }
    }

    document.getElementById('prevMonth')?.addEventListener('click', function () {
        currentDate.setMonth(currentDate.getMonth() - 1);
        renderCalendar();
    });

    document.getElementById('nextMonth')?.addEventListener('click', function () {
        currentDate.setMonth(currentDate.getMonth() + 1);
        renderCalendar();
    });

    document.getElementById('todayBtn')?.addEventListener('click', function () {
        const today = new Date();

        currentDate = new Date(today.getFullYear(), today.getMonth(), 1);
        selectedDate = today;

        renderCalendar();
    });

    document.getElementById('btnNuevaCitaGeneral')?.addEventListener('click', function () {
        openCreateModal(selectedDate);
    });

    renderCalendar();
});