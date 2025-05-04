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
                            {{-- <div class="text-box-banner text-center">
                                <h3>TruongDung Pet - Dịch Vụ Thú Y Cần Thơ</h3>
                                <p>Chuyên: Khám & Điều trị bệnh, Spa, Cắt tỉa lông, Nhuộm, Pet hotel.
                                </p>
                            </div> --}}
                        </div>
                    </div>
                    <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
        <div class="product-detail key-section">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-md-5 mb-4">
                        <div class="swiper mySwiper2" style="--swiper-navigation-color: #fff; --swiper-pagination-color: #fff">
                            <div class="swiper-wrapper">
                                {{-- <div class="swiper-slide">
                                    <img class="card-img-top rounded-3" src="{{ $product->avatarUrl }}" />
                                </div> --}}
                                @if (count($product->galleryUrl))
                                    @foreach ($product->galleryUrl as $index => $imageUrl)
                                        <div class="swiper-slide">
                                            <img class="thumb card-img-top rounded-4" src="{{ $imageUrl }}" />
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        @if (count($product->galleryUrl) > 1)
                            <div class="swiper mySwiper mt-1" thumbsSlider="">
                                <div class="swiper-wrapper">
                                    {{-- <div class="swiper-slide cursor-pointer">
                                    <img class="card-img-top rounded-2" src="{{ $product->avatarUrl }}" />
                                </div> --}}
                                    @if (count($product->galleryUrl))
                                        @foreach ($product->galleryUrl as $index => $imageUrl)
                                            <div class="swiper-slide cursor-pointer">
                                                <img class="card-img-top rounded-2" src="{{ $imageUrl }}" />
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="col-12 col-md-7">
                        <div class="product-information">
                            <h3 class="product-name">{!! $product->name !!}</h3>
                            <div class="product-sku">
                                <p><strong>Mã sản phẩm:</strong> {!! $product->sku !!}</p>
                            </div>
                            <div class="product-catalog">
                                <p><strong>Danh mục: </strong>{!! $product->catalogsName() !!} </p>
                            </div>
                            <div class="product-unit">
                                <p><strong>Đơn vị tính:</strong> <span class="text-capitalize">{!! $product->unit !!}</span></p>
                            </div>
                            <div class="product-variable mt-4">
                                @if ($product->variables->count())
                                    <h4 class="mb-0">Các tùy chọn</h4>
                                    <div class="product-variable-tab-menu">
                                        <div class="nav">
                                            @foreach ($product->variables as $index => $variable)
                                                <a class="nav-link {{ $index === 0 ? 'active show' : '' }}" data-bs-toggle="tab" href="#variable{{ $variable->id }}">
                                                    {!! $variable->name !!}
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                                <div class="tab-content">
                                    @foreach ($product->variables as $index => $variable)
                                        <div class="tab-pane fade {{ $index === 0 ? 'active show' : '' }}" id="variable{{ $variable->id }}">
                                            <form class="cart-form" action="{{ route('cart.add') }}" method="post">
                                                @csrf
                                                <div class="product-variable-tab-content-inner">
                                                    <div>
                                                        @if (!empty($variable->sub_sku))
                                                            <p>• {!! $variable->sub_sku !!}</p>
                                                        @endif
                                                    </div>
                                                    @if (!empty($variable->description))
                                                        <p>• {!! $variable->description !!}</p>
                                                    @endif
                                                    <div class="variable-price" data-variable-id="{{ $variable->id }}">
                                                        {!! number_format($variable->price) !!}₫
                                                        {{-- @if (Auth::check())
                                                            <a class="btn btn-link text-decoration-none p-2" href="{{ route('admin.product', ['key' => $product->id]) }}"><i class="far fa-edit"></i> Sửa</a>
                                                        @endif --}}
                                                    </div>
                                                </div>
                                                <div class="d-flex mt-4 align-items-center">
                                                    <div class="variable-quantity me-4">
                                                        <div class="input-group quantity-input">
                                                            <div class="input-group-prepend">
                                                                <button class="btn btn-quantity decreaseBtn" data-variable-id="{{ $variable->id }}" type="button"><i class="bi bi-dash"></i></button>
                                                            </div>
                                                            <input class="form-control quantity text-center align-self-center quantityInput" name="product-quantity" data-variable-id="{{ $variable->id }}" data-price="{{ $variable->price }}"
                                                                type="text" value="1">
                                                            <div class="input-group-append">
                                                                <button class="btn btn-quantity increaseBtn" data-variable-id="{{ $variable->id }}" type="button"><i class="bi bi-plus"></i></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <input name="price" type="hidden" value="{{ $variable->price }}">
                                                        <input name="variable_id" type="hidden" value="{{ $variable->id }}">
                                                        <button class="key-btn-dark btn-add-to-cart" type="submit" title="Add to Cart">
                                                            <i class="bi bi-basket3"></i>
                                                            <span>Thêm vào giỏ hàng</span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="key-section">
            <div class="container">
                <div class="row mb-4 product-description">
                    <div class="col-12">
                        <div class="description-tab">
                            <ul class="nav nav-underline" id="pills-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button
                                        class="nav-link active" id="description-tab" data-bs-toggle="pill" data-bs-target="#description" type="button" role="tab" aria-controls="description" aria-selected="true">Mô tả sản phẩm</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button
                                        class="nav-link" id="review-tab" data-bs-toggle="pill" data-bs-target="#reviews" type="button" role="tab" aria-controls="review" aria-selected="false">Đánh giá</button>
                                </li>
                            </ul>
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab" tabindex="0">
                                    <div class="p-4">
                                        {!! $product->description !!}
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="review-tab" tabindex="0">
                                    <div class="p-4">
                                        Đánh giá sản phẩm
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if (count($product->relatedProducts()))
            <div class="product-showcase-wrapper home-product key-bg-section" style="background-image: url({{ asset('images/bg-contact-1.jpg') }});">
                <div class="container">
                    <div class="text-center">
                        <h2 class="text-dark fw-semibold fs-1 mb-3">Các sản phẩm liên quan</h2>
                    </div>
                </div>
                <div class="product-showcase--inner">
                    <div class="product-slide-wrapper related-product-slide-wrapper">
                        <div class="container">
                            <div class="product-slide--inner">
                                <div class="product-sapo" style="width:0px">
                                    {{-- <h5 id="cate-name">
                                    Pate gói
                                </h5>
                                <p class="product-des" id="cate-des">
                                    Các phương pháp chẩn đoán hình ảnh hoặc làm xét nghiệm: Siêu âm, X-Quang,
                                    Xét nghiệm máu, virus, nước tiểu, da, kháng sinh đồ...
                                </p> --}}
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

                                <div class="product-slider" style="width:100%">
                                    <div class="swiper product-list ">
                                        <div class="swiper-wrapper">
                                            @foreach ($product->relatedProducts() as $product)
                                                <div class="swiper-slide">
                                                    <!-- Product item -->
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
                                                    <!-- end product -->
                                                </div>
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
        @endif
    </div>
@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function updateQuantity(element) {
                var variableId = element.data('variable-id');
                var quantityInput = $('.quantityInput[data-variable-id="' + variableId + '"]');
                var priceElement = $('.variable-price[data-variable-id="' + variableId + '"]');

                var currentQuantity = parseInt(quantityInput.val());
                var variablePrice = parseFloat(quantityInput.data('price'));

                if (element.hasClass('increaseBtn')) {
                    currentQuantity++;
                } else if (element.hasClass('decreaseBtn')) {
                    currentQuantity--;
                }

                // Kiểm tra nếu giá trị không phải là số
                if (isNaN(currentQuantity)) {
                    currentQuantity = 1;
                }

                // Chặn số lượng xuống dưới 0 (nếu không muốn cho phép số âm)
                currentQuantity = Math.max(1, currentQuantity);

                quantityInput.val(currentQuantity); // Thay đổi giá trị thuộc tính value trong HTML

                var newPrice = currentQuantity * variablePrice;
                if (priceElement.length) {
                    priceElement.text(newPrice.toLocaleString() + '₫');
                }
            }

            // Sự kiện click nút
            $('.btn-quantity').on('click', function() {
                updateQuantity($(this));
                return false; // Ngăn chặn sự kiện click mặc định
            });

            // Sự kiện input trên input
            $('.quantityInput').on('keyup', function() {
                updateQuantity($(this));
            });

            // Kiểm tra kiểu số khi nhập (Optional)
            $('.quantityInput').on('keypress', function(event) {
                var keyCode = event.which;
                if (keyCode < 48 || keyCode > 57) {
                    event.preventDefault();
                }
            });
        });
    </script>
@endpush
