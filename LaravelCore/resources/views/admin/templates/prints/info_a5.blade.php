@php
    $settings = cache()->get('settings_' . Auth::user()->company_id);
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
                <h4 class="text-uppercase">PHIẾU KHÁM LÂM SÀNG</h4>
            </div>
            <div class="row mb-2">
                <div class="col-12 col-md-5 mb-2">
                    <small class="mb-0 pe-2">Thú cưng: <strong>{{ $pet->name }}</strong></small><br />
                    <small class="mb-0 pe-2">Loài: <strong>{{ $pet->animal->specie . '(' . $pet->genderStr ?? 'Không rõ loài' . ')' }}</strong></small><br />
                    <small class="mb-0 pe-2">Tuổi: <strong> {{ $pet->age ?? 'Không rõ' }} </strong></small><br />
                    <small class="mb-0 pe-2">Triệt sản: <strong>{{ $pet->neuterStr }} </strong></small><br />
                </div>
                <div class="col-12 col-md-7 mb-2">
                    <small class="mb-0">Khách hàng: <strong>{{ $customer->name }}</strong></small><br />
                    <small class="mb-0">Điện thoại: <strong>{{ $customer->phone ?? 'Không có' }}</strong></small><br />
                    <small class="mb-0">Địa chỉ: <strong>{{ $customer->address ?? 'Không có' }}</strong></small><br />
                </div>
            </div>
            <div class="row">
                <div class="col-12 mb-3">
                    <p class="mb-0">Lý do đến khám: <strong>{{ $info->requirements->join(', ') }}</strong></p>
                    <p class="mb-0">Chẩn đoán sơ bộ: <strong>{{ $info->prelim_diag }}</strong></p>
                </div>
                <div class="col-12">
                    <h5 class="text-uppercase">Thông tin khám</h5>
                </div>
            </div>
            <div class="row align-self-stretch align-items-end">
                <div class="col-6 pb-1 mb-2">
                    <div class="d-flex justify-content-between border-bottom py-1">
                        <strong class="float-start">Bệnh sử: </strong>
                        <span class="float-end">{{ $info->history ?? 'Không có' }}</span>
                    </div>
                </div>
                <div class="col-6 pb-1 mb-2">
                    <div class="d-flex justify-content-between border-bottom py-1">
                        <strong class="float-start">Lý do đến khám: </strong>
                        <span class="float-end">{{ implode(', ', $info->requirements) }}</span>
                    </div>
                </div>
                <div class="col-6 pb-1 mb-2">
                    <div class="d-flex justify-content-between border-bottom py-1">
                        <strong class="float-start">Môi trường sống: </strong>
                        <span class="float-end">{{ $info->environment }}</span>
                    </div>
                </div>
                <div class="col-6 pb-1 mb-2">
                    <div class="d-flex justify-content-between py-1">
                        <strong class="float-start">Thân nhiệt: </strong>
                        <span class="float-end">{{ $info->temperature }}°C</span>
                    </div>
                </div>
                <div class="col-6 pb-1 mb-2">
                    <div class="d-flex justify-content-between border-bottom py-1">
                        <strong class="float-start">Cân nặng: </strong>
                        <span class="float-end">{{ $info->weight }}kg</span>
                    </div>
                </div>
                <div class="col-6 pb-1 mb-2">
                    <div class="d-flex justify-content-between py-1">
                        <strong class="float-start">Chỉ số BCS: </strong>
                        <span class="float-end">{{ $info->bcs }}</span>
                    </div>
                </div>
                <div class="col-6 pb-1 mb-2">
                    <div class="d-flex justify-content-between border-bottom py-1">
                        <strong class="float-start">Thức ăn hàng ngày: </strong>
                        <span class="float-end">{{ $info->daily_food }}</span>
                    </div>
                </div>
                <div class="col-6 pb-1 mb-2">
                    <div class="d-flex justify-content-between border-bottom py-1">
                        <strong class="float-start">Thức ăn gần đây: </strong>
                        <span class="float-end">{{ $info->recent_food }}</span>
                    </div>
                </div>
            </div>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Triệu chứng</th>
                        <th>Chẩn đoán sơ bộ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach (json_decode($info->symptoms) as $index => $symptom)
                        <tr>
                            <td>{{ $symptom->name }}: {{ $symptom->measure }}</td>
                            <td>{{ implode(', ', $symptom->diseases) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="row mt-3">
                <div class="col-12 mb-2">
                    <p class="mb-0">Chẩn đoán: <strong>{{ implode(', ', $info->final_diag ?? []) }}</strong></p>
                </div>
                <div class="col-6 mb-2">
                    <p class="mb-0">Phác đồ điều trị bằng lời: <strong>{!! nl2br($info->treatment_plan) !!}</strong></p>
                </div>
                <div class="col-6 mb-2">
                    <p class="mb-0">Lời dặn: <strong>{!! nl2br($info->advice) !!}</strong></p>
                </div>
                <div class="col-6 mb-2">
                    <p class="mb-0">Tiên lượng: <strong>{!! nl2br($info->prognosis) !!}</strong></p>
                </div>
                <div class="col-6 mb-2">
                    <p class="mb-0">Ghi chú: <strong>{!! nl2br($info->note) !!}</strong></p>
                </div>
            </div>
            <div class="row border-top justify-content-between my-3">
                <div class="col-5 pt-3 text-center">
                    <p class="mt-3">
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
                        <em><strong>{{ $info->_doctor->name }}</strong></em>
                    </p>
                </div>
            </div>
        </div>
    </div>
