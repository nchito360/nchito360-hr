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
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="card-title mb-0">{{ $company->organization_name }}</h5>
                @if($company->logo)
                    <img src="{{ $company->logo }}" alt="Company Logo" class="img-thumbnail" style="height: 50px;">
                @endif
            </div>

            <p class="text-muted mb-3">{{ $company->description }}</p>

            <div class="row mb-3">
                <div class="col-md-3">
                    <h6>Industry</h6>
                    <p>{{ $company->industry ?? 'N/A' }}</p>
                </div>
                <div class="col-md-3">
                    <h6>Email</h6>
                    <p>{{ $company->email ?? 'N/A' }}</p>
                </div>
                <div class="col-md-3">
                    <h6>Website</h6>
                    <p>
                        @if($company->website)
                            <a href="{{ $company->website }}" target="_blank">{{ $company->website }}</a>
                        @else
                            N/A
                        @endif
                    </p>
                </div>
            </div>

            <hr>

            <div class="row mb-3">
                <div class="col-md-3">
                    <h6>Total Departments</h6>
                    <p>{{ count($company->departments ?? []) }}</p>
                </div>
                <div class="col-md-3">
                    <h6>Total Branches</h6>
                    <p>{{ count($company->branches ?? []) }}</p>
                </div>
                <div class="col-md-3">
                    <h6>Team Members</h6>
                    <p>{{ $teamMembers->count() }}</p>
                </div>
                <div class="col-md-3">
                    <h6>Your Role</h6>
                    <p>{{ $currentRole ?? 'N/A' }}</p>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-3">
                    <h6>Your Department</h6>
                    <p>{{ $currentDepartment ?? 'N/A' }}</p>
                </div>
                <div class="col-md-3">
                    <h6>Your Branch</h6>
                    <p>{{ $currentBranch ?? 'N/A' }}</p>
                </div>
            </div>

            <hr>

            <div class="row">

                <div class="col-md-6">
                    <h6>All Branches</h6>
                    <ul>
                        @forelse($company->branches as $branch)
                            <li>{{ $branch }}</li>
                        @empty
                            <li>No branches listed.</li>
                        @endforelse
                    </ul>
                </div>
                <div class="col-md-6">
                    <h6>All Departments</h6>
                    <ul>
                        @forelse($company->departments as $department)
                            <li>{{ $department }}</li>
                        @empty
                            <li>No departments listed.</li>
                        @endforelse
                    </ul>
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
                        <th>Role</th>
                        <th>Department</th>
                        <th>Branch</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $index => $user)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->position ?? 'N/A' }}</td>
                            <td>{{ $user->department ?? 'N/A' }}</td>
                            <td>{{ $user->branch ?? 'N/A' }}</td>
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
                        <input type="text" name="company_code" id="company_code" class="form-control" required>
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
