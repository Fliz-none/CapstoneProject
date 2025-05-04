@php
    $settings = cache()->get('settings_' . Auth::user()->company_id);
    $info = $xray->info;
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
                    <p class="mb-0">Mã phiếu: <strong>{{ $xray->code }}</strong></p>
                    <p class="mb-0">Phiếu khám: <strong>{{ $info->code }}</strong></p>
                    <p class="mb-0">Ngày tạo: {{ $xray->created_at->format('d/m/Y H:i') }}</p>
                    <div class="d-flex align-items-center justify-content-start" style="height: 10.5mm; overflow: hidden;">
                        <svg id="barcode-{{ $info->code }}"></svg>
                        <input class="barcode-value" type="hidden" value="{{ $info->code }}">
                    </div>
                </div>
            </div>
            <div class="my-4 pt-3 text-center border-top">
                <h4 class="text-uppercase">Phiếu X-Quang</h4>
            </div>
            <div class="row my-3">
                <div class="col-5 mb-2">
                    <p class="mb-0 pe-2">Thú cưng: <strong>{{ $pet->name }}</strong></p>
                    <p class="mb-0 pe-2">Loài: <strong>{{ $pet->animal->specie . ' ' . $pet->genderStr }}</strong></p>
                    <p class="mb-0 pe-2">Tuổi: <strong> {{ $pet->age ?? 'Không rõ' }} </strong></p>
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
                    <p class="mb-0">Bác sĩ chỉ định: <strong>{{ $info->_doctor->name }}</strong></p>
                </div>
                <div class="col-12">
                    <h5 class="text-uppercase">Thông Tin Phiếu X-Quang </h5>
                </div>
            </div>
            <div class="row justify-content-between">
                <div class="col-12">
                    <p class="mb-0">Nội dung: <strong>{{ $xray->detail->_service->name }}</strong></p>
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="width: 15%">Kết quả:</th>
                                <th> </th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($xray->details)
                                @foreach (json_decode($xray->details, true) as $index => $detail)
                                    <tr>
                                        <td><strong>{{ $detail['name'] }}</strong></td>
                                        <td>{!! nl2br($detail['note']) !!}</td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                    <p class="mb-0">Kết luận: <strong> {!! nl2br($xray->conclusion) !!} </strong>
                </div>
            </div>

            <div class="row border-top justify-content-between my-3">
                <div class="col-5 pt-3 text-center">
                    <p class="mt-4">
                        <strong>Khách hàng</strong><br /><em>(Ký nhận)</em>
                        <!-- Chữ ký KH  -->
                    </p>
                </div>
                <div class="col-5 pt-3 text-center">
                    <p>
                        ........., {{ Carbon\Carbon::now()->format('\n\g\à\y d \t\h\á\n\g m \n\ă\m Y') }}<br />
                        <strong>Kỹ thuật viên</strong><br />
                    </p>
                    <div class="d-flex my-5">
                        <!-- Chữ ký BS  -->
                    </div>
                    <p class="mb-5">
                        <em><strong>{{ optional($xray->technician)->name }}</strong></em>
                    </p>
                </div>
            </div>
        </div>
    </div>
    @if ($xray->details)
        @foreach (json_decode($xray->details, true) as $e => $detail)
            @if (isset($detail['images']))
                @foreach ($xray->galleryUrl[$e] as $e => $gallery)
                    <div class="d-flex flex-column align-items-center py-5 mt-5 w-100 h-100" style="page-break-before: always;">
                        <img src="{{ $gallery }}" alt="{{ $detail['name'] }}" style="max-width: 20cm; max-height: 29cm; object-fit: cover;">
                        <div class="w-100 px-5 text-start">
                            <h4 class="fw-bold mt-4">{{ $detail['name'] }}</h4>
                            <p>{{ $detail['note'] }}</p>
                        </div>
                    </div>
                @endforeach
            @endif
        @endforeach
    @endif
</div>
