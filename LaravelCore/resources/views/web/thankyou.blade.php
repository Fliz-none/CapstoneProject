@extends('web.layouts.app')
@section('title')
    {{ $pageName }}
@endsection
@section('content')
    <div class="master-wrapper">
        <div class="banner-page-cpn">
            <div class="imagebox">
                <img src="{{ asset('images/banner/lien-he-banner.jpg') }}" alt="Checkout Banner">
            </div>
            <div class="textbox">
                <div class="child-container">
                    <h3 class="">
                        Cảm ơn
                    </h3>
                    <span> Cảm ơn vì đã đặt hàng </span>
                </div>
            </div>
        </div>
        <div class="support-wrapper support-fwidth-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center">
                        <div class="d-flex justify-content-center">
                            <img src="{{ asset('images/checkout-success.png') }}" alt="" class="img-fluid mb-2">
                        </div>
                        <p>Đơn hàng cảm ơn vì đã đặt hàng</p>
                        <a href="{{ route('home') }}" class="cta-btn btn-save-modal">
                            <span class="">Trang chủ</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
