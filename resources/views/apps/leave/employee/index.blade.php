@extends('layouts.user')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold mb-4">🗕️ My Leave Dashboard</h4>

    {{-- Alerts --}}
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Leave Balance Overview --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-center shadow-sm border-0">
                <div class="card-body">
                    <h6 class="text-muted">Total Leave Entitlement</h6>
                    <h3 class="text-primary">{{ $leaveEntitlement }} Days</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center shadow-sm border-0">
                <div class="card-body">
                    <h6 class="text-muted">Used Leave Days</h6>
                    <h3 class="text-warning">{{ $usedLeaveDays }} Days</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center shadow-sm border-0">
                <div class="card-body">
                    <h6 class="text-muted">Remaining Leave</h6>
                    <h3 class="text-success">{{ $remainingLeaveDays }} Days</h3>
                </div>
            </div>
        </div>
    </div>

    {{-- Leave History Table --}}
<div class="card mb-4 shadow-sm">
    <div class="card-header bg-light">
        <h5 class="mb-0">🗂️ Leave History</h5>
    </div>
    <div class="card-body">
        @if($appliedLeaves->count())
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Type</th>
                        <th>From</th>
                        <th>To</th>
                        <th>Days</th>
                        <th>Status</th>
                        <th>Reason</th>
                        <th>Document</th> {{-- NEW COLUMN --}}
                        <th>Manager Comment</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($appliedLeaves as $leave)
                    @php
                        $days = \Carbon\Carbon::parse($leave->start_date)->diffInDays($leave->end_date) + 1;
                    @endphp
                    <tr>
                        <td>{{ ucfirst($leave->type) }}</td>
                        <td>{{ $leave->start_date }}</td>
                        <td>{{ $leave->end_date }}</td>
                        <td>{{ $days }}</td>
                        <td>
                            <span class="badge bg-{{
                                $leave->status === 'approved' ? 'success' :
                                ($leave->status === 'pending' ? 'warning text-dark' :
                                ($leave->status === 'declined' ? 'danger' : 'secondary'))
                            }}">
                                {{ ucfirst($leave->status) }}
                            </span>
                        </td>
                        <td>{{ $leave->reason }}</td>

                        {{-- Supporting Document --}}
                        <td>
                            @if ($leave->supporting_document)
                                @php
                                    $ext = pathinfo($leave->supporting_document, PATHINFO_EXTENSION);
                                    $url = asset('public/storage/' . $leave->supporting_document);
                                @endphp
                                <a href="{{ $url }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                    {{ in_array($ext, ['jpg', 'jpeg', 'png']) ? 'View Image' : 'View PDF' }}
                                </a>
                            @else
                                <span class="text-muted">No file</span>
                            @endif
                        </td>

                        <td>{{ $leave->manager_comment ?? '—' }}</td>
                        <td>
                            @if($leave->status === 'pending')
                                <a href="{{ route('leave.edit', $leave->id) }}"
                                    class="btn btn-sm btn-outline-primary mb-1">Edit</a>
                                <form action="{{ route('leave.cancel', $leave->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button class="btn btn-sm btn-outline-warning mb-1">Cancel</button>
                                </form>
                                <form action="{{ route('leave.destroy', $leave->id) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Delete this application?');">
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
        <p class="text-muted mb-0">No leave applications submitted yet.</p>
        @endif
    </div>
</div>


    {{-- Leave Application Form (conditional on probation) --}}
    @if(!$user->is_on_probation)
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-light">
            <h5 class="mb-0">✍️ Apply for Leave</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('leave.apply') }}" method="POST" enctype="multipart/form-data">
                {{-- CSRF Token --}}
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="leave_type" class="form-label">Leave Type</label>
                        <select name="leave_type" class="form-select" required>
                            <option value="">-- Select Type --</option>
                            <option value="annual">Annual Leave</option>
                            <option value="sick">Sick Leave</option>
                            <option value="paternity">Paternity Leave</option>
                            <option value="vacation">Vacation</option>
                            <option value="day_off">Day Off</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="start_date" class="form-label">Start Date</label>
                        <input type="date" name="start_date" class="form-control" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="end_date" class="form-label">End Date</label>
                        <input type="date" name="end_date" class="form-control" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="reason" class="form-label">Reason</label>
                    <textarea name="reason" class="form-control" rows="3" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="supporting_document" class="form-label">Supporting Document (optional)</label>
                    <input type="file" name="supporting_document" class="form-control" accept=".pdf,image/*">
                    <small class="text-muted">Accepted formats: PDF, JPG, PNG (max 2MB)</small>
                </div>
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Submit Request</button>
                </div>
            </form>
        </div>
    </div>
    @endif

    {{-- Calendar Planner --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="mb-3">📆 Plan Your Leave (Calendar)</h5>
            <iframe src="https://calendar.google.com/calendar/embed?height=600&wkst=1&ctz=Africa%2FWindhoek"
                style="border:solid 1px #ccc" width="100%" height="600" frameborder="0" scrolling="no"></iframe>
        </div>
    </div>

    {{-- Declined Leaves --}}
    @if($declinedLeaves->count())
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-light">
            <h5 class="mb-0 text-danger">❌ Declined Applications</h5>
        </div>
        <div class="card-body">
            @foreach($declinedLeaves as $leave)
            <div class="mb-3 p-3 border rounded bg-light">
                <strong>{{ ucfirst($leave->type) }}</strong> from
                {{ $leave->start_date }} to {{ $leave->end_date }} —
                <span class="text-danger">Declined</span>
                <br>
                <small>Comment: {{ $leave->manager_comment }}</small>
                <form action="{{ route('leave.edit', $leave->id) }}" method="GET" class="mt-2">
                    <button class="btn btn-sm btn-outline-primary">Edit & Resubmit</button>
                </form>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection