@extends('web.layouts.app')
@section('title')
    {{ $pageName }}
@endsection
@section('content')
    <div class="master-wrapper">
        <div class="banner-page-cpn">
            <div class="imagebox">
                <img src="assets/images/banner/lien-he-banner.jpg" alt="">
            </div>
            <div class="textbox">
                <div class="child-container">
                    <h3>
                        Giỏ hàng
                    </h3>
                    <span> Giỏ hàng của bạn </span>
                </div>
            </div>
        </div>
        <div class="support-wrapper support-fwidth-wrapper">
            <div class="container">

                <div class="row">
                    <div class="col-12 text-center">
                        <div class="d-flex justify-content-center">
                            <img src="assets/images/cart-x.png" alt="" class="img-fluid mb-2">
                        </div>
                        <p>Không có sản phẩm nào trong giỏ hàng</p>
                        <a href="index.html" class="cta-btn btn-save-modal">
                            <span class="">Trở lại trang chủ</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
