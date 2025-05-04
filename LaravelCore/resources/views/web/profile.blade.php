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
                        <img class="img-fluid" src="{{asset('images/banner/cua-hang-banner.jpg')}}" loading="lazy"
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
                        <img class="img-fluid" src="{{asset('images/banner/dv-thu-cung-banner.jpg')}}" loading="lazy"
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

    <div class="support-wrapper support-fwidth-wrapper"
        style="background-image: url({{asset('images/bg-store-3.jpg')}});">
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
