@extends('layouts.user')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold mb-3">Company Overview</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

<!-- Summary Card -->
<div class="card mb-4">
    <div class="card-body">
        @if($company)
        <div class="container-xxl flex-grow-1 container-p-y">
    {{-- Header with Logo --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">{{ $company->organization_name }}</h4>
            <p class="text-muted mb-0">{{ $company->description }}</p>
        </div>
        @if($company->logo)
            <img src="{{ $company->logo }}" alt="Company Logo" class="img-thumbnail" style="height: 60px;">
        @endif
    </div>

    {{-- Quick Stats --}}
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card border-start border-primary border-3 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <i class="bx bx-buildings fs-2 text-primary me-3"></i>
                    <div>
                        <h6 class="mb-1">Industry</h6>
                        <p class="mb-0">{{ $company->industry ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-start border-success border-3 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <i class="bx bx-envelope fs-2 text-success me-3"></i>
                    <div>
                        <h6 class="mb-1">Email</h6>
                        <p class="mb-0">{{ $company->email ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-start border-info border-3 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <i class="bx bx-globe fs-2 text-info me-3"></i>
                    <div>
                        <h6 class="mb-1">Website</h6>
                        <p class="mb-0">
                            @if($company->website)
                                <a href="{{ $company->website }}" target="_blank">{{ $company->website }}</a>
                            @else
                                N/A
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Metrics --}}
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card text-center h-100 shadow-sm">
                <div class="card-body">
                    <i class="bx bx-layer fs-1 text-warning mb-2"></i>
                    <h6>Total Departments</h6>
                    <p class="mb-0 fw-bold">{{ count($company->departments ?? []) }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-center h-100 shadow-sm">
                <div class="card-body">
                    <i class="bx bx-store fs-1 text-danger mb-2"></i>
                    <h6>Total Branches</h6>
                    <p class="mb-0 fw-bold">{{ count($company->branches ?? []) }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-center h-100 shadow-sm">
                <div class="card-body">
                    <i class="bx bx-group fs-1 text-secondary mb-2"></i>
                    <h6>Team Members</h6>
                    <p class="mb-0 fw-bold">{{ $teamMembers->count() }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-center h-100 shadow-sm">
                <div class="card-body">
                    <i class="bx bx-user-check fs-1 text-primary mb-2"></i>
                    <h6>Your Role</h6>
                    <p class="mb-0 fw-bold">{{ $currentRole ?? 'N/A' }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- User Info --}}
    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="card h-100 shadow-sm">
                <div class="card-body d-flex align-items-center">
                    <i class="bx bx-buildings fs-2 text-info me-3"></i>
                    <div>
                        <h6 class="mb-1">Your Department</h6>
                        <p class="mb-0">{{ $currentDepartment ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card h-100 shadow-sm">
                <div class="card-body d-flex align-items-center">
                    <i class="bx bx-current-location fs-2 text-success me-3"></i>
                    <div>
                        <h6 class="mb-1">Your Branch</h6>
                        <p class="mb-0">{{ $currentBranch ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- All Branches & Departments --}}
    <div class="row g-4">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="card-title mb-3"><i class="bx bx-map-pin text-warning me-2"></i>All Branches</h6>
                    <ul class="list-unstyled">
                        @forelse($company->branches as $branch)
                            <li><i class="bx bx-chevron-right text-muted me-1"></i> {{ $branch }}</li>
                        @empty
                            <li class="text-muted">No branches listed.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="card-title mb-3"><i class="bx bx-sitemap text-primary me-2"></i>All Departments</h6>
                    <ul class="list-unstyled">
                        @forelse($company->departments as $department)
                            <li><i class="bx bx-chevron-right text-muted me-1"></i> {{ $department }}</li>
                        @empty
                            <li class="text-muted">No departments listed.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>


            <hr>

            <div class="card mt-4">
    <div class="card-header">
        <h5 class="mb-0">Team Members</h5>
    </div>
    <div class="card-body table-responsive">
        @if($users->isNotEmpty())
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role / Position</th>
                        <th>Department</th>
                        <th>Branch</th>
                        <th>Privileges</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($users as $index => $user)
                    <tr>
                        <form action="{{ route('employee.team.update', $user->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                            <td>{{ $user->email }}</td>

                            @php
                                $isOwner = $user->company && $user->company->owner_id === $user->id;
                            @endphp

                            <td>
                                <input type="text" name="position" value="{{ $user->position }}" class="form-control form-control-sm"  {{ $isOwner ? 'disabled' : '' }}>
                            </td>
                            <td>
                                <select name="department" class="form-select form-select-sm"  {{ $isOwner ? 'disabled' : '' }}>
                                    <option value="">Select Department</option>
                                    @if($user->company && $user->company->departments)
                                        @foreach($user->company->departments as $dept)
                                            <option value="{{ $dept }}" {{ $user->department == $dept ? 'selected' : '' }}>
                                                {{ $dept }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </td>
                            <td>
                                <select name="branch" class="form-select form-select-sm"  {{ $isOwner ? 'disabled' : '' }}>
                                    <option value="">Select Branch</option>
                                    @if($user->company && $user->company->branches)
                                        @foreach($user->company->branches as $branch)
                                            <option value="{{ $branch }}" {{ $user->branch == $branch ? 'selected' : '' }}>
                                                {{ $branch }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </td>
                            <td>
                           

                            <select name="privileges" class="form-select form-select-sm" required {{ $isOwner ? 'disabled' : '' }}>
                                <option value="">-- Select --</option>
                                <option value="departmental" {{ $user->privileges === 'departmental' ? 'selected' : '' }}>Departmental</option>
                                <option value="notifications" {{ $user->privileges === 'notifications' ? 'selected' : '' }}>Notifications</option>
                                <option value="full" {{ $user->privileges === 'full' ? 'selected' : '' }}>Full Access</option>
                                <option value="none" {{ $user->privileges === 'none' ? 'selected' : '' }}>No Access</option>
                                @if(!$isOwner)
                                    <option value="suspended" {{ $user->privileges === 'suspended' ? 'selected' : '' }}>Suspend Account</option>
                                    <option value="delete" {{ $user->privileges === 'delete' ? 'selected' : '' }}>Delete from Company</option>
                                @endif
                            </select>

                            </td>
                            <td>
                                <button type="submit" class="btn btn-sm btn-primary">Update</button>
                            </td>
                        </form>
                    </tr>
                @endforeach

                </tbody>
            </table>
        @else
            <p class="text-muted">No team members found in this company.</p>
        @endif
    </div>
</div>





        @else
            <h5 class="card-title mb-2">No Company Assigned</h5>
            <p class="text-muted mb-3">You are not currently part of any company.</p>
        @endif
    </div>
</div>





    <!-- Company Controls -->
    <div class="row">
        <!-- Request to Join -->
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h6 class="mb-0">Request to Join Company</h6>
                </div>
                <div class="card-body">
                <form action="{{ route('employee.company.request.join') }}" method="POST">
    @csrf
    <label for="company_code">Company Code</label>
    <input type="text" 
           name="company_code" 
           id="company_code" 
           class="form-control @error('company_code') is-invalid @enderror" 
           value="{{ old('company_code') }}" 
           required>

    @error('company_code')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror

    <button class="btn btn-primary btn-sm mt-2" type="submit">Send Request</button>
</form>


                    @if($joinRequests->isNotEmpty())
    <div class="card mt-4">
        <div class="card-header">
            <h6>My Join Requests</h6>
        </div>



        <div class="card-body">

            <ul>
    @foreach($joinRequests as $request)
        <li class="mb-2">
            <div>
                <strong>{{ $request->company->organization_name ?? 'N/A' }}</strong>
                <span>
                    @if($request->status == 'pending')
                        <span class="badge bg-warning text-dark">Pending</span>
                    @elseif($request->status == 'approved')
                        <span class="badge bg-success">Approved</span>
                    @else
                        <span class="badge bg-danger">Rejected</span>
                    @endif
                </span>
                <small class="text-muted ms-2">{{ $request->created_at->format('d M Y') }}</small>
            </div>
            <div>
                @if($request->status == 'pending')
                    <form action="{{ route('employee.company.request.cancel', $request->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Cancel this request?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger mt-1">Cancel</button>
                    </form>
                @else
                    <span class="text-muted">No action</span>
                @endif
            </div>
        </li>
    @endforeach
            </ul>


          
        </div>
    </div>
@endif

                </div>
            </div>
        </div>

        <!-- Switch Company -->
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h6 class="mb-0">Switch Company</h6>
                </div>
                <div class="card-body">
                   <form action="{{ route('employee.company.switch') }}" method="POST">
                        @csrf
                        <label for="switch_company_code">New Company Code</label>
                        <input type="text" name="switch_company_code" id="switch_company_code" class="form-control" required>
                        <button class="btn btn-warning btn-sm mt-2" type="submit">Switch</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Control Company -->
<div class="col-md-4 mb-4">
    <div class="card h-100">
        <div class="card-header">
            <h6 class="mb-0">Company Controls</h6>
        </div>
        <div class="card-body">

            <!-- Manage Company -->
            <form action="{{ route('employee.company.manage') }}" method="GET">
                <button class="btn btn-primary btn-sm w-100 my-2" type="submit">Manage Company</button>
            </form>

            <!-- Register New Company -->
            <form action="{{ route('employee.company.register.form') }}" method="GET">
                <button class="btn btn-success btn-sm w-100 my-2" type="submit">Register New Company</button>
            </form>

            <!-- Leave Company -->
            <form action="{{ route('employee.company.leave') }}" method="POST" onsubmit="return confirm('Are you sure you want to leave this company?');">
                @csrf
                <button class="btn btn-danger btn-sm w-100 my-2" type="submit">Leave Company</button>
            </form>

        </div>
    </div>
</div>

    </div>
</div>
@endsection
