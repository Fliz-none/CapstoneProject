@extends('web.layouts.app')
@section('title')
    {{ $pageName }}
@endsection
@section('content')
    <div class="master-wrapper">
        <div class="container-fluid px-0">
            <div class="home-banner-wrapper">
                <div class="swiper">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="home-banner-slide">
                                <img class="img-fluid" src="{{ asset('images/banner/banner-hero.jpg') }}" alt="Trang chủ" loading="lazy">
                            </div>
                            <div class="text-box-banner top text-center">
                                <h2> Dịch vụ TruongDung Pet cung cấp </h2>
                                <p> TruongDung Pet đặt tình yêu và sự chân thành đến với sức khỏe của Pet cưng của bạn. </p>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="home-banner-slide">
                                <img class="img-fluid" src="{{ asset('images/banner/spa-banner.jpg') }}" alt="Trang chủ" loading="lazy">
                            </div>
                            <div class="text-box-banner text-center">
                                <h3>TruongDung Pet - Dịch Vụ Thú Y Cần Thơ</h3>
                                <p>Chuyên: Khám & Điều trị bệnh, Spa, Cắt tỉa lông, Nhuộm, Pet hotel.
                                </p>
                            </div>
                        </div>
                    </div>
                    <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
        <div class="banner-w-nav">
            @include('web.includes.subnav', ['pageName' => $pageName])
        </div>
        <div class="key-section">
            <div class="container">
                <div class="row align-items-center mb-4">
                    <div class="col-12 col-md-6 p-2 p-md-5">
                        <h2 class="text-dark fw-semibold fs-1 mb-3">Dịch vụ nhuộm</h2>

                        <p class="justify">Dịch vụ nhuộm lông thú cưng tại TruongDung Pet có những style cơ bản
                            sau: nhuộm lông 2 tai, nhuộm lông 4 chân và đuôi sáng tạo trên thú cưng. Màu nhuộm
                            lông cho chó mèo sẽ giữ màu hơn 6 tháng.</p>
                        <p class="mt-4">
                            <a class="key-btn-dark" href="#" title="Đặt lịch ngay">
                                Đặt lịch ngay <img class="img-fluid" src="{{ asset('images/img/arrow-right.png') }}" alt="">
                            </a>
                        </p>
                    </div>
                    <div class="col-12 col-md-6 p-2 p-md-5">
                        <div class="img my-4 img-style">
                            <div class="img-inner">
                                <img class="img-fluid" src="{{ asset('images/spa-img-1.jpg') }}" alt="dịch vụ thú cưng" loading="lazy">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row align-items-center mb-4">
                    <div class="col-12 col-md-6 p-2 p-md-5">
                        <div class="img my-4 img-style">
                            <div class="img-inner">
                                <img class="img-fluid" src="{{ asset('images/spa-img-2.jpg') }}" alt="dịch vụ thú cưng" loading="lazy">
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 p-2 p-md-5">
                        <h2 class="text-dark fw-semibold fs-1 mb-3">Spa</h2>

                        <p class="justify">Với hệ thống trang thiết bị hiện đại nhất và tốt nhất cùng với đội
                            ngũ nhân viên được đào tạo bài bản thì tại TruongDung Pet đã cung cấp các dịch vụ
                            spa.</p>
                        <p class="mt-4">
                            <a class="key-btn-dark" href="#" title="Đặt lịch ngay">
                                Đặt lịch ngay <img class="img-fluid" src="{{ asset('images/img/arrow-right.png') }}" alt="">
                            </a>
                        </p>
                    </div>
                </div>
                <div class="row align-items-center mb-4">
                    <div class="col-12 col-md-6 p-2 p-md-5">
                        <h2 class="text-dark fw-semibold fs-1 mb-3">Cắt tỉa lông</h2>

                        <p class="justify">Với đội ngũ thợ grooming tâm huyết và nhiều kinh nghiệm, TruongDung
                            Pet sẽ là địa chỉ tin cậy để các chú cún và mèo khoác lên mình những bộ áo mới cực
                            kì xinh đẹp.</p>
                        <p class="mt-4">
                            <a class="key-btn-dark" href="#" title="Đặt lịch ngay">
                                Đặt lịch ngay <img class="img-fluid" src="{{ asset('images/img/arrow-right.png') }}" alt="">
                            </a>
                        </p>
                    </div>
                    <div class="col-12 col-md-6 p-2 p-md-5">
                        <div class="img my-4 img-style">
                            <div class="img-inner">
                                <img class="img-fluid" src="{{ asset('images/spa-img-3.jpg') }}" alt="dịch vụ thú cưng" loading="lazy">
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="product-showcase-wrapper home-product key-bg-section" style="background-image: url({{ asset('images/bg-contact-1.jpg') }});">
            <div class="container">
                <div class="p-4 text-center">
                    <h2 class="text-dark fw-semibold fs-1 mb-3">Các sản phẩm của TruongDungPet</h2>
                </div>
            </div>
            <div class="product-showcase--inner">
                <div class="product-slide-wrapper product-slide-wrapper-3">
                    <div class="container">
                        <div class="product-slide--inner">
                            <div class="product-sapo">
                                <p class="product-cate text-uppercase">
                                    Sản phẩm nổi bật
                                </p>
                                <h5>
                                    Boss yêu thích
                                </h5>
                                <p class="product-des">
                                    TruongDungPet <br />
                                    Cung cấp những sản phẩm chất lượng và an toàn sức khỏe của thú cưng, mang lại cho khách hàng sự hài lòng và yên tâm.
                                </p>
                                <a class="cta-btn" href="{{ route('product') }}">
                                    Xem tất cả sản phẩm
                                </a>
                                <div class="custom-slide-nav">
                                    <div class="swiper-button-prev">
                                        <svg width="48" height="30" viewBox="0 0 48 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="15" cy="15" r="14.5" transform="rotate(180 15 15)" stroke="#333333"></circle>
                                            <path d="M48 15.5L12.5 15.5M12.5 15.5L15.5 19M12.5 15.5L15.5 12" stroke="#333333"></path>
                                        </svg>
                                    </div>
                                    <div class="swiper-button-next">
                                        <svg width="48" height="30" viewBox="0 0 48 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="33" cy="15" r="14.5" stroke="#333333"></circle>
                                            <path d="M0 15.5H35.5M35.5 15.5L32.5 12M35.5 15.5L32.5 19" stroke="#333333"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <div class="product-slider product-list">
                                <div class="swiper">
                                    <div class="swiper-wrapper">
                                        @foreach ($products as $product)
                                            @include('web.includes.product_box', ['product' => $product])
                                        @endforeach
                                    </div>
                                </div>
                                <div class="swiper-pagination"></div>
                                <div class="custom-slide-nav">
                                    <div class="swiper-button-prev">
                                        <svg width="48" height="30" viewBox="0 0 48 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="15" cy="15" r="14.5" transform="rotate(180 15 15)" stroke="#333333"></circle>
                                            <path d="M48 15.5L12.5 15.5M12.5 15.5L15.5 19M12.5 15.5L15.5 12" stroke="#333333"></path>
                                        </svg>
                                    </div>
                                    <div class="swiper-button-next">
                                        <svg width="48" height="30" viewBox="0 0 48 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="33" cy="15" r="14.5" stroke="#333333"></circle>
                                            <path d="M0 15.5H35.5M35.5 15.5L32.5 12M35.5 15.5L32.5 19" stroke="#333333"></path>
                                        </svg>
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
