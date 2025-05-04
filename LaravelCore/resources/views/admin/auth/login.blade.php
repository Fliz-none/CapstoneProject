@extends('admin.layouts.auth')
@section('title')
    Login
@endsection
@section('content')
    <div class="col-lg-5 col-12">
        <div id="auth-left">
            <div class="auth-logo">
                <a href="index.html"><img src="{{ asset('admin/assets/images/logo/logo-footer.svg') }}" alt="Logo" style="min-height: 100px;"></a>
            </div>
            <h1 class="auth-title">Log in.</h1>
            <p class="auth-subtitle mb-5">Log in with your data that you entered during registration.</p>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group position-relative has-icon-left mb-4">
                    <input id="email" type="email"
                        class="form-control form-control-xl @error('email') is-invalid @enderror" name="email"
                        value="{{ old('email') }}" required placeholder="Email" autocomplete="email" autofocus>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <div class="form-control-icon">
                        <i class="bi bi-person"></i>
                    </div>
                </div>
                <div class="form-group position-relative has-icon-left mb-4">
                    <input id="password" type="password"
                        class="form-control form-control-xl @error('password') is-invalid @enderror" name="password"
                        required placeholder="Password" autocomplete="current-password">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <div class="form-control-icon">
                        <i class="bi bi-shield-lock"></i>
                    </div>
                </div>
                <div class="form-check form-check-lg d-flex align-items-end">
                    <input class="form-check-input me-2" type="checkbox" name="remember" id="remember"
                        {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label text-gray-600" for="remember">
                        Keep me logged in
                    </label>
                </div>
                <button type="submit" class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Log in</button>
            </form>
            <div class="text-center mt-5 text-lg fs-4">
                <p class="text-gray-600">Don't have an account? <a href="{{ route('admin.register') }}" class="font-bold">Sign up</a>.</p>
                <p><a class="font-bold" href="{{ route('password.request')}}">Forgot password?</a>.</p>
            </div>
        </div>
    </div>
@endsection
