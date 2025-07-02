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
                                <h2 class="fs-sm-1 fs-md-3 key-primary">...cho thú cưng hạnh phúc</h2>
                                <p class="text-dark"><strong>Chuỗi dịch vụ thú cưng chuyên nghiệp TRUONGDUNGPET
                                    </strong>
                                </p>
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
        <div class="home-story-wrapper" style="background-image: url({{ asset('images/bg-store.jpg') }});">
            <div class="bg-blur"></div>
            <div class="child-container position-relative overflow-hidden">
                <div class="story-content-wrapper w-675">
                    <div class="story-content-top">
                        <div class="story-content-title text-center">
                            <p class="fw-semibold">
                                CÂU CHUYỆN TRUONGDUNGPET
                            </p>
                            <h4>
                                Mang lại sức khỏe và vẻ đẹp
                                cho thú cưng
                            </h4>
                        </div>

                        <div class="story-content-des text-center">
                            <p>TRUONGDUNGPET là không gian dịch vụ y tế và chăm sóc sức khỏe dành riêng cho thú
                                cưng.
                                Với đội ngũ bác sĩ, kỹ thuật viên chuyên nghiệp, giàu kinh nghiệm cùng các trang
                                thiết bị hiện đại sẽ mang đến
                                sức khỏe và vẻ đẹp chạm vào cảm xúc cho các boss</p>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-10 col-lg-3 col-md-6 text-center text-dark p-2 p-md-3">
                        <a class="story-list-item" href="{{ route('shop') }}" title="Cửa hàng">
                            <div class="d-flex justify-content-center align-items-center rounded-4 p-4 pin-bg h-200">
                                <img class="img-fluid" src="{{ asset('images/dich-vu-thu-y_1.png') }}" alt="Cửa hàng" style="width: 100px; height: auto;">
                            </div>
                            <p class="text-dark fw-semibold mt-3 text-uppercase">Cửa hàng</p>
                        </a>
                    </div>
                    <div class="col-10 col-lg-3 col-md-6 text-center text-dark p-2 p-md-3">
                        <a class="story-list-item" href="{{ route('post', ['sub' => 'spa-&-grooming']) }}" title="SPA & GROOMING">
                            <div class="d-flex justify-content-center align-items-center rounded-4 p-4 blue-bg h-200">
                                <img class="img-fluid" src="{{ asset('images/spa-grooming_1.png') }}" alt="SPA & GROOMING" style="width: 100px; height: auto;">
                            </div>
                            <p class="text-dark fw-semibold mt-3 text-uppercase">SPA & GROOMING</p>
                        </a>

                    </div>
                    <div class="col-10 col-lg-3 col-md-6 text-center text-dark p-2 p-md-3">
                        <a class="story-list-item" href="{{ route('post', ['sub' => 'khach-san-thu-cung']) }}" title="KHÁCH SẠN THÚ CƯNG">
                            <div class="d-flex justify-content-center align-items-center rounded-4 p-4 amber-bg h-200">
                                <img class="img-fluid" src="{{ asset('images/khach-san-thu-cung.png') }}" alt="KHÁCH SẠN THÚ CƯNG" style="width: 100px; height: auto;">
                            </div>
                            <p class="text-dark fw-semibold mt-3 text-uppercase">KHÁCH SẠN THÚ CƯNG</p>
                        </a>

                    </div>
                    <div class="col-10 col-lg-3 col-md-6 text-center text-dark p-2 p-md-3">
                        <a class="story-list-item" href="{{ route('post', ['sub' => 'san-pham']) }}" title="PETSHOP">
                            <div class="d-flex justify-content-center align-items-center rounded-4 p-4 teal-bg h-200">
                                <img class="img-fluid" src="{{ asset('images/petshop_1.png') }}" alt="PETSHOP" style="width: 100px; height: auto;">
                            </div>
                            <p class="text-dark fw-semibold mt-2 text-uppercase">PETSHOP</p>
                        </a>

                    </div>
                </div>
            </div>
        </div><div class="product-showcase-wrapper home-product key-bg-section" style="background-image: url({{ asset('images/bg-contact-1.jpg') }});">
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
        {{-- <div class="home-recipe-wrapper" style="background-image: url({{ asset('images/bg-store-2.jpg') }});"> --}}
        <div class="home-recipe-wrapper" style="background-image: url({{ asset('images/bg-about-3.jpg') }});">
            <div class="child-container">
                <div class="home-recipe-header">
                    <div class="home-recipe-title text-dark">
                        <p>GÓC KIẾN THỨC</p>
                        <h4>
                            chia sẻ bí quyết<br />
                            chăm sóc boss
                        </h4>
                    </div>
                    <a class="recipe-cta" href="{{ route('post', ['sub' => 'posts', 'category' => 'cham-soc-boss']) }}">
                        Xem tất cả
                        <img class="img-fluid" src="{{ asset('images/img/arrow-right.png') }}" alt="">
                    </a>
                </div>

                <div class="recipe-list pc-recipe-list">
                    @for ($i = 0; $i < 4; $i++)
                        <div class="recipe-item-column">
                            @php
                                $category = $categories->where('slug', 'cham-soc-boss')->first();
                            @endphp
                            @if ($category && $category->posts->count())
                                @foreach ($category->posts()->orderBy('created_at', 'DESC')->offset($i * 2)->limit(2)->get() as $post)
                                    <div class="recipe-item recipe-img">
                                        <div class="recipe-image">
                                            <a href="{{ route('post', ['sub' => 'posts', 'category' => $post->category->slug, 'post' => $post->slug]) }}" title="{{ $post->title }}">
                                                <img class="img-fluid" src="{{ $post->getImageUrlAttribute() }}" alt="">
                                            </a>
                                        </div>
                                        <div class="recipe-overlay">
                                            <a href="{{ route('post', ['sub' => 'posts', 'category' => $post->category->slug, 'post' => $post->slug]) }}" title="{{ $post->title }}">
                                                <p class="recipe-cate">{{ $category->name }}</p>
                                                <h5 class="recipe-name">{{ $post->title }}</h5>
                                                <div class="item-cta">
                                                    <svg width="115" height="46" viewBox="0 0 115 46" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M51.4169 43.2545C63.7675 42.9768 77.54 41.9015 91.0627 38.7052C95.2628 37.7127 99.3916 36.531 103.288 34.5695C105.048 33.7082 106.714 32.6709 108.262 31.4736C109.387 30.5555 110.333 29.4401 111.052 28.1828C112.754 25.2287 112.278 22.1978 109.678 20C108.12 18.7111 106.41 17.6159 104.585 16.7387C99.3144 14.2457 93.7843 12.3338 88.094 11.0373C83.3876 9.99211 78.598 9.35946 73.7801 9.14671C73.212 9.17003 72.6441 9.09405 72.1024 8.92221C71.7098 8.74496 71.1803 8.1955 71.2279 7.87646C71.2967 7.62611 71.416 7.39227 71.5786 7.18914C71.7412 6.98601 71.9437 6.81783 72.1738 6.69483C72.6561 6.5438 73.1662 6.50141 73.6671 6.57075C81.4963 6.49395 89.0578 8.04779 96.417 10.5588C100.004 11.8031 103.52 13.2429 106.947 14.8717C108.769 15.7613 110.444 16.9207 111.915 18.3103C115.002 21.1816 115.633 25.0574 113.878 28.8741C112.957 30.8245 111.583 32.5296 109.868 33.8487C106.858 36.2533 103.395 37.7895 99.7902 39.0538C92.8296 41.5057 85.6131 42.9 78.3194 43.928C69.6452 45.1503 60.9026 45.833 52.1427 45.9723C41.6423 46.1377 31.2074 45.606 20.9509 43.2013C16.8568 42.2989 12.925 40.7828 9.29036 38.7052C6.89077 37.3941 4.7855 35.611 3.10316 33.4647C0.426001 29.8725 0.158282 26.0559 2.13343 22.0856C3.28804 19.9022 4.84844 17.9557 6.7322 16.3488C11.5927 11.9472 17.3218 8.99901 23.3901 6.65938C31.3026 3.60486 39.5482 1.93285 47.9485 0.904832C58.6784 -0.317218 69.5147 -0.301356 80.241 0.952099C89.5277 1.97421 98.6836 3.66395 107.471 6.95479C108.595 7.38018 109.678 7.906 110.772 8.40819C111.534 8.76268 112.028 9.31214 111.701 10.1806C111.457 10.8483 110.719 11.0491 109.737 10.6119C104.205 8.1187 98.3207 6.86616 92.425 5.63726C85.5219 4.25612 78.5271 3.37351 71.4956 2.99633C59.0689 2.18653 46.5902 3.24015 34.4795 6.12174C27.9188 7.61991 21.6067 10.039 15.7334 13.3061C12.6539 14.9653 9.84561 17.0789 7.40446 19.5746C6.4881 20.534 5.67463 21.5854 4.97716 22.7118C2.85924 26.2154 3.19241 29.6598 6.03019 32.5667C7.50543 34.0348 9.15565 35.3184 10.9442 36.3892C14.8826 38.7939 19.2732 40.0523 23.7708 40.9681C32.4091 42.7523 41.1366 43.2722 51.4169 43.2545Z"
                                                            fill="white"></path>
                                                    </svg>

                                                    <span>Xem ngay</span>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    @endfor
                </div>

                <div class="recipe-list mb-recipe-list">
                    @for ($i = 0; $i < 2; $i++)
                        <div class="recipe-item-column">
                            @php
                                $category = $categories->where('slug', 'cham-soc-boss')->first();
                            @endphp
                            @if ($category && $category->posts->count())
                                @foreach ($category->posts()->orderBy('created_at', 'DESC')->offset($i * 3)->limit(3)->get() as $post)
                                    <div class="recipe-item recipe-img">
                                        <div class="recipe-image">
                                            <a href="{{ route('post', ['sub' => 'posts', 'category' => $post->category->slug, 'post' => $post->slug]) }}" title="{{ $post->title }}">
                                                <img class="img-fluid" src="{{ $post->getImageUrlAttribute() }}" alt="">
                                            </a>
                                        </div>
                                        <div class="recipe-overlay">
                                            <a href="{{ route('post', ['sub' => 'posts', 'category' => $post->category->slug, 'post' => $post->slug]) }}" title="{{ $post->title }}">
                                                <p class="recipe-cate">{{ $category->name }}</p>
                                                <h5 class="recipe-name">{{ $post->title }}</h5>
                                                <div class="item-cta">
                                                    <svg width="115" height="46" viewBox="0 0 115 46" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M51.4169 43.2545C63.7675 42.9768 77.54 41.9015 91.0627 38.7052C95.2628 37.7127 99.3916 36.531 103.288 34.5695C105.048 33.7082 106.714 32.6709 108.262 31.4736C109.387 30.5555 110.333 29.4401 111.052 28.1828C112.754 25.2287 112.278 22.1978 109.678 20C108.12 18.7111 106.41 17.6159 104.585 16.7387C99.3144 14.2457 93.7843 12.3338 88.094 11.0373C83.3876 9.99211 78.598 9.35946 73.7801 9.14671C73.212 9.17003 72.6441 9.09405 72.1024 8.92221C71.7098 8.74496 71.1803 8.1955 71.2279 7.87646C71.2967 7.62611 71.416 7.39227 71.5786 7.18914C71.7412 6.98601 71.9437 6.81783 72.1738 6.69483C72.6561 6.5438 73.1662 6.50141 73.6671 6.57075C81.4963 6.49395 89.0578 8.04779 96.417 10.5588C100.004 11.8031 103.52 13.2429 106.947 14.8717C108.769 15.7613 110.444 16.9207 111.915 18.3103C115.002 21.1816 115.633 25.0574 113.878 28.8741C112.957 30.8245 111.583 32.5296 109.868 33.8487C106.858 36.2533 103.395 37.7895 99.7902 39.0538C92.8296 41.5057 85.6131 42.9 78.3194 43.928C69.6452 45.1503 60.9026 45.833 52.1427 45.9723C41.6423 46.1377 31.2074 45.606 20.9509 43.2013C16.8568 42.2989 12.925 40.7828 9.29036 38.7052C6.89077 37.3941 4.7855 35.611 3.10316 33.4647C0.426001 29.8725 0.158282 26.0559 2.13343 22.0856C3.28804 19.9022 4.84844 17.9557 6.7322 16.3488C11.5927 11.9472 17.3218 8.99901 23.3901 6.65938C31.3026 3.60486 39.5482 1.93285 47.9485 0.904832C58.6784 -0.317218 69.5147 -0.301356 80.241 0.952099C89.5277 1.97421 98.6836 3.66395 107.471 6.95479C108.595 7.38018 109.678 7.906 110.772 8.40819C111.534 8.76268 112.028 9.31214 111.701 10.1806C111.457 10.8483 110.719 11.0491 109.737 10.6119C104.205 8.1187 98.3207 6.86616 92.425 5.63726C85.5219 4.25612 78.5271 3.37351 71.4956 2.99633C59.0689 2.18653 46.5902 3.24015 34.4795 6.12174C27.9188 7.61991 21.6067 10.039 15.7334 13.3061C12.6539 14.9653 9.84561 17.0789 7.40446 19.5746C6.4881 20.534 5.67463 21.5854 4.97716 22.7118C2.85924 26.2154 3.19241 29.6598 6.03019 32.5667C7.50543 34.0348 9.15565 35.3184 10.9442 36.3892C14.8826 38.7939 19.2732 40.0523 23.7708 40.9681C32.4091 42.7523 41.1366 43.2722 51.4169 43.2545Z"
                                                            fill="white"></path>
                                                    </svg>
                                                    <span>Xem ngay</span>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    @endfor
                </div>
                <div class="mb-show mb-recipe">
                    <a class="recipe-cta" href="{{ route('post', ['sub' => 'posts', 'category' => 'cham-soc-boss']) }}">
                        Xem tất cả
                        <img class="img-fluid" src="{{ asset('images/img/arrow-right.png') }}" alt="">
                    </a>
                </div>

            </div>
        </div>
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
                <a class="cta-btn" href="{{ route('post', ['sub' => 'posts']) }}">
                    Xem tất cả
                </a>
            </div>
        </div>
        <div class="support-wrapper support-fwidth-wrapper" style="background-image: url({{ asset('images/bg-store-3.jpg') }});">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-md-8">
                        <h2 class="text-dark fw-semibold">Bạn có biết?</h2>
                        <p class="text-dark">TruongDung Pet là chuỗi cung ứng đầy đủ các dịch vụ thú y với tầm nhìn
                            trở thành thương hiệu Phòng khám Thú y-Dịch vụ chăm sóc Thú cưng có tâm, có tầm, hiện
                            đại hoá lớn nhất khu vực Cần Thơ và các tỉnh lân cận</p>

                        <a class="cta-btn" href="tel:0344333586">
                            HOTLINE 0344 333 586
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
