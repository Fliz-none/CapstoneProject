@extends('admin.layouts.auth')
@section('title')
    Sign up
@endsection
@section('content')
    <div class="col-lg-5 col-12">
        <div id="auth-left">
            <div class="auth-logo logo">
                <a href="index.html"><img src="{{ asset('admin/assets/images/logo/logo-footer.svg') }}" alt="Logo"
                        style="min-height: 100px;"></a>
            </div>
            <h1 class="auth-title">Sign Up</h1>
            <p class="auth-subtitle mb-5">Input your data to register to our website.</p>
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="form-group position-relative has-icon-left mb-4">
                    <input id="name" type="text"
                        class="form-control form-control-xl @error('name') is-invalid @enderror" name="name"
                        placeholder="Name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                    <div class="form-control-icon">
                        <i class="bi bi-person"></i>
                    </div>
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group position-relative has-icon-left mb-4">
                    <input id="phone" type="text"
                        class="form-control form-control-xl @error('phone') is-invalid @enderror" name="phone"
                        placeholder="Phone" value="{{ old('phone') }}" required autocomplete="phone"
                        inputmode="numeric">
                    <div class="form-control-icon">
                        <i class="bi bi-telephone"></i>
                    </div>
                    @error('phone')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group position-relative has-icon-left mb-4">
                    <input id="address" type="text"
                        class="form-control form-control-xl @error('address') is-invalid @enderror" name="address"
                        placeholder="Address" value="{{ old('address') }}" required autocomplete="address" autofocus>
                    <div class="form-control-icon">
                        <i class="bi bi-geo-alt"></i>
                    </div>
                    @error('address')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group position-relative has-icon-left mb-4">
                    <input id="email" type="email"
                        class="form-control form-control-xl @error('email') is-invalid @enderror" name="email"
                        placeholder="Email" value="{{ old('email') }}" required autocomplete="email">
                    <div class="form-control-icon">
                        <i class="bi bi-envelope"></i>
                    </div>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group position-relative has-icon-left mb-4">
                    <input id="password" type="password"
                        class="form-control form-control-xl @error('password') is-invalid @enderror" name="password"
                        placeholder="Password" required autocomplete="new-password">
                    <div class="form-control-icon">
                        <i class="bi bi-shield-lock"></i>
                    </div>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group position-relative has-icon-left mb-4">
                    <input id="password-confirm" type="password" class="form-control form-control-xl"
                        name="password_confirmation" placeholder="Confirm password" required
                        autocomplete="new-password">
                    <div class="form-control-icon">
                        <i class="bi bi-shield-lock"></i>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Sign up</button>
            </form>
            <div class="text-center mt-5 text-lg fs-4">
                @if (Route::has('login'))
                    <p class='text-gray-600'>Already have an account? <a href="{{ route('admin.login') }}" class="font-bold">Log in</a>.</p>
                @endif
            </div>
        </div>
    </div>
@endsection
