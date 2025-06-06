@extends('layouts.user')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold mb-3">Manage Branches</h4>
    <p class="mb-4">This page allows you to manage branches you are assigned to.</p>

    {{-- Empty State --}}
    <div class="text-center my-5">
        <img src="{{ asset('hr-app/assets/img/illustrations/404.png') }}" alt="No Branches" style="max-width: 300px;" class="mb-3">
        <h5>No branches assigned yet</h5>
        <p class="text-muted">Once your company admin assigns you to a branch, it will appear here.</p>
    </div>

    {{-- Future Dynamic Table (commented out for now) --}}
    {{-- 
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Branch Name</th>
                    <th>Location</th>
                    <th>Manager</th>
                    <th>Employees</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($branches as $branch)
                <tr>
                    <td>{{ $branch->name }}</td>
                    <td>{{ $branch->location }}</td>
                    <td>{{ $branch->manager->name ?? 'N/A' }}</td>
                    <td>{{ $branch->employees_count }}</td>
                    <td>
                        <a href="{{ route('branches.show', $branch->id) }}" class="btn btn-sm btn-primary">View</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    --}}
</div>
@endsection
