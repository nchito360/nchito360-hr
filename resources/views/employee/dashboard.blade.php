@extends('layouts.user')

@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <!-- Welcome Card -->
            <div class="row">



                <div class="col-lg-12 mb-4">
                    <div class="card">
                        <div class="d-flex align-items-end row">
                            <div class="col-sm-7">
                                <div class="card-body">
                                    <h5 class="card-title text-primary">
                                        Welcome back, {{ auth()->user()->first_name ?? 'John Doe' }}! 👋
                                    </h5>
                                    <p class="mb-4">Here's a quick summary of your HR dashboard.</p>
                                    <a href="{{route('employee.company.overview')}}" class="btn btn-sm btn-outline-primary">Manage Company</a>
                                </div>

                            </div>
                            <div class="col-sm-5 text-center text-sm-left">
                                <img src="{{ asset('hr-app/assets/img/illustrations/man-with-laptop-light.png') }}"
                                    height="140" alt="Dashboard">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Dashboard Cards -->
            <div class="row">

                <div class="my-3">
                    <div class="d-flex flex-wrap gap-2">
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


                <!-- Leave Balance -->
                <div class="col-md-6 col-xl-3 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">Leave Balance</h5>
                            <p class="card-text">10 of 20 days left</p>
                            <a href="#" class="btn btn-outline-info btn-sm">Apply Leave</a>
                        </div>
                    </div>
                </div>

                <!-- Payslips -->
                <div class="col-md-6 col-xl-3 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">Payslips</h5>
                            <p class="card-text">Access your monthly payslips</p>
                            <a href="#" class="btn btn-outline-secondary btn-sm">View Payslips</a>
                        </div>
                    </div>
                </div>

                <!-- Overtime Management -->
                <div class="col-md-6 col-xl-3 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">Overtime</h5>
                            <p class="card-text">Track and request overtime hours</p>
                            <a href="#" class="btn btn-outline-warning btn-sm">Manage Overtime</a>
                        </div>
                    </div>
                </div>

                <!-- Cash Requisition -->
                <div class="col-md-6 col-xl-3 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">Cash Requisition</h5>
                            <p class="card-text">Request funds for business use</p>
                            <a href="#" class="btn btn-outline-success btn-sm">Request Cash</a>
                        </div>
                    </div>
                </div>

                <!-- Attendance -->
                <div class="col-md-6 col-xl-3 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">Attendance</h5>
                            <p class="card-text">View daily check-ins & logs</p>
                            <a href="#" class="btn btn-outline-dark btn-sm">View Attendance</a>
                        </div>
                    </div>
                </div>

                <!-- Performance Reviews -->
                <div class="col-md-6 col-xl-3 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">Performance</h5>
                            <p class="card-text">Your recent performance reviews</p>
                            <a href="#" class="btn btn-outline-primary btn-sm">View Reviews</a>
                        </div>
                    </div>
                </div>

                <!-- Training & Development -->
                <div class="col-md-6 col-xl-3 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">Training</h5>
                            <p class="card-text">Courses and skills improvement</p>
                            <a href="#" class="btn btn-outline-info btn-sm">View Trainings</a>
                        </div>
                    </div>
                </div>

                <!-- Policies -->
                <div class="col-md-6 col-xl-3 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">Company Policies</h5>
                            <p class="card-text">Access official HR policies</p>
                            <a href="#" class="btn btn-outline-secondary btn-sm">Read Policies</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
