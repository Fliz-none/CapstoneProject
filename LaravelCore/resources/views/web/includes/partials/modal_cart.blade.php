<!-- cartModal -->
<div class="offcanvas offcanvas-end" id="offcanvasCart" tabindex="-1" aria-labelledby="offcanvasCartLabel">
    <div class="offcanvas-header bg-warning">
        <h5 class="offcanvas-title text-white" id="offcanvasCartLabel">{{ __('lang_web.cart.your_cart') }}</h5>
        <button class="btn-close" data-bs-dismiss="offcanvas" type="button" aria-label="Close"></button>
    </div>
    <hr class="m-1">
    <div class="offcanvas-body">
        <div class="row mini-cart-items">
            @if (Auth::check() && Auth::user()->cart)
                @foreach (Auth::user()->cart->items->groupBy('unit_id') as $unitId => $items)
                    @php
                        $first = $items->first(); // Dùng để lấy unit/product info
                        $product = $first->unit->variable->product;
                        $quantity = $items->sum('quantity');
                        $subTotal = $items->sum(fn($i) => $i->quantity * $i->price);
                    @endphp
                    <div class="mini-cart-item">
                        <div class="mini-cart-img">
                            <img src="{{ $product->avatarUrl }}" alt="{{ $product->name }}">
                            <form action="{{ route('cart.remove') }}" method="POST">
                                @csrf
                                <input type="hidden" name="unit_id" value="{{ $unitId }}">
                                <button class="mini-cart-item-delete just-icon" type="submit">
                                    <i class="bi bi-x"></i>
                                </button>
                            </form>
                        </div>
                        <div class="mini-cart-info">
                            <h6>
                                {{ $product->name }} - {{ $first->unit->variable->name }} - {{ $first->unit->term }}
                            </h6>
                            <span class="mini-cart-quantity">
                                {{ $quantity }} × {{ number_format($first->unit->price) . ' ' . $config['currency'] }}
                            </span>
                        </div>

                        <div class="mini-cart-price">
                            {{ number_format($subTotal) . ' ' . $config['currency'] }}
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-12 text-center">
                    <div class="d-flex justify-content-center">
                        <img class="img-fluid mb-2" src="{{ asset('images/cart-x.png') }}" alt="" style="width: 50px;">
                    </div>
                    <p>{{ __('lang_web.cart.no_cart') }}</p>
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
                    <trong>{{ __('lang_web.cart.temp_total') }}: <span>{{ number_format($is_login && $user->cart ? $user->cart->total : 0) . ' ' . $config['currency'] }}</span></trong>
                </p>
                <div class="d-flex gap-2 w-100 justify-content-center">
                    {!! $is_login ? '<a href="' . route('checkout') . '" class="key-btn-success d-flex justify-content-center" style="width: 50%;">' . __('lang_web.cart.pay') . '</a>' : '' !!}
                    <a class="key-btn-info d-flex justify-content-center" href="{{ route('shop') }}" style="width: 50%;">{{ __('lang_web.cart.go_to_store') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end cartModal -->
