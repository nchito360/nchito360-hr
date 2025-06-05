@extends('layouts.auth')

@section('content')
<div class="container-xl">
    <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">

            <div class="row  justify-content-center align-items-center vh-100">
                <div class="col-md-6 col-sm-10">
                     <div class="card">
                <div class="card-body">
                    <div class="app-brand justify-content-center">

                        <a href="#" class="app-brand-link gap-2">
                            <img src="{{ asset('hr-app/assets/img/logos/nchito360-logo (4).png') }}" alt="Logo"
                                style="height: 10rem;">
                        </a>

                    </div>
                    <h4 class="mb-2">Forgot your password?</h4>
                    <p class="mb-4">Enter your email and we’ll send you instructions to reset your password</p>

                    @if (session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" class="form-control" name="email" required />
                            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <button class="btn btn-primary d-grid w-100" type="submit">Send Reset Link</button>
                    </form>

                    <p class="text-center mt-3">
                        <a href="{{ route('login') }}">Back to login</a>
                    </p>
                </div>
            </div>
                </div>
            </div>

           
        </div>
    </div>
</div>
@endsection