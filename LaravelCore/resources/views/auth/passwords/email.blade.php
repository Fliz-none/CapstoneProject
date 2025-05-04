@extends('web.layouts.app')
@section('title')
    {{ __('Forgot Password') }}
@endsection
@section('content')
    <div class="container my-5 py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Forgot Password') }}</div>
                    <div class="card-body row justify-content-center align-items-center">
                        <div class="col-9">
                            <p class="auth-subtitle mb-3 ms-3">{{ __('Input your email and we will send you reset password link.') }}</p>
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif
                            <form method="POST" action="{{ route('password.email') }}">
                                @csrf
                                <div class="form-group position-relative has-icon-left p-4">
                                    <input class="form-control form-control-xl @error('email') is-invalid @enderror" id="email" name="email" type="email" value="{{ old('email') }}" required placeholder="Email" autocomplete="email" autofocus>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <button class="key-btn-dark mt-2 ms-3" type="submit">{{ __('Send') }}</button>
                                <div class="row mb-0">
                                    <div class="col-12 d-flex justify-content-end pe-2 p-lg-4">
                                        <span>Đã nhớ mật khẩu? <a href="{{ route('admin.login') }}">{{ __('Login') }}</a>.</span>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
