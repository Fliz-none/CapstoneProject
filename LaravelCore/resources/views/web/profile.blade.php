@extends('web.layouts.app')
@section('title')
    {{ $pageName }}
@endsection
@php
    $settings = cache()->get('settings');
@endphp
@section('content')
    <div class="master-wrapper">
        <div class="home-banner-wrapper">
            <div class="swiper">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="home-banner-slide">
                            <img class="img-fluid" src="{{ asset(env('FILE_STORAGE', '/storage/') . '/'. $settings['banner_home_1']) }}" loading="lazy" alt="banner">
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="home-banner-slide">
                            <img class="img-fluid" src="{{ asset(env('FILE_STORAGE', '/storage/') . '/'. $settings['banner_home_2']) }}" loading="lazy" alt="banner">
                        </div>
                    </div>
                </div>
                <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
            </div>

            <div class="swiper-pagination"></div>
        </div>
        <div class="container py-5">
            <div class="row">
                <div class="col-12 col-md-8">
                    <div class="profile-wrapper">
                        <div class="profile-header">
                            <h2 class="fw-semibold">Thông tin cá nhân</h2>
                        </div>
                        @php
                            $user = auth()->user();
                        @endphp
                        <div class="profile-content">
                            <div class="row justify-content-center">
                                <div class="col-12 col-sm-8 col-md-4">
                                    <div class="profile-avatar py-2">
                                        <img class="img-fluid rounded-circle" src="{{ $user->avatarUrl }}" alt="Avatar">
                                    </div>
                                </div>
                                <div class="col-12 col-md-8">
                                    <div class="profile-info">
                                        <h3 class="fw-semibold">{{ $user->name }}</h3>
                                        <p class="text-muted">{{ $user->email }}</p>
                                        <p class="text-muted">{{ $user->phone }}</p>
                                        <p class="text-muted">{{ $user->address }}</p>
                                        <p class="text-muted">{{ $user->created_at->format('d/m/Y') }}</p>
                                        <a class="key-btn-info mb-3 btn-web-profile" href="#">Chỉnh sửa thông tin</a>
                                        {!! $user->hasAnyPermission(\App\Models\User::ACCESS_ADMIN) ? '<a href="' . route('admin.home') . '" class="key-btn-dark mb-3">Truy cập trang quản trị</a>' : '' !!}
                                        <a class="key-btn-danger mb-3" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            {{ __('messages.profile.logout') }}
                                            <i class="icon-mid bi bi-box-arrow-right me-2"></i>
                                        </a>
                                        <form class="d-none" id="logout-form" action="{{ route('logout') }}" method="POST">
                                            @csrf
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        function submitLogoutForm() {
            const form = $("#logout-form");
            form.attr("action", "/logout");
            submitForm(form).done(function(response) {
                window.location.reload();
            });
        }

        $(document).on('click', '.btn-web-profile', function(e) {
            e.preventDefault();
            const form = $('#profile-web-form');
            const btn = form.find('button[type="submit"]');
            const originalText = btn.attr('data-text') || 'Save';
            btn.prop('disabled', false).html(originalText);
            $('#profile-web-modal').modal('show');
        });


        $(document).on('submit', '#profile-web-form', function(e) {
            e.preventDefault();
            const form = $(this);
            submitForm(form).done(function(response) {
                resetForm(form);
                setTimeout(() => {
                    location.reload();
                }, 500);
            });
        });

        //Preview avatar
        $('#profile-avatar').on('change', function(e) {
            const file = e.target.files[0];

            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#avatar-preview').attr('src', e.target.result);
                };
                reader.readAsDataURL(file);
            } else {
                alert("Vui lòng chọn một tệp hình ảnh hợp lệ.");
            }
        });
    </script>
@endpush
