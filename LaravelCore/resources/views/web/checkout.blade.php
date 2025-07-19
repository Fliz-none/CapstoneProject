@extends('web.layouts.app')
@section('title')
    {{ $pageName }}
@endsection
@section('content')
    @php
        $user = Auth::user();
        $cart = $user->cart;
    @endphp
    <div class="master-wrapper">
        <div class="banner-page-cpn">
            <div class="imagebox">
                <img src="{{ asset('images/banner/lien-he-banner.jpg') }}" alt="Checkout Banner">
            </div>
            <div class="textbox">
                <div class="child-container">
                    <h3 class="">
                        Thanh toán
                    </h3>
                    <span> Thanh toán </span>
                </div>
            </div>
        </div>
        <div class="support-wrapper support-fwidth-wrapper">
            <div class="container">
                @if (session('response') && session('response')['status'] == 'error')
                    <div class="alert bg-danger alert-dismissible fade show text-white mb-4" role="alert">
                        <i class="bi bi-x"></i>
                        {!! session('response')['msg'] !!}
                        <button class="btn-close" data-bs-dismiss="alert" type="button" aria-label="Close">
                        </button>
                    </div>
                @elseif ($errors->any())
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger alert-dismissible fade show text-white mb-4" role="alert">
                            <i class="bi bi-x"></i>
                            {{ $error }}
                            <button class="btn-close" data-bs-dismiss="alert" type="button" aria-label="Close">
                            </button>
                        </div>
                    @endforeach
                @endif
                <div class="card mb-5 checkout-address-card">
                    <div class="card-header">
                        <h4 class="fw-semibold text-dark"><i class="text-danger bi bi-geo-alt"></i> Địa chỉ nhận hàng</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="checkout-address">
                                    <div class="checkout-address-item d-flex align-items-center justify-content-between">
                                        <div class="checkout-address-info">
                                            <h5 class="mb-1">{{ $user->name }}{{ $user->phone ? ' - ' . $user->phone : '' }}</h5>
                                            <p>113 Nguyễn Văn Linh, Phường 3, Quận 5, Thành Phố Hồ Chí Minh</p>
                                        </div>
                                        <button class="btn text-primary" data-bs-toggle="modal" data-bs-target="#checkoutAddressModal">Thay đổi</button>
                                    </div>
                                    <div class="checkout-address-modal">
                                        <div class="modal fade" id="checkoutAddressModal" aria-labelledby="checkoutAddressModalLabel" tabindex="-1">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="checkoutAddressModalLabel">
                                                            Phương thức thanh toán</h5>
                                                        <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <ul class="list-group">
                                                            <li class="list-group-item">
                                                                <input class="form-check-input me-1" id="firstCheckboxStretched" name="radio" type="radio" value="">
                                                                <label class="form-check-label stretched-link" for="firstCheckboxStretched">First radio</label>
                                                            </li>
                                                            <li class="list-group-item">
                                                                <input class="form-check-input me-1" id="secondCheckboxStretched" name="radio" type="radio" value="">
                                                                <label class="form-check-label stretched-link" for="secondCheckboxStretched">Second radio</label>
                                                            </li>
                                                            <li class="list-group-item">
                                                                <input class="form-check-input me-1" id="thirdCheckboxStretched" name="radio" type="radio" value="">
                                                                <label class="form-check-label stretched-link" for="thirdCheckboxStretched">Third radio</label>
                                                            </li>
                                                        </ul>
                                                        <button class="key-btn-dark px-4 btn-select-address" type="button">Chọn</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-5 checkout-products-card">
                    <div class="card-header">
                        <h4 class="fw-semibold text-dark"><i class="text-danger bi bi-bag"></i> Sản phẩm</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle checkout-table">
                                <thead class="table-light">
                                    @if ($cart && $cart->count > 0)
                                        <tr>
                                            <th></th>
                                            <th>
                                                <h5>Tên sản phẩm</h5>
                                            </th>
                                            <th>
                                                <h5>Số lượng × Giá</h5>
                                            </th>
                                            <th class="text-end">
                                                <h5>Tạm tính</h5>
                                            </th>
                                        </tr>
                                    @endif
                                </thead>
                                <tbody>
                                    @if ($cart && $cart->count > 0)
                                        @foreach ($cart->items as $item)
                                            @php
                                                $unit = $item->unit;
                                                $variable = $unit->variable;
                                                $product = $variable->product;
                                                $display_name = $product->name . ' - ' . $variable->name . ' - ' . $unit->term;
                                                $shortDesc = \Illuminate\Support\Str::limit($variable->description ?? $product->description, 50);
                                            @endphp
                                            <tr>
                                                <td style="vertical-align: middle; width: 7rem;">
                                                    <img class="img-fluid rounded cursor-pointer thumb" src="{{ $product->avatarUrl }}" alt="{{ $product->name }}" style="max-width: 100%;">
                                                </td>
                                                <td>
                                                    <a class="text-dark" href="{{ route('product', ['catalogue' => $product->catalogues->first()->slug, 'slug' => $product->slug]) }}">
                                                        <h5 title="{{ $display_name }}">{{ $display_name }}</h5>
                                                    </a>
                                                    <p class="text-muted" title="{{ $shortDesc }}">{{ $shortDesc }}
                                                    </p>
                                                </td>
                                                <td>
                                                    {{ $item->quantity }} ×
                                                    {{ number_format($unit->price) . ' ' . $config['currency'] }}
                                                </td>
                                                <td class="text-end fw-semibold">
                                                    {{ $item->sub_total . ' ' . $config['currency'] }}
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td colspan="4">
                                                <div class="mb-3 text-end">
                                                    <h5 class="">Tổng ({{ $cart->count }} món):
                                                        <span class="text-warning fs-5">{{ number_format($cart->total) . ' ' . $config['currency'] }}</span>
                                                    </h5>
                                                </div>
                                            </td>
                                        </tr>
                                    @else
                                        <div class="col-12 text-center">
                                            <div class="d-flex justify-content-center">
                                                <img class="img-fluid mb-2" src="{{ asset('images/cart-x.png') }}" alt="">
                                            </div>
                                            <p>Không có sản phẩm nào trong giỏ hàng</p>
                                            <a class="cta-btn btn-save-modal" href="{{ route('shop') }}">
                                                <span class="">Vào cửa hàng</span>
                                            </a>
                                        </div>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card mb-5 checkout-payment-card">
                    <div class="card-header">
                        <h4 class="fw-semibold text-dark">
                            <i class="text-danger bi bi-credit-card"></i> Phương thức thanh toán
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="checkout-payment">
                                    <div class="checkout-payment-item d-flex align-items-center justify-content-between">
                                        <div class="checkout-payment-info">
                                            <h5 class="mb-1">Thanh toán khi nhận hàng</h5>
                                            <p>Bạn sẽ thanh toán trực tiếp bằng tiền mặt khi nhận hàng từ nhân viên giao hàng.</p>
                                        </div>
                                        <button class="btn text-primary" data-bs-toggle="modal" data-bs-target="#checkoutPaymentModal">Thay đổi</button>
                                    </div>
                                    <div class="checkout-payment-confirm">
                                        <table class="w-100 checkout-payment-table">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <h5>Tổng tiền hàng:</h5>
                                                    </td>
                                                    <td class="text-end fw-semibold">
                                                        {{ number_format($cart->total) . ' ' . $config['currency'] }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <h5>Phí vận chuyển:</h5>
                                                    </td>
                                                    <td class="text-end fw-semibold">
                                                        {{ number_format(0) . ' ' . $config['currency'] }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <h5>Giảm giá:</h5>
                                                    </td>
                                                    <td class="text-end fw-semibold">
                                                        {{ number_format(0) . ' ' . $config['currency'] }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <h5>Phải thanh toán:</h5>
                                                    </td>
                                                    <td class="text-end fw-semibold">
                                                        <span class="text-danger fs-5">
                                                            {{ number_format($cart->total) . ' ' . $config['currency'] }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div class="text-end">
                                            <form id="checkoutForm" action="{{ route('checkout.cod') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="payment_method">
                                                <button class="key-btn-danger px-5 mt-3" type="submit">Đặt hàng</button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="checkout-payment-modal">
                                        <div class="modal fade" id="checkoutPaymentModal" aria-labelledby="checkoutPaymentModalLabel" tabindex="-1">
                                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="checkoutPaymentModalLabel">
                                                            Thay đổi phương thức thanh toán
                                                        </h5>
                                                        <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="accordion" id="accordionExample">
                                                            <div class="accordion-item">
                                                                <h2 class="accordion-header">
                                                                    <button class="accordion-button" data-key="cod" data-bs-toggle="collapse" data-bs-target="#collapseOne" type="button" aria-expanded="true" aria-controls="collapseOne">
                                                                        Thanh toán khi nhận hàng
                                                                    </button>
                                                                </h2>
                                                                <div class="accordion-collapse collapse show" id="collapseOne" data-bs-parent="#accordionExample">
                                                                    <div class="accordion-body d-flex align-items-center">
                                                                        <img class="thumb me-3" src="{{ asset('images/thanhtoankhinhanhang.png') }}" alt="Thanh toán khi nhận hàng" width="160" height="160">
                                                                        <div>
                                                                            <p class="mb-0">Bạn sẽ thanh toán trực tiếp bằng tiền mặt khi nhận hàng từ nhân viên giao hàng.</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="accordion-item">
                                                                <h2 class="accordion-header">
                                                                    <button class="accordion-button collapsed" data-key="vnpay" data-bs-toggle="collapse" data-bs-target="#collapseTwo" type="button" aria-expanded="false" aria-controls="collapseTwo">
                                                                        Thanh toán qua VNPay
                                                                    </button>
                                                                </h2>
                                                                <div class="accordion-collapse collapse" id="collapseTwo" data-bs-parent="#accordionExample">
                                                                    <div class="accordion-body d-flex align-items-center">
                                                                        <img class="thumb me-3" src="{{ asset('images/thanhtoanquavnpay.gif') }}" alt="Thanh toán qua VNPay" width="160" height="160">
                                                                        <div>
                                                                            <p class="mb-0">Sử dụng VNPay để thanh toán bằng thẻ ngân hàng, Internet Banking hoặc quét mã QR.</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            {{-- <div class="accordion-item">
                                                                    <h2 class="accordion-header">
                                                                        <button class="accordion-button collapsed" data-key="momo" data-bs-toggle="collapse" data-bs-target="#collapseThree" type="button" aria-expanded="false" aria-controls="collapseThree">
                                                                            Thanh toán qua Momo
                                                                        </button>
                                                                    </h2>
                                                                    <div class="accordion-collapse collapse" id="collapseThree" data-bs-parent="#accordionExample">
                                                                        <div class="accordion-body d-flex align-items-center">
                                                                            <img class="thumb me-3" src="{{ asset('images/thanhtoanquamomo.gif') }}" alt="Thanh toán qua Momo" width="160" height="160">
                                                                            <div>
                                                                                <p class="mb-0">Thanh toán dễ dàng qua ứng dụng MoMo bằng cách quét mã QR hoặc xác nhận trực tiếp trên điện thoại.</p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div> --}}
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="key-btn-dark px-4 btn-select-payment" data-bs-dismiss="modal" type="button">Chọn</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $(document).on('click', '.btn-select-payment', function() {
                const $modal = $('#checkoutPaymentModal');
                const $form = $('#checkoutForm');
                var valueSelected = $modal.find('.accordion-button[aria-expanded="true"]').data('key');
                if (valueSelected) {
                    $form.find('input[name="payment_method"]').val(valueSelected);
                    switch (valueSelected) {
                        case 'cod':
                            $form.attr('action', `{{ route('checkout.cod') }}`)
                            $('.checkout-payment-info').html('<h5 class="mb-1">Thanh toán khi nhận hàng</h5><p>Bạn sẽ thanh toán trực tiếp bằng tiền mặt khi nhận hàng từ nhân viên giao hàng.</p>');
                            $('input[name="payment_method"]').val('cod');
                            break;
                        case 'vnpay':
                            $form.attr('action', `{{ route('checkout.vnpay') }}`)
                            $('.checkout-payment-info').html('<h5 class="mb-1">Thanh toán qua VNPay</h5><p>Sử dụng VNPay để thanh toán bằng thẻ ngân hàng, Internet Banking hoặc quét má QR.</p>');
                            $('input[name="payment_method"]').val('vnpay');
                            break;
                        case 'momo':
                            $form.attr('action', ``)
                            $('.checkout-payment-info').html('<h5 class="mb-1">Thanh toán qua Momo</h5><p>Thanh toán dễ dàng qua ứng dụng MoMo bằng cách quét má QR hoặc xác nhận trực tiếp trên điện thoại.</p>');
                            $('input[name="payment_method"]').val('momo');
                            break;
                    }
                }
            });

            $(document).on('submit', '#checkoutForm', function(e) {
                e.preventDefault();
                if (!$(this).attr('action')) {
                    Toastify({
                        text: "Vui lọc chọn phương thức thanh toán",
                        duration: 3000,
                        position: "center",
                        gravity: "top",
                        backgroundColor: "--bs-danger",
                    }).showToast();
                    return;
                }
                this.submit();
            })
        });
    </script>
@endpush
