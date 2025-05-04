@php
    $settings = cache()->get('settings_' . Auth::user()->company_id);
    $info = $microscope->info;
    $pet = $info->_pet;
    $customer = $info->_pet->_customer;
@endphp
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="microscope-modal-label">PHIẾU SOI KÍNH HIỂN VI {{ $microscope->code }}</h1>
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
                        <p class="mb-0">KTV thực hiện: <strong>{{ $microscope->technician_id ? $microscope->technician->name : '' }}</strong></p>
                    </div>
                    <div class="col-12 text-center">
                        <h5 class="text-uppercase">PHIẾU SOI KÍNH HIỂN VI {{ $microscope->code }}</h5>
                    </div>
                </div>
                <div class="row justify-content-between">
                    <div class="col-12">
                        <p class="border-bottom pb-2">Nội dung: <strong>{{ $microscope->detail->_service->name }}</strong></p>
                        <p class="border-bottom pb-2">Mẫu kiểm tra: <strong>{{ $microscope->sample }}</strong></p>
                        <p class="border-bottom pb-2">Phương pháp kiểm tra: <strong>{{ $microscope->method }}</strong></p>
                        <p class="border-bottom pb-2">Kết luận: <strong>{{ $microscope->conclusion }}</strong></p>
                        <p class="border-bottom pb-2">Khuyến cáo: <strong>{{ $microscope->recommendation }}</strong></p>
                    </div>
                </div>
                <div class="row align-items-center" data-gallery="">
                    <div class="col-12">
                        <p class="mb-0">Hình ảnh</p>
                    </div>
                    @if ($microscope->galleryUrl)
                        @foreach ($microscope->galleryUrl as $e => $gallery)
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
            <button class="btn btn-primary text-decoration-none btn-print print-microscope" data-id="{{ $microscope->id }}" data-url="{{ getPath(route('admin.microscope')) }}" type="button">
                <i class="bi bi-printer-fill"></i> In phiếu
            </button>

            @if (!empty(Auth::user()->hasAnyPermission(App\Models\User::UPDATE_MICROSCOPE)))
                <button class="btn btn-primary text-decoration-none btn-update-microscope" data-bs-dismiss="modal" data-id="{{ $microscope->id }}" type="button" aria-label="Close">
                    <i class="bi bi-pencil-square"></i> Cập nhật
                </button>
            @endif
        </div>
    </div>
</div>
