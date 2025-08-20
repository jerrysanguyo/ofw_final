@extends('layouts.auth')

@section('content')
<div id="app">
    <section class="section">
        <div class="container mt-5">
            <div class="row">
                <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                    
                    <div class="login-brand">
                        <img src="{{ asset('images/IT-white.webp') }}" alt="logo" width="100"
                            class="shadow-light rounded-circle">
                    </div>
                    
                    <div class="card card-primary">
                        <div class="card-header d-flex justify-content-center">
                            <h4 class="mb-0">Sign In</h4>
                        </div>

                        <div class="card-body">
                            <p class="text-muted text-center">Enter your email and password to access the admin panel.
                            </p>

                            <form method="POST" action="{{ route('authenticate') }}" class="needs-validation" novalidate>
                                @csrf
                                
                                <div class="form-group">
                                    <label for="email">{{ __('Email Address') }}</label>
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autofocus placeholder="Enter your email">

                                    @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <div class="d-block">
                                        <label for="password" class="control-label">{{ __('Password') }}</label>
                                        @if (Route::has('password.request'))
                                        <div class="float-right">
                                            <a href="{{ route('password.request') }}" class="text-small">
                                                {{ __('Forgot Password?') }}
                                            </a>
                                        </div>
                                        @endif
                                    </div>
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required placeholder="Enter your password">

                                    @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="remember" class="custom-control-input"
                                            id="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <label class="custom-control-label"
                                            for="remember">{{ __('Remember Me') }}</label>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-lg btn-block">
                                        {{ __('Login') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    <div class="simple-footer">
                        &copy; {{ date('Y') }} City of Taguig Information Technology. All rights reserved.
                    </div>

                </div>
            </div>
        </div>
    </section>
</div>
@endsection