{{-- Modal Info --}}
@php
    $path = Request::path();
    $pattern = '/^quantri\/info\/(new|expand|\d+)$/';
@endphp

@if (!preg_match($pattern, $path))
    <form class="save-form" id="info-form" method="post">
        @csrf
        <div class="modal fade" id="info-modal" data-bs-backdrop="static" aria-labelledby="info-modal-label">
            <div class="modal-dialog modal-xl modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header bg-info">
                        <h1 class="modal-title fs-5 text-white" id="info-modal-label">Phiếu khám</h1>
                        <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <section class="section">
                            <div class="row mb-3">
                                {{-- Thông tin khách hàng  --}}
                                <div class="col-12 col-lg-3 mb-3 mb-lg-0">
                                    <div class="card border h-100 mb-0">
                                        <div class="card-body" style="min-height: 373px">
                                            <div class="ajax-search">
                                                <label class="col-form-label fw-bold" for="info-customer_search">
                                                    <span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Thông tin khách hàng">Chọn khách hàng</span>
                                                </label>
                                                <div class="search-form">
                                                    <input class="form-control customer-information search-input" id="info-customer_search" data-url="{{ route('admin.user') }}?key=search" onclick="this.select()" placeholder="Tìm khách hàng"
                                                        autocomplete="off">
                                                </div>
                                                <ul class="list-customer-suggest overflow-auto search-result ps-0 mt-1" style="max-height: 330px"></ul>
                                            </div>
                                            <div class="form-group p-2 customer-suggestions"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-9">
                                    <div class="card border h-100 mb-0">
                                        <div class="card-body">
                                            <label class="col-form-label fw-bold">
                                                <span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Danh sách thú cưng của khách hàng">Chọn thú cưng</span>
                                                <button class="btn bg-white btn-refresh-list-pet ms-1 px-1 py-0" data-check="" type="button">
                                                    <i class="bi bi-arrow-repeat text-primary fs-5" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Tải lại danh sách"></i>
                                                </button>
                                            </label>
                                            <div class="row overflow-auto flex-nowrap align-items-stretch" id="pet-slider">
                                                <div class="col-6 col-md-4 col-lg-3 my-2">
                                                    <a class="btn-empty cursor-pointer">
                                                        <div class="card card-image add-gallery ratio ratio-1x1 rounded-3 mb-2 h-100" style="min-height: 260px">
                                                            <i class="bi bi-plus"></i>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- Info form --}}
                            <div class="card border mb-2">
                                <div class="card-body" style="min-height: 250px">
                                    <div class="row mb-4">
                                        <div class="col-12 mb-4">
                                            @php
                                                $fix_options = ['Khám bệnh', 'Cấp cứu', 'Xổ giun', 'Làm đẹp', 'Tiêm phòng', 'Lưu trú', 'Thai sản'];
                                            @endphp
                                            <label class="form-label fw-bold text-info" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Yêu cầu của khách hàng" for="info-requirements">
                                                Lý do đến khám
                                            </label>
                                            <div class="d-flex align-items-center">
                                                <div class="btn-group btn-group-column w-100">
                                                    @foreach ($fix_options as $i => $option)
                                                        <input class="btn-check @error('requirements') is-invalid @enderror" id="info-requirements-{{ $i }}" name="requirements[]" type="checkbox" value="{{ $option }}">
                                                        <label class="btn btn-outline-info mb-1" for="info-requirements-{{ $i }}">{{ $option }}</label>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <input class="form-control mt-2" id="info-requirements-other" name="requirements[]" placeholder="Lý do khác">
                                        </div>
                                        <div class="col-12 col-md-4 mb-4">
                                            <label class="form-label fw-bold text-info" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Môi trường sống của thú cưng" for="captive-environment">
                                                Môi trường sống
                                            </label>
                                            <div class="btn-group w-100">
                                                <input class="btn-check" id="captive-environment" name="environment" type="radio" value="Nuôi nhốt">
                                                <label class="btn btn-outline-info" for="captive-environment">Nuôi nhốt</label>
                                                <input class="btn-check" id="free-range-environment" name="environment" type="radio" value="Nuôi thả">
                                                <label class="btn btn-outline-info" for="free-range-environment">Nuôi thả</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-4 mb-4">
                                            <label class="form-label fw-bold text-info" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Cân nặng hiện tại của thú cưng" for="info-weight">
                                                Cân nặng
                                            </label>
                                            <div class="input-group">
                                                <input class="form-control rounded-0 rounded-start" id="info-weight" name="weight" type="text" placeholder="Nhập số thập phân" autocomplete="off">
                                                <span class="input-group-text rounded-0 rounded-end">kg</span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-4 mb-4">
                                            <label class="form-label fw-bold text-info" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Nhiệt độ cơ thể hiện tại của thú cưng" for="info-temperature">
                                                Thân nhiệt
                                            </label>
                                            <div class="input-group">
                                                <input class="form-control rounded-0 rounded-start @error('temperature') is-invalid @enderror" id="info-temperature" name="temperature" type="text" placeholder="Nhập số thập phân"
                                                    autocomplete="off" required>
                                                <span class="input-group-text rounded-0 rounded-end">°C</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card border shadow-none mb-3">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12 col-lg-3">
                                                    <div class="ajax-search" style="max-height: 550px">
                                                        <div class="input-group mb-3 position-relative search-form">
                                                            <input class="form-control search-input" id="service-select" data-url="{{ route('admin.service') }}?key=search&type=is_indicated" placeholder="Tìm kiếm dịch vụ..." autocomplete="off">
                                                        </div>
                                                        <div class="info-services overflow-auto" style="max-height: 250px">
                                                            <ul class="list-group search-result">
                                                                @foreach (cache()->get('services_' . Auth::user()->company_id)->where('is_indicated', 1) as $service)
                                                                    @php
                                                                        $symptomNames = $service->symptoms->pluck('name')->implode(', ');
                                                                    @endphp
                                                                    <li class="list-group-item list-group-item-action cursor-pointer info-service rounded-3 border-0" data-symptom="{{ $symptomNames }}" data-price="{{ $service->price }}"
                                                                        data-id="{{ $service->id }}">
                                                                        {{ $service->name }}
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-9">
                                                    <table class="table table-hover table-striped mb-4">
                                                        <thead>
                                                            <tr>
                                                                <th class="text-info">Chỉ định dịch vụ</th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="info-indications">
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer footer-fixed">
                                    <div class="row">
                                        <div class="col-12 col-md-3 mb-3">
                                            @php
                                                $services = cache()->get('services_' . Auth::user()->company_id)->where('ticket', 'info');
                                            @endphp
                                            <select class="form-select" id="info-service_id" name="service_id">
                                                @if ($services->count())
                                                    @foreach ($services as $key => $service)
                                                    @php
                                                        $is_selected = '';
                                                        if (cache()->get('settings_' . Auth::user()->company_id)['default_info_service'] == $service->id) {
                                                            $is_selected = 'selected';
                                                        }
                                                    @endphp
                                                        <option value="{{ $service->id }}" {{ $is_selected }}>
                                                            {{ $service->name }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        <div class="col-12 col-md-6 mb-3">
                                            <div class="d-flex align-items-center" style="height: 40px">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" id="info-type-clinic" name="type" type="radio" value="1" checked>
                                                    <label class="form-check-label" for="info-type-clinic">
                                                        Tại phòng khám
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" id="info-type-home" name="type" type="radio" value="2">
                                                    <label class="form-check-label" for="info-type-home">
                                                        Tại nhà
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" id="info-type-online" name="type" type="radio" value="3">
                                                    <label class="form-check-label" for="info-type-online">
                                                        Online
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-3 mb-3">
                                            <div class="text-end">
                                                <input name="order_id" type="hidden" value="">
                                                <input name="id" type="hidden" value="">
                                                <input name="pet_id" type="hidden" value="">
                                                <input name="customer_id" type="hidden" value="">
                                                <button class="btn btn-outline-info btn-expand-info" type="button"><i class="bi bi-arrows-angle-expand"></i> Mở rộng</button>
                                                <button class="btn btn-info m-1" data-text='<i class="bi bi-floppy me-2"></i> Lưu' type="submit">
                                                    <i class="bi bi-floppy"></i> Lưu
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endif

{{-- Modal Symptoms --}}
<div class="modal fade" id="info_symptoms-modal" aria-labelledby="info_symptoms-modal-label">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h1 class="modal-title text-white fs-5" id="info_symptoms-modal-label">Quy trình thăm khám</h1>
                <button class="btn-close text-white" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="input-group mb-3 position-relative search-container">
                    <input class="form-control" id="symptom-select" placeholder="Tìm triệu chứng...">
                </div>
                <div class="accordion overflow-auto mb-4" id="accordion-symptoms" style="max-height: 750px">
                    @php $list_symptoms = cache()->get('symptoms_' . Auth::user()->company_id); @endphp
                    @foreach ($list_symptoms as $index => $symptom_item)
                        @if ($index == 0 || $symptom_item->group !== $list_symptoms[$index - 1]->group)
                            <div class="accordion-item">
                                <h2 class="accordion-header bg-light">
                                    <button class="accordion-button" data-bs-toggle="collapse" data-bs-target="#{{ Str::slug($symptom_item->group) }}" type="button" aria-expanded="true" aria-controls="{{ Str::slug($symptom_item->group) }}">
                                        {{ $symptom_item->group }}
                                    </button>
                                </h2>
                                <div class="accordion-collapse collapse" id="{{ Str::slug($symptom_item->group) }}" data-bs-parent="#accordion-symptoms">
                                    <div class="accordion-body">
                                        <div class="info-item symptoms-checkboxes {{ Str::slug($symptom_item->group) }}-select">
                                            <ul class="list-group search-list">
                        @endif
                        <li class="list-group-item list-group-item-action rounded-3 border-0">
                            <div class="input-group d-flex align-items-center">
                                <form class="symptom-item-form input-group d-flex align-items-center">
                                    <label for="symptom-item-{{ $symptom_item->id }}">{{ $symptom_item->name }}</label>
                                    <input name="name" type="hidden" value="{{ $symptom_item->name }}">
                                    <input class="form-control form-control-plaintext border-bottom ms-1" id="symptom-item-{{ $symptom_item->id }}" name="measure" type="text" style="height: 40px;">
                                    <input name="group" type="hidden" value="{{ $symptom_item->group }}">
                                    <input name="disease" type="hidden" value="{{ e($symptom_item->diseases->toJson()) }}">
                                    <input name="id" type="hidden" value="{{ $symptom_item->id }}">
                                    <button class="btn btn-info text-decoration-none" type="submit">
                                        <i class="bi bi-play-fill mb-3" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Thêm"></i>
                                    </button>
                                </form>
                            </div>
                        </li>
                        @if ($index == count($list_symptoms) - 1 || $symptom_item->group !== $list_symptoms[$index + 1]->group)
                            <li class="list-group-item list-group-item-action rounded-3 border-0">
                                <div class="input-group d-flex align-items-center">
                                    <form class="symptom-item-form input-group d-flex align-items-center">
                                        <input class="form-control form-control-plaintext border-bottom ms-1" name="name" type="text" style="height: 40px;" placeholder="Triệu chứng khác">
                                        <input class="form-control form-control-plaintext border-bottom ms-1" name="measure" type="text" style="height: 40px;" placeholder="Mô tả">
                                        <input name="group" type="hidden" value="{{ $symptom_item->group }}">
                                        <input name="disease" type="hidden">
                                        <input name="id" type="hidden">
                                        <button class="btn btn-info text-decoration-none" type="submit">
                                            <i class="bi bi-play-fill mb-3" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Thêm"></i>
                                        </button>
                                    </form>
                                </div>
                            </li>
                            </ul>
                </div>
            </div>
        </div>
    </div>
    @endif
    @endforeach
</div>
</div>
</div>
</div>
</div>

{{-- Modal medicines --}}
<div class="modal fade" id="info_medicines-modal" aria-labelledby="info_medicines-modal-label">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h1 class="modal-title text-white fs-5" id="info_medicines-modal-label">Thuốc điều trị</h1>
                <button class="btn-close text-white" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="ajax-search">
                    <div class="input-group mb-3 position-relative search-form">
                        <input class="form-control search-input" id="info-medicine-select" data-url="{{ route('admin.medicine') }}?key=search" placeholder="Thuốc điều trị...">
                    </div>
                    <div class="overflow-auto medicine-checkboxes" style="max-height: 500px">
                        <ul class="list-group list-group-flush search-result">
                            @foreach (cache()->get('medicines_' . Auth::user()->company_id) as $medicine)
                                @php
                                    $unit = optional($medicine->_variable->_units->where('rate', 1)->first())->term ?? 'ĐVT';
                                    $dosages = $medicine->dosages
                                        ->map(function ($dosage) use ($unit, $medicine) {
                                            return '<div class="card card-body border shadow-none mb-1">
                                                        <div class="row g-1 list-medicines-dosage">
                                                            <div class="col-6 col-md-4">
                                                                <label for="medicine-item-dosage-dosage-' .
                                                $dosage->id .
                                                '">Liều dùng</label>
                                                                <div class="input-group">
                                                                    <input type="text" id="medicine-item-dosage-dosage-' .
                                                $dosage->id .
                                                '" class="form-control medicine-item-dosage-dosage" value="' .
                                                $dosage->dosage .
                                                '">
                                                                    <span class="input-group-text">' .
                                                $unit .
                                                '/lần</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-6 col-md-2">
                                                                <label for="medicine-item-dosage-frequency-' .
                                                $dosage->id .
                                                '">Số lần/ngày</label>
                                                                <input type="text" id="medicine-item-dosage-frequency-' .
                                                $dosage->id .
                                                '" class="form-control medicine-item-dosage-frequency" value="' .
                                                $dosage->frequency .
                                                '">
                                                            </div>
                                                            <div class="col-4 col-md-2">
                                                                <label for="medicine-item-dosage-quantity-' .
                                                $dosage->id .
                                                '">Số ngày</label>
                                                                <input type="text" id="medicine-item-dosage-quantity-' .
                                                $dosage->id .
                                                '" class="form-control medicine-item-dosage-quantity" value="' .
                                                $dosage->quantity .
                                                '">
                                                            </div>
                                                            <div class="col-4 col-md-3">
                                                                <label for="medicine-item-dosage-route-' .
                                                $dosage->id .
                                                '">Đường cấp</label>
                                                                <input type="text" id="medicine-item-dosage-route-' .
                                                $dosage->id .
                                                '" class="form-control medicine-item-dosage-route" value="' .
                                                $dosage->route .
                                                '">
                                                            </div>
                                                            <div class="col-4 col-md-1 d-flex align-items-end">
                                                                <input type="hidden" value="' .
                                                $medicine->name .
                                                '" class="medicine-item-dosage-medicine_name">
                                                                <input type="hidden" value="' .
                                                $medicine->id .
                                                '" class="medicine-item-dosage-medicine_id">
                                                                <div class="d-grid">
                                                                    <a class="btn btn-info btn-create-prescription_detail cursor-pointer align-middle" data-unit="' .
                                                $unit .
                                                '" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Thêm">
                                                                        <i class="bi bi-play-fill"></i>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>';
                                        })
                                        ->join('');
                                @endphp
                                <li class="list-group-item cursor-pointer border-0" data-id="{{ $medicine->id }}">
                                    <p class="mb-0 medicine-item-title" data-bs-toggle="collapse" href="#medicine-item-{{ $medicine->id }}" aria-expanded="false" aria-controls="medicine-item-{{ $medicine->id }}">{{ $medicine->name }} -
                                        {{ $medicine->_variable->name }}</p>
                                    <div class="collapse" id="medicine-item-{{ $medicine->id }}">
                                        {!! $dosages !!}
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
