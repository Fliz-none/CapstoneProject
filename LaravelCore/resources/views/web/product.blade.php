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
                                <img class="img-fluid" src="{{ asset('images/banner/banner-shop.jpg') }}" alt="Trang chủ"
                                    loading="lazy">
                            </div>
                            <div class="text-box-banner top text-center">
                                <h2> Dịch vụ TruongDung Pet cung cấp </h2>
                                <p> TruongDung Pet đặt tình yêu và sự chân thành đến với sức khỏe của Pet cưng của bạn. </p>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="home-banner-slide">
                                <img class="img-fluid" src="{{ asset('images/banner/dv-thu-cung-banner.jpg') }}"
                                    alt="Trang chủ" loading="lazy">
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
        <div class="product-detail key-section pb-0">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-md-5 mb-4">
                        <div class="swiper mySwiper2"
                            style="--swiper-navigation-color: #9a9a9a; --swiper-pagination-color: #fff">
                            <div class="swiper-wrapper">
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
                            <div class="product-variable mt-4">
                                @if ($product->variables->count())
                                    <h4 class="mb-0">Các tùy chọn</h4>
                                    <div class="product-variable-tab-menu">
                                        <div class="nav">
                                            @foreach ($product->variables as $index => $variable)
                                                <a class="nav-link mb-2 {{ $index === 0 ? 'active show' : '' }}"
                                                    data-bs-toggle="tab" href="#variable{{ $variable->id }}">
                                                    {!! $variable->name !!}
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                                <div class="tab-content">
                                    @foreach ($product->variables as $index => $variable)
                                        <div class="tab-pane fade {{ $index === 0 ? 'active show' : '' }}"
                                            id="variable{{ $variable->id }}">
                                            <form class="cart-form" action="{{ route('cart.add') }}" method="post">
                                                @csrf
                                                <div class="product-variable-tab-content-inner mb-4">
                                                    <div>
                                                        @if (!empty($variable->sub_sku))
                                                            <p>• {!! $variable->sub_sku !!}</p>
                                                        @endif
                                                    </div>
                                                    @if (!empty($variable->description))
                                                        <p>• {!! $variable->description !!}</p>
                                                    @endif
                                                    <div class="variable-details">
                                                        <h6 class="text-uppercase my-2">Quy cách đóng gói</h6>
                                                        <div class="variable-units d-flex align-items-center">
                                                            @forelse ($variable->units as $unit)
                                                                <div class="variable-unit me-2">
                                                                    <a href="javascript:void(0);"
                                                                        class="btn-select-unit key-btn-white"
                                                                        data-price="{{ $unit->price }}"
                                                                        data-unit_id="{{ $unit->id }}">{{ $unit->term }}
                                                                        <span class="unit-price"
                                                                            data-price="{{ $unit->price }}">{{ number_format($unit->price, 0, ',', '.') . $config['currency'] }}</span>
                                                                    </a>
                                                                </div>
                                                            @empty
                                                                <p class="variable-unit">Sản phẩm đang được cập nhật</p>
                                                            @endforelse
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- tinh gia tri san pham duoc chon --}}
                                                <div class="preview-price-container d-flex align-items-center gap-2 mb-3"
                                                    data-variable-id="{{ $variable->id }}">
                                                    <i class="bi bi-currency-exchange fs-4 text-warning"></i>
                                                    <h4 class="text-dark mb-0 preview-price">
                                                        0 {{ $config['currency'] }}
                                                    </h4>
                                                </div>
                                                <div class="d-flex mb-4 align-items-center">
                                                    <div class="variable-quantity me-4">
                                                        <div class="input-group quantity-input">
                                                            <div class="input-group-prepend">
                                                                <button class="btn btn-quantity decreaseBtn"
                                                                    data-variable-id="{{ $variable->id }}"
                                                                    type="button"><i class="bi bi-dash"></i></button>
                                                            </div>
                                                            <input
                                                                class="form-control quantity text-center align-self-center quantityInput"
                                                                data-variable-id="{{ $variable->id }}"
                                                                data-price="{{ $variable->price }}"
                                                                type="text"
                                                                value="1"
                                                                style="width: 5rem">
                                                            <div class="input-group-append">
                                                                <button class="btn btn-quantity increaseBtn"
                                                                    data-variable-id="{{ $variable->id }}"
                                                                    type="button"><i class="bi bi-plus"></i></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <input name="unit_id" type="hidden">
                                                        <input name="quantity" type="hidden" value="1">
                                                        <button class="key-btn-dark btn-add-to-cart" type="submit"
                                                            title="Add to Cart">
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
            <div class="container">
                <div class="row mb-4 product-description">
                    <div class="col-12">
                        <div class="description-tab">
                            <ul class="nav nav-underline" id="pills-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="description-tab" data-bs-toggle="pill"
                                        data-bs-target="#description" type="button" role="tab"
                                        aria-controls="description" aria-selected="true">Mô tả sản phẩm</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="review-tab" data-bs-toggle="pill"
                                        data-bs-target="#reviews" type="button" role="tab" aria-controls="review"
                                        aria-selected="false">Đánh giá</button>
                                </li>
                            </ul>
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active p-3" id="description" role="tabpanel"
                                    aria-labelledby="description-tab" tabindex="0">
                                    <h5>{{ $product->excerpt }}</h5>
                                    <p>
                                        {!! $product->description ?? 'Không có mô tả sản phẩm' !!}
                                    </p>
                                </div>
                                <div class="tab-pane fade p-3" id="reviews" role="tabpanel"
                                    aria-labelledby="review-tab" tabindex="0">
                                    <p>
                                        Không có đánh giá nào cho sản phẩm này.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if (count($product->relatedProducts()))
                <div class="product-showcase-wrapper home-product key-bg-section">
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
                                        <div class="custom-slide-nav">
                                            <div class="swiper-button-prev">
                                                <svg width="48" height="30" viewBox="0 0 48 30" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <circle cx="15" cy="15" r="14.5"
                                                        transform="rotate(180 15 15)" stroke="#333333"></circle>
                                                    <path d="M48 15.5L12.5 15.5M12.5 15.5L15.5 19M12.5 15.5L15.5 12"
                                                        stroke="#333333"></path>
                                                </svg>
                                            </div>
                                            <div class="swiper-button-next">
                                                <svg width="48" height="30" viewBox="0 0 48 30" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <circle cx="33" cy="15" r="14.5" stroke="#333333">
                                                    </circle>
                                                    <path d="M0 15.5H35.5M35.5 15.5L32.5 12M35.5 15.5L32.5 19"
                                                        stroke="#333333"></path>
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
                                                                <a href="{{ route('product', ['catalogue' => $product->catalogues->first()->slug, 'slug' => $product->slug]) }}"
                                                                    title="{{ $product->name }}">
                                                                    <img class="img-fluid"
                                                                        src="{{ $product->avatarUrl }}">
                                                                </a>
                                                            </div>
                                                            <div class="product-content text-start">
                                                                <a class="product-name"
                                                                    href="{{ route('product', ['catalogue' => $product->catalogues->first()->slug, 'slug' => $product->slug]) }}"
                                                                    title="{{ $product->name }}">
                                                                    {{ $product->name }}
                                                                </a>
                                                                <p class="short">Biến thể:
                                                                    {{ $product->variables->pluck('name')->take(3)->implode(', ') }}{{ $product->variables->count() > 3 ? ', ...' : '' }}
                                                                </p>
                                                                <p class="price">Giá: <span>{!! $product->displayPrice() !!}</span>
                                                                </p>
                                                                <div
                                                                    class="d-flex justify-content-between align-items-center">
                                                                    <div class="product-ratting">
                                                                        <ul>
                                                                            <li><a href="#"><i
                                                                                        class="bi bi-star-fill"></i></i></a>
                                                                            </li>
                                                                            <li><a href="#"><i
                                                                                        class="bi bi-star-fill"></i></i></a>
                                                                            </li>
                                                                            <li><a href="#"><i
                                                                                        class="bi bi-star-fill"></i></i></a>
                                                                            </li>
                                                                            <li><a href="#"><i
                                                                                        class="bi bi-star-half"></i></a>
                                                                            </li>
                                                                            <li><a href="#"><i
                                                                                        class="bi bi-star"></i></a></li>
                                                                        </ul>
                                                                    </div>
                                                                    <div>
                                                                        <a class="detail"
                                                                            href="{{ route('product', ['catalogue' => $product->catalogues->first()->slug, 'slug' => $product->slug]) }}"><i
                                                                                class="bi bi-bag-check"></i></a>
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
                                                <svg width="48" height="30" viewBox="0 0 48 30" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <circle cx="15" cy="15" r="14.5"
                                                        transform="rotate(180 15 15)" stroke="#333333"></circle>
                                                    <path d="M48 15.5L12.5 15.5M12.5 15.5L15.5 19M12.5 15.5L15.5 12"
                                                        stroke="#333333"></path>
                                                </svg>
                                            </div>
                                            <div class="swiper-button-next">
                                                <svg width="48" height="30" viewBox="0 0 48 30" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <circle cx="33" cy="15" r="14.5" stroke="#333333">
                                                    </circle>
                                                    <path d="M0 15.5H35.5M35.5 15.5L32.5 12M35.5 15.5L32.5 19"
                                                        stroke="#333333"></path>
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
    </div>
@endsection
@push('scripts')
    <script>
        function updatePrice($form) {
            const price = parseFloat($form.find('.btn-select-unit.active').data('price')) || 0;
            const quantity = parseInt($form.find('[name="quantity"]').val()) || 1;
            const total = price * quantity;
            $form.find('.preview-price').text(
                new Intl.NumberFormat('vi-VN').format(total) + ' {{ $config['currency'] }}'
            );
        }

        $(document).ready(function() {
            // Khi chọn đơn vị tính
            $('.btn-select-unit').on('click', function() {
                const $this = $(this);
                const $form = $this.closest('form');
                // Bỏ active ở tất cả unit khác
                $form.find('.btn-select-unit').removeClass('active');
                $this.addClass('active');
                // Gán unit_id
                $form.find('input[name="unit_id"]').val($this.data('unit_id'));
                // Cập nhật giá
                updatePrice($form);

                //Cập nhật giao diện nút
                $form.find('.btn-select-unit').removeClass('active');
                $this.addClass('active');
            });

            // Tăng giảm số lượng
            $('.increaseBtn, .decreaseBtn').on('click', function() {
                const $form = $(this).closest('form');
                const $input = $form.find('.quantityInput');
                let val = parseInt($input.val()) || 1;             
                if ($(this).hasClass('increaseBtn')) {
                    $input.val(val + 1);
                } else if (val > 1) {
                    $input.val(val - 1);
                }
                
                $form.find('[name="quantity"]').val($input.val());   

                updatePrice($form);
            });

            // Khi nhập số lượng thủ công
            $('.quantityInput').on('input blur keyup', function() {
                // Chỉ cho nhập số
                $(this).val($(this).val().replace(/[^0-9]/g, ''));
                if(isNaN($(this).val())) return;

                // Khoa nguoi dung nhap so am
                if ($(this).val() < 0) {
                    $(this).val(0);
                }

                // Khoa nguoi dung nhap so lon hon 1000
                if ($(this).val() > 1000) {
                    $(this).val(1000);
                }
                
                const $form = $(this).closest('form');
                $form.find('[name="quantity"]').val($(this).val());   
                updatePrice($form);
            });
        });
    </script>
@endpush
