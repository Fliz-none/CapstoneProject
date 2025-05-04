<form class="save-form" id="medicine-form" method="post">
    @csrf
    <div class="modal fade" id="medicine-modal" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="medicine-modal-label">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h1 class="modal-title text-white fs-5" id="medicine-modal-label">Thông tin thuốc</h1>
                    <button class="btn-close text-white" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-lg-4 overflow-auto" style="max-height: 350px">
                            <div class="card shadow-none border mb-3">
                                <div class="card-body">
                                    <div class="mb-3 form-group">
                                        <label class="form-label" for="medicine-product_id">Chọn sản phẩm</label>
                                        <select class="form-select select2" id="medicine-product_id" name="product_id" data-ajax--url="{{ route('admin.product', ['key' => 'select2']) }}" data-placeholder="Chọn một sản phẩm" required>
                                        </select>
                                    </div>
                                    <div class="mb-3 form-group d-none">
                                        <label class="form-label" for="medicine-variable_id">Chọn biến thể</label>
                                        <select class="form-control" id="medicine-variable_id" name="variable_id" autocomplete="off" required></select>
                                    </div>
                                    <div class="mb-3 form-group">
                                        <label class="form-label" for="medicine-name">Tên thuốc</label>
                                        <input class="form-control" id="medicine-name" name="name" type="text" placeholder="Tên thuốc" autocomplete="off" required>
                                    </div>
                                    <div class="mb-3 form-group">
                                        <label class="form-label text-dark" for="medicine-contraindications">Chống chỉ định</label>
                                        <textarea class="form-control" id="medicine-contraindications" name="contraindications" placeholder="Chống chỉ định" rows="2"></textarea>
                                    </div>
                                    <div class="mb-3 form-group">
                                        <label class="form-label text-dark" for="medicine-sample_dosages">Liều dùng tham khảo</label>
                                        <textarea class="form-control" id="medicine-sample_dosages" name="sample_dosages" placeholder="Liều dùng tham khảo" rows="5"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-8">
                            <div class="row">
                                <div class="col-12 col-lg-6">
                                    <div class="card shadow-none border mb-3">
                                        <div class="card-body">
                                            <div class="input-group mb-3 position-relative search-container">
                                                <label class="form-label fw-bolder d-flex align-items-center text-info mb-0" for="medicine-symptom-select">Triệu chứng</label>
                                                <input class="form-control search-input ms-3" id="medicine-symptom-select" placeholder="Triệu chứng...">
                                            </div>
                                            <div class="search-item overflow-auto" style="height: 250px">
                                                <ul class="list-group search-list">
                                                    @foreach (cache()->get('symptoms_' . Auth::user()->company_id) as $symptom)
                                                        <li class="list-group-item border border-0 pb-0">
                                                            <input class="form-check-input me-1" id="medicine-symptom-{{ $symptom->id }}" name="symptoms[]" type="checkbox" value="{{ $symptom->id }}">
                                                            <label class="form-check-label d-inline" for="medicine-symptom-{{ $symptom->id }}">{{ $symptom->name }}</label>
                                                            <ul class="list-group"></ul>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <div class="card shadow-none border mb-3">
                                        <div class="card-body">
                                            <div class="input-group mb-3 position-relative search-container">
                                                <label class="form-label fw-bolder d-flex align-items-center text-info mb-0" for="medicine-disease-select">Bệnh</label>
                                                <input class="form-control search-input ms-3" id="medicine-disease-select" placeholder="Bệnh...">
                                            </div>
                                            <div class="search-item overflow-auto" style="height: 250px">
                                                <ul class="list-group search-list">
                                                    @foreach (cache()->get('diseases_' . Auth::user()->company_id) as $disease)
                                                        <li class="list-group-item border border-0 pb-0">
                                                            <input class="form-check-input me-1" id="medicine-disease-{{ $disease->id }}" name="diseases[]" type="checkbox" value="{{ $disease->id }}">
                                                            <label class="form-check-label d-inline" for="medicine-disease-{{ $disease->id }}">{{ $disease->name }}</label>
                                                            <ul class="list-group"></ul>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-12 mt-4">
                            <div class="card shadow-none border mb-3">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-9">
                                            <label class="form-label fw-bolder d-flex align-items-center text-info mb-0" for="medicine-disease-select">Các liều dùng</label>
                                        </div>
                                        <div class="col-3 text-end">
                                            <a class="btn btn-outline-info ms-2 mb-3 btn-sm block btn-append-dosage">
                                                <i class="bi bi-plus-circle"></i>
                                                Thêm liều dùng
                                            </a>
                                        </div>
                                    </div>
                                    <datalist id="medicine-routes">
                                        <option value="Đường uống (PO)">
                                        <option value="Trực tràng (PR)">
                                        <option value="Âm đạo (PV)">
                                        <option value="Dưới lưỡi (SL)">
                                        <option value="Tiêm tĩnh mạch (IV)">
                                        <option value="Thuốc tiêm (IJ)">
                                        <option value="Tiêm dưới da (SC)">
                                        <option value="Tiêm bắp (IM)">
                                        <option value="Nhỏ giọt (Instill)">
                                        <option value="Truyền dịch (Inf)">
                                    </datalist>
                                    <table class="table table-borderless table-detail">
                                        <thead>
                                            <tr>
                                                <th>Liều dùng/lần</th>
                                                <th>Số lần/ngày</th>
                                                <th>Số ngày</th>
                                                <th>Đường cấp</th>
                                                <th>Loài</th>
                                                <th>Tuổi</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody id="dosages"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="px-5">
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-12 text-end">
                                @if (!empty(Auth::user()->hasAnyPermission(App\Models\User::UPDATE_MEDICINE, App\Models\User::CREATE_MEDICINE)))
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
