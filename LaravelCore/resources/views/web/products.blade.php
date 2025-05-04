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
                                <img class="img-fluid" src="{{ asset('images/banner/banner-shop.jpg') }}" alt="Trang chủ" loading="lazy">
                            </div>
                            {{-- <div class="text-box-banner top text-center">
                                <h2> Dịch vụ TruongDung Pet cung cấp </h2>
                                <p> TruongDung Pet đặt tình yêu và sự chân thành đến với sức khỏe của Pet cưng của bạn. </p>
                            </div> --}}
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

        <div class="product-list-wrapper key-section">
            <div class="container">
                <div class="row">
                    @if ($isMobile)
                        <div class="offcanvas offcanvas-start" id="filter-sidebar" data-bs-scroll="true" data-bs-backdrop="false" aria-labelledby="filter-sidebar-label" tabindex="-1">
                            <div class="offcanvas-header">
                                <h5 class="offcanvas-title" id="filter-sidebar-label"></h5>
                                <button class="btn-close" data-bs-dismiss="offcanvas" type="button" aria-label="Close"></button>
                            </div>
                            <div class="offcanvas-body">
                                <div class="widget-left">
                                    <!-- widget search -->
                                    <div class="widget-pet search cbcl-filterform">
                                        <div class="widget-header">
                                            <h5 class="mb-0">Tìm sản phẩm</h5>
                                        </div>
                                        <div class="widget-body filter-input-field">
                                            <div class="input-box">
                                                <img src="{{ asset('images/ic-input-search.svg') }}" alt="">
                                                <input name="search" type="text" value="" placeholder="Tìm kiếm sản phẩm">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- widget catalogue -->
                                    <div class="widget-pet search cbcl-filterform">
                                        <div class="widget-header">
                                            <h5 class="mb-0">Danh mục</h5>
                                        </div>
                                        <div class="widget-body filter-input-field">
                                            <ul class="list-group">
                                                @include('web.includes.catalogue_recursion', [
                                                    'catalogues' => $catalogues->whereNull('parent_id'),
                                                    'product' => isset($product) ? $product : null,
                                                ])
                                            </ul>
                                        </div>
                                    </div>
                                    <!-- widget Best Selling -->
                                    @foreach ($catalogues as $cat)
                                        @if ($cat->products->where('status', 3)->isNotEmpty())
                                            <div class="widget-pet search cbcl-filterform">
                                                <div class="widget-header">
                                                    <h5 class="mb-0">Sản phẩm bán chạy</h5>
                                                </div>
                                                <div class="widget-body filter-input-field">
                                                    <div class="row product-list">
                                                        @foreach ($cat->products->where('status', 3) as $product)
                                                            <!-- Product item -->
                                                            <div class="col-12">
                                                                <div class="product-item product-item-verical">
                                                                    <div class="product-image">
                                                                        <a href="{{ route('shop', ['catalogue' => $cat->slug, 'slug' => $product->slug]) }}" title="{{ $product->name }}">
                                                                            <img class="img-fluid" src="{{ $product->avatarUrl }}">
                                                                        </a>
                                                                    </div>
                                                                    <div class="product-content text-start">
                                                                        <a class="product-name" href="{{ route('shop', ['catalogue' => $cat->slug, 'slug' => $product->slug]) }}" title="{{ $product->name }}">
                                                                            {{ $product->name }}
                                                                        </a>
                                                                        <p class="short">Quy cách: {{ $product->unit }} </p>
                                                                        <p class="price">Giá: <span>{!! $product->displayPrice() !!}</span></p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- end product -->
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="col col-md-3 p-3 d-none d-lg-block">
                            <div class="widget-left sticky-top">
                                <!-- widget search -->
                                <div class="widget-pet search cbcl-filterform">
                                    <div class="widget-header">
                                        <h5 class="mb-0">Tìm sản phẩm</h5>
                                    </div>
                                    <div class="widget-body filter-input-field">
                                        <div class="input-box">
                                            <img src="{{ asset('images/ic-input-search.svg') }}" alt="">
                                            <input name="search" type="text" value="" placeholder="Tìm kiếm sản phẩm">
                                        </div>
                                    </div>
                                </div>
                                <!-- widget price -->
                                {{-- <div class="widget-pet search cbcl-filterform">
                                <div class="widget-header">
                                    <h5 class="mb-0">Giá</h5>
                                </div>
                                <div class="widget-body filter-input-field">
                                </div>
                            </div> --}}
                                <!-- widget catalogue -->
                                <div class="widget-pet search cbcl-filterform">
                                    <div class="widget-header">
                                        <h5 class="mb-0">Danh mục</h5>
                                    </div>
                                    <div class="widget-body filter-input-field">
                                        <ul class="list-group">
                                            @include('web.includes.catalogue_recursion', [
                                                'catalogues' => $catalogues->whereNull('parent_id'),
                                                'product' => isset($product) ? $product : null,
                                            ])
                                        </ul>
                                    </div>
                                </div>
                                <!-- widget Best Selling -->
                                @foreach ($catalogues as $cat)
                                    @if ($cat->products->where('status', 3)->isNotEmpty())
                                        <div class="widget-pet search cbcl-filterform">
                                            <div class="widget-header">
                                                <h5 class="mb-0">Sản phẩm bán chạy</h5>
                                            </div>
                                            <div class="widget-body filter-input-field">
                                                <div class="row product-list">
                                                    @foreach ($cat->products->where('status', 3) as $product)
                                                        <!-- Product item -->
                                                        <div class="col-12">
                                                            <div class="product-item product-item-verical">
                                                                <div class="product-image">
                                                                    <a href="{{ route('shop', ['catalogue' => $cat->slug, 'slug' => $product->slug]) }}" title="{{ $product->name }}">
                                                                        <img class="img-fluid" src="{{ $product->avatarUrl }}">
                                                                    </a>
                                                                </div>
                                                                <div class="product-content text-start">
                                                                    <a class="product-name" href="{{ route('shop', ['catalogue' => $cat->slug, 'slug' => $product->slug]) }}" title="{{ $product->name }}">
                                                                        {{ $product->name }}
                                                                    </a>
                                                                    <p class="short">Quy cách: {{ $product->unit }} </p>
                                                                    <p class="price">Giá: <span>{!! $product->displayPrice() !!}</span></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- end product -->
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endif
                    <div class="col-12 col-lg-9">
                        <div class="cbcl-filterform w-100" style="max-width: 100%">
                            <div class="d-flex justify-content-between align-items-center filter-input-field">
                                <div class="d-block d-lg-none">
                                    <button class="btn btn-short-mb" data-bs-toggle="offcanvas" data-bs-target="#filter-sidebar" type="button" aria-controls="filter-sidebar"><i
                                            class="bi bi-sliders"></i> Lọc</button>
                                </div>
                                <div class="products-count">Tìm thấy {{ $products->firstItem() }} đến {{ $products->lastItem() }} trong số {{ $products->total() }} sản phẩm</div>
                                <div class="select-box">
                                    <select name="province_id">
                                        <option value="default">Măc định</option>
                                        <option value="new">Mới nhất</option>
                                        <option value="price-az">Giá tăng dần</option>
                                        <option value="price-za">Giá giảm dần</option>
                                    </select>
                                    <span class="svg-ic">
                                        <svg width="12" height="8" viewBox="0 0 12 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1 1.5L6 6.5L11 1.5" stroke="#828282" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="row product-list mb-5" id="products">
                            @if ($products->isNotEmpty())
                                @foreach ($products as $product)
                                    <!-- Product item -->
                                    <div class="col-6 col-md-4">
                                        <div class="product-item product-item-row">
                                            <div class="product-image">
                                                <a href="{{ route('shop', ['catalogue' => $product->catalogues->first()->slug, 'slug' => $product->slug]) }}" title="{{ $product->name }}">
                                                    <img class="img-fluid" src="{{ $product->avatarUrl }}">
                                                </a>
                                            </div>
                                            <div class="product-content text-start">
                                                <a class="product-name" href="{{ route('shop', ['catalogue' => $product->catalogues->first()->slug, 'slug' => $product->slug]) }}" title="{{ $product->name }}">
                                                    {{ $product->name }}
                                                </a>
                                                <p class="short">Quy cách: {{ $product->unit }} </p>
                                                <p class="price">Giá: <span>{!! $product->displayPrice() !!}</span></p>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="product-ratting">
                                                        <ul>
                                                            <li><a href="#"><i class="bi bi-star-fill"></i></i></a></li>
                                                            <li><a href="#"><i class="bi bi-star-fill"></i></i></a></li>
                                                            <li><a href="#"><i class="bi bi-star-fill"></i></i></a></li>
                                                            <li><a href="#"><i class="bi bi-star-half"></i></a></li>
                                                            <li><a href="#"><i class="bi bi-star"></i></a></li>
                                                        </ul>
                                                    </div>
                                                    <div>
                                                        <a class="detail" href="{{ route('shop', ['catalogue' => $product->catalogues->first()->slug, 'slug' => $product->slug]) }}"><i class="bi bi-bag-check"></i></a>
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
    </div>
@endsection
@push('scripts')
    <script>
        $('[name="search"]').add('[name="catalogues[]"]').change(function() {
            let catalogues = $("input[name='catalogues[]']:checked").map(function() {
                return $(this).val();
            }).get()
            $.get(`{{ route('ajax', ['type' => 'product', 'key' => 'filter']) }}/?catalogues=${catalogues}&search=${$('[name="search"]').val()}`, function(products) {
                $('.products-count').text('Tìm thấy ' + products.length + ' sản phẩm.')
                let str = ''
                products.forEach(product => {
                    str += `
                    <!-- Product item -->
                    <div class="col-6 col-md-4">
                        <div class="product-item product-item-row">
                            <div class="product-image">
                                <a href="{{ route('shop') }}/${product.catalogues[0].slug}/${product.slug}" title="${product.name}">
                                    <img class="img-fluid" src="${product.avatarUrl}">
                                </a>
                            </div>
                            <div class="product-content text-start">
                                <a class="product-name" href="{{ route('shop') }}/${product.catalogues[0].slug}/${product.slug}" title="${product.name}">
                                    ${product.name}
                                </a>
                                <p class="short">Quy cách: ${product.unit} </p>
                                <p class="price">Giá: <span>${product.price}</span></p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="product-ratting">
                                        <ul>
                                            <li><a href="#"><i class="bi bi-star-fill"></i></i></a></li>
                                            <li><a href="#"><i class="bi bi-star-fill"></i></i></a></li>
                                            <li><a href="#"><i class="bi bi-star-fill"></i></i></a></li>
                                            <li><a href="#"><i class="bi bi-star-half"></i></a></li>
                                            <li><a href="#"><i class="bi bi-star"></i></a></li>
                                        </ul>
                                    </div>
                                    <div>
                                        <a class="detail" href="{{ route('shop') }}/${product.catalogues[0].slug}/${product.slug}"><i class="bi bi-bag-check"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end product -->`
                });
                $('#products').html(str)
            })
        })
    </script>
@endpush
