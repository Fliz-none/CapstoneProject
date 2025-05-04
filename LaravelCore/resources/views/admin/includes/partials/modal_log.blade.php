<form class="save-form" id="log-form" method="post">
    @csrf
    <div class="modal fade" id="log-modal" data-bs-backdrop="static" aria-labelledby="log-modal-label">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="log-modal-label">Danh mục</h1>
                    <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label" for="log-name">Tên danh mục</label>
                        <input class="form-control" id="log-name" name="name" type="text" placeholder="Tên danh mục" autocomplete="off" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="log-note">Ghi chú</label>
                        <textarea class="form-control" id="log-note" name="note" placeholder="Nhập nội dung ghi chú"></textarea>
                    </div>
                    <hr class="px-5">
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-12 col-lg-6">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" id="log-status" name="status" type="checkbox" checked>
                                    <label class="form-check-label" for="log-status">Hoạt động</label>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6 text-end">
                                @if (!empty(Auth::user()->hasAnyPermission(App\Models\User::UPDATE_CATALOGUE, App\Models\User::CREATE_CATALOGUE)))
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
