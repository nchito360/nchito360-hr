@extends('layouts.user')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold">Manage Company</h4>

    @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if(auth()->user() && auth()->user()->privileges === 'full')

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

    <div>
        @if ($joinRequests->isNotEmpty())
        <div class="card p-4 mb-4">
            <h5 class="mb-3">Pending Join Requests</h5>
            <table class="table">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($joinRequests as $request)
                    <tr>
                        <td>{{ $request->user->first_name }} {{ $request->user->last_name }}</td>
                        <td>{{ $request->user->email }}</td>
                        <td>
                            <form action="{{ route('employee.company.request.approve', $request->id) }}" method="POST"
                                class="d-inline">
                                @csrf
                                <button class="btn btn-success btn-sm">Approve</button>
                            </form>
                            <form action="{{ route('employee.company.request.reject', $request->id) }}" method="POST"
                                class="d-inline">
                                @csrf
                                <button class="btn btn-danger btn-sm">Reject</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
        <div class="card p-4 mb-4">
            <h5 class="mb-3">Company Code</h5>
            <div class="d-flex align-items-center mb-2">
                <p class="text-muted mb-0">
                    Your company code is:
                    <strong id="companyCode">{{ $company->company_code }}</strong>
                </p>
                <button type="button" class="btn btn-outline-secondary btn-sm ms-2" onclick="copyCompanyCode()"
                    title="Copy to clipboard">
                    <i class="bx bx-clipboard"></i>
                </button>
            </div>
            <p class="text-muted">Share this code with employees to allow them to join your company.</p>
        </div>
        <script>
        function copyCompanyCode() {
            const code = document.getElementById('companyCode').innerText;
            navigator.clipboard.writeText(code).then(function() {
                // Optional: show feedback
                alert('Company code copied to clipboard!');
            });
        }
        </script>


        @php
        $canEdit = auth()->user() && auth()->user()->privileges === 'full';
        $disabled = !$canEdit ? 'disabled' : '';
        @endphp

        <form action="{{ route('employee.company.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="card p-4 mb-4">
                <h5 class="mb-3">Company Details</h5>

                <div class="mb-3">
                    <label for="organization_name" class="form-label">Name</label>
                    <input type="text" class="form-control" name="organization_name"
                        value="{{ old('organization_name', $company->organization_name) }}" required {{ $disabled }}>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Contact Email</label>
                    <input type="email" class="form-control" name="email" value="{{ old('email', $company->email) }}"
                        required {{ $disabled }}>
                </div>

                <div class="mb-3">
                    <label for="industry" class="form-label">Industry</label>
                    <input type="text" class="form-control" name="industry"
                        value="{{ old('industry', $company->industry) }}" {{ $disabled }}>
                </div>

                <div class="mb-3">
                    <label for="website" class="form-label">Website</label>
                    <input type="url" class="form-control" name="website"
                        value="{{ old('website', $company->website) }}" {{ $disabled }}>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" name="description" rows="3"
                        {{ $disabled }}>{{ old('description', $company->description) }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="company_code" class="form-label">Company Code</label>
                    <input type="text" class="form-control" name="company_code"
                        value="{{ old('company_code', $company->company_code) }}" {{ $disabled }}>
                </div>
            </div>

            <div class="card p-4 mb-4">
                <h5 class="mb-3">Branches</h5>
                <div class="mb-3">
                    <label for="branches" class="form-label">List of Branches (comma-separated)</label>
                    <input type="text" class="form-control" name="branches"
                        value="{{ old('branches', implode(',', $company->branches ?? [])) }}" {{ $disabled }}>
                </div>
            </div>

            <div class="card p-4 mb-4">
                <h5 class="mb-3">Departments</h5>
                <div class="mb-3">
                    <label for="departments" class="form-label">List of Departments (comma-separated)</label>
                    <input type="text" class="form-control" name="departments"
                        value="{{ old('departments', implode(',', $company->departments ?? [])) }}" {{ $disabled }}>
                </div>
            </div>

            @if($canEdit)
            <div class="text-end mb-4">
                <button type="submit" class="btn btn-primary">Update Company</button>
            </div>
            @endif
        </form>


        <div class="card p-4 mb-4">
            <h5 class="mb-3">Delete Company</h5>
            <p class="text-danger">Deleting your company will remove all associated data. This action cannot be undone.
            </p>
            <form action="{{ route('employee.company.destroy') }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" {{ $disabled }}>Delete Company</button>
            </form>

        </div>

    </div>

    @else
    <div class="col-md-12 mb-4">
        <div class="card h-100 border-muted shadow-sm">
            <div class="card-body text-center">
                <i class="bx bx-lock-alt fs-1 text-muted mb-3"></i>
                <h5 class="card-title text-muted">Access Restricted</h5>
                <p class="card-text text-muted">
                    You do not have the required privileges to manage applications or the company.
                    Please contact your administrator for further assistance.
                </p>
                <a href="mailto:support@nchito360.site" class="btn btn-outline-muted">
                    Contact Support
                </a>
            </div>
        </div>
    </div>

    @endif







    @endsection