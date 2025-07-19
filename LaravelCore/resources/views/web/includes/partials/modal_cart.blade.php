<!-- cartModal -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasCart" aria-labelledby="offcanvasCartLabel">
    <div class="offcanvas-header bg-warning">
        <h5 class="offcanvas-title text-white" id="offcanvasCartLabel">Giỏ hàng của bạn</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <hr class="m-1">
    <div class="offcanvas-body">
        <div class="row mini-cart-items">
            @if (Auth::check() && Auth::user()->cart)
                @foreach (Auth::user()->cart->items as $item)
                    @php
                        $product = $item->unit->variable->product;
                    @endphp
                    <div class="mini-cart-item">
                        <div class="mini-cart-img">
                            <img src="{{ $product->avatarUrl }}" alt="{{ $product->name }}">
                            <form action="{{ route('cart.remove') }}" method="POST">
                                @csrf
                                <input type="hidden" name="unit_id" value="{{ $item->unit_id }}">
                                <button class="mini-cart-item-delete just-icon" type="submit">
                                    <i class="bi bi-x"></i>
                                </button>
                            </form>
                        </div>
                        <div class="mini-cart-info">
                            <h6>
                                {{ $product->name }} - {{ $item->unit->variable->name }} - {{ $item->unit->term }}
                            </h6>
                            <span class="mini-cart-quantity">
                                {{ $item->quantity }} × {{ number_format($item->unit->price) . ' ' . $config['currency'] }} 
                            </span>
                        </div>

                        <div class="mini-cart-price">
                            {{ $item->sub_total . ' ' . $config['currency'] }}
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-12 text-center">
                    <div class="d-flex justify-content-center">
                        <img src="{{ asset('images/cart-x.png') }}" alt="" class="img-fluid mb-2"
                            style="width: 50px;">
                    </div>
                    <p>Không có sản phẩm nào trong giỏ hàng</p>
                </div>
            @endif
        </div>
    </div>
    <hr class="m-1">
    <div class="offcanvas-footer p-4">
        <div class="row">
            @php
                $is_login = Auth::check();
                $user = Auth::user();
            @endphp
            <div class="col-12 text-center">
                <p class="mb-3 fw-bold mini-cart-total">
                    <trong>Tạm tính: <span>{{ number_format($is_login && $user->cart ? $user->cart->total : 0) . ' ' . $config['currency'] }}</span></trong>
                </p>
                <div class="d-flex gap-2 w-100 justify-content-center">
                    {!! $is_login ? '<a href="' . route('checkout') . '" class="key-btn-success" style="width: 50%;">Thanh toán</a>' : '' !!}
                    <a href="{{ route('shop') }}" class="key-btn-info" style="width: 50%;">Vào cửa hàng</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end cartModal -->
