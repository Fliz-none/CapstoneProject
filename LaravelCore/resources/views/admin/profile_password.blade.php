@extends('admin.layouts.app')
@section('title')
    {{ $pageName }}
@endsection
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>{{ $pageName }}</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav class="breadcrumb-header float-start float-lg-end" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active" aria-current="page">{{ $pageName }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="row gutters-sm">
                <div class="col-md-4 mb-3">
                    @include('admin.includes.profile_beside')
                </div>
                <div class="col-md-8">
                    <form action="{{ route('admin.profile.change_password') }}" method="post">
                        @csrf
                        <div class="card mb-3 py-5">
                            @if (session('response'))
                                <div class="alert alert-{{ session('response')['status'] }} alert-dismissible fade show text-white" role="alert">
                                    <i class="fas fa-check"></i>
                                    {!! session('response')['msg'] !!}
                                    <button class="btn-close" data-bs-dismiss="alert" type="button" arial-label="Close"></button>
                                </div>
                            @endif
                            <div class="card-body">
                                <div class="row align-items-center mb-4">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0" data-bs-toggle="tooltip" data-bs-title="Please enter your current password for this account">{{ __('messages.profile.current_password') }}</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input class="form-control @error('current_password') is-invalid @enderror" id="profile-current-password" name="current_password" type="password" placeholder="{{ __('messages.profile.current_password') }}" autocomplete="current-password">
                                        @error('current_password')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row align-items-center mb-4">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0" data-bs-toggle="tooltip" data-bs-title="Please enter a new password (must not match the current password, at least 8 characters, 1 uppercase letter, 1 lowercase letter, 1 number, and 1 special character, and no more than 3 consecutive characters)">{{ __('messages.profile.new_password') }}</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input class="form-control @error('password') is-invalid @enderror" name="password" type="password" autocomplete="new-password" placeholder="{{ __('messages.profile.new_password') }}">
                                        @error('password')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row align-items-center mb-4">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0" data-bs-toggle="tooltip" data-bs-title="Please re-enter the new password to confirm you didn't make a mistake above">{{ __('messages.profile.confirm_password') }}</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input class="form-control @error('password') is-invalid @enderror" name="password_confirmation" type="password" autocomplete="new-password" placeholder="{{ __('messages.profile.confirm_password') }}">
                                        @error('password_confirmation')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row align-items-center">
                                    <div class="col-sm-12 d-flex justify-content-center">
                                        <input name="id" type="hidden" value="{{ Auth::user()->id }}">
                                        <button class="btn btn-primary " type="submit">{{ __('messages.update') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection


@push('scripts')
    <script>
        $('#profile-avatar').change(function(e) {
            e.preventDefault()
            const form = $(this).parents('form')
            src = URL.createObjectURL(document.getElementById('profile-avatar').files[0])
            $(this).parents('form').find('img').attr('src', src)
            submitForm(form)
        })
    </script>
@endpush
