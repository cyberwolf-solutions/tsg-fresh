@extends('layouts.master-without-nav')

@section('title')
    @lang('translation.signin')
@endsection

@section('content')
    <!-- Auth Page Wrapper -->
    <div class="auth-page-wrapper d-flex justify-content-center align-items-center min-vh-100" 
         style="background: linear-gradient(135deg, #7930c7 0%, #2367dd 100%);">

        <!-- Auth Card -->
        <div class="card shadow-lg rounded-4" style="width: 100%; max-width: 450px;">
            <div class="card-body p-5">
                <div class="text-center mb-4">
                    <h3 class="fw-bold text-primary">Welcome Back!</h3>
                    <p class="text-muted">Sign in to continue to <strong>TSG Fresh Resort Waikkal</strong></p>
                </div>

                <!-- Form -->
                <form action="{{ route('login') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="text"
                            class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email') }}" id="email" name="email"
                            placeholder="Enter email">
                        @error('email')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password-input" class="form-label">Password</label>
                        <div class="position-relative auth-pass-inputgroup mb-3">
                            <input type="password"
                                class="form-control pe-5 password-input @error('password') is-invalid @enderror"
                                name="password" id="password-input" placeholder="Enter password">
                            <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon"
                                type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                            @error('password')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="text-end mb-3">
                            <a href="{{ route('password.request') }}" class="text-muted">Forgot password?</a>
                        </div>
                    </div>

                    <div class="mt-4">
                        <button class="btn btn-primary w-100 fw-semibold" type="submit">Sign In</button>
                    </div>
                </form>
                <!-- End Form -->
            </div>
        </div>

        <!-- Footer -->
        <footer class="position-absolute bottom-0 text-center w-100 py-3 text-white small">
            <script>document.write(new Date().getFullYear())</script> © TSG Fresh Resort Waikkal. Crafted with <i
                class="mdi mdi-heart text-danger"></i> by CyberWolf Solutions (Pvt) Ltd.
        </footer>
    </div>
@endsection

@section('script')
    <script src="{{ URL::asset('build/js/pages/password-addon.init.js') }}"></script>
@endsection
