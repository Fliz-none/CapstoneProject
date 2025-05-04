<form class="save-form" id="company-form" name="company" method="post">
    @csrf
    <div class="modal fade" id="company-modal" aria-labelledby="company-modal-label">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h1 class="modal-title fs-5 text-white" id="company-modal-label">Phiếu chi</h1>
                    <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-md-6 form-group">
                            <label class="form-label" for="company-name">Tên công ty</label>
                            <input class="form-control" id="company-name" name="name" type="text" placeholder="Tên công ty">
                        </div>
                        <div class="col-12 col-md-6 form-group">
                            <label for="company-user_id">Người đại diện</label>
                            <select class="form-select select2" id="company-user_id" name="user_id" data-ajax--url="{{ route('admin.user', ['key' => 'select2']) }}" data-placeholder="Chọn người đại diện">
                            </select>
                        </div>
                        <div class="col-12 col-md-6 form-group">
                            <label class="form-label" for="company-contract_total">Tổng giá trị hợp đồng</label>
                            <input class="form-control money" id="company-contract_total" name="contract_total" type="text" placeholder="Tổng giá trị hợp đồng">
                        </div>
                        <div class="col-12 col-md-6 form-group">
                            <label class="form-label" for="company-address">Địa chỉ</label>
                            <input class="form-control" id="company-address" name="address" type="text" placeholder="Địa chỉ">
                        </div>
                        <div class="col-12 col-md-6 form-group">
                            <label class="form-label" for="company-domain">URL Website</label>
                            <input class="form-control" id="company-domain" name="domain" type="text" placeholder="URL Website">
                        </div>
                        <div class="col-12 col-md-6 form-group">
                            <label class="form-label" for="company-phone">Số điện thoại</label>
                            <input class="form-control" id="company-phone" name="phone" type="text" placeholder="Số điện thoại">
                        </div>
                        <div class="col-12 col-md-6 form-group">
                            <label class="form-label" for="company-email">Email</label>
                            <input class="form-control" id="company-email" name="email" type="text" placeholder="Email">
                        </div>
                        <div class="col-12 col-md-6 form-group">
                            <label class="form-label" for="company-tax_id">Mã số thuế</label>
                            <input class="form-control" id="company-tax_id" name="tax_id" type="text" placeholder="Mã số thuế">
                        </div>
                        <div class="col-12">
                            <label class="form-label text-info" for="company-has_website">Các module</label>
                            <div class="d-grid table-responsive p-1">
                                <div class="btn-group">
                                    <input class="btn-check" id="company-has_website" name="has_website" type="checkbox" checked>
                                    <label class="btn btn-outline-primary text-nowrap" for="company-has_website">
                                        Website
                                    </label>
                                    <input class="btn-check" id="company-has_shop" name="has_shop" type="checkbox">
                                    <label class="btn btn-outline-primary text-nowrap" for="company-has_shop">
                                        Cửa hàng
                                    </label>
                                    <input class="btn-check" id="company-has_warehouse" name="has_warehouse" type="checkbox">
                                    <label class="btn btn-outline-primary text-nowrap" for="company-has_warehouse">
                                        Kho hàng
                                    </label>
                                    <input class="btn-check" id="company-has_clinic" name="has_clinic" type="checkbox">
                                    <label class="btn btn-outline-primary text-nowrap" for="company-has_clinic">
                                        Khám bệnh
                                    </label>
                                    <input class="btn-check" id="company-has_attendance" name="has_attendance" type="checkbox">
                                    <label class="btn btn-outline-primary text-nowrap" for="company-has_attendance">
                                        Chấm công
                                    </label>
                                    <input class="btn-check" id="company-has_beauty" name="has_beauty" type="checkbox">
                                    <label class="btn btn-outline-primary text-nowrap" for="company-has_beauty">
                                        Spa-gooming
                                    </label>
                                    <input class="btn-check" id="company-has_booking" name="has_booking" type="checkbox">
                                    <label class="btn btn-outline-primary text-nowrap" for="company-has_booking">
                                        Đặt hẹn
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 form-group">
                            <label class="form-label" for="company-note">Ghi chú</label>
                            <textarea class="form-control" id="company-note" name="note" type="text" rows="1" placeholder="Nhập nội dung ghi chú" ></textarea>
                        </div>
                        <div class="col-12 col-md-6 form-group">
                            <label class="form-label" for="company-deadline">Thời hạn hợp đồng</label>
                            <input class="form-control" id="company-deadline" name="deadline" type="date" placeholder="Chọn ngày hết hạn hợp đồng">
                        </div>
                    </div>
                    <hr class="px-5">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-check form-switch px-0">
                                <input class="form-check-input ms-0 ms-md-1 me-1 me-md-2" id="company-status" name="status" type="checkbox" value="1" role="switch" checked>
                                <label class="form-check-label" for="company-status">Hoạt động</label>
                            </div>
                        </div>
                        <div class="col-6 text-end">
                            @if (!empty(Auth::user()->hasAnyPermission(App\Models\User::UPDATE_COMPANY, App\Models\User::CREATE_COMPANY)))
                                <input name="id" type="hidden">
                                <button class="btn btn-primary" id="company-submit" type="submit">
                                    Lưu
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</form>
