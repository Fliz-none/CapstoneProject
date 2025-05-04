@php
    $settings = cache()->get('settings_' . Auth::user()->company_id);
    $pet = $info->_pet;
    $customer = $info->_pet->_customer;
    $order = $info->detail->_order;
@endphp
<div class="modal-dialog modal-xl">
    <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="order-modal-label">Phiếu khám: <strong>{{ $info->code }}</h1>
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
                            <span class="float-end">{!! nl2br($info->history) ?? 'Không có' !!}</span>
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
                @if (count(json_decode($info->symptoms)))
                    <table class="table table-bordered table-hover">
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
                                    <td>{{ implode(', ', $symptom->diseases ?? ['Chưa ghi nhận bất thường']) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
                <div class="row mt-3">
                    <div class="col-12 mb-3 border-bottom">
                        <p class="mb-0"><strong>Chẩn đoán:</strong> {{ implode(', ', $info->final_diag ?? []) }}</p>
                    </div>
                    @if ($info->treatment_plan)
                        <div class="col-12 col-lg-6 mb-3 border-bottom">
                            <p class="mb-0"><strong>Phác đồ điều trị bằng lời:</strong> {!! nl2br($info->treatment_plan) ?? 'Không có' !!}</p>
                        </div>
                    @endif
                    @if ($info->advice)
                        <div class="col-12 col-lg-6 mb-3 border-bottom">
                            <p class="mb-0"><strong>Lời dặn:</strong> {!! nl2br($info->advice) ?? 'Không có' !!}</p>
                        </div>
                    @endif
                    @if ($info->prognosis)
                        <div class="col-12 col-lg-6 mb-3">
                            <p class="mb-0"><strong>Tiên lượng:</strong> {!! nl2br($info->prognosis) ?? 'Không có' !!}</p>
                        </div>
                    @endif
                    @if ($info->note)
                        <div class="col-12 col-lg-6 mb-3">
                            <p class="mb-0"><strong>Ghi chú:</strong> {!! nl2br($info->note) ?? 'Không có' !!}</p>
                        </div>
                    @endif
                </div>
                <div class="table-responsive">
                    <table class="table table-wide table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Tên dịch vụ</th>
                                <th class="text-end">Chức năng</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($info->indications->count())
                                @foreach ($info->indications as $index => $indication)
                                    @php
                                        $ticket = optional($indication->detail->_service)->ticket;
                                        if ($indication->has_booking) {
                                            $class = 'btn-update-booking';
                                            $color = 'text-info';
                                            $title = 'Đã có lịch hẹn';
                                        } else {
                                            $class = 'btn-create-booking';
                                            $color = 'text-success';
                                            $title = 'Chưa có lịch hẹn';
                                        }
                                        $booking_btn =
                                            '<a class="btn btn-link text-decoration-none ' .
                                            $class .
                                            '" data-id="' .
                                            optional($indication->has_booking)->id .
                                            '" data-service_id="' .
                                            $indication->detail->service_id .
                                            '" data-doctor_id="' .
                                            $indication->info->doctor_id .
                                            '" data-pet_id="' .
                                            $indication->info->pet_id .
                                            '">
                                            <i class="bi bi-calendar-check ' .
                                            $color .
                                            '" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="' .
                                            $title .
                                            '"></i>
                                        </a>';
                                    @endphp
                                    <tr>
                                        <td>
                                            {{ $indication->detail->_service->name }}
                                            <small>{{ $indication->detail->note ? ' (' . $indication->detail->note . ')' : '' }}<small>
                                        </td>
                                        <td class="text-end">
                                            {{-- @if ($ticket && isset($indication->$ticket))
                                                <a class="btn btn-link text-decoration-none btn-preview preview-{{ $ticket }} text-info fw-bold p-0" data-id="{{ $indication->$ticket->id }}" data-url="{{ getPath(route('admin.' . $ticket)) }}"><i class="bi bi-receipt-cutoff" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Xem chi tiết phiếu"></i></a>
                                            @endif --}}
                                            @if (!$indication->export_id)
                                                <a class="btn btn-link text-decoration-none btn-indication-export" data-id="{{ $indication->id }}">
                                                    <i class="icon-mid bi bi-dropbox" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Xuất vật tư tiêu hao"></i>
                                                </a>
                                            @endif
                                            @if (Auth::user()->can(App\Models\User::READ_BOOKING))
                                                {!! $booking_btn !!}
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            @if (optional($info->prescriptions)->toArray())
                                @foreach ($info->prescriptions ?? [] as $prescription)
                                    @php
                                        $booking_btn = '<a class="btn btn-link text-decoration-none btn-create-booking" data-service_id="' . $prescription->detail->service_id . '" data-doctor_id="' . $prescription->_info->doctor_id . '" data-pet_id="' . $prescription->_info->pet_id . '">
                                            <i class="bi bi-calendar-check text-success" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Tạo lịch hẹn"></i>
                                            </a>';
                                    @endphp
                                    <tr>
                                        <td>
                                            {{ $prescription->detail->_service->name }} <small>{{ $prescription->detail->note ? ' (' . $prescription->detail->note . ')' : '' }}<small>
                                        </td>
                                        <td class="text-end">
                                            <a class="btn btn-link text-decoration-none btn-preview preview-prescription text-info fw-bold" data-id="{{ $prescription->id }}" data-url="{{ getPath(route('admin.prescription')) }}" data-bs-dismiss="modal" type="button" aria-label="Close">
                                                <i class="bi bi-receipt-cutoff" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Xem chi tiết đơn thuốc"></i>
                                            </a>
                                            @if (!$prescription->export_id)
                                                <a class="btn btn-link text-decoration-none btn-prescription-export" data-id="{{ $prescription->id }}">
                                                    <i class="bi bi-capsule-pill text-success" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Xuất đơn thuốc"></i>
                                                </a>
                                            @endif
                                            @if (Auth::user()->can(App\Models\User::READ_BOOKING))
                                                {!! $booking_btn !!}
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            @if (!$info->indications->count() && !$info->prescriptions->count())
                                <tr>
                                    <td class="text-center" colspan="2">
                                        <span class="text-secondary">Chưa có dịch vụ nào</span>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            @if (Auth::user()->can(App\Models\User::UPDATE_ORDER))
                <button class="btn btn-outline-danger btn-update-order" data-id="{{ $order->id }}" data-bs-dismiss="modal" type="button" aria-label="Close">
                    <i class="bi bi-pencil-square"></i> Xem đơn hàng
                </button>
            @else
                @if (Auth::user()->can(App\Models\User::READ_ORDER))
                    <a class="btn btn-outline-danger btn-preview preview-order" data-url="{{ getPath(route('admin.order')) }}" data-id="{{ $info->_detail->order_id }}">
                        <i class="bi bi-archive"></i>
                        Xem đơn hàng
                    </a>
                @endif
            @endif
            <a class="btn btn-success m-1 btn-print print-info" data-id="{{ $info->id }}" data-url="{{ getPath(route('admin.info')) }}">
                <i class="bi bi-printer"></i>
                In phiếu khám
            </a>
            @if (Auth::user()->can(App\Models\User::UPDATE_INFO))
                <a class="btn btn-primary" href="{{ route('admin.info', ['key' => $info->id]) }} ">
                    <i class="bi bi-pencil-square"></i> Cập nhật
                </a>
            @endif
        </div>
    </div>
</div>
