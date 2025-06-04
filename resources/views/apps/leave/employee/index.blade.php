@extends('layouts.user')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold">My Leave Dashboard</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <!-- Accumulated Leave Days -->
    <div class="card mb-4">
        <div class="card-body">
            <h5>Accumulated Leave Days: <span class="badge bg-primary">{{ $leaveDays ?? 'Null' }}</span></h5>
        </div>
    </div>

    <!-- Applied Leave Days List -->
<div class="card mb-4">
    <div class="card-header">
        <h5>My Leave Applications</h5>
    </div>
    <div class="card-body">
        @if($appliedLeaves->count())
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Dates</th>
                            <th>Status</th>
                            <th>Reason</th>
                            <th>Manager's Comment</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($appliedLeaves as $leave)
                            <tr>
                                <td>{{ ucfirst($leave->type) }}</td>
                                <td>{{ $leave->start_date }} - {{ $leave->end_date }}</td>
                                <td>
                                    @if($leave->status === 'approved')
                                        <span class="badge bg-success">Approved</span>
                                    @elseif($leave->status === 'pending')
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @elseif($leave->status === 'declined')
                                        <span class="badge bg-danger">Declined</span>
                                    @else
                                        <span class="badge bg-secondary">{{ ucfirst($leave->status) }}</span>
                                    @endif
                                </td>
                                <td>{{ $leave->reason }}</td>
                                <td>{{ $leave->manager_comment ?? '—' }}</td>
                                <td>
                                    @if($leave->status === 'pending')
                                        <a href="{{ route('leave.edit', $leave->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                        <form action="{{ route('leave.cancel', $leave->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button class="btn btn-sm btn-outline-warning">Cancel</button>
                                        </form>
                                        <form action="{{ route('leave.destroy', $leave->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this leave application?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger">Delete</button>
                                        </form>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="mb-0">You have not applied for any leave yet.</p>
        @endif

        <div class="mt-3">
            <a href="{{ route('leave.apply')}}" class="btn btn-success">Apply for Leave</a>
        </div>

    </div>
</div>


   <!-- Calendar Card -->
<div class="card mb-4">
    <div class="card-body">
        <h5>Plan your Leave Calendar</h5>
       <iframe src="https://calendar.google.com/calendar/embed?height=600&wkst=1&ctz=Africa%2FWindhoek&showPrint=0&src=ZW4uY2hyaXN0aWFuI2hvbGlkYXlAZ3JvdXAudi5jYWxlbmRhci5nb29nbGUuY29t&src=ZW4udWcjaG9saWRheUBncm91cC52LmNhbGVuZGFyLmdvb2dsZS5jb20&src=ZW4uem0jaG9saWRheUBncm91cC52LmNhbGVuZGFyLmdvb2dsZS5jb20&color=%234285F4&color=%23F6BF26&color=%237CB342" style="border:solid 1px #777" width="100%" height="600" frameborder="0" scrolling="no"></iframe>
    </div>
</div>




    <!-- Apply / Plan Leave -->
    <div class="card mb-4">
        <div class="card-header">
            <h5>Apply or Plan Leave</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('leave.apply') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="leave_type" class="form-label">Leave Type</label>
                    <select name="leave_type" class="form-control" required>
                        <option value="">-- Select Type --</option>
                        <option value="annual">Annual Leave</option>
                        <option value="sick">Sick Leave</option>
                        <option value="paternity">Paternity Leave</option>
                        <option value="vacation">Vacation</option>
                        <option value="day_off">Day Off</option>
                        <option value="other">Other</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="start_date" class="form-label">Start Date</label>
                    <input type="date" name="start_date" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="end_date" class="form-label">End Date</label>
                    <input type="date" name="end_date" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="reason" class="form-label">Reason</label>
                    <textarea name="reason" class="form-control" rows="3" required></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Submit Leave Request</button>
            </form>
        </div>
    </div>

    <!-- Declined Applications -->
    @if($declinedLeaves->count())
        <div class="card mb-4">
            <div class="card-header">
                <h5>Declined Leave Applications</h5>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    @foreach($declinedLeaves as $leave)
                        <li class="list-group-item">
                            <strong>{{ ucfirst($leave->leave_type) }}</strong> from 
                            {{ $leave->start_date }} to {{ $leave->end_date }} 
                            — <span class="text-danger">Declined</span>
                            <br><small>Comment: {{ $leave->manager_comment }}</small>
                            <form action="{{ route('leave.edit', $leave->id) }}" method="GET" class="mt-2">
                                <button class="btn btn-sm btn-outline-primary">Edit & Resubmit</button>
                            </form>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif
</div>
@endsection
