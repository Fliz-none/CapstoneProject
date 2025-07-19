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
                        Thank you
                    </h3>
                    <span> Thanks for your order </span>
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
                        <p class="text-start">We have received your order.<br>
                        You will receive an email in 5 minutes.<br>
                        For any inquiries about your order, please contact us:<br>
                        <strong>Hotline:</strong> {{ $config['company_hotline'] }}<br>
                        <strong>Email:</strong> {{ $config['company_email'] }}<br>
                        {!! isset($order_code) ? '<strong>Order Code:</strong> ' . $order_code : '' !!}
                        </p>
                        <a href="{{ route('home') }}" class="cta-btn btn-save-modal">
                            <span class="">Trang chủ</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
