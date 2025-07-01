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


    <h4 class="fw-bold">Team Leave Applications</h4>

    @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Filter Form -->
    <!-- <form method="GET" action="{{ route('manage.leave') }}" class="mb-4">
        <select name="status" id="status" class="form-select">
            <option value="">All</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
        </select>
        <button type="submit" class="btn btn-primary">Filter</button>
    </form> -->



    <!-- All Leave Applications -->
    <div class="card mb-4">
        <div class="card-header">
            <h5>All Leave Applications</h5>
        </div>
        <div class="card-body">
            @if ($allLeaves->count())
            <table class="table">
                <thead>
                    <tr>
                        <th>Employee</th>
                        <th>Type</th>
                        <th>From</th>
                        <th>To</th>
                        <th>Days</th>
                        <th>Reason</th>
                        <th>Document</th>
                        <th>Status</th>
                        <th>Manager Comment</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($allLeaves as $leave)
                    <tr>
                        <td>{{ $leave->user->first_name }} {{ $leave->user->last_name }}</td>
                        <td>{{ ucfirst($leave->type) }}</td>
                        <td>{{ $leave->start_date }}</td>
                        <td>{{ $leave->end_date }}</td>
                        <td>
                            {{ \Carbon\Carbon::parse($leave->start_date)->diffInDays(\Carbon\Carbon::parse($leave->end_date)) + 1 }}
                        </td>
                        <td>{{ $leave->reason }}</td>
                        <td>
                            @if ($leave->supporting_document)
                            @php
                            $ext = pathinfo($leave->supporting_document, PATHINFO_EXTENSION);
                            $url = asset('storage/' . $leave->supporting_document);
                            @endphp

                            <a href="{{ $url }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                {{ in_array($ext, ['jpg', 'jpeg', 'png']) ? 'View Image' : 'View PDF' }}
                            </a>
                            @else
                            <span class="text-muted">No file</span>
                            @endif
                        </td>

                        <td>
                            @if($leave->status == 'pending')
                            <span class="badge bg-warning text-dark">Pending</span>
                            @elseif($leave->status == 'approved')
                            <span class="badge bg-success">Approved</span>
                            @elseif($leave->status == 'rejected')
                            <span class="badge bg-danger">Rejected</span>
                            @endif
                        </td>
                        <td>{{ $leave->manager_comment }}</td>
                        <td>
                            @if($leave->status == 'pending')
                            <form action="{{ route('leave.approve', $leave->id) }}" method="POST" class="d-inline">
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
                                                <textarea name="manager_comment" class="form-control"
                                                    required></textarea>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-danger">Reject</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            @else
                            <span class="text-muted">-</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <p>No leave applications found.</p>
            @endif
        </div>
    </div>
</div>
@endsection