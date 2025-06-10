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
                    <form action="{{ route('admin.profile.change_settings') }}" method="post">
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
                                        <h6 class="mb-0" data-bs-toggle="tooltip" data-bs-title="System-wide display name">{{ __('messages.profile.name') }}</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input class="form-control @error('name') is-invalid @enderror" id="profile-name" name="name" type="text" value="{{ Auth::user()->name ?? old('name') }}">
                                        @error('name')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row align-items-center mb-4">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0" data-bs-toggle="tooltip" data-bs-title="Choose gender for convenience in addressing and displaying content">{{ __('messages.profile.gender') }}</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <div class="btn-group" role="group" aria-label="Gender selection">
                                            <input class="btn-check" id="gender-male" name="gender" type="radio" value="0" autocomplete="off" {{ Auth::user()->gender == '0' || old('gender') == '0' ? 'checked' : '' }}>
                                            <label class="btn btn-outline-primary" for="gender-male">{{ __('messages.profile.male') }}</label>
                                            <input class="btn-check" id="gender-female" name="gender" type="radio" value="1" autocomplete="off" {{ Auth::user()->gender == '1' || old('gender') == '1' ? 'checked' : '' }}>
                                            <label class="btn btn-outline-primary" for="gender-female">{{ __('messages.profile.female') }}</label>
                                            <input class="btn-check" id="gender-other" name="gender" type="radio" value="2" autocomplete="off" {{ Auth::user()->gender == '2' || old('gender') == '2' ? 'checked' : '' }}>
                                            <label class="btn btn-outline-primary" for="gender-other">{{ __('messages.profile.other') }}</label>
                                        </div>
                                        @error('gender')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row align-items-center mb-4">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0" data-bs-toggle="tooltip" data-bs-title="System-wide email address for login and receiving notifications">{{ __('messages.profile.email') }}</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input class="form-control @error('email') is-invalid @enderror" id="profile-email" name="email" type="email" value="{{ Auth::user()->email ?? old('email') }}" inputmode="email" placeholder="{{ __('messages.profile.enter_email') }}">
                                        @error('email')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row align-items-center mb-4">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0" data-bs-toggle="tooltip" data-bs-title="Used for contact when necessary">{{ __('messages.profile.phone') }}</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input class="form-control @error('phone') is-invalid @enderror" id="profile-phone" name="phone" type="text" value="{{ Auth::user()->phone ?? old('phone') }}" inputmode="numeric" placeholder="{{ __('messages.profile.enter_phone') }}">
                                        @error('phone')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row align-items-center mb-4">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0" data-bs-toggle="tooltip" data-bs-title="Used for shipping and receiving goods">{{ __('messages.profile.address') }}</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input class="form-control @error('address') is-invalid @enderror @error('address') is-invalid @enderror" id="profile-address" name="{{ __('messages.profile.address') }}" type="text"
                                            value="{{ Auth::user()->address ?? old('address') }}" placeholder="{{ __('messages.profile.enter_address') }}">
                                        @error('address')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row align-items-center mb-4">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0" data-bs-toggle="tooltip" data-bs-title="Used to verify you are the account owner updating this information">{{ __('messages.profile.password') }}</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input class="form-control @error('password') is-invalid @enderror" id="profile-password" name="password" type="password" placeholder="{{ __('messages.profile.enter_password') }}">
                                        @error('password')
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
