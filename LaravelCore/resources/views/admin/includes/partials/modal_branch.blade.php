<form class="save-form" id="branch-form" method="post">
    @csrf
    <div class="modal fade" id="branch-modal" data-bs-backdrop="static" aria-labelledby="branch-modal-label">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="branch-modal-label">Chi nhánh</h1>
                    <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="form-group row align-items-center">
                                <div class="col-12">
                                    <label for="branch-name" class="form-label" data-bs-toggle="tooltip" data-bs-title="Tên gọi của chi nhánh">Tên chi nhánh</label>
                                </div>
                                <div class="col-12">
                                    <input type="text" id="branch-name" name="name" class="form-control" placeholder="Tên chi nhánh" autocomplete="off" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group row align-items-center">
                                <div class="col-12">
                                    <label for="branch-phone" class="form-label" data-bs-toggle="tooltip" data-bs-title="Số điện thoại của chi nhánh">Số điện thoại</label>
                                </div>
                                <div class="col-12">
                                    <input type="text" id="branch-phone" name="phone" class="form-control" placeholder="Số điện thoại" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group row align-items-center">
                                <div class="col-12">
                                    <label for="branch-address" class="form-label" data-bs-toggle="tooltip" data-bs-title="Địa chỉ chi tiết về chi nhánh">Địa chỉ</label>
                                </div>
                                <div class="col-12">
                                    <input type="text" id="branch-address" name="address" class="form-control" placeholder="Số nhà, đường, phường / xã, quận / huyện, tỉnh / thành" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group row align-items-center">
                                <div class="col-12">
                                    <label for="branch-note" class="form-label" data-bs-toggle="tooltip" data-bs-title="Ghi chú để gợi nhớ hoặc lưu ý về chi nhánh">Ghi chú</label>
                                </div>
                                <div class="col-12">
                                    <textarea name="note" id="branch-note" rows="3" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-check form-switch px-0">
                                <input type="checkbox" id="branch-status" name="status" value="1" class="form-check-input ms-0 ms-md-1 me-1 me-md-2" role="switch" checked>
                                <label for="branch-status" class="form-check-label">Hoạt động</label>
                            </div>
                        </div>
                        <div class="col-6 text-end">
                            @if (!empty(Auth::user()->hasAnyPermission(App\Models\User::UPDATE_BRANCH, App\Models\User::CREATE_BRANCH)))
                            <input name="id" type="hidden">
                            <button class="btn btn-primary px-3 fw-bold" type="submit">Lưu</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
