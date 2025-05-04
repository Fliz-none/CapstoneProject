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
                                    <img class="img-fluid" src="{{ asset('images/banner/spa-banner.jpg') }}" alt="Trang chủ" loading="lazy">
                                </div>
                                <div class="text-box-banner text-center">
                                    <h2>{{ $pageName }}</h2>
                                </div>
                            </div>
                        </div>
                        <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
            <div class="news-list-wrapper">
                <div class="container">
                    <div class="news-list-content d-flex flex-wrap" id="list-news">
                        @foreach ($posts as $post)
                            <div class="news-item">
                                <div class="news-image">
                                    <a href="{{ route('post', ['sub' => 'posts', 'category' => $post->category->slug, 'post' => $post->slug]) }}" title="{{ $post->title }}">
                                        <img class="img-fluid" src="{{ $post->imageUrl }}" alt="{{ $post->title }}">
                                    </a>
                                </div>
                                <div class="news-content">
                                    <a class="news-category d-flex" href="{{ route('post', ['sub' => 'posts', 'category' => $post->category->slug]) }}" title="{{ $post->category->name }}">
                                        <span class="badge text-bg-light">{{ $post->category->name }}</span>
                                    </a>
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
                        @endforeach
                    </div>
                </div>
                @if ($posts->count() > 0 && $posts->lastPage() > 1)
                    <nav class="daesang-paginate d-flex align-items-center justify-content-center">
                        <!-- Trang trước -->
                        @if ($posts->onFirstPage())
                            <a class="nav-svg disabled" href="#">
                                <svg width="10" height="16" viewBox="0 0 10 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M8.76758 0.333194C9.21184 0.777454 9.21184 1.49774 8.76758 1.942L2.7464 7.96318L8.76758 13.9844C9.21184 14.4286 9.21184 15.1489 8.76758 15.5932C8.32332 16.0374 7.60303 16.0374 7.15878 15.5932L0.333194 8.76758C-0.111065 8.32332 -0.111065 7.60303 0.333194 7.15878L7.15878 0.333194C7.60303 -0.111065 8.32332 -0.111065 8.76758 0.333194Z"
                                        fill="#3F3E3F"></path>
                                </svg>
                            </a>
                        @else
                            <a class="nav-svg" href="{{ $posts->previousPageUrl() }}">
                                <svg width="10" height="16" viewBox="0 0 10 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M8.76758 0.333194C9.21184 0.777454 9.21184 1.49774 8.76758 1.942L2.7464 7.96318L8.76758 13.9844C9.21184 14.4286 9.21184 15.1489 8.76758 15.5932C8.32332 16.0374 7.60303 16.0374 7.15878 15.5932L0.333194 8.76758C-0.111065 8.32332 -0.111065 7.60303 0.333194 7.15878L7.15878 0.333194C7.60303 -0.111065 8.32332 -0.111065 8.76758 0.333194Z"
                                        fill="#3F3E3F"></path>
                                </svg>
                            </a>
                        @endif

                        @php
                            $totalPages = $posts->lastPage();
                            $currentPage = $posts->currentPage();
                            $startPage = max(1, $currentPage - 2);
                            $endPage = min($totalPages, $currentPage + 2);
                        @endphp

                        <!-- Hiển thị trang đầu tiên và dấu "..." nếu cần -->
                        @if ($startPage > 1)
                            <a href="{{ $posts->url(1) }}">1</a>
                            @if ($startPage > 2)
                                <a class="disabled" href="#">...</a>
                            @endif
                        @endif

                        <!-- Hiển thị các trang giữa -->
                        @for ($page = $startPage; $page <= $endPage; $page++)
                            @if ($page == $currentPage)
                                <a class="active" href="#">{{ $page }}</a>
                            @else
                                <a href="{{ $posts->url($page) }}">{{ $page }}</a>
                            @endif
                        @endfor

                        <!-- Hiển thị dấu "..." và trang cuối cùng nếu cần -->
                        @if ($endPage < $totalPages)
                            @if ($endPage < $totalPages - 1)
                                <a class="disabled" href="#">...</a>
                            @endif
                            <a href="{{ $posts->url($totalPages) }}">{{ $totalPages }}</a>
                        @endif

                        <!-- Trang tiếp theo -->
                        @if ($posts->hasMorePages())
                            <a class="nav-svg" href="{{ $posts->nextPageUrl() }}">
                                <svg width="10" height="17" viewBox="0 0 10 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M0.762882 0.571476C1.20714 0.127216 1.92743 0.127216 2.37169 0.571476L9.19727 7.39706C9.64153 7.84132 9.64153 8.5616 9.19727 9.00586L2.37169 15.8314C1.92743 16.2757 1.20714 16.2757 0.762882 15.8314C0.318623 15.3872 0.318623 14.6669 0.762882 14.2226L6.78406 8.20146L0.762882 2.18028C0.318623 1.73602 0.318623 1.01573 0.762882 0.571476Z"
                                        fill="#3F3E3F"></path>
                                </svg>
                            </a>
                        @else
                            <a class="nav-svg disabled" href="#">
                                <svg width="10" height="17" viewBox="0 0 10 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M0.762882 0.571476C1.20714 0.127216 1.92743 0.127216 2.37169 0.571476L9.19727 7.39706C9.64153 7.84132 9.64153 8.5616 9.19727 9.00586L2.37169 15.8314C1.92743 16.2757 1.20714 16.2757 0.762882 15.8314C0.318623 15.3872 0.318623 14.6669 0.762882 14.2226L6.78406 8.20146L0.762882 2.18028C0.318623 1.73602 0.318623 1.01573 0.762882 0.571476Z"
                                        fill="#3F3E3F"></path>
                                </svg>
                            </a>
                        @endif
                    </nav>
                @endif
            </div>
        </div>
    </main>
@endsection
