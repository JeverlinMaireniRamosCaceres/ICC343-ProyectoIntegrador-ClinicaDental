@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row g-4">
    <div class="col-md-3">
        <div class="card p-3">
            <div class="d-flex align-items-center">
                <div class="bg-info bg-opacity-10 p-3 rounded-3 me-3 text-info">
                    <i class="bi bi-people fs-3"></i>
                </div>
                <div>
                    <h6 class="text-muted m-0">Pacientes</h6>
                    <h4 class="fw-bold m-0">1,250</h4>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection