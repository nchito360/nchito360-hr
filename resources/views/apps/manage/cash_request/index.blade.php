@extends('layouts.user')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
@if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="card p-4 mb-4">
            <h5 class="mb-3">Manage Applications</h5>
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('manage.attendance') }}" class="btn btn-primary">
                    <i class="bx bx-calendar-check me-1"></i> Manage Attendance
                </a>
                <a href="{{ route('manage.overtime') }}" class="btn btn-warning">
                    <i class="bx bx-time-five me-1"></i> Manage Overtime
                </a>
                <a href="{{ route('manage.payroll') }}" class="btn btn-success">
                    <i class="bx bx-money me-1"></i> Manage Payroll
                </a>
                <a href="{{ route('manage.leave') }}" class="btn btn-info">
                    <i class="bx bx-calendar-minus me-1"></i> Manage Leave
                </a>
                <a href="{{ route('manage.cash_request') }}" class="btn btn-secondary">
                    <i class="bx bx-wallet me-1"></i> Manage Cash Requests
                </a>
                <a href="{{ route('manage.employees') }}" class="btn btn-dark">
                    <i class="bx bx-group me-1"></i> Manage Employees
                </a>
            </div>
        </div>
    <h4 class="fw-bold">Cash Request Management</h4>
    <p>Welcome to the attendance module. Start by logging or reviewing attendance records.</p>
</div>
@endsection
