<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="order-modal-label">Order {{ $order->code }}</h1>
            <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="container">
                <div class="row mb-3">
                    <div class="col-12 col-lg-6">
                        <strong>Customer:</strong> {{ $order->customer ? $order->customer->name : 'Anonymous' }}<br>
                        @if (optional($order->customer)->phone)
                            <strong>Phone:</strong> {{ $order->customer ? $order->customer->phone : 'N/A' }}<br>
                        @endif
                        @if (optional($order->customer)->address || $order->local_id)
                            <strong>Address:</strong> {{ $order->fullAddress }}
                        @endif
                        <strong>Note:</strong> {{ $order->note }}
                    </div>
                    <div class="col-12 col-lg-6 text-end">
                        <strong>Branch:</strong> {{ $order->branch->name }}<br />
                        <strong>Seller:</strong> {{ $order->dealer->name }}<br />
                        <strong>Sale Date:</strong> {{ $order->created_at->format('d/m/Y H:i') }}<br />
                        <strong>Status:</strong> {{ $order->statusStr['string'] }}
                    </div>
                </div>
                <table class="table table-bordered mb-3">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th class="text-center">Quantity</th>
                            <th class="text-center">Unit Price</th>
                            <th class="text-end">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $goods = $order->details;
                        @endphp
                        @if($goods->count())
                            <tr>
                                <td colspan="4"><h5 class="text-primary mb-0">Products</h5></td>
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
                                        {{ number_format($good->realPrice) . 'VND' }}
                                        {!! $good->discount > 0 ? '<br/><small>Discounted ' . number_format($good->originalTotal - $good->total) . 'VND</small>' : '' !!}
                                    </td>
                                    <td class="text-end">
                                        {{ $good->realPrice ? number_format($good->quantity * $good->realPrice) . 'VND' : 'Free' }}
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
                            <th colspan="3">TOTAL {{ $goods->sum('quantity') ? $goods->sum('quantity') . ' PRODUCTS' : '' }}{{ $goods->sum('quantity') ? ' - ' : '' }}</th>
                            <th class="text-end fw-bold">{{ number_format($sumOriginal) }}VND</th>
                        </tr>
                        @if ($order->discount)
                            <tr>
                                <th colspan="3">DISCOUNT</th>
                                <th class="text-end fw-bold">{{ parseDiscount($order->discount) }}</th>
                            </tr>
                        @endif
                        <tr>
                            <th colspan="3">AMOUNT DUE</th>
                            <th class="text-end fw-bold">{{ number_format($order->total) . 'VND' }}</th>
                        </tr>
                    </tfoot>
                </table>
                <h5 class="text-primary">Payments</h5>
                <table class="table table-bordered mb-3">
                    <thead>
                        <tr>
                            <th>Transaction Code</th>
                            <th class="text-center">Description</th>
                            <th class="text-center">Collector</th>
                            <th class="text-end">Amount</th>
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
                            <th class="text-end" colspan="3">TOTAL ORDER VALUE</th>
                            <th class="text-end fw-bold">{{ number_format($order->total) }}VND</th>
                        </tr>
                        <tr>
                            <th class="text-end" colspan="3">TOTAL PAID</th>
                            <th class="text-end fw-bold">{{ number_format($order->paid) }}VND</th>
                        </tr>
                        <tr>
                            <th class="text-end" colspan="3">{{ $order->total > $order->paid ? 'AMOUNT DUE' : 'CHANGE' }}</th>
                            <th class="text-end fw-bold {{ $order->total > $order->paid ? 'text-danger' : 'text-success' }}">{{ number_format($order->total - $order->paid) }}VND</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="modal-footer">
            @if (Auth::user()->can(App\Models\User::CREATE_TRANSACTION)) 
            <button class="btn btn-primary text-decoration-none btn-create-transaction" data-bs-dismiss="modal" data-order="{{ $order->id }}" type="button" aria-label="Close">
                <i class="bi bi-pencil-square"></i> Make Payment
            </button>
            @endif
            <div class="dropdown">
                <button class="btn btn-primary text-decoration-none" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-printer-fill"></i> Print Receipt
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item cursor-pointer btn-print print-order" data-id="{{ $order->id }}" data-url="{{ getPath(route('admin.order')) }}" data-template="a5">Size A5</a></li>
                    <li><a class="dropdown-item cursor-pointer btn-print print-order" data-id="{{ $order->id }}" data-url="{{ getPath(route('admin.order')) }}" data-template="c80">Size 80mm</a></li>
                </ul>
            </div>
            @if (Auth::user()->can(App\Models\User::UPDATE_ORDER)) 
            <button class="btn btn-primary text-decoration-none btn-update-order" data-bs-dismiss="modal" data-id="{{ $order->id }}" type="button" aria-label="Close">
                <i class="bi bi-pencil-square"></i> Update
            </button>
            @endif
        </div>
    </div>
</div>
