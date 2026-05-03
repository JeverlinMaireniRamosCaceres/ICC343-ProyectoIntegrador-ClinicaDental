document.addEventListener('DOMContentLoaded', function () {
    const calendarGrid = document.getElementById('calendarGrid');
    const calendarTitle = document.getElementById('calendarTitle');
    const selectedDateTitle = document.getElementById('selectedDateTitle');

    const modalFechaTexto = document.getElementById('modalFechaTexto');
    const modalFechaInput = document.getElementById('modalFechaInput');
    const modalHoraTexto = document.getElementById('modalHoraTexto');
    const modalHoraInput = document.getElementById('modalHoraInput');
    const modalOdontologoTexto = document.getElementById('modalOdontologoTexto');
    const modalOdontologoInput = document.getElementById('modalOdontologoInput');

    if (!calendarGrid || !calendarTitle || !selectedDateTitle) return;

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

                const dayButton = document.createElement('button');
                dayButton.type = 'button';
                dayButton.className = 'calendar-day text-start';

                if (!isCurrentMonth) dayButton.classList.add('other-month');
                if (isSelected) dayButton.classList.add('active');
                if (isToday) dayButton.classList.add('today');

                dayButton.innerHTML = `
                    <div class="d-flex justify-content-between align-items-start">
                        <span class="calendar-day-number">${date.getDate()}</span>

                        ${
                            appointmentCount > 0
                                ? `<button type="button" class="calendar-view-btn">Ver</button>`
                                : ''
                        }
                    </div>

                    <div class="calendar-day-info">
                        ${
                            appointmentCount > 0
                                ? `<span class="calendar-dot"></span><span>${appointmentCount} cita${appointmentCount > 1 ? 's' : ''}</span>`
                                : `<span>Sin citas</span>`
                        }
                    </div>
                `;

                const clickedDate = new Date(date);

                dayButton.addEventListener('click', function () {
                    selectedDate = clickedDate;
                    selectedDateTitle.textContent = formatSelectedDate(selectedDate);
                    renderCalendar();
                });

                const viewButton = dayButton.querySelector('.calendar-view-btn');

                if (viewButton) {
                    viewButton.addEventListener('click', function (event) {
                        event.stopPropagation();

                        const modalFecha = document.getElementById('modalCitasDiaFecha');

                        if (modalFecha) {
                            modalFecha.textContent = formatSelectedDate(clickedDate);
                        }

                        const modal = new bootstrap.Modal(document.getElementById('modalCitasDia'));
                        modal.show();
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

        selectedDateTitle.textContent = formatSelectedDate(selectedDate);
        renderCalendar();
    });

    document.querySelectorAll('.availability-row:not(.occupied)').forEach(function (slot) {
        slot.addEventListener('click', function () {
            document.querySelectorAll('.availability-row').forEach(function (item) {
                item.classList.remove('active');
            });

            slot.classList.add('active');

            const selectedDateKey = formatDateKey(selectedDate);
            const time = slot.dataset.time;
            const timeLabel = slot.dataset.timeLabel;
            const doctorId = slot.dataset.doctorId;
            const doctorName = slot.dataset.doctorName;

            modalFechaTexto.textContent = formatSelectedDate(selectedDate);
            modalFechaInput.value = selectedDateKey;

            modalHoraTexto.textContent = timeLabel;
            modalHoraInput.value = time;

            modalOdontologoTexto.textContent = doctorName;
            modalOdontologoInput.value = doctorId;

            const modal = new bootstrap.Modal(document.getElementById('modalNuevaCita'));
            modal.show();
        });
    });

    selectedDateTitle.textContent = formatSelectedDate(selectedDate);
    renderCalendar();
});