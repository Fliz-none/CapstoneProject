@php
    $settings = cache()->get('settings_' . Auth::user()->company_id);
    $info = $prescription->info;
    $pet = $info->_pet;
    $customer = $info->_pet->_customer;
    $order = $info->_detail->_order;
@endphp
<div class="modal-dialog modal-xl">
    <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="order-modal-label">Đơn thuốc: <strong>{{ $info->code }} {{ $info->name ? '(' . $info->name . ')' : '' }}</h1>
            <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="container">
                <div class="row mb-3">
                    <div class="col-12 col-lg-4">
                        <strong>Khách hàng:</strong> {{ $customer->name }}<br>
                        @if (optional($customer)->phone)
                            <strong>Số điện thoại:</strong> {{ $customer ? $customer->phone : 'Không có' }}<br>
                        @endif
                        @if (optional($customer)->address || $customer->local_id)
                            <strong>Địa chỉ:</strong> {{ $customer->fullAddress }}
                        @endif
                    </div>
                    <div class="col-12 col-lg-3">
                        <strong>Thú cưng: </strong>{{ $pet->name }} - {{ $pet->animal->specie . ' (' . ($pet->genderStr != '' ? $pet->genderStr : 'Không rõ giống') . ')' }}<br />
                        <strong>Tuổi: </strong> {{ $pet->age ?? 'Không rõ' }} <br />
                        <strong>Triệt sản: </strong>{{ $pet->neuterStr != '' ? $pet->neuterStr : 'Không rõ' }} <br />
                    </div>
                    <div class="col-12 col-lg-5">
                        <strong>Chi nhánh:</strong> {{ $order->branch->name }}<br />
                        <strong>Bác sĩ:</strong> {{ $info->doctor->name }}<br />
                        <strong>Ngày khám:</strong> {{ $order->created_at->format('d/m/Y H:i') }}<br />
                    </div>
                </div>
                <h5 class="text-uppercase">Thông tin cơ bản</h5>
                <div class="row mb-3">
                    <div class="col-12 col-lg-6">
                        <div class="d-flex justify-content-between border-bottom py-1">
                            <strong class="float-start">Bệnh sử: </strong>
                            <span class="float-end">{{ $info->history ?? 'Không có' }}</span>
                        </div>
                    </div>
                    @if ($info->requirements)
                        <div class="col-12 col-lg-6">
                            <div class="d-flex justify-content-between border-bottom py-1">
                                <strong class="float-start">Lý do đến khám: </strong>
                                <span class="float-end">{{ implode(', ', array_filter($info->requirements ?? ['Không có'])) }}</span>
                            </div>
                        </div>
                    @endif
                    @if ($info->environment)
                        <div class="col-12 col-lg-6">
                            <div class="d-flex justify-content-between border-bottom py-1">
                                <strong class="float-start">Môi trường sống: </strong>
                                <span class="float-end">{{ $info->environment }}</span>
                            </div>
                        </div>
                    @endif
                    @if ($info->temperature)
                        <div class="col-12 col-lg-6">
                            <div class="d-flex justify-content-between border-bottom py-1">
                                <strong class="float-start">Thân nhiệt: </strong>
                                <span class="float-end">{{ $info->temperature }}°C</span>
                            </div>
                        </div>
                    @endif
                    @if ($info->weight)
                        <div class="col-12 col-lg-6">
                            <div class="d-flex justify-content-between border-bottom py-1">
                                <strong class="float-start">Cân nặng: </strong>
                                <span class="float-end">{{ $info->weight }}kg</span>
                            </div>
                        </div>
                    @endif
                    @if ($info->bcs)
                        <div class="col-12 col-lg-6">
                            <div class="d-flex justify-content-between border-bottom py-1">
                                <strong class="float-start">Chỉ số BCS: </strong>
                                <span class="float-end">{{ $info->bcs }}</span>
                            </div>
                        </div>
                    @endif
                    @if ($info->daily_food)
                        <div class="col-12 col-lg-6">
                            <div class="d-flex justify-content-between border-bottom py-1">
                                <strong class="float-start">Thức ăn hàng ngày: </strong>
                                <span class="float-end">{{ $info->daily_food }}</span>
                            </div>
                        </div>
                    @endif
                    @if ($info->recent_food)
                        <div class="col-12 col-lg-6">
                            <div class="d-flex justify-content-between border-bottom py-1">
                                <strong class="float-start">Thức ăn gần đây: </strong>
                                <span class="float-end">{{ $info->recent_food }}</span>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="row mt-3">
                    <div class="col-12 mb-3 border-bottom">
                        <p class="mb-0"><strong>Chẩn đoán:</strong> {{ implode(', ', $info->final_diag ?? []) }}</p>
                    </div>
                </div>
                @if ($prescription->prescription_details->count())
                    <div class="table-responsive">
                        <table class="table table-wide table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Thuốc</th>
                                    <th>Liều dùng</th>
                                    <th>Lần dùng</th>
                                    <th>Số ngày</th>
                                    <th>Đường dùng</th>
                                    <th>Ghi chú</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($prescription->prescription_details as $index => $detail)
                                    <tr>
                                        <td class="width: 50%">
                                            {!! $detail->_medicine->fullName !!}<br />
                                            <small class="badge bg-light-info"> {!! $detail->_medicine->_variable->fullName !!} </small>
                                        </td>
                                        <td>{{ $detail->dosage }} {{ optional($detail->_medicine->_variable->_units->where('rate', 1)->first())->term ?? 'ĐVT' }}/lần</td>
                                        <td>{{ $detail->frequency }} lần/ngày</td>
                                        <td>{{ $detail->quantity }} ngày</td>
                                        <td>{{ $detail->route }}</td>
                                        <td>{{ $detail->note }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
        <div class="modal-footer">
            @if (Auth::user()->can(App\Models\User::UPDATE_INFO))
                <a class="btn btn-primary" href="{{ route('admin.info', ['key' => $info->id]) }}">
                    <i class="bi bi-pencil-square"></i> Xem phiếu khám
                </a>
            @else
                @if (Auth::user()->can(App\Models\User::READ_INFO))
                    <a class="btn btn-primary btn-preview preview-info" data-url="{{ getPath(route('admin.info')) }}" data-id="{{ $info->id }}" data-bs-dismiss="modal" type="button" aria-label="Close">
                        <i class="bi bi-archive"></i>
                        Xem phiếu khám
                    </a>
                @endif
            @endif
            {{-- <a class="btn btn-success m-1 btn-print print-prescription" data-id="{{ $prescription->id }}" data-url="{{ getPath(route('admin.prescription')) }}">
                <i class="bi bi-printer"></i>
                In đơn thuốc
            </a> --}}
            <a class="btn btn-success btn-prescription-export" data-id="{{ $prescription->id }}">
                <i class="bi bi-capsule-pill" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Xuất đơn thuốc"></i>
                Xuất đơn thuốc
            </a>
        </div>
    </div>
</div>
