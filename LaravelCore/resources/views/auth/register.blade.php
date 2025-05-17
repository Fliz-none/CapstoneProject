@extends('web.layouts.app')
@section('title')
    {{ __('Register') }}
@endsection
@section('content')
    <div class="container my-5 py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Register') }}</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="row mb-3">
                                <label class="col-md-4 col-form-label text-md-end" for="name">{{ __('Name') }}</label>
                                <div class="col-md-6">
                                    <input class="form-control @error('name') is-invalid @enderror" id="name" name="name" type="text" value="{{ old('name') }}" required autofocus placeholder="Name">
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-md-4 col-form-label text-md-end" for="phone">{{ __('Phone') }}</label>
                                <div class="col-md-6">
                                    <input class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" type="text" value="{{ old('phone') }}" required autocomplete="on" inputmode="numeric" placeholder="Phone number">
                                    @error('phone')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-md-4 col-form-label text-md-end" for="address">{{ __('Address') }}</label>
                                <div class="col-md-6">
                                    <input class="form-control @error('address') is-invalid @enderror" id="address" name="address" type="text" value="{{ old('address') }}" autocomplete="on" placeholder="Address">
                                    @error('address')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-md-4 col-form-label text-md-end" for="birthday">{{ __('Birthday') }}</label>
                                <div class="col-md-6">
                                    <input class="form-control @error('birthday') is-invalid @enderror" id="birthday" name="birthday" type="date" value="{{ old('birthday') }} " max="{{ now()->format('Y-m-d') }}" />
                                    @error('birthday')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-md-4 col-form-label text-md-end" for="men">{{ __('Gender') }}</label>
                                <div class="col-md-6 d-flex align-items-center">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" id="men" name="gender" type="radio" value="0" checked>
                                        <label class="form-check-label cursor-pointer" for="men">
                                            {{ __('Male') }}
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" id="women" name="gender" type="radio" value="1">
                                        <label class="form-check-label cursor-pointer" for="women">
                                            {{ __('Female') }}
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" id="other" name="gender" type="radio" value="2">
                                        <label class="form-check-label cursor-pointer" for="other">
                                            {{ __('Order') }}
                                        </label>
                                    </div>
                                    @error('gender')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-md-4 col-form-label text-md-end" for="email">{{ __('Email Address') }}</label>
                                <div class="col-md-6">
                                    <input class="form-control @error('email') is-invalid @enderror" id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="on" placeholder="Email address">
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
                                    <input class="form-control @error('password') is-invalid @enderror" id="password" name="password" type="password" require placeholder="Password">
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
                                    <input class="form-control" id="password-confirm" name="password_confirmation" type="password" required placeholder="Confirm password">
                                </div>
                            </div>
                            <div class="row mb-0">
                                <div class="d-flex align-items-center col-md-6 offset-md-4">
                                    <button class="key-btn-dark" type="submit">
                                        {{ __('Register') }}
                                    </button>
                                </div>
                                <div class="col-12 d-flex justify-content-end pe-2 p-lg-4">
                                    <div class="ms-2">
                                        <span>Already have an account? <a href="{{ route('login') }}"> {{ __('Login') }}</a></span>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
