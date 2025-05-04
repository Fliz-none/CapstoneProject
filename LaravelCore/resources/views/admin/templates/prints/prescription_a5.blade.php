@php
    $settings = cache()->get('settings_' . Auth::user()->company_id);
    $info = $prescription->info;
    $pet = $info->_pet;
    $customer = $info->_pet->_customer;
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
            <div class="row mb-3">
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
                    <p class="mb-0">Mã phiếu: <strong>{{ $info->code }}</strong></p>
                    <p class="mb-0">Ngày tạo: {{ $info->created_at->format('d/m/Y H:i') }}</p>
                    <div class="d-flex align-items-center justify-content-start" style="height: 10.5mm; overflow: hidden;">
                        <svg id="barcode-{{ $info->code }}"></svg>
                        <input class="barcode-value" type="hidden" value="{{ $info->code }}">
                    </div>
                </div>
            </div>
            <div class="my-4 pt-3 text-center border-top">
                <h4 class="text-uppercase">ĐƠN THUỐC</h4>
            </div>
            <div class="row my-3">
                <div class="col-5 mb-2">
                    <p class="mb-0 pe-2">Thú cưng: <strong>{{ $pet->name }}</strong></p>
                    <p class="mb-0 pe-2">Loài: <strong>{{ $pet->animal->specie . '(' . $pet->genderStr . ')' }}</strong></p>
                    <p class="mb-0 pe-2">Tuổi: <strong> {{ $pet->age ?? 'Không rõ' }} </strong> tháng</p>
                    <p class="mb-0 pe-2">Triệt sản: <strong>{{ $pet->neuterStr }} </strong></p>
                </div>
                <div class="col-7 mb-2">
                    <p class="mb-0">Khách hàng: <strong>{{ $customer->name }}</strong></p>
                    <p class="mb-0">SĐT: <strong>{{ $customer->phone ?? 'Không có' }}</strong></p>
                    <p class="mb-0">Địa chỉ: <strong>{{ $customer->address ?? 'Không có' }}</strong>
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-12 mb-3">
                    <p class="mb-0">Lý do đến khám: <strong>{{ implode(', ', $info->requirements ?? []) }}</strong></p>
                    <p class="mb-0">Chẩn đoán sơ bộ: <strong>{{ $info->prelim_diag }}</strong></p>
                </div>
                <div class="col-12">
                    <h5 class="text-uppercase">Thuốc điều trị</h5>
                </div>
            </div>
            <div class="row">
                @foreach ($prescription->prescription_details as $index => $prescription_detail)
                    <div class="col-7 py-2 border-bottom">
                        <strong>{{ $index + 1 }}. {{ $prescription_detail->medicine->name }}</strong> <br />
                        {{ $prescription_detail->dosage }} {{ $prescription_detail->medicine->_variable->units->where('rate', 1)->first()->term }}/lần - {{ $prescription_detail->frequency }} lần/ngày
                    </div>
                    <div class="col-5 py-2 border-bottom">
                        <strong>{{ $prescription_detail->quantity }} </strong> ngày - {{ $prescription_detail->route }} <br />
                        <!-- Hiện ghi chú liều dùng -->
                        <smail>{!! nl2br($prescription_detail->note) !!}</smail>
                    </div>
                @endforeach
            </div>

            <div class="row justify-content-between align-items-star my-3">
                <div class="col-6 pt-3 text-star">
                    <p class="mt-3">
                        <strong>Lời dặn:</strong><br />
                        {{ $prescription->message }}
                    </p>
                </div>
                <div class="col-5 pt-3 text-center">
                    <p>
                        ........., {{ Carbon\Carbon::now()->format('\n\g\à\y d \t\h\á\n\g m \n\ă\m Y') }}<br />
                        <strong>Người phát thuốc</strong><br />
                    </p>
                    <div class="d-flex my-5">
                        <!-- Chữ ký BS  -->
                    </div>
                    <p class="mb-5">
                        <em><strong>{{ $info->_doctor->name }}</strong></em>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
