@php
    $settings = cache()->get('settings_' . Auth::user()->company_id);
@endphp
{{-- <link href="{{ asset('admin/css/bootstrap.css') }}" rel="stylesheet"> --}}
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
                    <img class="img-fluid" src="{{ Auth::user()->company->logo_square_bw }}" alt="Logo" style="width: 200px;" />
                </div>
                <div class="col-5">
                    <h6 class="text-uppercase mb-0">{{ $settings['company_brandname'] }}</h6>
                    <small class="mb-0">{{ $settings['company_address'] }}</small><br>
                    <small class="mb-0">Website: {{ $settings['company_website'] }}</small><br>
                    <small class="mb-0">SĐT: {{ $settings['company_phone'] }}</small>
                </div>
                <div class="col-4 ms-auto">
                    <p class="mb-0">Mã phiếu: <strong>{{ $order->code }}</strong></p>
                    <p class="mb-0">Ngày tạo: {{ $order->created_at->format('d/m/Y H:i') }}</p>
                    <div class="d-flex align-items-center justify-content-start" style="height: 10.5mm; overflow: hidden;">
                        <svg id="barcode-{{ $order->code }}"></svg>
                        <input class="barcode-value" type="hidden" value="{{ $order->code }}">
                    </div>
                </div>
            </div>
            <div class="my-2 pt-3 text-center border-top">
                <h4 class="text-uppercase">HÓA ĐƠN {{ $order->code }}</h4>
            </div>
            <div class="row mt-2">
                <div class="col-12 col-md-5 mb-2">
                    <p class="mb-0">Khách hàng: <strong>{{ optional($order->_customer)->name ?? 'Vô danh' }}</strong></p>
                    <p class="mb-0">SĐT: <strong>{{ optional($order->_customer)->phone ?? 'Không có' }}</strong></p>
                    <p class="mb-0">Địa chỉ: <strong>{{ optional($order->_customer)->fullAddress ?? 'Không có' }}</strong></p>
                </div>
                <div class="col-12 col-md-7 mb-2">
                    <p class="mb-0 pe-2">Người bán: <strong>{{ $order->_dealer->name }}</strong></p>
                    <p class="mb-0 pe-2">Chi nhánh: <strong> {{ $order->_branch->name }} </strong></p>
                    <p class="mb-0 pe-2">Ngày bán: <strong>{{ $order->created_at->format('d/m/Y H:i') }}</strong></p>
                </div>
            </div>
            <div class="row justify-content-between">
                <div class="col-12 p-1">
                    <table class="table table-borderless mb-1">
                        <thead class="border-top">
                            <tr>
                                <th>Hàng hóa / Dịch vụ</th>
                                <th class="text-center">Số lượng</th>
                                <th class="text-center">Đơn giá</th>
                                <th class="text-end">Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody class="border-top">
                            @php
                                $goods = $order->details->whereNull('service_id');
                            @endphp
                            @if ($goods->count())
                                <tr>
                                    <td class="p-1 ps-4" colspan="4">
                                        <h5 class="text-primary mb-0">Các hàng hóa</h5>
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
                                            {{ number_format($good->realPrice) . 'đ' }}
                                            {!! $good->discount > 0 ? '<br/><small>Đã giảm ' . number_format($good->originalTotal - $good->total) . 'đ</small>' : '' !!}
                                        </td>
                                        <td class="text-end p-1">
                                            {{ $good->realPrice ? number_format($good->quantity * $good->realPrice) . 'đ' : 'Miễn phí' }}
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            @php
                                $services = $order->details->whereNull('stock_id');
                            @endphp
                            @if ($services->count())
                                <tr>
                                    <td class="p-1 ps-4" colspan="4">
                                        <h5 class="text-primary mb-0">Các dịch vụ</h5>
                                    </td>
                                </tr>
                                @foreach ($services as $service)
                                    <tr>
                                        <td class="p-1">
                                            {{ $service->_service->name }}
                                            <small>{{ $service->note ? '(' . $service->note . ')' : '' }}</small>
                                        </td>
                                        <td class="text-center p-1">
                                            {{ $service->quantity . ' ' . ($service->_service->unit ?? 'ĐVT') }}
                                        </td>
                                        <td class="text-end p-1">
                                            {{ number_format($service->realPrice) . 'đ' }}
                                            {!! $service->discount > 0 ? '<br/><small>Đã giảm ' . number_format($service->originalTotal - $service->total) . 'đ</small>' : '' !!}
                                        </td>
                                        <td class="text-end p-1">
                                            {{ $service->realPrice ? number_format($service->quantity * $service->realPrice) . 'đ' : 'Miễn phí' }}
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
                                <th colspan="3" class="p-0">TỔNG
                                    {{ $goods->sum('quantity') ? $goods->sum('quantity') . ' SẢN PHẨM' : '' }}{{ $goods->sum('quantity') && $services->sum('quantity') ? ' - ' : '' }}{{ $services->sum('quantity') ? $services->sum('quantity') . ' DỊCH VỤ' : '' }}
                                </th>
                                <th class="text-end fw-bold p-0">{{ number_format($sumOriginal) }}đ</th>
                            </tr>
                            @if ($order->discount)
                                <tr>
                                    <th class="p-0" colspan="3">GIẢM GIÁ</th>
                                    <th class="text-end fw-bold p-0">{{ parseDiscount($order->discount) }}</th>
                                </tr>
                            @endif
                            <tr>
                                <th class="p-0" colspan="3">PHẢI THANH TOÁN</th>
                                <th class="text-end fw-bold fs-5 p-0">{{ number_format($order->total) . 'đ' }}</th>
                            </tr>
                        </tfoot>
                    </table>
                    <h5 class="text-primary">Các thanh toán</h5>
                    <table class="table table-borderless table-hover mb-1">
                        <thead class="border-top border-bottom">
                            <tr>
                                <th>Mã giao dịch</th>
                                <th class="text-center">Nội dung</th>
                                <th class="text-center">Người thu</th>
                                <th class="text-end">Số tiền</th>
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
                                        <small></small>
                                    </td>
                                    <td class="text-end p-0">
                                        {{ $transaction->_cashier->name }}
                                    </td>
                                    <td class="text-end p-0">
                                        {{ number_format($transaction->amount) }}đ<br />
                                        <small>{{ $transaction->paymentStr }}</small>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="border-top">
                            <tr>
                                <th class="text-end p-0" colspan="3">TỔNG GIÁ TRỊ ĐƠN HÀNG</th>
                                <th class="text-end p-0 fw-bold">{{ number_format($order->total) }}đ</th>
                            </tr>
                            <tr>
                                <th class="text-end p-0" colspan="3">TỔNG SỐ TIỀN ĐÃ THANH TOÁN</th>
                                <th class="text-end p-0 fw-bold">{{ number_format($order->paid) }}đ</th>
                            </tr>
                            <tr>
                                <th class="text-end p-0" colspan="3">{{ $order->total > $order->paid ? 'CÒN THIẾU' : 'TIỀN THỪA' }}</th>
                                <th class="text-end p-0 fw-bold">{{ number_format($order->total - $order->paid) }}đ</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        @if ($order->note)
            <div class="row mt-1 p-2" style="opacity: 1; border-radius:.5rem; border: 1px solid #000000">
                <div class="col-12">
                    <strong>Ghi chú: </strong>
                    {{ $order->note }}
                </div>
            </div>
        @endif
        @php $thankyou = '<div class="col-12 text-center">CẢM ƠN QUÝ KHÁCH VÀ HẸN GẶP LẠI<br />HOTLINE: ' . $settings['company_hotline'] . '<br /><small>Vui lòng đổi trả trong 24 giờ nếu hàng hóa có vấn đề</small></div>' @endphp
        <div class="row justify-content-between align-items-start mt-2">
            <div class="col-6 pt-1 text-center">
                @php
                    $print_order_bank_a5 = cache()->get('settings_' . Auth::user()->company_id)['print_order_bank_a5'] ?? 0
                @endphp
                @if ($order->transactions->count() && $order->transactions->last()->payment >= 2 && $print_order_bank_a5)
                    Quét mã thanh toán bằng ứng dụng ngân hàng. <br>
                    @php
                        $bank_info = json_decode($settings['bank_info']);
                        $index = $order->transactions->last()->payment - 2;
                        $src = 'https://img.vietqr.io/image/' . $bank_info[$index]->bank_id . '-' . $bank_info[$index]->bank_number . '-qr_only.png?amount=' . $order->total . '&addInfo=Thanh%20toan%20' . $order->code;
                    @endphp
                    <img class="my-3 img-fluid" src="{{ $src }}" alt="QR thanh toán" style="max-width: 150px">
                    <ul class="list-unstyled">
                        <li>Tài khoản số: {{ $bank_info[$index]->bank_number }}</li>
                        <li>Tại ngân hàng: {{ $bank_info[$index]->bank_name }}</li>
                        <li>Nội dung: Thanh toán <strong>{{ $order->code }}</strong></li>
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
                    ........., {{ Carbon\Carbon::now()->format('\n\g\à\y d \t\h\á\n\g m \n\ă\m Y') }}<br />
                    <strong>Thu ngân</strong><br />
                </p>
                <div class="d-flex my-5">
                    <!-- Chữ ký BS  -->
                </div>
                <p class="mb-5">
                    <em><strong>{{ $order->_dealer->name }}</strong></em>
                </p>
                {!! $thankyou !!}
            </div>
        </div>
    </div>
