<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="order-modal-label">Đơn hàng {{ $order->code }}</h1>
            <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="container">
                <div class="row mb-3">
                    <div class="col-12 col-lg-6">
                        <strong>Khách hàng:</strong> {{ $order->customer ? $order->customer->name : 'Vô danh' }}<br>
                        @if (optional($order->customer)->phone)
                            <strong>Số điện thoại:</strong> {{ $order->customer ? $order->customer->phone : 'Không có' }}<br>
                        @endif
                        @if (optional($order->customer)->address || $order->local_id)
                            <strong>Địa chỉ:</strong> {{ $order->fullAddress }}
                        @endif
                        <strong>Ghi chú:</strong> {{ $order->note }}
                    </div>
                    <div class="col-12 col-lg-6 text-end">
                        <strong>Chi nhánh:</strong> {{ $order->branch->name }}<br />
                        <strong>Người bán:</strong> {{ $order->dealer->name }}<br />
                        <strong>Ngày bán:</strong> {{ $order->created_at->format('d/m/Y H:i') }}<br />
                        <strong>Trạng thái:</strong> {{ $order->statusStr['string'] }}
                    </div>
                </div>
                <table class="table table-bordered mb-3">
                    <thead>
                        <tr>
                            <th>Hàng hóa / Dịch vụ</th>
                            <th class="text-center">Số lượng</th>
                            <th class="text-center">Đơn giá</th>
                            <th class="text-end">Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $goods = $order->details;
                        @endphp
                        @if($goods->count())
                            <tr>
                                <td colspan="4"><h5 class="text-primary mb-0">Các hàng hóa</h5></td>
                            </tr>
                            @foreach ($goods as $good)
                                <tr>
                                    <td>
                                        {!! $good->_stock->import_detail->_variable->fullName !!}<br />
                                        <small>{{ $good->note }}</small>
                                    </td>
                                    <td class="text-center">
                                        {{ $good->quantity . ' ' . $good->_unit->term }}
                                    </td>
                                    <td class="text-end">
                                        {{ number_format($good->realPrice) . 'đ' }}
                                        {!! $good->discount > 0 ? '<br/><small>Đã giảm ' . number_format($good->originalTotal - $good->total) . 'đ</small>' : '' !!}
                                    </td>
                                    <td class="text-end">
                                        {{ $good->realPrice ? number_format($good->quantity * $good->realPrice) . 'đ' : 'Miễn phí' }}
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                    <tfoot>
                        <tr>
                            @php 
                                $sumOriginal = $order->details->sum(function ($detail) {
                                    return $detail->realPrice > $detail->price ? $detail->total : $detail->originalTotal;
                                });
                            @endphp
                            <th colspan="3">TỔNG {{ $goods->sum('quantity') ? $goods->sum('quantity') . ' SẢN PHẨM' : '' }}{{ $goods->sum('quantity') && $services->sum('quantity') ? ' - ' : '' }}{{ $services->sum('quantity') ? $services->sum('quantity') . ' DỊCH VỤ' : '' }} </th>
                            <th class="text-end fw-bold">{{ number_format($sumOriginal) }}đ</th>
                        </tr>
                        @if ($order->discount)
                            <tr>
                                <th colspan="3">GIẢM GIÁ</th>
                                <th class="text-end fw-bold">{{ parseDiscount($order->discount) }}</th>
                            </tr>
                        @endif
                        <tr>
                            <th colspan="3">PHẢI THANH TOÁN</th>
                            <th class="text-end fw-bold">{{ number_format($order->total) . 'đ' }}</th>
                        </tr>
                    </tfoot>
                </table>
                <h5 class="text-primary">Các thanh toán</h5>
                <table class="table table-bordered mb-3">
                    <thead>
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
                                <td>
                                    @if (Auth::user()->can(App\Models\User::UPDATE_ORDER))
                                        <a class="btn btn-update-transaction text-primary fw-bold p-0" data-bs-dismiss="modal" data-id="{{ $transaction->id }}"> {{ $transaction->code }}</a>
                                    @else
                                        <span class="fw-bold">{{ $transaction->code }}</span>
                                    @endif
                                    <br /><small>{{ $transaction->created_at->format('d/m/Y H:i') }}</small>
                                </td>
                                <td class="text-start">
                                    {{ $transaction->note }}<br />
                                    <small></small>
                                </td>
                                <td class="text-end">
                                    {!! $transaction->_cashier->fullName !!}
                                </td>
                                <td class="text-end">
                                    <span class="text-danger">{!! $transaction->fullAmount !!}</span><br />
                                    <small>{{ $transaction->paymentStr }}</small>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th class="text-end" colspan="3">TỔNG GIÁ TRỊ ĐƠN HÀNG</th>
                            <th class="text-end fw-bold">{{ number_format($order->total) }}đ</th>
                        </tr>
                        <tr>
                            <th class="text-end" colspan="3">TỔNG SỐ TIỀN ĐÃ THANH TOÁN</th>
                            <th class="text-end fw-bold">{{ number_format($order->paid) }}đ</th>
                        </tr>
                        <tr>
                            <th class="text-end" colspan="3">{{ $order->total > $order->paid ? 'CÒN THIẾU' : 'TIỀN THỪA' }}</th>
                            <th class="text-end fw-bold {{ $order->total > $order->paid ? 'text-danger' : 'text-success' }}">{{ number_format($order->total - $order->paid) }}đ</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="modal-footer">
            @if (Auth::user()->can(App\Models\User::CREATE_TRANSACTION)) 
            <button class="btn btn-primary text-decoration-none btn-create-transaction" data-bs-dismiss="modal" data-order="{{ $order->id }}" type="button" aria-label="Close">
                <i class="bi bi-pencil-square"></i> Thanh toán
            </button>
            @endif
            <div class="dropdown">
                <button class="btn btn-primary text-decoration-none" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-printer-fill"></i> In phiếu
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item cursor-pointer btn-print print-order" data-id="{{ $order->id }}" data-url="{{ getPath(route('admin.order')) }}" data-template="a5">Khổ A5</a></li>
                    <li><a class="dropdown-item cursor-pointer btn-print print-order" data-id="{{ $order->id }}" data-url="{{ getPath(route('admin.order')) }}" data-template="c80">Khổ 80mm</a></li>
                </ul>
            </div>
            @if (Auth::user()->can(App\Models\User::UPDATE_ORDER)) 
            <button class="btn btn-primary text-decoration-none btn-update-order" data-bs-dismiss="modal" data-id="{{ $order->id }}" type="button" aria-label="Close">
                <i class="bi bi-pencil-square"></i> Cập nhật
            </button>
            @endif
        </div>
    </div>
</div>
