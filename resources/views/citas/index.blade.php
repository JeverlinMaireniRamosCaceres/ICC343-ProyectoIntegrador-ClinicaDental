@extends('layouts.app')

@section('title', 'Citas')

@section('content')

    <div class="container-fluid p-3">

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm rounded-4 border-0 mb-3" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-3">

                <div class="d-flex justify-content-between align-items-center mb-3">

                    <div>
                        <h4 class="fw-semibold mb-1">Calendario de citas</h4>
                        <h4 class="fw-semibold mb-0" id="calendarTitle">Junio 2026</h4>
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

                <div class="calendar-weekdays mb-2 mt-2">
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

    @rol('Administrador', 'Secretaria')
        @include('citas.partials.modal-create')
    @endrol

    @include('citas.partials.modal-dia')

    <script>
        window.puedeGestionarCitas = @json(auth()->user()->rol->nombre !== 'Doctor');
    </script>

    <script src="{{ asset('js/modal-citas-dia.js') }}"></script>

    @rol('Administrador', 'Secretaria')
        @if ($errors->any())
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const fecha = @json(old('fecha'));

                    if (fecha) {
                        document.getElementById('modalFechaInput').value = fecha;

                        const fechaTexto = new Date(fecha + 'T00:00:00');

                        const opciones = {
                            weekday: 'long',
                            day: '2-digit',
                            month: 'long',
                            year: 'numeric'
                        };

                        document.getElementById('modalFechaTexto').textContent =
                            fechaTexto.toLocaleDateString('es-DO', opciones);
                    }

                    const modal = new bootstrap.Modal(document.getElementById('modalNuevaCita'));
                    modal.show();
                });
            </script>
        @endif
    @endrol

@endsection
