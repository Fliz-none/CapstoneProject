@php
    $settings = cache()->get('settings');
@endphp
<div id="print-container" style="font-size: 75%; color: #000000">
    <div id="print-container">
        <style>
            #print-container {
                font-family: "Times New Roman", Times, serif;
                font-size: 13pt !important;
                color: black;
            }

            #print-container .content {
                width: 210mm;
                padding: 8mm 0 0 0;
            }
        </style>
        <div class="container content">
            <div class="row mb-1">
                <div class="col-2 text-center">
                    <img class="img-fluid" src="{{ cache()->get('settings')['logo_square_bw'] }}" alt="Logo" style="width: 200px;" />
                </div>
                <div class="col-5">
                    <h6 class="text-uppercase mb-0">{{ $settings['company_brandname'] }}</h6>
                    <small class="mb-0">{{ $settings['company_address'] }}</small><br>
                    <small class="mb-0">Website: {{ $settings['company_website'] }}</small><br>
                    <small class="mb-0">Phone: {{ $settings['company_phone'] }}</small>
                </div>
                <div class="col-4 ms-auto">
                    <p class="mb-0">Invoice Code: <strong>{{ $order->code }}</strong></p>
                    <p class="mb-0">Created At: {{ $order->created_at->format('d/m/Y H:i') }}</p>
                    <div class="d-flex align-items-center justify-content-start" style="height: 10.5mm; overflow: hidden;">
                        <svg id="barcode-{{ $order->code }}"></svg>
                        <input class="barcode-value" type="hidden" value="{{ $order->code }}">
                    </div>
                </div>
            </div>
            <div class="my-2 pt-3 text-center border-top">
                <h4 class="text-uppercase">INVOICE {{ $order->code }}</h4>
            </div>
            <div class="row mt-2">
                <div class="col-12 col-md-5 mb-2">
                    <p class="mb-0">Customer: <strong>{{ optional($order->_customer)->name ?? 'Anonymous' }}</strong></p>
                    <p class="mb-0">Phone: <strong>{{ optional($order->_customer)->phone ?? 'None' }}</strong></p>
                    <p class="mb-0">Address: <strong>{{ optional($order->_customer)->fullAddress ?? 'None' }}</strong></p>
                </div>
                <div class="col-12 col-md-7 mb-2">
                    <p class="mb-0 pe-2">Cashier: <strong>{{ $order->_dealer->name }}</strong></p>
                    <p class="mb-0 pe-2">Branch: <strong> {{ $order->_branch->name }} </strong></p>
                    <p class="mb-0 pe-2">Sale Date: <strong>{{ $order->created_at->format('d/m/Y H:i') }}</strong></p>
                </div>
            </div>
            <div class="row justify-content-between">
                <div class="col-12 p-1">
                    <table class="table table-borderless mb-1">
                        <thead class="border-top">
                            <tr>
                                <th>Product / Service</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-center">Unit Price</th>
                                <th class="text-end">Total</th>
                            </tr>
                        </thead>
                        <tbody class="border-top">
                            @php
                                $goods = $order->details;
                            @endphp
                            @if ($goods->count())
                                <tr>
                                    <td class="p-1 ps-4" colspan="4">
                                        <h5 class="text-primary mb-0">Products</h5>
                                    </td>
                                </tr>
                                @foreach ($goods as $good)
                                    <tr>
                                        <td class="p-1">
                                            {{ $good->_stock->import_detail->_variable->_product->name . ' - ' . $good->_stock->import_detail->_variable->name }}<br />
                                            <small>{{ $good->note }}</small>
                                        </td>
                                        <td class="text-center p-1">
                                            {{ $good->quantity . ' ' . $good->_unit->term }}
                                        </td>
                                        <td class="text-end p-1">
                                            {{ number_format($good->realPrice) . 'VND' }}
                                            {!! $good->discount > 0 ? '<br/><small>Discounted ' . number_format($good->originalTotal - $good->total) . 'VND</small>' : '' !!}
                                        </td>
                                        <td class="text-end p-1">
                                            {{ $good->realPrice ? number_format($good->quantity * $good->realPrice) . 'VND' : 'Free' }}
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                        <tfoot class="border-top">
                            <tr>
                                @php 
                                    $sumOriginal = $order->details->sum(function ($detail) {
                                        return $detail->realPrice > $detail->price ? $detail->total : $detail->originalTotal;
                                    });
                                @endphp
                                <th colspan="3" class="p-0">TOTAL
                                    {{ $goods->sum('quantity') ? $goods->sum('quantity') . ' PRODUCTS' : '' }}{{ $goods->sum('quantity') && $services->sum('quantity') ? ' - ' : '' }}{{ $services->sum('quantity') ? $services->sum('quantity') . ' SERVICES' : '' }}
                                </th>
                                <th class="text-end fw-bold p-0">{{ number_format($sumOriginal) }}VND</th>
                            </tr>
                            @if ($order->discount)
                                <tr>
                                    <th class="p-0" colspan="3">DISCOUNT</th>
                                    <th class="text-end fw-bold p-0">{{ parseDiscount($order->discount) }}</th>
                                </tr>
                            @endif
                            <tr>
                                <th class="p-0" colspan="3">TOTAL DUE</th>
                                <th class="text-end fw-bold fs-5 p-0">{{ number_format($order->total) . 'VND' }}</th>
                            </tr>
                        </tfoot>
                    </table>
                    <h5 class="text-primary">Payments</h5>
                    <table class="table table-borderless table-hover mb-1">
                        <thead class="border-top border-bottom">
                            <tr>
                                <th>Transaction Code</th>
                                <th class="text-center">Description</th>
                                <th class="text-center">Cashier</th>
                                <th class="text-end">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $transactions = $order->transactions;
                            @endphp
                            @foreach ($transactions as $transaction)
                                <tr>
                                    <td class="p-0">
                                        <span class="fw-bold">{{ $transaction->code }}</span>
                                        <br /><small>{{ $transaction->created_at->format('d/m/Y H:i') }}</small>
                                    </td>
                                    <td class="text-start p-0">
                                        {{ $transaction->note }}<br />
                                    </td>
                                    <td class="text-end p-0">
                                        {{ $transaction->_cashier->name }}
                                    </td>
                                    <td class="text-end p-0">
                                        {{ number_format($transaction->amount) }}VND<br />
                                        <small>{{ $transaction->paymentStr }}</small>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="border-top">
                            <tr>
                                <th class="text-end p-0" colspan="3">ORDER TOTAL</th>
                                <th class="text-end p-0 fw-bold">{{ number_format($order->total) }}VND</th>
                            </tr>
                            <tr>
                                <th class="text-end p-0" colspan="3">TOTAL PAID</th>
                                <th class="text-end p-0 fw-bold">{{ number_format($order->paid) }}VND</th>
                            </tr>
                            <tr>
                                <th class="text-end p-0" colspan="3">{{ $order->total > $order->paid ? 'DUE BALANCE' : 'CHANGE' }}</th>
                                <th class="text-end p-0 fw-bold">{{ number_format($order->total - $order->paid) }}VND</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        @if ($order->note)
            <div class="row mt-1 p-2" style="opacity: 1; border-radius:.5rem; border: 1px solid #000000">
                <div class="col-12">
                    <strong>Note: </strong>
                    {{ $order->note }}
                </div>
            </div>
        @endif
        @php $thankyou = '<div class="col-12 text-center">THANK YOU AND SEE YOU AGAIN<br />HOTLINE: ' . $settings['company_hotline'] . '<br /><small>Please return within 24 hours if there are any issues with the products</small></div>' @endphp
        <div class="row justify-content-between align-items-start mt-2">
            <div class="col-6 pt-1 text-center">
                @php
                    $print_order_bank_a5 = cache()->get('settings')['print_order_bank_a5'] ?? 0
                @endphp
                @if ($order->transactions->count() && $order->transactions->last()->payment >= 2 && $print_order_bank_a5)
                    Scan the code with your banking app. <br>
                    @php
                        $bank_info = json_decode($settings['bank_info']);
                        $index = $order->transactions->last()->payment - 2;
                        $src = 'https://img.vietqr.io/image/' . $bank_info[$index]->bank_id . '-' . $bank_info[$index]->bank_number . '-qr_only.png?amount=' . $order->total . '&addInfo=Payment%20for%20' . $order->code;
                    @endphp
                    <img class="my-3 img-fluid" src="{{ $src }}" alt="Payment QR" style="max-width: 150px">
                    <ul class="list-unstyled">
                        <li>Account Number: {{ $bank_info[$index]->bank_number }}</li>
                        <li>Bank Name: {{ $bank_info[$index]->bank_name }}</li>
                        <li>Note: Payment for <strong>{{ $order->code }}</strong></li>
                    </ul>
                @else
                    @php
                        echo $thankyou;
                        $thankyou = '';
                    @endphp
                @endif
            </div>
            <div class="col-6 pt-1 text-center">
                <p>
                    ........., {{ Carbon\Carbon::now()->format('day d month m year Y') }}<br />
                    <strong>Cashier</strong><br />
                </p>
                <div class="d-flex my-5">
                    <!-- Signature -->
                </div>
                <p class="mb-5">
                    <em><strong>{{ $order->_dealer->name }}</strong></em>
                </p>
                {!! $thankyou !!}
            </div>
        </div>
    </div>
</div>