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
        <div class="support-wrapper support-fwidth-wrapper" style="background-image: url({{ asset('images/bg-about-3.jpg') }}); background-position: center bottom !important">
            <div class="container">
                <div class="row justify-content-center mb-md-4">
                    <div class="col-12 col-md-8 col-lg-7 px-4 order-md-2">
                        <h2 class="text-dark fw-semibold fs-1">Về TruongDung Pet</h2>
                        <div class="img my-4 img-style">
                            <div class="img-inner">
                                <img class="img-fluid" src="{{ asset('images/img-about-2.jpg') }}" alt="ve-truongdungpet" loading="lazy">
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-4 px-4 order-md-1">
                        <div class="d-block d-sm-none">
                            <p class="text-dark" style="text-align: justify;">Chúng tôi thấu hiểu những nỗi lo
                                lắng
                                của bạn trong quá trình chăm
                                lo
                                cho thú cưng của bạn TruongDung Pet ra đời với sứ mệnh là người bạn - người đồng
                                hành
                                luôn sát cánh cùng bạn trong quá trình nuôi dưỡng thú cưng.</p>
                        </div>
                        <div class="img mb-4 img-style">
                            <div class="img-inner">
                                <img class="" src="{{ asset('images/img-about-1.jpg') }}" alt="ve-truongdungpet" loading="lazy">
                            </div>
                        </div>

                        <div class="d-none d-sm-block">
                            <p class="text-dark" style="text-align: justify;">Chúng tôi thấu hiểu những nỗi lo
                                lắng
                                của bạn trong quá trình chăm
                                lo
                                cho thú cưng của bạn TruongDung Pet ra đời với sứ mệnh là người bạn - người đồng
                                hành
                                luôn sát cánh cùng bạn trong quá trình nuôi dưỡng thú cưng.</p>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center mb-4">
                    <div class="col-12 col-md-5 col-lg-5 px-4 order-md-2">
                        <div class="my-md-5">
                            <p class="text-dark" style="text-align: justify;">TruongDung Pet là trang website
                                cung
                                cấp, chia sẻ kiến thức thông tin chính xác nhất liên quan đến lĩnh vực thú cưng,
                                được đúc kết từ những kinh nghiệm và khó khăn khi nuôi dưỡng thú cưng từ kinh
                                nghiệm
                                thực tế</p>
                        </div>
                        <div class="my-4 my-md-5">

                            <a class="cta-btn" href="{{ route('contact') }}" title="Liên hệ với chúng tôi">
                                Liên hệ với chúng tôi
                            </a>
                        </div>
                    </div>
                    <div class="col-12 col-md-7 col-lg-6 px-4 order-md-1">
                        <div class="img mb-4 img-style">
                            <div class="img-inner">
                                <img class="" src="{{ asset('images/img-about-3.jpg') }}" alt="ve-truongdungpet" loading="lazy">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="gap-400"></div>
        </div>
        <div class="key-section">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-lg-6 pe-md-5">
                        <h2 class="fw-semibold">Lịch sử hình thành và phát triển của TruongDung Pet</h2>
                    </div>
                </div>
                <div class="row justify-content-between">
                    <div class="col-12 col-lg-4 pt-md-4">
                        <p style="text-align: justify;">TRUONGDUNGPET là không gian dịch vụ y tế và chăm sóc sức
                            khỏe dành riêng cho thú cưng.
                            Với đội ngũ bác sĩ, kỹ thuật viên chuyên nghiệp, giàu kinh nghiệm cùng các trang
                            thiết
                            bị hiện đại sẽ mang đến sức khỏe và vẻ đẹp chạm vào cảm xúc cho các boss</p>
                    </div>
                    <div class="col-12 col-lg-7">
                        <div class="img img-style">
                            <div class="img-inner">
                                <img class="" src="{{ asset('images/img-about-4.jpg') }}" alt="ve-truongdungpet" loading="lazy">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="aboutus-wrapper">
            <div class="vision-wrapper" style="background-image: url({{ asset('images/bg-about-4.jpg') }});">
                <div class="child-container">
                    <h4 class="vision-title">
                        Tầm nhìn &amp; sứ mệnh
                    </h4>
                    <div class="vision-content">
                        <div class="vision-item">
                            <div class="v-img">
                                <img class="img-fluid" src="{{ asset('images/tam-nhin.png') }}" alt="">
                            </div>
                            <div class="v-content">
                                <h5>Tầm nhìn</h5>
                                <p>Đến năm 2030, TruongDung Pet phấn đấu trở thành thương hiệu Phòng khám Thú
                                    y-Dịch
                                    vụ chăm sóc Thú cưng có tâm, có tầm, hiện đại hoá lớn nhất Đồng bằng sông
                                    Cửu
                                    Long .! </p>
                            </div>
                        </div>
                        <div class="vision-item">
                            <div class="v-img">
                                <img class="img-fluid" src="{{ asset('images/su-menh.png') }}" alt="">
                            </div>
                            <div class="v-content">
                                <h5>Sứ mệnh</h5>
                                <p> TruongDung Pet sinh ra với sứ mệnh mang lại sức khoẻ, vẻ đẹp và làm cho Thú
                                    cưng
                                    hạnh phúc hơn.!</p>
                            </div>
                        </div>
                    </div>
                    <div class="vision-cta-wrapper">
                        <a class="vision-cta cta-bg" href="{{ route('contact') }}" title="Cơ hội việc làm từ TruongDung Pet">
                            Cơ hội việc làm từ TruongDung Pet
                        </a>
                        <a class="vision-cta" href="{{ route('shop') }}" title="Cửa hàng TruongDung Pet">
                            Cửa hàng TruongDung Pet
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="support-wrapper support-fwidth-wrapper" style="background-image: url({{ asset('images/bg-store-3.jpg') }});">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-md-8">
                        <h2 class="text-dark fw-semibold">Bạn có biết?</h2>
                        <p class="text-dark">TruongDung Pet là chuỗi cung ứng đầy đủ các dịch vụ thú y với tầm
                            nhìn
                            trở thành thương hiệu Phòng khám Thú y-Dịch vụ chăm sóc Thú cưng có tâm, có tầm,
                            hiện
                            đại hoá lớn nhất khu vực Cần Thơ và các tỉnh lân cận</p>

                        <a class="cta-btn" href="tel:0344333586" title="HOTLINE 0344 333 586">
                            HOTLINE 0344 333 586
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
