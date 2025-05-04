@php
    $settings = cache()->get('settings_' . Auth::user()->company_id);
    $service = $detail->_service;
    $info = $detail->indication->info;
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
            <div class="row align-items-end">
                <div class="col-3 text-star">
                    <img class="img-fluid" src="{{ Auth::user()->company->logo_square_bw }}" alt="Logo" style="width: 150px;" />
                </div>
                <div class="col-9">
                    <h6 class="text-uppercase mb-0">{{ $settings['company_brandname'] }}</h6>
                    <small class="mb-0">{{ $settings['company_address'] }}</small><br>
                    <small class="mb-0">Website: {{ $settings['company_website'] }}</small><br>
                    <small class="mb-0">SĐT: {{ $settings['company_phone'] }}</small>
                </div>
            </div>
            <div class="my-4 pt-3 text-center">
                <h5 class="text-uppercase">PHIẾU CAM KẾT</h5>
            </div>
            <div class="row my-3">
                <div class="col-6 col-md-5 mb-2">
                    <p class="mb-0 pe-2">Thú cưng: <strong>{{ $pet->name }}</strong></p>
                    <p class="mb-0 pe-2">Loài: <strong>{{ $pet->animal->specie . '(' . $pet->genderStr . ')' }}</strong></p>
                    <p class="mb-0 pe-2">Tuổi: <strong> {{ $pet->birthday ? (new DateTime($pet->birthday))->diff(new DateTime())->m : 'Không rõ' }} </strong>(tháng)</p>
                    <p class="mb-0 pe-2">Triệt sản: <strong>{{ $pet->neuterStr }} </strong></p>
                </div>
                <div class="col-6 col-md-7 mb-2">
                    <p class="mb-0">Khách hàng: <strong>{{ $customer->name }}</strong></p>
                    <p class="mb-0">SĐT: <strong>{{ $customer->phone ?? '' }}</strong></p>
                    <p class="mb-0">Địa chỉ: <strong>{{ $customer->address ?? '' }}</strong>
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-12 mb-3">
                    <p class="">Tại cơ sở: {{ $info->_doctor->branch->name }}</p>
                    <p class="">Lý do: {{ implode(', ',$info->requirements) }}</p>
                    <p class="">Chỉ định dịch vụ: {{ $service->name }}</p>
                    <p class="pe-3">{!! nl2br($service->commitment_note) !!}</p>
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
                        <strong>Bác sĩ điều trị</strong><br />
                    </p>
                    <div class="d-flex my-5">
                        <!-- Chữ ký BS  -->
                    </div>
                    <p class="mb-5">
                        <em><strong>{{ optional($info->doctor)->name }}</strong></em>
                    </p>
                </div>
            </div>
        </div>
    </div>
