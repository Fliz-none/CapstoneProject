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
                            <i class="bi bi-tag fs-4" aria-hidden="true"></i>
                            <a href="{{ route('post', ['sub' => 'posts', 'category' => $post->category->slug]) }}">{{ $post->category->name }}</a>
                        </p>
                        <h3 class="news-detail-title">
                            {{ $pageName }}
                        </h3>
                        <div class="news-detail-head-bot">
                            <p class="date">
                                <i class="bi bi-calendar3" aria-hidden="true"></i>
                                {{ \Carbon\Carbon::parse($post->created_at)->format('d/m/Y') }}
                            </p>
                        </div>
                    </div>

                    <div class="news-detail-main">
                        {!! $post->content !!}
                    </div>

                    <div class="news-detail-share">
                        <p>
                            Nếu bạn thấy thông tin này hữu ích
                        </p>
                        <div class="justify-content-start gap-2">
                            <a class="btn-sharing" href="javascript:void(0);" onclick="sharePostHandle()" title="Share">
                                <i class="bi bi-share"></i>
                                Chia sẻ ngay
                            </a>
                            <a class="btn-sharing" href="javascript:void(0)" onclick="copyLink()" title="Copy link">
                                <i class="bi bi-link-45deg"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="news-relative-wrapper">
                    <div class="container px-3">
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
                                @forelse ($relatedPosts->take(12) as $post)
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
                                @empty
                                    <p class="text-center">Không có bài viết liên quan</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
@push('scripts')
    <script>
        function sharePostHandle() {
            const url = encodeURIComponent(window.location.href);
            const title = encodeURIComponent(document.title);

            Swal.fire({
                title: 'Chia sẻ bài viết',
                html: `
                    <div class="text-center">
                        <p class="fw-semibold">Chia sẻ bài viết qua
                        <div style="display: flex; justify-content: center; gap: 20px;">
                            <a href="https://www.facebook.com/sharer/sharer.php?u=${url}" target="_blank" title="Facebook">
                                <img src="{{ asset('images/img/fb-ic.png') }}" alt="Facebook" style="width:50px;height:50px;margin-top:2px;">
                            </a>
                            <a href="https://www.instagram.com/" target="_blank" title="Instagram">
                                <img src="{{ asset('images/img/insta-ic.png') }}" alt="Instagram" style="width:50px;height:50px;margin-top:2px;">
                            </a>
                            <a href="https://twitter.com/intent/tweet?url=${url}&text=${title}" target="_blank" title="Twitter">
                                <img src="{{ asset('images/img/tw-ic.png') }}" alt="Twitter" style="width:50px;height:50px;margin-top:2px;">
                            </a>
                            <a href="javascript:void(0);" onclick="copyLink('default','Zalo hiện không hỗ trợ chia sẻ trực tiếp qua website. Vui lòng gửi link qua Zalo thủ công.')" title="Zalo">
                                <img src="{{ asset('images/img/zl-ic.png') }}" alt="Zalo" style="width:50px;height:50px;margin-top:2px;">
                            </a>
                        </div>
                    </div>`,
                showConfirmButton: false,
                showCloseButton: true,
                width: 400
            });
        }

        function copyLink(backgroundColor = `#28a745`, text = "Đã sao chép liên kết bài viết!") {
            const link = window.location.href;
            navigator.clipboard.writeText(link).then(() => {
                Toastify({
                    text: text,
                    duration: 3000,
                    gravity: "top",
                    position: "center",
                    backgroundColor: backgroundColor,
                }).showToast();
            }).catch(() => {
                Toastify({
                    text: "Không thể sao chép liên kết.",
                    duration: 3000,
                    gravity: "top",
                    position: "center",
                    backgroundColor: "--bs-danger",
                }).showToast();
            });
        }

        // Bài viết liên quan
        new Swiper('.news-slider .swiper', {
            slidesPerView: 3,
            spaceBetween: 20,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            breakpoints: {
                1024: {
                    slidesPerView: 3
                },
                768: {
                    slidesPerView: 2
                },
                480: {
                    slidesPerView: 1
                }
            }
        });
    </script>
@endpush
