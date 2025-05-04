@php
    $settings = cache()->get('settings_' . Auth::user()->company_id);
    $info = $beauty->indication->info;
    $pet = $info->_pet;
    $customer = $info->_pet->_customer;
@endphp
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="beauty-modal-label">Phiếu Spa - Grooming {{ $beauty->code }}</h1>
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
                        <p class="mb-0">KTV thực hiện: <strong>{{ $beauty->technician_id ? $beauty->technician->name : '' }}</strong></p>
                    </div>
                    <div class="col-12 text-center">
                        <h5 class="text-uppercase">Phiếu Spa - Grooming {{ $beauty->code }}</h5>
                    </div>
                </div>
                <div class="row justify-content-between">
                    <div class="col-12">
                        <p class="border-bottom pb-2">Nội dung: <strong>{{ $beauty->indication->detail->_service->name }}</strong></p>
                        <div class="table-responsive">
                            <table class="table key-table" style="min-width: 500px">
                                <thead>
                                    <tr>
                                        <th>Chỉ tiêu</th>
                                        <th class="text-center" style="width: 18%">Đánh giá</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="beauty-detail" data-criterial-id="">
                                        <td><strong>Tắm</strong>
                                        </td>
                                        <td class="text-center">
                                            <input class="form-check-input criterial-review" id="beauty_detail[0][review]" name="beauty_detail[0][review]" type="checkbox" value="">
                                            <label class="form-check-label" for="beauty_detail[0][review]">
                                                Đạt
                                            </label>
                                        </td>
                                        <td>
                                            <button class="btn btn-link text-decoration-none btn-remove-criterial">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr class="beauty-detail" data-criterial-id="">
                                        <td><strong>Chải lông</strong>
                                        </td>
                                        <td class="text-center">
                                            <input class="form-check-input criterial-review" id="beauty_detail[1][review]" name="beauty_detail[1][review]" type="checkbox" value="">
                                            <label class="form-check-label" for="beauty_detail[1][review]">
                                                Đạt
                                            </label>
                                        </td>
                                        <td>
                                            <button class="btn btn-link text-decoration-none btn-remove-criterial">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <p class="border-bottom pb-2">Ghi chú: <strong>...</strong></p>
                    </div>
                </div>
                <div class="row align-items-center" data-gallery="">
                    <div class="col-12">
                        <p class="mb-0">Hình ảnh</p>
                    </div>
                    @if ($beauty->galleryUrl)
                        @foreach ($beauty->galleryUrl as $e => $gallery)
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
            <button class="btn btn-primary text-decoration-none btn-print print-beauty" data-id="{{ $beauty->id }}" data-url="{{ getPath(route('admin.beauty')) }}" type="button">
                <i class="bi bi-printer-fill"></i> In phiếu
            </button>

            @if (!empty(Auth::user()->hasAnyPermission(App\Models\User::UPDATE_BEAUTIES)))
                <button class="btn btn-primary text-decoration-none btn-update-beauty" data-bs-dismiss="modal" data-id="{{ $beauty->id }}" type="button" aria-label="Close">
                    <i class="bi bi-pencil-square"></i> Cập nhật
                </button>
            @endif
        </div>
    </div>
</div>
