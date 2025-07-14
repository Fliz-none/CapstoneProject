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
                            <img class="img-fluid" src="{{ asset('images/banner/lien-he-banner.jpg') }}" alt="banner" loading="lazy">
                        </div>
                        <div class="text-box-banner text-center">
                            <h2 class="fw-semibold">Liên hệ</h2>
                            <p>Kết nối với chúng tôi
                            </p>
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
                                truongthithuydung98@gmail.com
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
                                0344 333 586
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
                                H2-26 Bùi Quang Trinh, KDC 586, Phú Thứ Cái Răng, Cần Thơ
                            </p>
                        </div>
                    </div>
                    <div class="item">
                        <div class="icon">
                            <img src="{{ asset('images/web-lh.png') }}" alt="">
                        </div>
                        <div class="info">
                            <h3 class="title">
                                website
                            </h3>
                            <p class="desc">
                                thuytruongdungpet.com
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
                        <a href="https://www.facebook.com/TruongDungPet" title="facebook" target="_blank">
                            <img src="{{ asset('images/Facebook-lh.png') }}" alt="">
                        </a>
                        <a href="http://zalo.me/" title="instagram" target="_blank">
                            <img src="{{ asset('images/zalo-lh.png') }}" alt="">
                        </a>
                        <a href="https://www.youtube.com/" title="youtube" target="_blank">
                            <img src="{{ asset('images/youtube-lh.png') }}" alt="">
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="contact-office key-bg-section" style="background-image: url(images/bg-contact-1.jpg);">
            <div class="child-container">
                <div class="row">
                    <div class="col-lg-5 col-12">
                        <div class="titlebox">
                            <h3 class="fw-semibold">
                                Địa chỉ TruongDung Pet
                            </h3>
                            <span class="desc">Boss tìm đến TruongDung Pet tại:</span>
                        </div>
                        <div class="office-list">
                            <div class="office-item">
                                <a href="https://maps.app.goo.gl/8fMMhXLXcaRHkus59" target="_blank">
                                    <div class="office-name">
                                        Chi nhánh 1: H2-26 Đường Bùi Quang Trinh, KDC 586, Phường Phú Thứ, Quận
                                        Cái
                                        Răng, Thành Phố Cần Thơ
                                    </div>
                                </a>
                                <a href="tel:0344333586">
                                    <div class="office-hotline">
                                        Hotline: 0344 333 586
                                    </div>
                                </a>
                            </div>
                            <div class="office-item">
                                <a href="https://maps.app.goo.gl/VKhg6DCfkeNtSEJr9" target="_blank">
                                    <div class="office-name">
                                        Chi nhánh 2: 97B, Đường Trần Hoàng Na, Phương An Bình, Quận Ninh Kiều, Thành Phố Cần Thơ
                                    </div>
                                </a>
                                <a href="tel:0344333586">
                                    <div class="office-hotline">
                                        Hotline: 0344 333 586
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7 col-12">
                        <div class="map-embed">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3929.176348939073!2d105.8017884747937!3d10.002287690103255!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31a063c9138bf7ad%3A0xe9a00495b9c03576!2zVHJ1b25nRHVuZyBQZXQgLSBE4buLY2ggVuG7pSBUaMO6IFkgQ-G6p24gVGjGoQ!5e0!3m2!1svi!2s!4v1709980142012!5m2!1svi!2s" style="border:0; border-radius: 10px;"
                                width="600" height="450" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="contact-forms">
            <div class="child-container">
                <div class="title-form">
                    Hoặc qua form liên hệ
                </div>
                <form id="form_site_contact">
                    @csrf
                    <div class="group">
                        <span class="titl">
                            Họ và tên
                        </span>
                        <div class="field">
                            <input class="reverse" id="contact_name" name="contact_name" type="text" value="" placeholder="Nhập họ tên của bạn">
                        </div>
                        <div class="invalid-feedback" id="contact_name_contact_page">
                        </div>
                    </div>
                    <div class="group">
                        <span class="titl">
                            Email
                        </span>
                        <div class="field">
                            <input class="reverse" id="contact_email" name="contact_email" type="text" value="" placeholder="you@company.com">
                        </div>
                        <div class="invalid-feedback" id="contact_email_contact_page">
                        </div>
                    </div>
                    <div class="group">
                        <span class="titl">
                            Điện thoại
                        </span>
                        <div class="field">
                            <input class="reverse" id="contact_phone" name="contact_phone" type="number" value="" placeholder="+84 000 000 000">
                        </div>
                        <div class="invalid-feedback" id="contact_phone_contact_page">
                        </div>
                    </div>
                    <div class="group">
                        <span class="titl">
                            Lời nhắn
                        </span>
                        <div class="field">
                            <textarea class="reverse" id="contact_content" name="contact_content" placeholder=""></textarea>
                        </div>
                        <div class="invalid-feedback" id="contact_content_contact_page">
                        </div>
                    </div>
                    <div class="agree-privacy">
                        <label for="cbx">
                            <input id="cbx" name="rules" type="checkbox">
                            <span> Tôi đồng ý với các Điều khoản và dịch vụ.</span>
                        </label>
                    </div>
                    <button class="submit btn--submit__form-contact" id="btn_submit_contact" type="button">
                        Gửi
                    </button>
                    <button class="submit btn--submit__form-contact" id="btn_submit_contact_disable" type="button" style="display:none;" disabled="">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 4335 4335" width="20" height="20">
                            <path fill="#fff"
                                d="M3346 1077c41,0 75,34 75,75 0,41 -34,75 -75,75 -41,0 -75,-34 -75,-75 0,-41 34,-75 75,-75zm-1198 -824c193,0 349,156 349,349 0,193 -156,349 -349,349 -193,0 -349,-156 -349,-349 0,-193 156,-349 349,-349zm-1116 546c151,0 274,123 274,274 0,151 -123,274 -274,274 -151,0 -274,-123 -274,-274 0,-151 123,-274 274,-274zm-500 1189c134,0 243,109 243,243 0,134 -109,243 -243,243 -134,0 -243,-109 -243,-243 0,-134 109,-243 243,-243zm500 1223c121,0 218,98 218,218 0,121 -98,218 -218,218 -121,0 -218,-98 -218,-218 0,-121 98,-218 218,-218zm1116 434c110,0 200,89 200,200 0,110 -89,200 -200,200 -110,0 -200,-89 -200,-200 0,-110 89,-200 200,-200zm1145 -434c81,0 147,66 147,147 0,81 -66,147 -147,147 -81,0 -147,-66 -147,-147 0,-81 66,-147 147,-147zm459 -1098c65,0 119,53 119,119 0,65 -53,119 -119,119 -65,0 -119,-53 -119,-119 0,-65 53,-119 119,-119z">
                            </path>
                        </svg> Đang gửi yêu cầu...
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
