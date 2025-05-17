<div id="print-container" style="font-size: 75%; color: #000000">
    <div class="container-fluid print-template">
        <div class="row">
            <div class="col-12">
                <h6 class="text-center mb-0 py-3">EXPORT NOTE {{ $export->code }}</h6>
            </div>
            <div class="col-6"><small>Exporter:</small></div>
            <div class="col-6 text-end"><small>{{ $export->_user->name }}</small></div>
            <div class="col-6"><small>Export Date:</small></div>
            <div class="col-6 text-end"><small>{{ $export->created_at->format('d/m/Y H:i') }}</small></div>
            @if ($export->to_warehouse_id)
                <div class="col-6"><small>Receiving Warehouse:</small></div>
                <div class="col-6 text-end"><small>{{ $export->_to_warehouse->name }}</small></div>
                <div class="col-6"><small>Receiver:</small></div>
                <div class="col-6 text-end"><small>{{ $export->_receiver->name }}</small></div>
            @endif
            @if ($export->order_id)
                @if ($export->_order->customer_id)
                    <div class="col-6"><small>Customer:</small></div>
                    <div class="col-6 text-end"><small>{{ $export->_order->_customer->name }}</small></div>
                @endif
            @endif
        </div>
        <hr style="opacity: 1;">
        <div class="row">
            @foreach ($export->export_details as $i => $export_detail)
                <div class="col-12 fw-bold {{ $i ? 'mt-2' : '' }} mb-1">
                    {{ $export_detail->_stock->_import_detail->_variable->_product->name . ($export_detail->_stock->_import_detail->_variable->name ? ' - ' . $export_detail->_stock->_import_detail->_variable->name : $export_detail->_stock->_import_detail->_variable->id) }}
                    <small>{{ ($export_detail->_stock->expired ? Carbon\Carbon::createFromFormat('Y-m-d', $export_detail->_stock->expired)->format('d/m/Y') . ' - ' : '') . ($export_detail->_stock->lot ? $export_detail->_stock->lot . ' - ' : '') }}<br />{{ $export_detail->note }}</small>
                </div>
                <div class="col-8">
                    <small>{{ $export_detail->quantity . ' ' . $export_detail->_unit->term }} &times; {{ number_format($export_detail->_stock->price) }}đ</small>
                </div>
                <div class="col-4 text-end">
                    {{ number_format($export_detail->quantity * $export_detail->price) }}đ
                </div>
            @endforeach
        </div>
        <hr style="opacity: 1;">
        <div class="row">
            <div class="col-7 mb-3 fw-bold">
                TOTAL EXPORTED {{ $export->export_details->sum('quantity') }} ITEMS
            </div>
            <div class="col-5 mb-3 text-end fw-bold">
                {{ number_format($export->total) }}đ
            </div>
        </div>
        @if ($export->order_id)
            <div class="row">
                <div class="col-7 mb-3 fw-bold">
                    ORDER VALUE
                </div>
                <div class="col-5 mb-3 text-end fw-bold">
                    {{ number_format($export->_order->total) }}đ
                </div>
            </div>
            <div class="row">
                <div class="col-7 mb-3 fw-bold">
                    PROFIT
                </div>
                <div class="col-5 mb-3 text-end fw-bold">
                    {{ number_format($export->_order->total - $export->total) }}đ
                </div>
            </div>
        @endif
    </div>
    @if ($export->note)
        <div class="row m-4 p-3" style="opacity: 1; border-radius:.5rem; border: 1px solid #000000">
            <div class="col-12">
                {!! nl2br($export->note) !!}
            </div>
        </div>
    @endif
    <div class="row mt-3">
        <div class="col-12 text-center">THIS DOCUMENT IS NOT A VALID INVOICE<br />FOR DETAILS, PLEASE CONTACT {{ cache('settings')->company_phone }}</div>
    </div>
</div>
