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
                    <div class="card mb-3 py-5">
                        <div class="card-body">
                            @if (Auth::user()->name)
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">{{ __('messages.profile.name') }}</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    {{ Auth::user()->name }}
                                </div>
                            </div>
                            <hr>
                            @endif
                            @if (Auth::user()->gender)
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">{{ __('messages.profile.gender') }}</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    {{ Auth::user()->genderStr }}
                                </div>
                            </div>
                            <hr>
                            @endif
                            @if (Auth::user()->email)
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">{{ __('messages.profile.email') }}
                                        @if (Auth::user()->email_verified_at)
                                            <span class="text-success"><i class="bi bi-check-circle-fill"></i></span>
                                        @endif
                                    </h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    {{ Auth::user()->email }}
                                </div>
                            </div>
                            <hr>
                            @endif
                            @if (Auth::user()->phone)
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">{{ __('messages.profile.phone') }}</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    {{ Auth::user()->phone }}
                                </div>
                            </div>
                            <hr>
                            @endif
                            @if (Auth::user()->address || Auth::user()->local_id)
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">{{ __('messages.profile.address') }}</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    {{ Auth::user()->fullAddress }}
                                </div>
                            </div>
                            <hr>
                            @endif
                            @if (Auth::user()->birthday)
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">{{ __('messages.profile.birthday') }}</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    {{ Carbon\Carbon::parse(Auth::user()->birthday)->format('d/m/Y') }}
                                </div>
                            </div>
                            <hr>
                            @endif
                            @if (Auth::user()->last_login_at)
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">{{ __('messages.profile.last_login') }}</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    {{ Carbon\Carbon::parse(Auth::user()->last_login_at)->format('d/m/Y H:i:s') }}
                                </div>
                            </div>
                            <hr>
                            @endif
                            <div class="row">
                                <div class="col-sm-12 d-flex justify-content-center align-items-center">
                                    <a href="{{ route('admin.profile', ['key' => 'settings']) }}" class="btn btn-primary cursor-pointer">
                                        {{ __('messages.update') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
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
