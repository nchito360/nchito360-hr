@extends('layouts.user')

@section('content')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3">Leave Application</h4>

        <div class="card">
            <div class="card-body">
                <form method="POST" action="#">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Leave Type</label>
                        <select class="form-select">
                            <option>Sick Leave</option>
                            <option>Annual Leave</option>
                            <option>Emergency Leave</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Start Date</label>
                        <input type="date" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">End Date</label>
                        <input type="date" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary">Apply</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
