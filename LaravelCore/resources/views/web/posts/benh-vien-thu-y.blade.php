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
                                <img class="img-fluid" src="{{ asset('images/banner/banner-hero.jpg') }}" alt="img" loading="lazy">
                            </div>
                            <div class="text-box-banner top text-center">
                                <h2> Dịch vụ TruongDung Pet cung cấp </h2>
                                <p> TruongDung Pet đặt tình yêu và sự chân thành đến với sức khỏe của Pet cưng của bạn. </p>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="home-banner-slide">
                                <img class="img-fluid" src="{{ asset('images/banner/spa-banner.jpg') }}" alt="img" loading="lazy">
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
        <div class="key-section key-bg-section" style="background-image: url({{ asset('images/bg-dvtc.jpg') }});">
            <div class="container">
                <div class="row align-items-center mb-4">
                    <div class="col-12 col-md-6 p-2 p-md-5">
                        <h2 class="text-dark fw-semibold fs-1 mb-3">Dịch vụ thú y</h2>

                        <p class="justify">Hãy kiểm tra sức khỏe định kỳ và dẫn thú cưng đi khám bệnh tại thú y
                            TruongDung
                            Pet nếu thấy bé có bất kỳ triệu chứng nào khác thường. Hơn nữa việc kiểm tra sức
                            khỏe định kỳ cho bé còn giúp bạn tiết kiệm chi phí khám chữa bệnh và thời gian
                            điều trị cho vật nuôi. Thay vì phải bỏ ra hàng triệu để chữa bệnh cho chó mèo
                            thì việc kiểm tra sức khỏe định kỳ sẽ giúp bạn phát hiện sớm bệnh và tiết kiệm
                            được rất nhiều chi phí, giúp vật nuôi khỏe mạnh hơn.</p>
                        <p class="mt-4">
                            <a class="key-btn-dark" href="#" title="Đặt lịch ngay">
                                Đặt lịch ngay <img class="img-fluid" src="{{ asset('images/img/arrow-right.png') }}" alt="">
                            </a>
                        </p>
                    </div>
                    <div class="col-12 col-md-6 p-2 p-md-5">
                        <div class="img my-4 img-style">
                            <div class="img-inner">
                                <img class="img-fluid" src="{{ asset('images/dvty-img-1.jpg') }}" alt="dịch vụ thú cưng" loading="lazy">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row align-items-center mb-4">
                    <div class="col-12 col-md-6 p-2 p-md-5">
                        <div class="img my-4 img-style">
                            <div class="img-inner">
                                <img class="img-fluid" src="{{ asset('images/dvty-img-2.jpg') }}" alt="dịch vụ thú cưng" loading="lazy">
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 p-2 p-md-5">
                        <h2 class="text-dark fw-semibold fs-1 mb-3">Khám và điều trị</h2>

                        <p class="justify">Chuẩn đoán và điều trị hiệu quả các bệnh về hệ hô hấp, hệ tiêu hóa,
                            hệ tuần hoàn, tiết niệu, sinh dục, lông da, xương khớp, các bệnh về mắt và tai</p>
                        <p class="mt-4">
                            <a class="key-btn-dark" href="#" title="Đặt lịch ngay">
                                Đặt lịch ngay <img class="img-fluid" src="{{ asset('images/img/arrow-right.png') }}" alt="">
                            </a>
                        </p>
                    </div>
                </div>
                <div class="row align-items-center mb-4">
                    <div class="col-12 col-md-6 p-2 p-md-5">
                        <h2 class="text-dark fw-semibold fs-1 mb-3">Xét nghiệm<br>
                            Chẩn đoán hình ảnh</h2>

                        <p class="justify">Các phương pháp chẩn đoán hình ảnh hoặc làm xét nghiệm: Siêu âm,
                            X-Quang, Xét nghiệm máu, virus, nước tiểu, da, kháng sinh đồ...</p>
                        <p class="mt-4">
                            <a class="key-btn-dark" href="#" title="Đặt lịch ngay">
                                Đặt lịch ngay <img class="img-fluid" src="{{ asset('images/img/arrow-right.png') }}" alt="">
                            </a>
                        </p>
                    </div>
                    <div class="col-12 col-md-6 p-2 p-md-5">
                        <div class="img my-4 img-style">
                            <div class="img-inner">
                                <img class="img-fluid" src="{{ asset('images/dvty-img-3.jpg') }}" alt="dịch vụ thú cưng" loading="lazy">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row align-items-center justify-content-center mb-4">
                    <div class="col-12 col-md-6 p-2 p-md-5 text-center">
                        <h2 class="text-dark fw-semibold fs-1 mb-3">Dịch vụ cấp cứu 24/7</h2>

                        <p>TruongDung Pet cung cấp dịch vụ cấp cứu 24/7, kể cả ngày lễ. Trường
                            hợp cấp cứu sau 19h xin vui lòng liên hệ trước và mang thú cưng tới thú y TruongDung
                            Pet cơ sở 1 KDC 586.</p>
                        <p class="mt-4">
                            <a class="key-btn-dark" href="#" title="Đặt lịch ngay">
                                Đặt lịch ngay <img class="img-fluid" src="{{ asset('images/img/arrow-right.png') }}" alt="">
                            </a>
                        </p>
                    </div>
                    <div class="gap-500"></div>
                    <!-- <div class="col-12 col-md-8 p-2">
                                                <div class="img my-4 img-style">
                                                    <div class="img-inner">
                                                        <img class="img-fluid" src="images/dvty-img-4.jpg" alt="dịch vụ thú cưng" loading="lazy">
                                                    </div>
                                                </div>
                                            </div> -->
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
