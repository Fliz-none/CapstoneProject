<form class="save-form" id="attribute-form" method="post">
    @csrf
    <div class="modal fade" id="attribute-modal" data-bs-backdrop="static" aria-labelledby="attribute-modal-label">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="attribute-modal-label">Thuộc tính</h1>
                    <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3 form-group">
                        <label class="form-label" for="attribute-key" data-bs-toggle="tooltip" data-bs-title="Tên đặc điểm cụ thể được sử dụng để mô tả và phân biệt sản phẩm">Tên thuộc tính</label>
                        <input class="form-control" id="attribute-key" name="key" type="text" placeholder="Tên thuộc tính">
                    </div>
                    <div class="mb-3 form-group">
                        <label class="form-label" for="attribute-value" data-bs-toggle="tooltip" data-bs-title="Giá trị của thuộc tính">Giá trị</label>
                        <textarea class="form-control" id="attribute-value" name="value" placeholder="Nhập giá trị thuộc tính. MẸO: thêm dấu phẩy để thêm nhiều hơn 1 giá trị"></textarea>
                    </div>
                    <hr class="px-5">
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-12 text-end">
                                @if (!empty(Auth::user()->hasAnyPermission(App\Models\User::UPDATE_ATTRIBUTE, App\Models\User::CREATE_ATTRIBUTE)))
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
