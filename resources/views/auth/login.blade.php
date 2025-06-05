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

                            <p class="mb-4 texr-center">Sign in to continue</p>

                            @if (session('status'))
                            <div class="alert alert-success">{{ session('status') }}</div>
                            @endif

                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" required
                                        autofocus />
                                    @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <div class="mb-3 form-password-toggle">
                                    <label class="form-label" for="password">Password</label>
                                    <div class="input-group input-group-merge">
                                        <input type="password" id="password" class="form-control" name="password"
                                            required />
                                        <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                    </div>
                                    @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <div class="mb-3 text-end">
                                    <a href="{{ route('password.request') }}">Forgot password?</a>
                                </div>

                                <div class="mb-3">
                                    <button class="btn btn-primary d-grid w-100" type="submit">Sign in</button>
                                </div>
                            </form>

                            <p class="text-center">
                                <span>New here?</span>
                                <a href="{{ route('register') }}"><span>Create an account</span></a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>
@endsection