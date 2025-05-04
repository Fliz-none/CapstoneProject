<form class="save-form" id="diseases-form" method="post">
    @csrf
    <div class="modal fade" id="diseases-modal" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="diseases-modal-label">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h1 class="modal-title text-white fs-5" id="diseases-modal-label">Thông tin bệnh lý</h1>
                    <button class="btn-close text-white" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="card shadow-none border mb-3">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="mb-3 form-group">
                                                <label class="form-label" for="diseases-name">Tên bệnh</label>
                                                <input class="form-control" id="diseases-name" name="name" type="text" placeholder="Tên bệnh" autocomplete="off" required>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <div class="mb-3 form-group">
                                                <label class="form-label" for="infection_chain">Chuỗi lây nhiễm</label>
                                                <textarea class="form-control" id="infection_chain" name="infection_chain" placeholder="Chuỗi lây nhiễm" rows="2" autocomplete="off"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <div class="mb-3 form-group">
                                                <label class="form-label" for="counsel">Tư vấn</label>
                                                <textarea class="form-control" id="counsel" name="counsel" placeholder="Tư vấn" rows="2" autocomplete="off"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <div class="mb-3 form-group">
                                                <label class="form-label" for="complication">Biến chứng</label>
                                                <textarea class="form-control" id="complication" name="complication" placeholder="Biến chứng" rows="2"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <div class="mb-3 form-group">
                                                <label class="form-label" for="prevention">Phòng ngừa</label>
                                                <textarea class="form-control" id="prevention" name="prevention" placeholder="Phòng ngừa" rows="2"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label" for="prognosis">Tiên lượng</label>
                                                <textarea class="form-control mb-0" id="prognosis" name="prognosis" placeholder="Tiên lượng" rows="2"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label" for="advice">Lời dặn</label>
                                                <textarea class="form-control mb-0" id="advice" name="advice" placeholder="Lời dặn" rows="2"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="card shadow-none border mb-3">
                                <div class="card-body">
                                    <div class="input-group mb-3 position-relative search-container">
                                        <label class="form-label fw-bolder d-flex align-items-center text-info mb-0 w-25" for="disease-symptom-select">Triệu chứng</label>
                                        <input class="form-control search-input ms-3" id="disease-symptom-select" placeholder="Tìm triệu chứng...">
                                    </div>
                                    <div class="search-item overflow-auto" style="height: 250px">
                                        <ul class="list-group search-list">
                                            @foreach (cache()->get('symptoms_' . Auth::user()->company_id) as $symptom)
                                                <li class="list-group-item border border-0 pb-0">
                                                    <input class="form-check-input me-1" id="disease-symptom-{{ $symptom->id }}" name="symptoms[]" type="checkbox" value="{{ $symptom->id }}">
                                                    <label class="form-check-label d-inline" for="disease-symptom-{{ $symptom->id }}">{{ $symptom->name }}</label>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="card shadow-none border mb-3">
                                <div class="card-body">
                                    <div class="input-group mb-3 position-relative search-container">
                                        <label class="form-label fw-bolder d-flex align-items-center text-info mb-0 w-25" for="disease-service-select">Dịch vụ</label>
                                        <input class="form-control search-input ms-3" id="disease-service-select" placeholder="Tìm dịch vụ...">
                                    </div>
                                    <div class="search-item overflow-auto" style="height: 250px">
                                        <ul class="list-group search-list">
                                            @foreach (cache()->get('services_' . Auth::user()->company_id) as $service)
                                                <li class="list-group-item border border-0 pb-0">
                                                    <input class="form-check-input me-1" id="disease-service-{{ $service->id }}" name="services[]" type="checkbox" value="{{ $service->id }}">
                                                    <label class="form-check-label d-inline" for="disease-service-{{ $service->id }}">{{ $service->name }}</label>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="card shadow-none border mb-3">
                                <div class="card-body">
                                    <div class="input-group mb-3 position-relative search-container">
                                        <label class="form-label fw-bolder d-flex align-items-center text-info mb-0" for="disease-medicine-select">Thuốc</label>
                                        <input class="form-control search-input ms-3" id="disease-medicine-select" placeholder="Tìm thuốc...">
                                    </div>
                                    <div class="search-item overflow-auto" style="height: 250px">
                                        <ul class="list-group search-list">
                                            @foreach (cache()->get('medicines_' . Auth::user()->company_id) as $medicine)
                                                <li class="list-group-item border border-0 pb-0">
                                                    <input class="form-check-input me-1" id="disease-medicine-{{ $medicine->id }}" name="medicines[]" type="checkbox" value="{{ $medicine->id }}">
                                                    <label class="form-check-label d-inline" for="disease-medicine-{{ $medicine->id }}">{{ $medicine->name }}</label>
                                                </li>
                                            @endforeach
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
                                @if (!empty(Auth::user()->hasAnyPermission(App\Models\User::UPDATE_DISEASE, App\Models\User::CREATE_DISEASE)))
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
