@php
    $settings = cache()->get('settings');
@endphp
{{-- <link href="{{ asset('admin/css/bootstrap.css') }}" rel="stylesheet"> --}}
<div id="print-container" style="font-size: 75%; color: #000000">
    <div class="container-fluid print-template">
        <div class="row">
            <div class="col-4">
                <img class="img-fluid" src="{{ asset('storage/' . $settings['logo_square_bw']) }}" />
            </div>
            <div class="col-8">
                <h6 class="text-uppercase mb-0">{{ $settings['company_name'] }}</h6>
                <small class="mb-0">
                    Address: {{ $settings['company_address'] }} <br />
                    Phone: {{ $settings['company_hotline'] }}
                </small>
            </div>
        </div>
        <div class="row mb-3 pb-3" style="border-bottom: 1px solid #000;">
            <div class="col-12">
                <h6 class="text-center mb-0 py-3">INVOICE {{ $order->code }}</h6>
            </div>
            <div class="col-6"><small>Cashier: </small></div>
            <div class="col-6 text-end"><small>{{ $order->_dealer->name }}</small></div>
            <div class="col-6"><small>Sale Date:</small></div>
            <div class="col-6 text-end"><small>{{ $order->created_at->format('d/m/Y H:i') }}</small></div>
            @if ($order->customer_id)
                <div class="col-6"><small>Customer: </small></div>
                <div class="col-6 text-end"><small>{{ $order->_customer->name }}</small></div>
                <div class="col-6"><small>Phone:</small></div>
                <div class="col-6 text-end"><small>{{ $order->_customer->phone }}</small></div>
            @endif
        </div>
        @php
            $goods = $order->details;
        @endphp
        @if ($goods->count())
            <div class="fw-bold mb-0 mt-3 text-uppercase">Goods</div>
            <div class="row px-0">
                @foreach ($goods as $i => $good)
                    <div class="col-12 fw-bold {{ $i ? 'mt-2' : '' }}">
                        {{ $good->_stock->import_detail->_variable->_product->name . ' - ' . $good->_stock->import_detail->_variable->name }}
                    </div>
                    <div class="col-4 d-flex align-items-end pe-0">
                        <small>
                            {{ $good->quantity . ' ' . $good->_unit->term }}
                        </small>
                    </div>
                    <div class="col-4 d-flex align-items-end px-0">
                        <small>
                            @if ($good->realPrice != $good->price)
                                <s class="ms-2">{{ number_format($good->price) }}</s><br>
                            @endif
                            &times; {{ number_format($good->realPrice) }}
                        </small>
                    </div>
                    <div class="col-4 d-flex align-items-end text-end px-0">
                        <small>
                            @if ($good->discount_program > 0)
                                <s class="me-4">{{ number_format($good->total + $good->discount_program) }}</s><br>
                            @endif
                            {{ $good->realPrice ? number_format($good->total) . ' VND' : 'Free' }}
                        </small>
                    </div>
                    <div class="col-12 fw-bold">
                        <small>{{ $good->note }}</small>
                    </div>
                    <hr style="border: none; border-top: 1px solid #ccc; width: 80%; margin: 0.5rem auto;" />
                @endforeach
            </div>
        @endif
        <div class="row pt-3" style="border-top: 1px solid #000;">
            @php
                $sumOriginal = $order->details->sum(function ($detail) {
                    return $detail->realPrice > $detail->price ? $detail->total : $detail->originalTotal;
                });
            @endphp
            <div class="col-7 d-flex align-items-end mb-3 fw-bold">
                TOTAL
                {{ $goods->sum('quantity') ? $goods->sum('quantity') . ' PRODUCTS' : '' }}
            </div>
            <div class="col-5 mb-3 text-end">
                @if ($order->total != $sumOriginal)
                    <s class="me-4">{{ number_format($sumOriginal) }}</s><br>
                @endif
                <span class="fw-bold">{{ number_format($order->total) }} VND</span>
            </div>
            @if ($order->transactions->count())
                <div class="col-7 fw-bold">
                    Receive
                </div>
                <div class="col-5 fw-bold text-end">
                    {{ number_format($order->receive) }}VND
                </div>
                <div class="col-7 fw-bold">
                    Refund
                </div>
                <div class="col-5 fw-bold text-end">
                    {{ number_format($order->refund) }}VND
                </div>
            @endif
        </div>
    </div>
    @if ($order->note)
        <div class="row m-4 p-3" style="opacity: 1; border-radius:.5rem; border: 1px solid #000000">
            <div class="col-12">
                {{ $order->note }}
            </div>
        </div>
    @endif
    @php
        $print_order_bank_c80 = cache()->get('settings_' . Auth::user()->company_id)['print_order_bank_c80'] ?? 0;
    @endphp
    @if ($order->transactions->count() && $order->transactions->last()->payment >= 2 && $print_order_bank_c80)
        <div class="row mt-3 justify-content-center">
            <div class="col-9 text-center">
                Scan the QR code below using your bank app to make the payment. <br>
                @php
                    $bank_info = json_decode($settings['bank_info']);
                    $index = $order->transactions->last()->payment - 2;
                    $src = 'https://img.vietqr.io/image/' . $bank_info[$index]->bank_id . '-' . $bank_info[$index]->bank_number . '-qr_only.png?amount=' . $order->total . '&addInfo=Payment%20for%20' . $order->code;
                @endphp
            </div>
            <div class="col-4 text-center">
                <img class="my-3 img-fluid" src="{{ $src }}" alt="Payment QR">
            </div>
            <ul class="col-12 text-center">
                <li>Account Number: {{ $bank_info[$index]->bank_number }}</li>
                <li>Bank Name: {{ $bank_info[$index]->bank_name }}</li>
                <li>Content: Payment for <strong>{{ $order->code }}</strong></li>
            </ul>
        </div>
    @endif
    <div class="row mt-3">
        <div class="col-12 text-center">THANK YOU AND SEE YOU AGAIN<br />HOTLINE: {{ $settings['company_hotline'] }}<br /><small>Please return within 24 hours if there is any problem with the goods</small></div>
    </div>
</div>
