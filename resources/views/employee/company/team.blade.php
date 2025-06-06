@extends('layouts.user')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold mb-4">My Team</h4>
    <p class="mb-4">View and manage your team members within your company.</p>

    {{-- Empty State --}}
    <div class="text-center my-5">
        <img src="{{ asset('hr-app/assets/img/illustrations/404.png') }}" alt="No Team" style="max-width: 300px;" class="mb-3">
        <h5>No team members added yet</h5>
        <p class="text-muted">Once your company admin adds employees, they will appear here.</p>
    </div>

    {{-- Future Team Table (disabled for now) --}}
    {{-- 
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Department</th>
                    <th>Role</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($teamMembers as $member)
                <tr>
                    <td>{{ $member->name }}</td>
                    <td>{{ $member->email }}</td>
                    <td>{{ $member->department }}</td>
                    <td>{{ $member->role }}</td>
                    <td>
                        <span class="badge bg-success">Active</span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    --}}
</div>
@endsection
