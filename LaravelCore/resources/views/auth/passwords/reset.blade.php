@extends('web.layouts.app')
@section('title')
    {{ __('Reset Password') }}
@endsection
@section('content')
    <div class="container my-5 py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Reset Password') }}</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf
                            <input name="token" type="hidden" value="{{ $token }}">
                            <div class="row mb-3">
                                <label class="col-md-4 col-form-label text-md-end" for="email">{{ __('Email Address') }}</label>
                                <div class="col-md-6">
                                    <input class="form-control @error('email') is-invalid @enderror" id="email" name="email" type="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus placeholder="Email address">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-md-4 col-form-label text-md-end" for="password">{{ __('Password') }}</label>
                                <div class="col-md-6">
                                    <input class="form-control @error('password') is-invalid @enderror" id="password" name="password" type="password" required autocomplete="off" placeholder="{{ __('Password') }}">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-md-4 col-form-label text-md-end" for="password-confirm">{{ __('Confirm Password') }}</label>
                                <div class="col-md-6">
                                    <input class="form-control" id="password-confirm" name="password_confirmation" type="password" required autocomplete="off" required placeholder="{{ __('Confirm Password') }}">
                                </div>
                            </div>
                            <div class="row mb-0">
                                <div class="d-flex align-items-center col-md-6 offset-md-4">
                                    <button class="key-btn-dark" type="submit">
                                        {{ __('Reset Password') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
