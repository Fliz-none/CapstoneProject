<form class="save-form" id="warehouse-form" method="post">
    @csrf
    <div class="modal fade" id="warehouse-modal" data-bs-backdrop="static" aria-labelledby="warehouse-modal-label">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="warehouse-modal-label">Kho hàng</h1>
                    <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3 form-group">
                        <label class="form-label fw-bold" for="warehouse-name" data-bs-toggle="tooltip" data-bs-title="Tên của kho hàng">Tên kho</label>
                        <input class="form-control" id="warehouse-name" name="name" type="text" placeholder="Tên kho" autocomplete="off" required>
                    </div>
                    <div class="mb-3 form-group">
                        <label class="form-label fw-bold" for="warehouse-branch_id" data-bs-toggle="tooltip" data-bs-title="Chi nhánh mà kho hàng thuộc về">Chi nhánh</label>
                        <select class="form-select select2" id="warehouse-branch_id" data-ajax--url="{{ route('admin.branch', ['key' => 'select2']) }}" data-placeholder="Chọn một chi nhánh" name="branch_id">
                        </select>
                    </div>
                    <div class="mb-3 form-group">
                        <label class="form-label fw-bold" for="warehouse-address" data-bs-toggle="tooltip" data-bs-title="Địa chỉ của kho hàng">Địa chỉ</label>
                        <input class="form-control" id="warehouse-address" name="address" type="text" autocomplete="off" placeholder="Nhập địa chỉ">
                    </div>
                    <div class="mb-3 form-group">
                        <label class="form-label fw-bold" for="warehouse-status" data-bs-toggle="tooltip" data-bs-title="Trạng thái kho hàng">Trạng thái</label>
                        <select name="status" id="warehouse-status" class="form-control">
                            <option value="2">Mở bán</option>
                            <option value="1">Dùng nội bộ</option>
                            <option value="0">Bị khóa</option>
                        </select>
                    </div>
                    <div class="mb-3 form-group">
                        <label class="form-label fw-bold" for="warehouse-note" data-bs-toggle="tooltip" data-bs-title="Lưu ý hoặc gợi nhớ về kho hàng">Ghi chú</label>
                        <textarea class="form-control" id="warehouse-note" name="note" autocomplete="off" placeholder="Nhập nội dung ghi chú"></textarea>
                    </div>
                    <hr class="px-5">
                    <div class="mb-3 form-group">
                        <div class="row">
                            <div class="col-12 col-lg-12 text-end">
                                @if (!empty(Auth::user()->hasAnyPermission(App\Models\User::UPDATE_WAREHOUSE, App\Models\User::CREATE_WAREHOUSE)))
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
