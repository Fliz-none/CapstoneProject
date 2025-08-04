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
                    <h3 class="fw-semibold text-dark" >
                      {{__('lang_web.cart.cart')}}
                    </h3>
                    <span> {{__('lang_web.cart.your_cart')}} </span>
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
                        <p>{{__('lang_web.cart.no_cart')}}</p>
                        <a href="index.html" class="cta-btn btn-save-modal">
                            <span class="">Trở lại trang chủ</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
