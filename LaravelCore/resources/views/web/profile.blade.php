@extends('web.layouts.app')
@section('title')
    {{ $pageName }}
@endsection
@section('content')
    <div class="master-wrapper">
        <div class="home-banner-wrapper">
            <div class="swiper">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="home-banner-slide">
                            <img class="img-fluid" src="{{ asset('images/banner/cua-hang-banner.jpg') }}" loading="lazy"
                                alt="banner">
                        </div>
                        <div class="text-box-banner text-center">
                            <h2 class="fw-semibold">Dịch vụ TruongDung Pet cung cấp</h2>
                            <p>ChTruongDung Pet đặt tình yêu và sự chân thành đến với sức khỏe của Pet cưng của bạn.
                            </p>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="home-banner-slide">
                            <img class="img-fluid" src="{{ asset('images/banner/dv-thu-cung-banner.jpg') }}" loading="lazy"
                                alt="banner">
                        </div>
                        <div class="text-box-banner text-center">
                            <h3>Dịch vụ TruongDung Pet cung cấp</h3>
                            <p>TruongDung Pet đặt tình yêu và sự chân thành đến với sức khỏe của Pet cưng của bạn.
                            </p>
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
                                        <a href="#" class="key-btn-info mb-3">Chỉnh sửa thông tin</a>
                                        {!! $user->hasAnyPermission(\App\Models\User::ACCESS_ADMIN) ? '<a href="' . route('admin.home') . '" class="key-btn-dark mb-3">Truy cập trang quản trị</a>' : '' !!}
                                        <a class="key-btn-danger mb-3" href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                        submitLogoutForm();">
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
        <div class="support-wrapper support-fwidth-wrapper"
            style="background-image: url({{ asset('images/bg-store-3.jpg') }});">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-md-8">
                        <h2 class="text-dark fw-semibold">Bạn có biết?</h2>
                        <p class="text-dark">TruongDung Pet là chuỗi cung ứng đầy đủ các dịch vụ thú y với tầm nhìn
                            trở thành thương hiệu Phòng khám Thú y-Dịch vụ chăm sóc Thú cưng có tâm, có tầm, hiện
                            đại hoá lớn nhất khu vực Cần Thơ và các tỉnh lân cận</p>

                        <a href="tel:0344333586" title="HOTLINE 0344 333 586" class="cta-btn">
                            HOTLINE 0344 333 586
                        </a>
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
            submitForm(form).done(function (response) {
                window.location.reload();
            });
        }
    </script>
@endpush