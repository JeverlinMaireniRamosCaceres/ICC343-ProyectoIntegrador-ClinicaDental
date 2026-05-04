@extends('layouts.app')

@section('title', 'Citas')

@section('content')

<div class="container-fluid py-4 px-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">Citas</h2>
        </div>

    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body">
                    <small class="text-muted">Citas de hoy</small>
                    <h4 class="fw-bold mb-0 text-primary">6</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">

        <!-- Calendario -->
        <div class="col-xl-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h4 class="fw-bold mb-0" id="calendarTitle">Mayo 2026</h4>
                            <small class="text-muted">Selecciona un día para ver horarios disponibles</small>
                        </div>

                        <div class="d-flex gap-2">
                            <button class="btn btn-light rounded-circle shadow-sm" id="prevMonth" type="button">
                                <i class="bi bi-chevron-left"></i>
                            </button>

                            <button class="btn btn-light rounded-pill px-3 shadow-sm" id="todayBtn" type="button">
                                Hoy
                            </button>

                            <button class="btn btn-light rounded-circle shadow-sm" id="nextMonth" type="button">
                                <i class="bi bi-chevron-right"></i>
                            </button>
                        </div>
                    </div>

                    <div class="calendar-weekdays mb-2">
                        <div>Lun</div>
                        <div>Mar</div>
                        <div>Mié</div>
                        <div>Jue</div>
                        <div>Vie</div>
                        <div>Sáb</div>
                    </div>

                    <div id="calendarGrid" class="calendar-grid"></div>

                </div>
            </div>
        </div>

        <!-- Disponibilidad -->
        <div class="col-xl-4">
            <div class="card border-0 shadow-sm rounded-4 sticky-panel">
                <div class="card-body p-4">

                    <small class="text-muted">Día seleccionado</small>
                    <h5 class="fw-bold mt-1 mb-3" id="selectedDateTitle"></h5>

                    <hr>

                    <h6 class="fw-bold mb-1">Disponibilidad</h6>
                    <small class="text-muted d-block mb-3">
                        Seleccione un horario disponible para registrar la cita.
                    </small>

                    <div id="availabilityList" class="d-flex flex-column gap-2">

                        <button type="button"
                                class="availability-row"
                                data-time="08:00"
                                data-time-label="08:00 AM"
                                data-doctor-id="1"
                                data-doctor-name="Dr. Juan Pérez">
                            <div>
                                <span class="fw-bold d-block">08:00 AM</span>
                                <small class="text-muted">Dr. Juan Pérez</small>
                            </div>

                        </button>

                        <button type="button"
                                class="availability-row"
                                data-time="08:30"
                                data-time-label="08:30 AM"
                                data-doctor-id="2"
                                data-doctor-name="Dra. Laura Gómez">
                            <div>
                                <span class="fw-bold d-block">08:30 AM</span>
                                <small class="text-muted">Dra. Laura Gómez</small>
                            </div>

                        </button>

                        <button type="button"
                                class="availability-row"
                                data-time="09:30"
                                data-time-label="09:30 AM"
                                data-doctor-id="3"
                                data-doctor-name="Dr. Carlos Ramírez">
                            <div>
                                <span class="fw-bold d-block">09:30 AM</span>
                                <small class="text-muted">Dr. Carlos Ramírez</small>
                            </div>

                        </button>

                        <button type="button"
                                class="availability-row"
                                data-time="10:00"
                                data-time-label="10:00 AM"
                                data-doctor-id="2"
                                data-doctor-name="Dra. Laura Gómez">
                            <div>
                                <span class="fw-bold d-block">10:00 AM</span>
                                <small class="text-muted">Dra. Laura Gómez</small>
                            </div>
                            
                        </button>

                    </div>

                </div>
            </div>
        </div>

    </div>

</div>

@include('citas.partials.modal-create')
@include('citas.partials.modal-dia')

@endsection