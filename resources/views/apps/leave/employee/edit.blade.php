@extends('layouts.user')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold mb-4">✏️ Edit Leave Application</h4>

    {{-- Alerts --}}
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-header bg-light">
            <h5 class="mb-0">Update Leave Details</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('leave.update', $leave->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="leave_type" class="form-label">Leave Type</label>
                        <select name="leave_type" class="form-select" required>
                            <option value="">-- Select Type --</option>
                            <option value="annual" {{ $leave->type === 'annual' ? 'selected' : '' }}>Annual Leave
                            </option>
                            <option value="sick" {{ $leave->type === 'sick' ? 'selected' : '' }}>Sick Leave</option>
                            <option value="paternity" {{ $leave->type === 'paternity' ? 'selected' : '' }}>Paternity
                                Leave</option>
                            <option value="vacation" {{ $leave->type === 'vacation' ? 'selected' : '' }}>Vacation
                            </option>
                            <option value="day_off" {{ $leave->type === 'day_off' ? 'selected' : '' }}>Day Off</option>
                            <option value="other" {{ $leave->type === 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="start_date" class="form-label">Start Date</label>
                        <input type="date" name="start_date" class="form-control" value="{{ $leave->start_date }}"
                            required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="end_date" class="form-label">End Date</label>
                        <input type="date" name="end_date" class="form-control" value="{{ $leave->end_date }}" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="supporting_document">Attach Supporting Document (optional)</label>
                    <input type="file" name="supporting_document" class="form-control" accept=".pdf,image/*">

                    @if ($leave->supporting_document)
                    <p class="mt-2">Current:
                        <a href="{{ asset('storage/' . $leave->supporting_document) }}" target="_blank">
                            View Document
                        </a>
                    </p>
                    @endif
                </div>

                <div class="mb-3">
                    <label for="reason" class="form-label">Reason</label>
                    <textarea name="reason" class="form-control" rows="3" required>{{ $leave->reason }}</textarea>
                </div>

                

                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                    <a href="{{ route('apps.leave') }}" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection