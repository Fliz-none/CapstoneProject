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
                                <img class="img-fluid" src="{{ asset(env('FILE_STORAGE', '/storage/') . '/' . $settings['banner_store_1']) }}" alt="Trang chủ" loading="lazy">
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="home-banner-slide">
                                <img class="img-fluid" src="{{ asset(env('FILE_STORAGE', '/storage/') . '/' . $settings['banner_store_2']) }}" alt="Trang chủ" loading="lazy">
                            </div>
                        </div>
                    </div>
                    <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
        <div class="product-list-wrapper key-section" id="product-list-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col col-md-3 p-3 d-none d-lg-block">
                        <div class="widget-left sticky-top" id="widget-sidebar">
                            <!-- widget search -->
                            <div class="widget-pet search cbcl-filterform">
                                <div class="widget-header">
                                    <h5 class="mb-0">{{ __('lang_web.shop.search_product') }}</h5>
                                </div>
                                <div class="widget-body filter-input-field">
                                    <div class="input-box">
                                        <img src="{{ asset('images/ic-input-search.svg') }}" alt="">
                                        <input name="search" type="text" value="{{ request('search') }}" placeholder="{{ __('lang_web.shop.search') }}">
                                    </div>
                                </div>
                            </div>
                            <!-- widget catalogue -->
                            <div class="widget-pet search cbcl-filterform">
                                <div class="widget-header">
                                    <h5 class="mb-0">{{ __('lang_web.shop.category_product') }}</h5>
                                </div>
                                <div class="widget-body filter-input-field">
                                    <ul class="list-group overflow-auto" style="max-height: 75vh">
                                        <li class="list-group-item border-0 pb-0" id="catalogue-group-0">
                                            <input class="catalogue-radio" id="catalogue-0" name="catalogue_slug" type="radio" value="flash_sale" {{ request('catalogue_slug') == 'flash_sale' ? 'checked' : '' }}>
                                            <label class="catalogue-label d-flex align-items-center" for="catalogue-0">
                                                <img class="w-25 me-2" src="{{ asset('images/cata_flash_sale.png') }}" alt="Sản phẩm khuyến mãi">
                                                Khuyến mãi
                                            </label>
                                        </li>
                                        @include('web.includes.catalogue_recursion', [
                                            'catalogues' => $catalogues,
                                            'product' => isset($product) ? $product : null,
                                        ])
                                    </ul>
                                </div>
                            </div>
                            <!-- widget Best Selling -->
                        </div>
                    </div>

                    <div class="col-12 col-lg-9">
                        <div class="cbcl-filterform w-100" style="max-width: 100%">
                            <div class="d-flex justify-content-between align-items-center filter-input-field">
                                <div class="d-block d-lg-none">
                                    <button class="btn btn-short-mb" data-bs-toggle="offcanvas" data-bs-target="#widget-sidebar" type="button" aria-controls="widget-sidebar"><i class="bi bi-sliders fs-5"></i></button>
                                </div>
                                <div class="products-count">{{ __('lang_web.shop.from') }} {{ $products->firstItem() }} {{ __('lang_web.shop.to') }}
                                    {{ $products->lastItem() }} {{ __('lang_web.shop.in') }} {{ $products->total() }} {{ __('lang_web.shop.product') }}</div>
                                <div class="select-box">
                                    <select class="form-select" name="order">
                                        <option value="default" selected disabled hidden>{{ __('lang_web.shop.sort_by') }}</option>
                                        <option value="default" {{ request('order') === 'default' ? 'selected' : '' }}>{{ __('lang_web.shop.default') }}</option>
                                        <option value="created_at-asc" {{ request('order') === 'created_at-asc' ? 'selected' : '' }}>{{ __('lang_web.shop.oldest') }}</option>
                                        <option value="created_at-desc" {{ request('order') === 'created_at-desc' ? 'selected' : '' }}>{{ __('lang_web.shop.newest') }}</option>
                                        <option value="name-asc" {{ request('order') === 'name-asc' ? 'selected' : '' }}>{{ __('lang_web.shop.a_z') }} </option>
                                        <option value="name-desc" {{ request('order') === 'name-desc' ? 'selected' : '' }}>{{ __('lang_web.shop.z_a') }}</option>
                                        <option value="price-asc" {{ request('order') === 'price-asc' ? 'selected' : '' }}>Giá tăng dần</option>
                                        <option value="price-desc" {{ request('order') === 'price-desc' ? 'selected' : '' }}>Giá giảm dần</option>
                                    </select>
                                    <span class="svg-ic">
                                        <svg width="12" height="8" viewBox="0 0 12 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1 1.5L6 6.5L11 1.5" stroke="#828282" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="row product-list mb-5 " id="products" >
                            @if ($products->isNotEmpty())
                                @foreach ($products as $product)
                                    <!-- Product item -->
                                    <div class="col-12 col-md-6 col-lg-4 mb-3">
                                        <div class="product-item product-item-row h-100">
                                            <div class="product-image">
                                                <a href="{{ route('product', ['catalogue' => $product->catalogues->first()->slug, 'slug' => $product->slug]) }}" title="{{ $product->name }}">
                                                    <img class="img-fluid" src="{{ $product->avatarUrl }}">
                                                </a>
                                            </div>
                                            <div class="product-content text-start">
                                                <a class="product-name" href="{{ route('product', ['catalogue' => $product->catalogues->first()->slug, 'slug' => $product->slug]) }}" title="{{ $product->name }}">
                                                    {{ $product->name }}
                                                </a>
                                                <p class="short">{{ __('lang_web.shop.variant') }}:
                                                    {{ $product->variables->pluck('name')->take(3)->implode(', ') }}{{ $product->variables->count() > 3 ? '...' : '' }}
                                                </p>
                                                <p class="price">{{ __('lang_web.shop.price') }}: <span>{!! $product->displayPrice() !!}</span></p>
                                                <p>
                                                    {{ __('lang_web.shop.quantity_sold') }}: {{ number_format($product->quantitySold) }}
                                                </p>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    @php
                                                        $rating = $product->star ?? 0;
                                                        $fullStars = floor($rating);
                                                        $halfStar = $rating - $fullStars >= 0.25 && $rating - $fullStars < 0.75;
                                                        $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
                                                    @endphp

                                                    <div class="product-ratting">
                                                        @if ($rating)
                                                            <ul class="d-flex" style="gap: 3px; padding-left: 0; margin: 0; list-style: none;">
                                                                @for ($i = 0; $i < $fullStars; $i++)
                                                                    <li><i class="bi bi-star-fill text-warning"></i></li>
                                                                @endfor

                                                                @if ($halfStar)
                                                                    <li><i class="bi bi-star-half text-warning"></i></li>
                                                                @endif

                                                                @for ($i = 0; $i < $emptyStars; $i++)
                                                                    <li><i class="bi bi-star text-warning"></i></li>
                                                                @endfor
                                                            </ul>
                                                        @else
                                                            <small>Chưa có đánh giá nào</small>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end product -->
                                @endforeach
                            @else
                                <p>{{ __('Sản phẩm đang được cập nhật!') }}</p>
                            @endif
                        </div>
                        @if ($products->count() > 0 && $products->lastPage() > 1)
                            <nav class="daesang-paginate d-flex align-items-center justify-content-center">
                                <!-- Trang trước -->
                                @if ($products->onFirstPage())
                                    <a class="nav-svg disabled" href="#">
                                        <svg width="10" height="16" viewBox="0 0 10 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M8.76758 0.333194C9.21184 0.777454 9.21184 1.49774 8.76758 1.942L2.7464 7.96318L8.76758 13.9844C9.21184 14.4286 9.21184 15.1489 8.76758 15.5932C8.32332 16.0374 7.60303 16.0374 7.15878 15.5932L0.333194 8.76758C-0.111065 8.32332 -0.111065 7.60303 0.333194 7.15878L7.15878 0.333194C7.60303 -0.111065 8.32332 -0.111065 8.76758 0.333194Z"
                                                fill="#3F3E3F"></path>
                                        </svg>
                                    </a>
                                @else
                                    <a class="nav-svg" href="{{ $products->previousPageUrl() }}">
                                        <svg width="10" height="16" viewBox="0 0 10 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M8.76758 0.333194C9.21184 0.777454 9.21184 1.49774 8.76758 1.942L2.7464 7.96318L8.76758 13.9844C9.21184 14.4286 9.21184 15.1489 8.76758 15.5932C8.32332 16.0374 7.60303 16.0374 7.15878 15.5932L0.333194 8.76758C-0.111065 8.32332 -0.111065 7.60303 0.333194 7.15878L7.15878 0.333194C7.60303 -0.111065 8.32332 -0.111065 8.76758 0.333194Z"
                                                fill="#3F3E3F"></path>
                                        </svg>
                                    </a>
                                @endif

                                @php
                                    $totalPages = $products->lastPage();
                                    $currentPage = $products->currentPage();
                                    $startPage = max(1, $currentPage - 2);
                                    $endPage = min($totalPages, $currentPage + 2);
                                @endphp

                                <!-- Hiển thị trang đầu tiên và dấu "..." nếu cần -->
                                @if ($startPage > 1)
                                    <a href="{{ $products->url(1) }}">1</a>
                                    @if ($startPage > 2)
                                        <a class="disabled" href="#">...</a>
                                    @endif
                                @endif

                                <!-- Hiển thị các trang giữa -->
                                @for ($page = $startPage; $page <= $endPage; $page++)
                                    @if ($page == $currentPage)
                                        <a class="active" href="#">{{ $page }}</a>
                                    @else
                                        <a href="{{ $products->url($page) }}">{{ $page }}</a>
                                    @endif
                                @endfor

                                <!-- Hiển thị dấu "..." và trang cuối cùng nếu cần -->
                                @if ($endPage < $totalPages)
                                    @if ($endPage < $totalPages - 1)
                                        <a class="disabled" href="#">...</a>
                                    @endif
                                    <a href="{{ $products->url($totalPages) }}">{{ $totalPages }}</a>
                                @endif

                                <!-- Trang tiếp theo -->
                                @if ($products->hasMorePages())
                                    <a class="nav-svg" href="{{ $products->nextPageUrl() }}">
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
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $(document).on('click', '.catalogue-radio', function(e) {
                let $this = $(this);
                // Nếu radio đang được checked => cho phép bỏ chọn
                if ($this.prop('checked') && $this.data('waschecked')) {
                    $this.prop('checked', false);
                    $this.data('waschecked', false);

                    let url = new URL(window.location.href);
                    url.searchParams.delete('catalogue_slug');
                    url.searchParams.delete('page');
                    url.hash = 'product-list-wrapper';
                    window.location.href = url.toString();

                    e.stopPropagation(); // Ngăn browser tự reset lại checked
                } else {
                    // Lưu trạng thái đã chọn
                    $('.catalogue-radio').data('waschecked', false);
                    $this.data('waschecked', true);

                    let url = new URL(window.location.href);
                    url.searchParams.set('catalogue_slug', $this.val());
                    url.searchParams.delete('page');
                    url.searchParams.delete('search');
                    url.hash = 'product-list-wrapper';
                    window.location.href = url.toString();
                }
            });


            // Search debounce
            let searchTimeout;
            $(document).on('input', 'input[name="search"]', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    let url = new URL(window.location.href);
                    url.searchParams.set('search', $(this).val());
                    url.hash = 'product-list-wrapper';
                    window.location.href = url.toString();
                }, 500);
            });

            // order
            $(document).on('change', 'select[name="order"]', function() {
                let url = new URL(window.location.href);
                url.searchParams.set('order', $(this).val());
                console.log($(this).val());
                console.log(url.toString());

                url.hash = 'product-list-wrapper';
                window.location.href = url.toString();
            });
        });
    </script>
@endpush
