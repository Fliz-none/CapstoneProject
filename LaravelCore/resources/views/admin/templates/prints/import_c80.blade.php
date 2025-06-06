@php
    $settings = cache()->get('settings');
@endphp
{{-- <link href="{{ asset('admin/css/bootstrap.css') }}" rel="stylesheet"> --}}
<div id="print-container" style="font-size: 75%; color: #000000">
    <div class="container-fluid print-template">
        <div class="row">
            <div class="col-12">
                <h6 class="text-center mb-0 py-3">IMPORT {{ $import->code }}</h6>
            </div>
            <div class="col-6"><small>Received by:</small></div>
            <div class="col-6 text-end"><small>{{ $import->user->name }}</small></div>
            <div class="col-6"><small>Receipt Date:</small></div>
            <div class="col-6 text-end"><small>{{ $import->created_at->format('d/m/Y H:i') }}</small></div>
            @if ($import->warehouse_id)
                <div class="col-6"><small>Warehouse:</small></div>
                <div class="col-6 text-end"><small>{{ $import->_warehouse->name }}</small></div>
            @endif
            @if ($import->supplier_id)
                <div class="col-6"><small>Supplier:</small></div>
                <div class="col-6 text-end"><small>{{ $import->_supplier->name }}</small></div>
            @endif
        </div>
        <hr style="opacity: 1;">
        <div class="row">
            @foreach ($import->import_details as $i => $import_detail)
                <div class="col-12 fw-bold {{ $i ? 'mt-2' : '' }}">
                    {{ $import_detail->_variable->_product->name . ($import_detail->_variable->name ? ' - ' . $import_detail->_variable->name : $import_detail->_variable->id) }}
                </div>
                <div class="col-8">
                    <small>{{ $import_detail->quantity }} &times; {{ number_format($import_detail->price) }}đ</small>
                </div>
                <div class="col-4 text-end">
                    {{ number_format($import_detail->quantity * $import_detail->price) }}đ
                </div>
            @endforeach
        </div>
        <hr style="opacity: 1;">
        <div class="row">
            <div class="col-7 mb-3 fw-bold">
                TOTAL ITEMS RECEIVED: {{ $import->import_details->sum('quantity') }}
            </div>
            <div class="col-5 mb-3 text-end fw-bold">
                {{ number_format($import->total) }}đ
            </div>
        </div>
    </div>
    @if ($import->note)
        <div class="row m-4 p-3" style="opacity: 1; border-radius:.5rem; border: 1px solid #000000">
            <div class="col-12">
                {!! nl2br($import->note) !!}
            </div>
        </div>
    @endif
    <div class="row mt-3">
        <div class="col-12 text-center">
            THANK YOU AND SEE YOU AGAIN<br />
            HOTLINE: {{ cache('settings')->company_phone }}<br />
            <small>Please return within 24 hours if there is any issue with the goods</small>
        </div>
    </div>
</div>
