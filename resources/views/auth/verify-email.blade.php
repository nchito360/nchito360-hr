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
        <div class="card-body text-center">
          <h4 class="mb-2">Verify Your Email Address</h4>
          <p class="mb-4">
            Thanks for signing up! Before getting started, please verify your email address by clicking the link we just emailed to you.
            If you didn’t receive the email, we’ll gladly send you another.
          </p>

          @if (session('status') == 'verification-link-sent')
            <div class="alert alert-success mb-3">
              A new verification link has been sent to your email address.
            </div>
          @endif

          <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="btn btn-primary w-100 mb-2">Resend Verification Email</button>
          </form>

          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-outline-secondary w-100">Logout</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
