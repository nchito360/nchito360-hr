@extends('layouts.user')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold">Register New Company</h4>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('employee.company.register') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="organization_name" class="form-label">Organization Name</label>
            <input type="text" class="form-control" id="organization_name" name="organization_name" required>
        </div>

        <div class="mb-3">
            <label for="logo" class="form-label">Logo URL</label>
            <input type="url" class="form-control" id="logo" name="logo">
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description"></textarea>
        </div>

        <div class="mb-3">
            <label for="industry" class="form-label">Industry</label>
            <input type="text" class="form-control" id="industry" name="industry">
        </div>

        <div class="mb-3">
            <label for="branches" class="form-label">Branches (comma-separated)</label>
            <input type="text" class="form-control" id="branches" name="branches[]">
        </div>

        <div class="mb-3">
            <label for="departments" class="form-label">Departments (comma-separated)</label>
            <input type="text" class="form-control" id="departments" name="departments[]">
        </div>

        <div class="mb-3">
            <label for="website" class="form-label">Website</label>
            <input type="url" class="form-control" id="website" name="website">
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Company Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>

        <button type="submit" class="btn btn-primary">Register Company</button>
    </form>
</div>
@endsection
