<div class="footer">
    <div class="container">
        <div class="footer-logo">
            <a href="{{ url('/') }}" title="PHÒNG KHÁM THÚ Y TRUONGDUNG">
                <img class="img-fluid" src="{{ asset('images/logo-footer.svg') }}" alt="PHÒNG KHÁM THÚ Y TRUONGDUNG">
            </a>
        </div>
        <div class="footer-content">
            <div class="row">
                <div class="col-xl-7 col-lg-7 col-12 text-white">
                    <div class="company-short-Info">
                        <h5 class="company-name">
                            PHÒNG KHÁM THÚ Y TRUONGDUNG
                        </h5>
                        <p class="company-des">
                            Chào mừng bạn đến với Phòng khám thú y TruongDung Pet - nơi chúng tôi cam kết mang
                            lại dịch vụ chăm sóc y tế tốt nhất cho thú cưng của bạn. Tại TruongDung Pet, chúng
                            tôi hiểu rõ tình cảm và tình yêu mà bạn dành cho thành viên bốn chân của gia đình,
                            và chúng tôi cam kết đem đến sự chăm sóc tận tâm và chuyên nghiệp nhất.
                        </p>
                    </div>
                    <div class="footer-menu mx-0">
                        <div class="footer-menu-item f-width">
                            <h5 class="fw-semibold">LIÊN HỆ</h5>

                            <ul class="menu-list ic-list">
                                <li>
                                    <img class="img-fluid" src="{{ asset('images/img/map-pin.png') }}" alt="">
                                    <p>
                                        H2-26 Bùi Quang Trinh, KDC 586, Phú Thứ Cái Răng, Cần Thơ
                                    </p>
                                </li>
                                <li>
                                    <img class="img-fluid" src="{{ asset('images/img/mail.png') }}" alt="">
                                    <a href="mailto:truongthithuydung98@gmail.com" title="">
                                        Email: truongthithuydung98@gmail.com
                                    </a>
                                </li>
                                <li class="align-items-start">
                                    <img class="img-fluid" src="{{ asset('images/img/phone.png') }}" alt="">
                                    <p>
                                        <span>Điện thoại: 0344 333 586</span>
                                    </p>
                                </li>
                                <li class="align-items-start">
                                    <img class="img-fluid" src="{{ asset('images/img/truso.png') }}" alt="">
                                    <p>
                                        <span>1801xxxxxx
                                            do sở KH-ĐT TP. Cần Thơ cấp ngày 19/01/2024</span>
                                    </p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-5 col-lg-5 col-12">
                    <div class="footer-menu">
                        <div class="footer-menu-item">
                            <h5 class="menu-item-name">DỊCH VỤ</h5>
                            <ul class="menu-list">
                                <li>
                                    <a href="#" title=" Khám chữa bệnh">
                                        Khám chữa bệnh
                                    </a>
                                <li>
                                    <a href="#" title=" Tiêm ngừa">
                                        Tiêm ngừa
                                    </a>
                                <li>
                                    <a href="#" title=" Hộ sản">
                                        Hộ sản
                                    </a>
                                <li>
                                    <a href="#" title=" Triệt sản">
                                        Triệt sản
                                    </a>
                                <li>
                                    <a href="#" title=" Spa & Grooming">
                                        Spa & Grooming
                                    </a>
                                <li>
                                    <a href="#" title=" Khách sạn thú cưng">
                                        Khách sạn thú cưng
                                    </a>
                            </ul>
                            <h5 class="menu-item-name mt-4">LIÊN KẾT</h5>
                            <div class="key-follow">
                                <div class="social-overlap process-scetion">
                                    <div class="social-icons mb-3 iconpad text-center">
                                        <a class="slider-nav-item color-facebook" href="#" target="_blank" rel="noopener"> <i class="facebook-icon"></i><br />
                                        </a><br />
                                        <a class="slider-nav-item color-messenger" href="#" target="_blank" rel="noopener"><i class="messenger-icon"></i><br />
                                        </a><br />
                                        <a class="slider-nav-item color-youtube" href="#" target="_blank" rel="noopener"><i class="youtube-icon"></i><br />
                                        </a><br />
                                        <a class="slider-nav-item color-zalo" href="#" target="_blank" rel="noopener"><i class="zalo-icon"></i><br />
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="footer-menu-item">
                            <h5 class="menu-item-name">DANH MỤC</h5>
                            <ul class="menu-list">
                                <li>
                                    <a href="{{ route('home') }}" title=" Trang chủ">
                                        Trang chủ
                                    </a>
                                <li>
                                    <a href="{{ route('post', ['sub' => 've-truongdung-pet']) }}" title=" Giới thiệu">
                                        Giới thiệu
                                    </a>
                                <li>
                                <li>
                                    <a href="{{ route('shop') }}" title=" Giới thiệu">
                                        PetShop
                                    </a>
                                <li>
                                    <a href="{{ route('post', ['sub' => 'posts', 'category' => 'cham-soc-boss']) }}" title=" Chăm sóc boss">
                                        Chăm sóc boss
                                    </a>
                                <li>
                                    <a href="{{ route('post', ['sub' => 'posts']) }}" title=" Tin tức truyền thông">
                                        Tin tức truyền thông
                                    </a>
                                <li>
                                    <a href="{{ route('post', ['sub' => 've-truongdung-pet']) }}" title=" Liên hệ">
                                        Liên hệ
                                    </a>
                            </ul>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="footer-credit text-center">
            <p>
                © 2022 TruongDung Pet. All rights reserved.
            </p>
        </div>
        <div class="fixed-ele">
            <a class="hotline-btn" href="tel:0344333586" title="">
                <img class="img-fluid" src="{{ asset('images/img/hotline-btn.png') }}" alt="">
            </a>
            <a class="backtop-btn" id="backTop" href="#" title="">
                <img src="{{ asset('images/img/backtotop.png') }}" alt="">
            </a>
        </div>
    </div>
</div>
