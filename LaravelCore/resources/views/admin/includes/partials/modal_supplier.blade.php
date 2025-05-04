<form class="save-form" id="supplier-form" method="post">
    @csrf
    <div class="modal fade" id="supplier-modal" data-bs-backdrop="static" aria-labelledby="supplier-modal-label">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h1 class="modal-title text-white fs-5" id="supplier-modal-label">Nhà cung cấp</h1>
                    <button class="btn-close text-white" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="form-group row align-items-center">
                                <div class="col-12">
                                    <label for="supplier-name" class="form-label" data-bs-toggle="tooltip" data-bs-title="Tên của công ty, tổ chức, hoặc cá nhân cung cấp sản phẩm, dịch vụ">Tên nhà cung cấp</label>
                                </div>
                                <div class="col-12">
                                    <input type="text" id="supplier-name" name="name" class="form-control" placeholder="Tên nhà cung cấp" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group row align-items-center">
                                <div class="col-12">
                                    <label for="supplier-phone" class="form-label" data-bs-toggle="tooltip" data-bs-title="Số điện thoại của nhà cung cấp">Số điện thoại</label>
                                </div>
                                <div class="col-12">
                                    <input type="text" id="supplier-phone" name="phone" class="form-control" placeholder="Số điện thoại" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group row align-items-center">
                                <div class="col-12">
                                    <label for="supplier-email" class="form-label" data-bs-toggle="tooltip" data-bs-title="Email của nhà cung cấp">Email</label>
                                </div>
                                <div class="col-12">
                                    <input type="text" id="supplier-email" name="email" class="form-control" placeholder="Email" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group row align-items-center">
                                <div class="col-12">
                                    <label for="supplier-address" class="form-label" data-bs-toggle="tooltip" data-bs-title="Địa chỉ của nhà cung cấp">Địa chỉ</label>
                                </div>
                                <div class="col-12">
                                    <input type="text" id="supplier-address" name="address" class="form-control" placeholder="Số nhà, đường, phường / xã, quận / huyện, tỉnh / thành" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group row align-items-center">
                                <div class="col-12">
                                    <label for="supplier-organ" class="form-label" data-bs-toggle="tooltip" data-bs-title="Đây là tên nhà cung cấp dùng sử dụng trong các giao dịch thương mại">Tên Công Ty</label>
                                </div>
                                <div class="col-12">
                                    <input type="text" id="supplier-organ" name="organ" class="form-control" placeholder="Tên Công ty" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group row align-items-center">
                                <div class="col-12">
                                    <label for="supplier-note" class="form-label" data-bs-toggle="tooltip" data-bs-title="Thông tin gợi nhớ hoặc lưu ý về nhà cung cấp">Ghi chú</label>
                                </div>
                                <div class="col-12">
                                    <textarea name="note" id="supplier-note" rows="3" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-check form-switch ps-0">
                                <input type="checkbox" id="supplier-status" name="status" value="1" class="form-check-input ms-0 ms-md-1 me-1 me-md-2" role="switch" checked>
                                <label for="supplier-status" class="form-check-label" data-bs-toggle="tooltip" data-bs-title="Trạng thái của nhà cung cấp (Có thể thay đổi sau)">Hoạt động</label>
                            </div>
                        </div>
                        <div class="col-6 text-end">
                            @if (!empty(Auth::user()->hasAnyPermission(App\Models\User::UPDATE_SUPPLIER, App\Models\User::CREATE_SUPPLIER)))
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
