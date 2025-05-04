@php
    $settings = cache()->get('settings_' . Auth::user()->company_id);
    $info = $surgery->info;
    $pet = $info->_pet;
    $customer = $info->_pet->_customer;
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
                    <p class="mb-0">Mã phiếu: <strong>{{ $surgery->code }}</strong></p>
                    <p class="mb-0">Phiếu khám: <strong>{{ $info->code }}</strong></p>
                    <p class="mb-0">Ngày tạo: {{ $surgery->created_at->format('d/m/Y H:i') }}</p>
                    <div class="d-flex align-items-center justify-content-start" style="height: 10.5mm; overflow: hidden;">
                        <svg id="barcode-{{ $info->code }}"></svg>
                        <input class="barcode-value" type="hidden" value="{{ $info->code }}">
                    </div>
                </div>
            </div>
            <div class="my-4 pt-3 text-center border-top">
                <h4 class="text-uppercase">Phiếu Phẫu Thuật</h4>
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
                    <h5 class="text-uppercase">Thông Tin Phiếu Phẫu Thuật </h5>
                </div>
            </div>
            <div class="row justify-content-between">
                <div class="col-6">
                    <p class="mb-0">Nội dung: <strong>{{ $surgery->detail->_service->name }}</strong></p>
                    <p class="mb-0">PP phẫu thuật: <strong>{{ $surgery->surgical_method }}</strong></p>
                    <p class="mb-0">PP gây mê, gây tê: <strong>{{ $surgery->anesthesia_method }}</strong></p>
                    <p class="mb-0">Thời gian bắt đầu: <strong>{{ $surgery->begin_at }}</strong></p>
                </div>
                <div class="col-6">
                    <p class="mb-0">BS phẫu thuật: <strong>{{ optional($surgery->surgeon)->name }}</strong></p>
                    <p class="mb-0">BS phụ: <strong>{{ optional($surgery->assistant)->name }}</strong></p>
                    <p class="mb-0">BS gây mê hồi sức: <strong>{{ optional($surgery->anesthetist)->name }}</strong></p>
                    <p class="mb-0">Thời gian kết thúc: <strong>{{ $surgery->complete_at }}</strong></p>
                </div>
                <div class="col-12 pt-2">
                    <p class="mb-0">Lược đồ phẫu thuật:</p>
                    @if ($surgery->diagram)
                        <table class="table">
                            <thead>
                                <tr>
                                    <th style="width:15%">Thời gian</th>
                                    <th>Trình tự thực hiện</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach (json_decode($surgery->diagram) as $diagram)
                                    <tr>
                                        <td><strong>{{ $diagram[0] }}</strong></td>
                                        <td>{{ $diagram[1] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                    <p class="mb-0">Theo dõi:</p>
                    @if ($surgery->details)
                        <table class="table key-table">
                            <thead>
                                {!! $surgery->table_details['head'] !!}
                            </thead>
                            <tbody>
                                {!! $surgery->table_details['body'] !!}
                            </tbody>
                        </table>
                    @endif
                </div>
                <div class="col-12">
                    <p>Lời dặn của BS: <strong> {!! nl2br($surgery->advice) !!} </strong></p>
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
                        <strong>Bác sĩ</strong><br />
                    </p>
                    <div class="d-flex my-5">
                        <!-- Chữ ký BS  -->
                    </div>
                    <p class="mb-5">
                        <em><strong>{{ optional($surgery->surgeon)->name }}</strong></em>
                    </p>
                </div>
            </div>
        </div>
    </div>
    @if ($surgery->images_before)
        @foreach ($surgery->galleryUrl['before'] as $e => $gallery)
            <div class="text-center py-5 w-100 h-50" style="page-break-before: always;">
                <img src="{{ $gallery }}" alt="Ảnh {{ $e + 1 }}" style="max-width: 20cm; max-height: 14cm; object-fit: cover;">
                <h4 class="mt-5">Hình ảnh trước phẫu thuật</h4>
            </div>
        @endforeach
    @endif

    @if ($surgery->images_after)
        @foreach ($surgery->galleryUrl['after'] as $i => $gallery)
            <div class="text-center py-5 w-100 h-50" style="page-break-before: always;">
                <img src="{{ $gallery }}" alt="Ảnh {{ $i + 1 }}" style="max-width: 20cm; max-height: 14cm; object-fit: cover;">
                <h4 class="mt-5">Hình ảnh sau phẫu thuật</h4>
            </div>
        @endforeach
    @endif

</div>
