@extends('layouts.user')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y d-flex flex-column align-items-center justify-content-center text-center" style="min-height: 70vh;">

    <!-- Buttons Row -->
    <div class="row w-100 mb-4">
        <div class="col">
            <div class="d-flex flex-wrap gap-2 justify-content-center">
                <a href="{{ route('apps.attendance') }}" class="btn btn-primary">
                    <i class="bx bx-calendar-check me-1"></i> Attendance
                </a>
                <a href="{{ route('apps.overtime') }}" class="btn btn-warning">
                    <i class="bx bx-time-five me-1"></i> Overtime
                </a>
                <a href="{{ route('apps.payroll') }}" class="btn btn-success">
                    <i class="bx bx-money me-1"></i> Payroll
                </a>
                <a href="{{ route('apps.leave') }}" class="btn btn-info">
                    <i class="bx bx-calendar-minus me-1"></i> Leave Days
                </a>
                <a href="{{ route('apps.cash-request') }}" class="btn btn-secondary">
                    <i class="bx bx-wallet me-1"></i> Cash Request
                </a>
                <a href="{{ route('apps.other') }}" class="btn btn-dark">
                    <i class="bx bx-briefcase-alt me-1"></i> Other Apps
                </a>
            </div>
        </div>
    </div>

    <!-- Illustration and message row -->
    <div class="row w-100 justify-content-center">
        <div class="col-auto">
            <img src="{{ asset('hr-app/assets/img/illustrations/404.png') }}" alt="No Applications" class="mb-4" style="max-width: 300px;">
            <h4 class="fw-bold">No Subscribed Applications</h4>
            <p class="text-muted mb-4">
                You haven’t subscribed to any applications yet. Once you subscribe, they will appear here.
            </p>
            <a href="#" class="btn btn-primary">
                <i class="bx bx-store"></i> Browse Available Applications
            </a>
        </div>
    </div>

</div>
@endsection
