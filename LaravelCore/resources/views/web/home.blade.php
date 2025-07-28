@extends('web.layouts.app')
@section('title')
    {{ $pageName }}
@endsection
@php
    $settings = cache()->get('settings');
@endphp
@section('content')
    <div class="master-wrapper">
        <div class="container-fluid px-0">
            <div class="home-banner-wrapper">
                <div class="swiper">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="home-banner-slide">
                                <img class="img-fluid" src="{{ asset(env('FILE_STORAGE', '/storage/') . '/'. $settings['banner_home_1']) }}" alt="Trang chủ" loading="lazy">
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="home-banner-slide">
                                <img class="img-fluid" src="{{ asset(env('FILE_STORAGE', '/storage/') . '/'. $settings['banner_home_2']) }}" alt="Trang chủ" loading="lazy">
                            </div>
                        </div>
                    </div>
                    <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
        <div class="home-story-wrapper">
            <div class="child-container position-relative overflow-hidden">
                <div class="story-content-wrapper w-250">
                    <div class="story-content-top">
                        <div class="story-content-title text-center">
                            <p class="fw-semibold">
                                CÂU CHUYỆN {{ $settings['company_name'] }}
                            </p>
                            <h4>
                                {{ $settings['company_slogan'] }}
                            </h4>
                        </div>

                        <div class="story-content-des text-center">
                            <p>{{ $settings['company_introduce'] }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div><div class="product-showcase-wrapper home-product key-bg-section" style="background-image: url({{ asset(env('FILE_STORAGE', '/storage/') . '/bg-contact-1.jpg') }})">
            <div class="container">
                <div class="p-4 text-center">
                    <h2 class="text-dark fw-semibold fs-1 mb-3">Các sản phẩm của {{ $settings['company_name'] }}</h2>
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
                                <p class="product-des">
                                    {{ $settings['company_name'] }} <br />
                                    Cung cấp những sản phẩm chất lượng và mang lại cho khách hàng sự hài lòng và yên tâm.
                                </p>
                                <a class="cta-btn bg-warning" href="{{ route('product') }}">
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
        {{-- <div class="home-recipe-wrapper" style="background-image: url({{ asset('images/bg-store-2.jpg') }});"> --}}
        <div class="home-news-wrapper">
            <div class="child-container">
                <div class="home-news-head">
                    <div class="home-news-title">
                        <p class="fw-semibold">
                            TRUYỀN THÔNG
                        </p>
                        <h4>
                            Tin tức - Sự kiện
                        </h4>
                    </div>

                </div>
            </div>
            @foreach ($categories as $category)
                @if ($category->name == 'Tin tức')
                    <div class="news-slider">
                        <div class="child-container">
                            <div class="swiper ">
                                <div class="swiper-wrapper">
                                    @foreach ($category->posts->take(12) as $post)
                                        <div class="swiper-slide ">
                                            <div class="news-slide-item">
                                                <div class="news-slide-image">
                                                    <a href="{{ route('post', ['sub' => 'posts', 'category' => $post->category->slug, 'post' => $post->slug]) }}" title="{{ $post->title }}">
                                                        <img class="img-fluid" src="{{ $post->getImageUrlAttribute() }}" alt="{{ $post->title }}">
                                                    </a>
                                                </div>
                                                <div class="news-slide-content">
                                                    <a class="news-title" href="{{ route('post', ['sub' => 'posts', 'category' => $post->category->slug, 'post' => $post->slug]) }}" title="{{ $post->title }}">
                                                        {{ $post->title }}
                                                    </a>
                                                    <p class="news-des">
                                                        {!! $post->excerpt ? Illuminate\Support\Str::limit(strip_tags($post->excerpt), 60) : Illuminate\Support\Str::limit(strip_tags($post->content), 60) !!}
                                                    </p>
                                                    <p class="date">
                                                        {{ \Carbon\Carbon::parse($post->created_at)->format('d/m/Y') }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span><span
                                    class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
                            </div>
                            <div class="custom-slide-nav">
                                <div class="swiper-button-prev swiper-button-disabled" role="button" aria-label="Previous slide" aria-controls="swiper-wrapper-da1010f63314d107d10d" aria-disabled="true" tabindex="-1">
                                    <svg width="48" height="30" viewBox="0 0 48 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="15" cy="15" r="14.5" transform="rotate(180 15 15)" stroke="#333333">
                                        </circle>
                                        <path d="M48 15.5L12.5 15.5M12.5 15.5L15.5 19M12.5 15.5L15.5 12" stroke="#333333">
                                        </path>
                                    </svg>
                                </div>
                                <div class="swiper-button-next" role="button" aria-label="Next slide" aria-controls="swiper-wrapper-da1010f63314d107d10d" aria-disabled="false" tabindex="0">
                                    <svg width="48" height="30" viewBox="0 0 48 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="33" cy="15" r="14.5" stroke="#333333"></circle>
                                        <path d="M0 15.5H35.5M35.5 15.5L32.5 12M35.5 15.5L32.5 19" stroke="#333333"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
            <div class="news-cta text-center">
                <a class="cta-btn  bg-warning" href="{{ route('post', ['sub' => 'posts']) }}">
                    Xem tất cả
                </a>
            </div>
        </div>
    </div>
@endsection
