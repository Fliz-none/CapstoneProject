@extends('web.layouts.app')
@section('title')
    {{ $pageName }}
@endsection
@section('content')
    <main>
        <div class="master-wrapper">
            <div class="container-fluid px-0">
                <div class="home-banner-wrapper">
                    <div class="swiper">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <div class="home-banner-slide">
                                    <img class="img-fluid" src="{{ asset('images/banner/banner-shop.jpg') }}" alt="Trang chủ" loading="lazy">
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
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
            <div class="news-detail-wrapper">
                <div class="container">
                    <div class="news-detail-head">
                        <p class="news-detail-cate">
                            <a href="{{ route('post', ['sub' => 'posts', 'category' => $post->category->slug]) }}">{{ $post->category->name }}</a>
                        </p>
                        <h3 class="news-detail-title">
                            {{ $pageName }}
                        </h3>
                        <div class="news-detail-head-bot">
                            <p class="date">
                                {{ \Carbon\Carbon::parse($post->created_at)->format('d/m/Y') }}
                            </p>

                            <a class="btn-sharing" href="javascript:;" onclick="copyLink()"><svg width="18" height="20" viewBox="0 0 18 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M13.9993 2.50001C13.0789 2.50001 12.3327 3.2462 12.3327 4.16668C12.3327 4.4561 12.4065 4.72829 12.5362 4.96547C12.5447 4.97834 12.5529 4.99151 12.5608 5.00499C12.5686 5.01836 12.576 5.03187 12.5829 5.04549C12.877 5.51847 13.4014 5.83334 13.9993 5.83334C14.9198 5.83334 15.666 5.08715 15.666 4.16668C15.666 3.2462 14.9198 2.50001 13.9993 2.50001ZM11.6311 6.51239C12.2352 7.12225 13.0731 7.50001 13.9993 7.50001C15.8403 7.50001 17.3327 6.00763 17.3327 4.16668C17.3327 2.32573 15.8403 0.833344 13.9993 0.833344C12.1584 0.833344 10.666 2.32573 10.666 4.16668C10.666 4.48086 10.7095 4.78489 10.7907 5.07308L6.36763 7.6543C5.76355 7.04444 4.92556 6.66668 3.99935 6.66668C2.1584 6.66668 0.666016 8.15906 0.666016 10C0.666016 11.841 2.1584 13.3333 3.99935 13.3333C4.92574 13.3333 5.76386 12.9554 6.36797 12.3454L10.7918 14.9232C10.7099 15.2125 10.666 15.5178 10.666 15.8333C10.666 17.6743 12.1584 19.1667 13.9993 19.1667C15.8403 19.1667 17.3327 17.6743 17.3327 15.8333C17.3327 13.9924 15.8403 12.5 13.9993 12.5C13.0745 12.5 12.2377 12.8766 11.6338 13.4849L7.2081 10.9059C7.28926 10.6179 7.33268 10.314 7.33268 10C7.33268 9.68583 7.28922 9.3818 7.20797 9.09361L11.6311 6.51239ZM5.41576 9.1212C5.42275 9.13482 5.43014 9.14832 5.43794 9.1617C5.44581 9.17517 5.45399 9.18835 5.46248 9.20121C5.59224 9.4384 5.66602 9.71059 5.66602 10C5.66602 10.2894 5.59225 10.5616 5.46248 10.7988C5.4539 10.8118 5.44562 10.8251 5.43768 10.8388C5.42997 10.852 5.42267 10.8654 5.41577 10.8788C5.12168 11.3518 4.59729 11.6667 3.99935 11.6667C3.07887 11.6667 2.33268 10.9205 2.33268 10C2.33268 9.07953 3.07887 8.33334 3.99935 8.33334C4.59729 8.33334 5.12168 8.64822 5.41576 9.1212ZM12.5121 15.0804C12.5326 15.0533 12.5518 15.0247 12.5694 14.9946C12.5862 14.9657 12.6011 14.9362 12.6141 14.9063C12.9132 14.4603 13.422 14.1667 13.9993 14.1667C14.9198 14.1667 15.666 14.9129 15.666 15.8333C15.666 16.7538 14.9198 17.5 13.9993 17.5C13.0789 17.5 12.3327 16.7538 12.3327 15.8333C12.3327 15.5624 12.3973 15.3065 12.5121 15.0804Z"
                                        fill="#C19A5F"></path>
                                </svg>
                                Chia sẻ
                            </a>
                        </div>
                    </div>

                    <div class="news-detail-main">
                        {!! $post->content !!}
                    </div>

                    <div class="news-detail-share">
                        <p>
                            Nếu bạn thấy thông tin này hữu ích
                        </p>

                        <a class="btn-sharing" href="javascript:;" onclick="copyLink()">
                            <svg width="18" height="20" viewBox="0 0 18 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M13.9993 2.50001C13.0789 2.50001 12.3327 3.2462 12.3327 4.16668C12.3327 4.4561 12.4065 4.72829 12.5362 4.96547C12.5447 4.97834 12.5529 4.99151 12.5608 5.00499C12.5686 5.01836 12.576 5.03187 12.5829 5.04549C12.877 5.51847 13.4014 5.83334 13.9993 5.83334C14.9198 5.83334 15.666 5.08715 15.666 4.16668C15.666 3.2462 14.9198 2.50001 13.9993 2.50001ZM11.6311 6.51239C12.2352 7.12225 13.0731 7.50001 13.9993 7.50001C15.8403 7.50001 17.3327 6.00763 17.3327 4.16668C17.3327 2.32573 15.8403 0.833344 13.9993 0.833344C12.1584 0.833344 10.666 2.32573 10.666 4.16668C10.666 4.48086 10.7095 4.78489 10.7907 5.07308L6.36763 7.6543C5.76355 7.04444 4.92556 6.66668 3.99935 6.66668C2.1584 6.66668 0.666016 8.15906 0.666016 10C0.666016 11.841 2.1584 13.3333 3.99935 13.3333C4.92574 13.3333 5.76386 12.9554 6.36797 12.3454L10.7918 14.9232C10.7099 15.2125 10.666 15.5178 10.666 15.8333C10.666 17.6743 12.1584 19.1667 13.9993 19.1667C15.8403 19.1667 17.3327 17.6743 17.3327 15.8333C17.3327 13.9924 15.8403 12.5 13.9993 12.5C13.0745 12.5 12.2377 12.8766 11.6338 13.4849L7.2081 10.9059C7.28926 10.6179 7.33268 10.314 7.33268 10C7.33268 9.68583 7.28922 9.3818 7.20797 9.09361L11.6311 6.51239ZM5.41576 9.1212C5.42275 9.13482 5.43014 9.14832 5.43794 9.1617C5.44581 9.17517 5.45399 9.18835 5.46248 9.20121C5.59224 9.4384 5.66602 9.71059 5.66602 10C5.66602 10.2894 5.59225 10.5616 5.46248 10.7988C5.4539 10.8118 5.44562 10.8251 5.43768 10.8388C5.42997 10.852 5.42267 10.8654 5.41577 10.8788C5.12168 11.3518 4.59729 11.6667 3.99935 11.6667C3.07887 11.6667 2.33268 10.9205 2.33268 10C2.33268 9.07953 3.07887 8.33334 3.99935 8.33334C4.59729 8.33334 5.12168 8.64822 5.41576 9.1212ZM12.5121 15.0804C12.5326 15.0533 12.5518 15.0247 12.5694 14.9946C12.5862 14.9657 12.6011 14.9362 12.6141 14.9063C12.9132 14.4603 13.422 14.1667 13.9993 14.1667C14.9198 14.1667 15.666 14.9129 15.666 15.8333C15.666 16.7538 14.9198 17.5 13.9993 17.5C13.0789 17.5 12.3327 16.7538 12.3327 15.8333C12.3327 15.5624 12.3973 15.3065 12.5121 15.0804Z"
                                    fill="#C19A5F"></path>
                            </svg>

                            Chia sẻ ngay
                        </a>
                    </div>
                </div>

                <div class="news-relative-wrapper">
                    <div class="container">
                        <div class="news-relative-head">
                            <p class="news-relative-title">
                                Bạn có thể quan tâm
                            </p>
                            <div class="custom-slide-nav">
                                <div class="swiper-button-prev">
                                    <svg width="48" height="30" viewBox="0 0 48 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="15" cy="15" r="14.5" transform="rotate(180 15 15)" stroke="#333333" />
                                        <path d="M48 15.5L12.5 15.5M12.5 15.5L15.5 19M12.5 15.5L15.5 12" stroke="#333333" />
                                    </svg>
                                </div>
                                <div class="swiper-button-next">
                                    <svg width="48" height="30" viewBox="0 0 48 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="33" cy="15" r="14.5" stroke="#333333" />
                                        <path d="M0 15.5H35.5M35.5 15.5L32.5 12M35.5 15.5L32.5 19" stroke="#333333" />
                                    </svg>
                                </div>
                            </div>       
                        </div>
                    </div>
                    <div class="news-slider outside-container-left">
                        <div class="swiper">
                            <div class="swiper-wrapper">
                                @foreach ($relatedPosts->take(12) as $post)
                                    <div class="swiper-slide">
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
