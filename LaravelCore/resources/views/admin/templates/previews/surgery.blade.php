@php
    $settings = cache()->get('settings_' . Auth::user()->company_id);
    $info = $surgery->info;
    $pet = $info->_pet;
    $customer = $info->_pet->_customer;
@endphp
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="surgerys-modal-label">Phiếu Phẫu Thuật {{ $surgery->code }}</h1>
            <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="container">
                <div class="row my-3">
                    <div class="col-12 col-md-5 mb-2">
                        <p class="mb-0 pe-2">Thú cưng: <strong>{{ $pet->name }}</strong></p>
                        <p class="mb-0 pe-2">Loài: <strong>{{ $pet->animal->specie . ' ' . $pet->genderStr }}</strong></p>
                        <p class="mb-0 pe-2">Tuổi: <strong>{{ $pet->birthday ? (new DateTime($pet->birthday))->diff(new DateTime())->m . ' (tháng)' : 'Không rõ' }} </strong></p>
                        <p class="mb-0 pe-2">Triệt sản: <strong>{{ $pet->neuterStr }}</strong></p>
                    </div>
                    <div class="col-12 col-md-7 mb-2">
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
                    <div class="col-12 text-center">
                        <h5 class="text-uppercase">PHIẾU PHẪU THUẬT {{ $surgery->code }}</h5>
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
                            <div class="table-responsive">
                                <table class="table key-table">
                                    <thead>
                                        {!! $surgery->table_details['head'] !!}
                                    </thead>
                                    <tbody>
                                        {!! $surgery->table_details['body'] !!}
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                    <div class="col-12 col-lg-6">
                        <p class="mb-1">Hình ảnh trước phẫu thuật</p>
                        <div class="row align-items-center border border-light-subtle rounded-1 m-0">
                            @if ($surgery->images_before)
                                @foreach ($surgery->galleryUrl['before'] as $e => $gallery)
                                    <div class="col-6 col-lg-4 mt-1">
                                        <div class="card card-image mb-1">
                                            <div class="ratio ratio-1x1">
                                                <img class="thumb img-fluid object-fit-cover cursor-pointer rounded" src="{{ $gallery }}" alt="Ảnh trước phẫu thuật - {{ $e }}">
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <p class="mb-1">Hình ảnh sau phẫu thuật</p>
                        <div class="row align-items-center border border-light-subtle rounded-1 m-0">
                            @if ($surgery->images_after)
                                @foreach ($surgery->galleryUrl['after'] as $i => $gallery)
                                    <div class="col-6 col-lg-4 mt-1">
                                        <div class="card card-image mb-1">
                                            <div class="ratio ratio-1x1">
                                                <img class="thumb img-fluid object-fit-cover cursor-pointer rounded" src="{{ $gallery }}" alt="Ảnh sau phẫu thuật - {{ $i }}">
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="col-12">
                        <p>Lời dặn của BS: <strong> {!! nl2br($surgery->advice) !!} </strong></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-primary text-decoration-none btn-print print-commitment" data-template="commitment_a5" data-id="{{ $info->id }}" data-url="{{ getPath(route('admin.info')) }}" type="button">
                <i class="bi bi-printer-fill"></i> In cam kết
            </button>
            <button class="btn btn-primary text-decoration-none btn-print print-surgery" data-id="{{ $surgery->indication->detail->service->id }}" data-url="{{ getPath(route('admin.surgery')) }}" type="button">
                <i class="bi bi-printer-fill"></i> In phiếu
            </button>

            @if (!empty(Auth::user()->hasAnyPermission(App\Models\User::UPDATE_SURGERY)))
                <button class="btn btn-primary text-decoration-none btn-update-surgery" data-bs-dismiss="modal" data-id="{{ $surgery->id }}" type="button" aria-label="Close">
                    <i class="bi bi-pencil-square"></i> Cập nhật
                </button>
            @endif
        </div>
    </div>
</div>
