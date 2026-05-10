@extends('layouts.app')

@section('title', 'Citas')

@section('content')

<div class="container-fluid py-3 px-5">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h2 class="fw-bold text-dark mb-0">Citas</h2>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h4 class="fw-bold mb-0" id="calendarTitle">Mayo 2026</h4>
                    <small class="text-muted">Selecciona un día para registrar o ver citas</small>
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

            <div id="calendarGrid" class="calendar-grid calendar-grid-full"></div>

        </div>
    </div>

</div>

@include('citas.partials.modal-create')
@include('citas.partials.modal-dia')
<script src="{{ asset('js/modal-citas-dia.js') }}"></script>
@endsection