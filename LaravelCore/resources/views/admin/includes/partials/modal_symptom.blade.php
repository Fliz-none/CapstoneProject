<form class="save-form" id="symptom-form" method="post">
    @csrf
    <div class="modal fade" id="symptom-modal" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="symptom-modal-label">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h1 class="modal-title text-white fs-5" id="symptom-modal-label">Thông tin triệu chứng</h1>
                    <button class="btn-close text-white" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="card shadow-none border mb-3">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="mb-3 form-group">
                                                <label class="form-label" data-bs-toggle="tooltip" data-bs-title="Tên triệu chứng xuất hiện ở thú cưng" for="symptom-name">Tên triệu chứng</label>
                                                <input class="form-control" id="symptom-name" name="name" type="text" placeholder="Tên triệu chứng" autocomplete="off" required="">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-3 form-group">
                                                <label class="form-label" data-bs-toggle="tooltip" data-bs-title="Nhóm cơ quan xuất hiện triệu chứng" for="group">Nhóm cơ quan</label>
                                                <select class="form-select" id="group" name="group" data-ajax--url="" data-placeholder="Chọn nhóm cơ quan" autocomplete="off">
                                                    <option>Chọn nhóm cơ quan</option>
                                                    @php
                                                        $settings = Cache::get('settings_' . Auth::user()->company_id);
                                                        $symptomGroup = isset($settings['symptom_group']) ? json_decode($settings['symptom_group']) : null;
                                                    @endphp
                                                    @if ($symptomGroup && count($symptomGroup ?? []) > 0)
                                                        @foreach ($symptomGroup as $key => $value)
                                                            <option value="{{ $value }}">{{ $value }}</option>
                                                        @endforeach
                                                    @else
                                                        <option value="">Không có dữ liệu</option>
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="card shadow-none border mb-3">
                                <div class="card-body overflow-auto">
                                    <div class="mb-3 position-relative search-container form-group">
                                        <label class="form-label" for="symptom-disease-search" data-bs-toggle="tooltip" data-bs-title="Thông qua phân tích kết quả để xác định loại bệnh">Gợi ý bệnh</label>
                                        <input class="form-control search-input" id="symptom-disease-search" placeholder="Tìm kiếm bệnh">
                                    </div>
                                    <div class="search-item overflow-auto" style="height: 250px">
                                        <ul class="list-group search-list">
                                            <?php $diseases = cache()->get('diseases_' . Auth::user()->company_id); ?>
                                            @if (count($diseases ?? []))
                                                @foreach ($diseases as $disease)
                                                    <li class="list-group-item border-0 pb-0">
                                                        <input class="form-check-input me-1" id="symptom-disease-{{ $disease->id }}" name="diseases[]" type="checkbox" value="{{ $disease->id }}">
                                                        <label class="form-check-label d-inline" for="symptom-disease-{{ $disease->id }}">{{ $disease->name }}</label>
                                                    </li>
                                                @endforeach
                                            @else
                                                <span class="ms-3 fst-italic">Không có bệnh nào được hiển thị</span>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="card shadow-none border mb-3">
                                <div class="card-body overflow-auto">
                                    <div class="mb-3 position-relative search-container form-group">
                                        <label class="form-label" for="symptom-medicine-search" data-bs-toggle="tooltip" data-bs-title="Thuốc được gợi ý để chữa trị các triệu chứng">Gợi ý thuốc</label>
                                        <input class="form-control search-input" id="symptom-medicine-search" placeholder="Tìm kiếm thuốc">
                                    </div>
                                    <div class="search-item overflow-auto" style="height: 250px">
                                        <ul class="list-group search-list">
                                            <?php $medicines = cache()->get('medicines_' . Auth::user()->company_id); ?>
                                            @if (count($medicines ?? []))
                                                @foreach ($medicines as $key => $medicine)
                                                <li class="list-group-item border-0 pb-0">
                                                    <input class="form-check-input me-1" id="symptom-medicine-{{ $medicine->id }}" name="medicines[]" type="checkbox" value="{{ $medicine->id }}">
                                                    <label class="form-check-label d-inline" for="symptom-medicine-{{ $medicine->id }}">{{ $medicine->name }}</label>
                                                </li>
                                                @endforeach
                                            @else
                                                <span class="ms-3 fst-italic">Không có thuốc được hiển thị</span>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="card shadow-none border mb-3">
                                <div class="card-body overflow-auto">
                                    <div class="mb-3 position-relative search-container form-group">
                                        <label class="form-label" for="symptom-service-search" data-bs-toggle="tooltip" data-bs-title="Dịch vụ được gợi ý dựa trên triệu chứng">Gợi ý dịch vụ</label>
                                        <input class="form-control search-input" id="symptom-service-search" placeholder="Tìm kiếm dịch vụ">
                                    </div>
                                    <div class="search-item overflow-auto" style="height: 250px">
                                        <ul class="list-group search-list">
                                            <?php $services = cache()->get('services_' . Auth::user()->company_id); ?>
                                            @if (count($services ?? []))
                                                @foreach ($services as $key => $service)
                                                    <li class="list-group-item border-0 pb-0">
                                                        <input class="form-check-input me-1" id="symptom-service-{{ $service->id }}" name="services[]" type="checkbox" value="{{ $service->id }}">
                                                        <label class="form-check-label d-inline" for="symptom-service-{{ $service->id }}">{{ $service->name }}</label>
                                                    </li>
                                                @endforeach
                                            @else
                                                <span class="ms-3 fst-italic">Không có dịch vụ được hiển thị</span>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="px-5">
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-12 text-end">
                                @if (!empty(Auth::user()->hasAnyPermission(App\Models\User::UPDATE_SYMPTOM, App\Models\User::CREATE_SYMPTOM)))
                                    <input name="id" type="hidden">
                                    <button class="btn btn-primary" type="submit">Lưu</button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
