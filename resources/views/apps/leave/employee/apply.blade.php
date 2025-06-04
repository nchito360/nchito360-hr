@extends('layouts.user')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

   

    <!-- Applied Leave Days List -->
<div class="card mb-4">
   

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

 
</div>
@endsection
