@extends('layouts.app')

@section('title', 'Abrir Caja')

@section('content')
    <div class="container py-4">

        <div class="d-flex align-items-center gap-3 mb-4">
            <a href="{{ route('caja-chica.index') }}" class="btn btn-sm btn-light rounded-pill px-3">
                <i class="bi bi-arrow-left"></i>
            </a>

            <h2 class="fw-semibold mb-0">
                Abrir caja
            </h2>
        </div>

        <div class="card border-0 shadow-sm rounded-3">

            <div class="card-body p-4">

                <form action="{{ route('caja-chica.store') }}" method="POST">

                    @csrf

                    <!-- FECHA -->

                    <div class="mb-3">

                        <label class="form-label text-muted fw-semibold small">
                            Fecha
                        </label>

                        <input type="date" name="fecha" class="form-control @error('fecha') is-invalid @enderror"
                            value="{{ old('fecha', date('Y-m-d')) }}" readonly>

                        @error('fecha')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    <!-- HORA APERTURA -->

                    <div class="mb-3">

                        <label class="form-label text-muted fw-semibold small">
                            Hora de apertura
                        </label>

                        <input type="time" name="horaApertura"
                            class="form-control @error('horaApertura') is-invalid @enderror"
                            value="{{ old('horaApertura', date('H:i')) }}" readonly>

                        @error('horaApertura')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    <!-- MONTO INICIAL -->

                    <div class="mb-4">

                        <label class="form-label text-muted fw-semibold small">
                            Monto inicial
                        </label>

                        <div class="input-group">

                            <span class="input-group-text bg-light border-end-0 text-muted">
                                RD$
                            </span>

                            <input type="number" name="saldoInicial"
                                class="form-control border-start-0 @error('saldoInicial') is-invalid @enderror"
                                value="{{ old('saldoInicial') }}" placeholder="0.00" step="0.01" min="0">

                            @error('saldoInicial')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                    </div>

                    <!-- BOTONES -->

                    <div class="d-flex gap-2 justify-content-end">

                        <a href="{{ route('caja-chica.index') }}" class="btn btn-light rounded-pill px-4">
                            Cancelar
                        </a>

                        <button type="submit" class="btn rounded-pill px-4"
                            style="background-color: #0ea5e9; color: white;">

                            <i class="bi bi-cash-coin"></i>
                            Abrir caja

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>
@endsection
