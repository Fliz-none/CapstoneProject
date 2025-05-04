@php
    $settings = cache()->get('settings_' . Auth::user()->company_id);
@endphp
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
        <div class="row" style="font-size: 10pt">
            <div class="col-8 px-0 text-start">
                <p class="fw-bold mb-1 text-uppercase">{{ $settings['company_name'] }}</p>
                <p class="mb-0">Địa chỉ: {{ $settings['company_address'] }}</p>
                <p>MST: {{ $settings['company_tax_id'] }}</p>
            </div>
            <div class="col-4 px-0 text-end">
                <p class="fw-bold mb-1">Mẫu số: 01-TT</p>
                <p>
                    (Ban hành theo TT số 133/2016/TT-BTC ngày 26/08/2016 của Bộ Tài Chính)
                </p>
            </div>
        </div>

        <div class="row position-relative mb-2">
            <div class="col-12 px-0 text-center">
                <h3 class="fw-bold">PHIẾU {{ $transaction->amount > 0 ? 'THU' : 'CHI'}}</h3>
                <p><em>{{ $transaction->created_at->format('\N\g\à\y d \t\h\á\n\g m \n\ă\m Y') }}</em></p>
            </div>
            <div class="col-3 px-0 position-absolute top-0 end-0">
                <p class="mb-0">Số: {{ $transaction->code }}</p>
                <p class="mb-0">Nợ:</p>
                <p class="mb-0">Có:</p>
            </div>
        </div>

        <div class="row">
            <div class="col-12 px-0">
                <p class="mb-1">Họ và tên người {{ $transaction->amount > 0 ? 'nộp' : 'nhận' }} tiền: <strong>{{ optional($transaction->_customer)->name }}</strong> </p>
                <p class="mb-1">Địa chỉ: {{ optional($transaction->_customer)->fullAddress }}
                </p>
                <p class="mb-1">Lý do {{ $transaction->amount > 0 ? 'nộp' : 'nhận' }}: {{ $transaction->note }} </p>
                <p class="mb-1">Số tiền: <strong>{{ number_format(abs($transaction->amount)) }}đ</strong> (<em>Viết bằng chữ: <strong>{{ numberToWords(abs($transaction->amount)) }} đồng</strong></em>)
                </p>
                <p class="mb-1">Kèm theo: ………… chứng từ gốc.</p>
            </div>
        </div>

        <div class="row text-end">
            <div class="col-12 px-0">
                <p class="mb-1"></p>
            </div>
        </div>

        <div class="row text-center">
            <div class="col-4 px-0">
                <p class="mb-0"></p>
                <p><strong>Người {{ $transaction->amount > 0 ? 'nộp' : 'nhận' }} tiền</strong></p><br />
            </div>
            <div class="col-4 px-0">
                <p class="mb-0"></p>
                <p><strong>Giám đốc</strong></p>
            </div>
            <div class="col-4 px-0">
                <p class="mb-0"><em>{{ Carbon\Carbon::now()->format('\N\g\à\y d \t\h\á\n\g m \n\ă\m Y') }}<em></p>
                <p><strong>Người lập phiếu</strong></p><br />
            </div>
        </div>
    </div>
</div>
