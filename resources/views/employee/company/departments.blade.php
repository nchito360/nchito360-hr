@extends('layouts.user')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold mb-3">Manage My Departments</h4>
    <p class="mb-4">This page allows you to manage the departments you're part of or responsible for.</p>

    {{-- Empty State --}}
    <div class="text-center my-5">
        <img src="{{ asset('hr-app/assets/img/illustrations/404.png') }}" alt="No Departments" style="max-width: 300px;" class="mb-3">
        <h5>No departments assigned yet</h5>
        <p class="text-muted">Once you’re assigned to a department, it will appear here.</p>
    </div>

    {{-- Future Dynamic Table (Commented out for now) --}}
    {{-- 
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Department Name</th>
                    <th>Branch</th>
                    <th>Head</th>
                    <th>Team Size</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($departments as $department)
                <tr>
                    <td>{{ $department->name }}</td>
                    <td>{{ $department->branch->name ?? 'N/A' }}</td>
                    <td>{{ $department->head->name ?? 'N/A' }}</td>
                    <td>{{ $department->employees_count }}</td>
                    <td>
                        <a href="{{ route('departments.show', $department->id) }}" class="btn btn-sm btn-primary">View</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    --}}
</div>
@endsection
