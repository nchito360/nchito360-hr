@extends('layouts.user')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Profile Info Card -->
    <div class="card mb-4">
        <div class="card-body d-flex align-items-center">
            <img src="{{ $user->profile_picture ? asset('uploads/profiles/' . $user->profile_picture) : asset('hr-app\assets\img\avatars\default-profile.png') }}"
                alt="Profile Picture"
                class="rounded-circle me-3 object-fit-cover"
                style="width: 100px; height: 100px; object-fit: cover;"
            >
            <div>
                <h5 class="mb-1">{{ $user->first_name }} {{ $user->last_name }}</h5>
                <p class="mb-0">{{ $user->email }}</p>
                <small class="text-muted">{{ $user->position ?? 'Position in Company' }}</small>
            </div>
        </div>
    </div>

<!-- Company Info -->
@if($user->company)
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">Company</h5>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <h6 class="mb-1">{{ $user->company->organization_name }}</h6>
                <p class="mb-0 text-muted">Department: {{ $user->department ?? ' ' }}</p>
                <p class="mb-0 text-muted">Branch: {{  $user->branch ?? ' ' }}</p>
            </div>
        </div>
    </div>
@endif


    <!-- Profile Update Form -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Update Profile</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('employee.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="first_name" class="form-label">First Name</label>
                    <input type="text" name="first_name" id="first_name" class="form-control" 
                           value="{{ old('first_name', $user->first_name) }}" required>
                </div>

                <div class="mb-3">
                    <label for="last_name" class="form-label">Last Name</label>
                    <input type="text" name="last_name" id="last_name" class="form-control" 
                           value="{{ old('last_name', $user->last_name) }}" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" name="email" id="email" class="form-control" 
                           value="{{ old('email', $user->email) }}" required>
                </div>

                <div class="mb-3">
                    <label for="position" class="form-label">Position</label>
                    <input type="text" name="position" id="position" class="form-control"
                           value="{{ old('position', $user->position) }}">
                </div>

                <div class="mb-3">
                    <label for="department" class="form-label">Department</label>
                    <select name="department" id="department" class="form-select">
                        <option value="">Select Department</option>
                        @if($user->company && $user->company->departments)
                            @foreach($user->company->departments as $department)
                                <option value="{{ $department }}"
                                    {{ old('department', $user->department) == $department ? 'selected' : '' }}>
                                    {{ $department }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <div class="mb-3">
                    <label for="branch" class="form-label">Branch</label>
                    <select name="branch" id="branch" class="form-select">
                        <option value="">Select Branch</option>
                        @if($user->company && $user->company->branches)
                            @foreach($user->company->branches as $branch)
                                <option value="{{ $branch }}"
                                    {{ old('branch', $user->branch) == $branch ? 'selected' : '' }}>
                                    {{ $branch }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>

            
                <div class="mb-3">
                    <label for="profile_picture" class="form-label">Profile Picture</label>
                    <input type="file" name="profile_picture" id="profile_picture" class="form-control">
                    <small class="text-muted">Max size: 2MB</small>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Update Profile</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
