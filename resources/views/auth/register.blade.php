@extends('layouts.auth')

@section('content')
<div class="container-xl ">
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


                            <p class="mb-4">Sign up to get started</p>

                            @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif

                            <form method="POST" action="{{ route('register') }}">
                                @csrf

                                <div class="mb-3">
                                    <label for="first_name" class="form-label">First Name</label>
                                    <input type="text" class="form-control" name="first_name" id="first_name"
                                        required />
                                    @error('first_name') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="last_name" class="form-label">Last Name</label>
                                    <input type="text" class="form-control" name="last_name" id="last_name" required />
                                    @error('last_name') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" id="email" required />
                                    @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <div class="mb-3 form-password-toggle">
                                    <label class="form-label" for="password">Password</label>
                                    <div class="input-group input-group-merge">
                                        <input type="password" class="form-control" name="password" id="password"
                                            required />
                                        <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                    </div>
                                    @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="password_confirmation">Confirm Password</label>
                                    <input type="password" class="form-control" name="password_confirmation" required />
                                </div>

                                <button class="btn btn-primary d-grid w-100" type="submit">Sign Up</button>
                            </form>

                            <p class="text-center mt-3">
                                <span>Already have an account?</span>
                                <a href="{{ route('login') }}"><span>Sign in instead</span></a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>




        </div>
    </div>
</div>
@endsection