@extends('layouts.master-without-nav')
@section('title')
    Create New Password
@endsection
@section('content')
    <div class="home-center">
        <div class="home-desc-center">
            <div class="container">
                <div class="home-btn"><a href="/" class=" router-link-active"><i class="fas fa-home h2"></i></a>
                </div>

                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card">
                            <div class="card-body">
                                <div class="px-2 py-3">
                                    <div class="text-center">
                                        <a href="index">
                                            <img src="{{ URL::asset('build/images/logo-dark.png') }}" height="22"
                                                alt="logo">
                                        </a>
                                        <h5 class="text-primary mb-2 mt-4">Reset Password</h5>
                                        <p class="text-muted">Re-Password with {{ config('app.name') }}.</p>
                                    </div>
                                    <div class="alert alert-success text-center mb-2 mt-4 pt-2" role="alert">
                                        Enter your Email and instructions will be sent to you!
                                    </div>

                                    <form method="POST" action="{{ route('password.update') }}" class="auth-input">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email Address</label>
                                            <input id="email" type="email"
                                                class="form-control @error('email') is-invalid @enderror" name="email"
                                                value="{{ $email ?? old('email') }}" required autocomplete="email"
                                                autofocus>
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="password-input">Password</label>
                                            <input type="password"
                                                class="form-control @error('password') is-invalid @enderror" name="password"
                                                placeholder="Enter password" id="password-input"
                                                aria-describedby="passwordInput" required="">
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                            <div id="passwordInput" class="form-text">Your password must be 8-20
                                                characters long.</div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label" for="confirm-password-input">Confirm
                                                Password</label>
                                            <input type="password" class="form-control" name="password_confirmation"
                                                placeholder="Confirm password" id="confirm-password-input" required="">
                                        </div>

                                        <div class="mt-4">
                                            <button class="btn btn-primary w-100" type="submit">Reset
                                                Password</button>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="mt-5 text-center ">
                            <p>Remember It ? <a href="{{ route('login') }}" class="fw-bold "> Sign In here</a>
                            </p>
                            <p>©
                                {{ date('Y') }} {{ config('app.name') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Log In page -->
    </div>
@endsection

@section('scripts')
    <!-- App js -->
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
