@extends('layouts.master-without-nav')
@section('title')
    Confirm Password
@endsection
@section('css')
    <!--Swiper slider css-->
    <link href="{{ URL::asset('build/libs/swiper/swiper-bundle.min.css') }}" rel="stylesheet" type="text/css" />
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
                                        <h5 class="text-primary mb-2 mt-4">Confirm Password</h5>
                                    </div>

                                    <form method="POST" action="{{ route('password.confirm') }}" class="auth-input">
                                        @csrf
                                        <div class="mb-4">
                                            <label class="form-label">Password</label>
                                            <input id="password" type="password"
                                                class="form-control @error('password') is-invalid @enderror" name="password"
                                                required autocomplete="current-password"
                                                placeholder="Confirm your password">
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="text-center mt-4">
                                            <button class="btn btn-primary w-100" type="submit">Confirm
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
    <!--Swiper slider js-->
    <script src="{{ URL::asset('build/libs/swiper/swiper-bundle.min.js') }}"></script>
    <!-- swiper.init js -->
    <script src="{{ URL::asset('build/js/pages/auth.init.js') }}"></script>
@endsection
