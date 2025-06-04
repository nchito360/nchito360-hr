@extends('layouts.auth')

@section('content')
<div class="container-xl w-50">
  <div class="authentication-wrapper authentication-basic container-p-y">
    <div class="authentication-inner">
      <div class="card">
        <div class="card-body">
          <div class="app-brand justify-content-center">
            
            <a href="#" class="app-brand-link gap-2">
      <img src="{{ asset('hr-app/assets/img/logos/nchito360-logo (4).png') }}" alt="Logo" style="height: 20rem;">
     
    </a>
   
          </div>
          <h4 class="mb-2">Reset Your Password</h4>
          <p class="mb-4">Enter your new password below</p>

          <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $request->route('token') }}">
            <input type="hidden" name="email" value="{{ old('email', $request->email) }}">

            <div class="mb-3">
              <label for="password" class="form-label">New Password</label>
              <input type="password" class="form-control" name="password" required />
              @error('password') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="mb-3">
              <label for="password_confirmation" class="form-label">Confirm Password</label>
              <input type="password" class="form-control" name="password_confirmation" required />
            </div>

            <button type="submit" class="btn btn-primary d-grid w-100">Reset Password</button>
          </form>

          <p class="text-center mt-3">
            <a href="{{ route('login') }}">Back to login</a>
          </p>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
