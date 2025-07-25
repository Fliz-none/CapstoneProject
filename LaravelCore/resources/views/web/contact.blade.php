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
                            <img class="img-fluid object-fit-contain" src="{{ asset(env('FILE_STORAGE', '/storage/') . '/' . $settings['banner_contact']) }}" alt="banner" loading="lazy">
                        </div>
                    </div>
                </div>
                <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
            </div>
            <div class="swiper-pagination"></div>
        </div>
        <div class="contact-infolist">
            <div class="container">
                <div class="titlebox text-center">
                    <h2 class="fw-semibold">
                        Chúng tôi muốn lắng nghe từ bạn
                    </h2>
                    <p class="">
                        Đội ngũ của chúng tôi luôn sẵn sàng hỗ trợ.
                    </p>
                </div>
                <div class="boxlist-info">
                    <div class="item">
                        <div class="icon">
                            <img src="{{ asset('images/email-lh.png') }}" alt="">
                        </div>
                        <div class="info">
                            <h3 class="title">
                                Email
                            </h3>
                            <p class="desc">
                                {{ $settings['company_email'] }}
                            </p>
                        </div>
                    </div>
                    <div class="item">
                        <div class="icon">
                            <img src="{{ asset('images/phone-lh.png') }}" alt="">
                        </div>
                        <div class="info">
                            <h3 class="title">
                                Hotline
                            </h3>
                            <p class="desc">
                                {{ $settings['company_hotline'] }}
                            </p>
                        </div>
                    </div>
                    <div class="item">
                        <div class="icon">
                            <img src="{{ asset('images/add-lh.png') }}" alt="">
                        </div>
                        <div class="info">
                            <h3 class="title">
                                Địa chỉ
                            </h3>
                            <p class="desc">
                                {{ $settings['company_address'] }}
                            </p>
                        </div>
                    </div>
                    <div class="item">
                        <div class="icon">
                            <img src="{{ asset('images/web-lh.png') }}" alt="">
                        </div>
                        <div class="info">
                            <h3 class="title">
                                Facebook
                            </h3>
                            <p class="desc">
                                <a href="{{ $settings['social_facebook'] }}">{{ $settings['company_name'] }}</a>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="social-networks">
                    <div class="social-networks-titlebox">
                        <h3 class="title">
                            Liên kết mạng xã hội
                        </h3>
                        <span class="desc">
                            Theo dõi chúng tôi qua:
                        </span>
                    </div>
                    <div class="social-list">
                        <a href="{{ $settings['social_facebook'] }}" title="facebook" target="_blank">
                            <img src="{{ asset('images/Facebook-lh.png') }}" alt="">
                        </a>
                        <a href="{{ $settings['social_zalo'] }}" title="instagram" target="_blank">
                            <img src="{{ asset('images/zalo-lh.png') }}" alt="">
                        </a>
                        <a href="{{ $settings['social_youtube'] }}" title="youtube" target="_blank">
                            <img src="{{ asset('images/youtube-lh.png') }}" alt="">
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="contact-office key-bg-section" style="background-image: url({{ asset(env('FILE_STORAGE', '/storage/') . '/bg-contact-1.jpg') }})">
            <div class="child-container">
                <div class="row">
                    <div class="col-lg-5 col-12">
                        <div class="titlebox">
                            <h3 class="fw-semibold">
                                Địa chỉ {{ $settings['company_name'] }}
                            </h3>
                            <span class="desc">Tìm đến {{ $settings['company_name'] }} tại:</span>
                        </div>
                        <div class="office-list">
                            @php
                                $url = null;
                                $branches = cache()->get('branches');
                            @endphp
                            @if ($branches)
                                @foreach ($branches as $index => $branch)
                                    @php
                                        $url = 'https://www.google.com/maps/search/?api=1&query=' . urlencode($branch->address);
                                    @endphp
                                    <div class="office-item">
                                        <a href="{{ $url }}" target="_blank">
                                            <div class="office-name">
                                                Chi nhánh {{ $index + 1 }}: {{ $branch->address }}
                                            </div>
                                        </a>
                                        <a href="tel:{{ $settings['company_hotline'] }}">
                                            <div class="office-hotline">
                                                Hotline: {{ $settings['company_hotline'] }}
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-7 col-12">
                        @if ($url)
                            <div class="map-embed">
                                <iframe
                                    src="https://maps.google.com/maps?q={{ urlencode($branches[0]->address) }}&output=embed" style="border:0; border-radius: 10px;" width="600" height="450" allowfullscreen="" loading="lazy"
                                    referrerpolicy="no-referrer-when-downgrade"></iframe>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
