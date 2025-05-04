@php
    $settings = cache()->get('settings_' . Auth::user()->company_id);
    $info = $bloodcell->info;
    $pet = $info->_pet;
    $customer = $info->_pet->_customer;
@endphp
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="bloodcell-modal-label">Phiếu Xét Nghiệm Tế Bào Máu {{ $bloodcell->code }}</h1>
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
                        <p class="mb-0">KTV thực hiện: <strong>{{ $bloodcell->technician_id ? $bloodcell->technician->name : '' }}</strong></p>
                    </div>
                    <div class="col-12 text-center">
                        <h5 class="text-uppercase">Phiếu Xét Nghiệm Tế Bào Máu {{ $bloodcell->code }}</h5>
                    </div>
                </div>
                <div class="row justify-content-between">
                    <div class="col-12">
                        <p class="border-bottom pb-2">Nội dung: <strong>{{ $bloodcell->detail->_service->name }}</strong></p>
                        <div class="table-responsive">
                            <table class="table key-table" style="min-width: 500px">
                                <thead>
                                    <tr>
                                        <th>Chỉ tiêu</th>
                                        <th class="text-center" style="width: 18%">Kết quả</th>
                                        <th class="text-center" style="width: 18%">Đánh giá</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($bloodcell->details)
                                        @foreach (json_decode($bloodcell->details, true) as $index => $detail)
                                            @php
                                                $normal_index = json_decode($detail['normal_index']);
                                                $min = $normal_index ? $normal_index[0] : '';
                                                $max = $normal_index ? $normal_index[1] : '';
                                            @endphp
                                            <tr>
                                                <td><strong>{{ $detail['name'] }}</strong> {{ $min !== '' && $max !== '' ? ' • ' . $min . ' - ' . $max : '' }} (%)
                                                    <br><small>{{ $detail['description'] }}</small>
                                                </td>
                                                <td class="text-center">{{ $detail['result'] }}</td>
                                                <td class="text-center">{{ $detail['review'] }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <p class="border-bottom pb-2">Kết luận: <strong>{!! nl2br($bloodcell->conclusion) !!}</strong></p>
                        <p class="border-bottom pb-2">Khuyến cáo: <strong>{!! nl2br($bloodcell->recommendation) !!}</strong></p>
                    </div>
                </div>
                <div class="row align-items-center" data-gallery="">
                    <div class="col-12">
                        <p class="mb-0">Hình ảnh</p>
                    </div>
                    @if ($bloodcell->galleryUrl)
                        @foreach ($bloodcell->galleryUrl as $e => $gallery)
                            <div class="col-6 col-lg-2 mt-2">
                                <div class="card card-image mb-1">
                                    <div class="ratio ratio-1x1">
                                        <img class="thumb img-fluid object-fit-cover cursor-pointer rounded" src="{{ $gallery }}">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-primary text-decoration-none btn-print print-bloodcell" data-id="{{ $bloodcell->id }}" data-url="{{ getPath(route('admin.bloodcell')) }}" type="button">
                <i class="bi bi-printer-fill"></i> In phiếu
            </button>

            @if (!empty(Auth::user()->hasAnyPermission(App\Models\User::UPDATE_BLOODCELL)))
                <button class="btn btn-primary text-decoration-none btn-update-bloodcell" data-bs-dismiss="modal" data-id="{{ $bloodcell->id }}" type="button" aria-label="Close">
                    <i class="bi bi-pencil-square"></i> Cập nhật
                </button>
            @endif
        </div>
    </div>
</div>
