<form class="save-form" id="service-form" method="post">
    @csrf
    <div class="modal fade" id="service-modal" data-bs-backdrop="static" aria-labelledby="service-modal-label">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h1 class="modal-title fs-5 text-white" id="service-modal-label">Dịch vụ</h1>
                    <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-8">
                            <div class="mb-3 form-group">
                                <label class="form-label fw-bold" data-bs-toggle="tooltip"
                                    data-bs-title="Hoạt động và dịch vụ được cung cấp để đảm bảo sức khỏe, vệ sinh, và sự thoải mái cho thú cưng"
                                    for="service-name">Tên dịch vụ</label>
                                <input class="form-control" id="service-name" name="name" type="text"
                                    placeholder="Tên dịch vụ" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="mb-3 form-group">
                                <label class="form-label fw-bold" data-bs-toggle="tooltip"
                                    data-bs-title="Đơn vị tính của dịch vụ trên hóa đơn thanh toán"
                                    for="service-unit">Đơn vị tính</label>
                                <input class="form-control" id="service-unit" name="unit" type="text"
                                    placeholder="Đơn vị tính" autocomplete="off" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="mb-3 form-group">
                                <label class="form-label fw-bold" data-bs-toggle="tooltip"
                                    data-bs-title="Số tiền mà khách hàng phải trả cho dịch vụ này"
                                    for="service-price">Giá dịch vụ</label>
                                <input class="form-control money" id="service-price" name="price" type="text"
                                    placeholder="Giá dịch vụ" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="mb-3 form-group">
                                <label class="form-label fw-bold" data-bs-toggle="tooltip"
                                    data-bs-title="Cơ số lương cho nhân viên thực hiện dịch vụ (số tiền hoặc phần trăm giá dịch vụ)"
                                    for="service-commission">Cơ số lương</label>
                                <input class="form-control money" id="service-commission" name="commission"
                                    type="text" placeholder="Cơ số lương" autocomplete="off" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group major-select">
                        <label class="form-label mt-1" data-bs-toggle="tooltip"
                            data-bs-title="Phân loại dịch vụ thành nhóm" for="service-major_id">Danh mục</label>
                        <select class="form-select select2" id="service-major_id" name="major_id"
                            data-ajax--url="{{ route('admin.major', ['key' => 'select2']) }}"
                            data-placeholder="Chọn danh mục">
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label" for="service-ticket">Mẫu phiếu</label>
                        <select class="form-select" id="service-ticket" name="ticket">
                            <option value="">Không có mẫu phiếu</option>
                            <option value="info">Khám bệnh</option>
                            <option value="beauty">Spa-Grooming</option>
                            <option value="quicktest">Kit test nhanh</option>
                            <option value="ultrasound">Siêu âm</option>
                            <option value="bloodcell">XNTB Máu</option>
                            <option value="biochemical">XNSH Máu</option>
                            <option value="microscope">Soi KHV</option>
                            <option value="xray">X-Quang</option>
                            <option value="surgery">Phẩu thuật</option>
                            <option value="accommodation">Điều trị nội trú</option>
                            <option value="info">Khám lâm sàng</option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3 form-group">
                                <label class="form-label mt-1" data-bs-toggle="tooltip" data-bs-title="Trạng thái hoạt động của dịch vụ" for="service-status">Trạng thái</label>
                                <select class="form-select" id="service-status" name="status">
                                    <option value="1" {{ old('status') === '1' ? 'selected' : '' }}> Hiện offline</option>
                                    <option value="2" {{ old('status') === '2' ? 'selected' : '' }}> Hiện online</option>
                                    <option value="0" {{ old('status') === '0' ? 'selected' : '' }}> Đã khóa</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label class="form-label mt-1" data-bs-toggle="tooltip"
                                    data-bs-title="Yêu cầu khách hàng cam kết cho dịch vụ này"
                                    for="service-commitment_required">Cam kết</label>
                                <div class="form-check form-switch align-middle">
                                    <input type="hidden" name="commitment_required" value="0">
                                    <input class="form-check-input" id="service-commitment_required" name="commitment_required" type="checkbox" value="1">
                                    <label class="form-check-label" for="service-commitment_required">Yêu cầu cam kết</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label class="form-label mt-1" data-bs-toggle="tooltip"
                                    data-bs-title="Chỉ bác sĩ mới được chỉ định dịch vụ này"
                                    for="service-is_indicated">Chỉ định</label>
                                <div class="form-check form-switch align-middle">
                                    <input class="form-check-input" id="service-is_indicated" name="is_indicated" type="checkbox">
                                    <label class="form-check-label" for="service-is_indicated">Yêu cầu chỉ định</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12" id="commitment-container">
                            <div class="form-group">
                                <label class="form-label" for="service-commitment_note">Nội dung cam kết</label>
                                <textarea class="form-control" name="commitment_note" id="service-commitment_note" rows="4"
                                    placeholder="Nhập nội dung cam kết tại đây..."></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-group criterial-select">
                        <label class="form-label mt-1" data-bs-toggle="tooltip"
                            data-bs-title="Chỉ tiêu cần đạt được để hoàn thành dịch vụ" for="service-criterial">Tiêu
                            chí</label>
                        <select class="form-control select2" id="service-criterial" name="criterial[]"
                            data-ajax--url="{{ route('admin.criterial', ['key' => 'select2']) }}"
                            data-placeholder="Chọn chỉ tiêu" multiple="multiple" size="1">
                        </select>
                    </div>
                    <hr class="px-5">
                    <div class="row">
                        <div class="col-12 text-end">
                            @if (!empty(Auth::user()->hasAnyPermission(App\Models\User::UPDATE_SERVICE, App\Models\User::CREATE_SERVICE)))
                                <input name="id" type="hidden">
                                <button class="btn btn-primary" type="submit">Lưu</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
