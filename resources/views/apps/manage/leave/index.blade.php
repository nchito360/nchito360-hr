@extends('layouts.user')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

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


        <h4 class="fw-bold">Team Leave Applications</h4>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- Pending Applications -->
        <div class="card mb-4">
            <div class="card-header">
                <h5>Pending Applications</h5>
            </div>
            <div class="card-body">
                @if ($pendingLeaves->count())
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Employee</th>
                                <th>Type</th>
                                <th>From</th>
                                <th>To</th>
                                <th>Reason</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pendingLeaves as $leave)
                                <tr>
                                    <td>{{ $leave->user->first_name }} {{ $leave->user->last_name }}</td>
                                    <td>{{ ucfirst($leave->type) }}</td>
                                    <td>{{ $leave->start_date }}</td>
                                    <td>{{ $leave->end_date }}</td>
                                    <td>{{ $leave->reason }}</td>
                                    <td>
                                        <form action="{{ route('leave.approve', $leave->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success">Approve</button>
                                        </form>
                                        <button class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#rejectModal{{ $leave->id }}">Reject</button>

                                        <!-- Reject Modal -->
                                        <div class="modal fade" id="rejectModal{{ $leave->id }}" tabindex="-1">
                                            <div class="modal-dialog">
                                                <form action="{{ route('leave.reject', $leave->id) }}" method="POST">
                                                    @csrf
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Reject Leave</h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <label>Comment</label>
                                                            <textarea name="manager_comment" class="form-control" required></textarea>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-danger">Reject</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p>No pending applications.</p>
                @endif
            </div>
        </div>
    </div>
@endsection
