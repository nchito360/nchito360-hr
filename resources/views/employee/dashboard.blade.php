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
                                    <!-- HR Insights & Facts Card -->
                                    <div id="hr-insight-card" class="alert alert-info d-flex align-items-center fade show" role="alert" style="transition: all 0.6s cubic-bezier(.4,2,.6,1); min-height: 70px;">
                                        <i class="bx bx-bulb bx-tada me-2" style="font-size: 2rem; color: #0d6efd;"></i>
                                        <div id="hr-insight-text" class="flex-grow-1" style="font-size: 1.1rem;">
                                            <!-- Fact will be injected here -->
                                        </div>
                                    </div>

                                    @push('scripts')
                                    <script>
                                        const hrFacts = [
                                            "Did you know? In Kenya, employees are entitled to at least 21 days of paid annual leave after every 12 months of service.",
                                            "HR Tip: Regular feedback improves employee engagement and performance.",
                                            "Fact: The Employment Act of Kenya protects against unfair dismissal.",
                                            "Insight: Continuous learning and training can boost your career growth.",
                                            "Law: Overtime work should be compensated at 1.5 times the normal hourly rate.",
                                            "Did you know? Employers must provide a safe and healthy working environment under the Occupational Safety and Health Act.",
                                            "HR Fact: Employees are entitled to paid sick leave after two consecutive months of service.",
                                            "Tip: Keeping your personal details updated helps HR serve you better.",
                                            "Fact: Gender equality in the workplace is protected by law in Kenya.",
                                            "Insight: Taking regular breaks can improve productivity and mental health."
                                        ];

                                        let currentFact = 0;

                                        function showNextFact() {
                                            const insightText = document.getElementById('hr-insight-text');
                                            const card = document.getElementById('hr-insight-card');
                                            // Fade out
                                            card.classList.remove('show');
                                            setTimeout(() => {
                                                // Change fact
                                                insightText.textContent = hrFacts[currentFact];
                                                // Fade in
                                                card.classList.add('show');
                                                // Next fact index
                                                currentFact = (currentFact + 1) % hrFacts.length;
                                            }, 600);
                                        }

                                        document.addEventListener('DOMContentLoaded', function() {
                                            document.getElementById('hr-insight-text').textContent = hrFacts[0];
                                            setInterval(showNextFact, 4000);
                                        });
                                    </script>
                                    @endpush
                                    
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

            <div class="row">
        <!-- Leave Balance -->
        <div class="col-md-6 col-xl-3 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">Leave Balance</h5>
                    <p class="card-text">manage your Leave Days</p>
                    <a href="#" class="btn btn-outline-info btn-sm alert-btn">Apply Leave</a>
                </div>
            </div>
        </div>

        <!-- Payslips -->
        <div class="col-md-6 col-xl-3 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">Payslips</h5>
                    <p class="card-text">Access your monthly payslips</p>
                    <a href="#" class="btn btn-outline-secondary btn-sm alert-btn">View Payslips</a>
                </div>
            </div>
        </div>

        <!-- Overtime Management -->
        <div class="col-md-6 col-xl-3 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">Overtime</h5>
                    <p class="card-text">Track and request overtime hours</p>
                    <a href="#" class="btn btn-outline-warning btn-sm alert-btn">Manage Overtime</a>
                </div>
            </div>
        </div>

        <!-- Cash Requisition -->
        <div class="col-md-6 col-xl-3 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">Cash Requisition</h5>
                    <p class="card-text">Request funds for business use</p>
                    <a href="#" class="btn btn-outline-success btn-sm alert-btn">Request Cash</a>
                </div>
            </div>
        </div>

        <!-- Attendance -->
        <div class="col-md-6 col-xl-3 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">Attendance</h5>
                    <p class="card-text">View daily check-ins & logs</p>
                    <a href="#" class="btn btn-outline-dark btn-sm alert-btn">View Attendance</a>
                </div>
            </div>
        </div>

        <!-- Performance Reviews -->
        <div class="col-md-6 col-xl-3 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">Performance</h5>
                    <p class="card-text">Your recent performance reviews</p>
                    <a href="#" class="btn btn-outline-primary btn-sm alert-btn">View Reviews</a>
                </div>
            </div>
        </div>

        <!-- Training & Development -->
        <div class="col-md-6 col-xl-3 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">Training</h5>
                    <p class="card-text">Courses and skills improvement</p>
                    <a href="#" class="btn btn-outline-info btn-sm alert-btn">View Trainings</a>
                </div>
            </div>
        </div>

        <!-- Policies -->
        <div class="col-md-6 col-xl-3 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">Company Policies</h5>
                    <p class="card-text">Access official HR policies</p>
                    <a href="#" class="btn btn-outline-secondary btn-sm alert-btn">Read Policies</a>
                </div>
            </div>
        </div>
    </div>
            
        </div>
    </div>
@endsection
