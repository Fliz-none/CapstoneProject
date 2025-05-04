<form class="save-form" id="category-form" method="post">
    @csrf
    <div class="modal fade" id="category-modal" data-bs-backdrop="static" aria-labelledby="category-modal-label">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h1 class="modal-title text-white fs-5" id="category-modal-label">Chuyên mục</h1>
                    <button class="btn-close text-white" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label" for="category-name">Tên</label>
                        <input class="form-control" id="category-name" name="name" type="text" placeholder="Tên chuyên mục" autocomplete="off" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="category-note">Mô tả</label>
                        <textarea class="form-control" id="category-note" name="note" rows="6" placeholder="Nhập nội dung mô tả"></textarea>
                    </div>
                    <hr class="px-5">
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-12 col-lg-6">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" id="category-status" name="status" type="checkbox" checked>
                                    <label class="form-check-label" for="category-status">Hoạt động</label>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6 text-end">
                                @if (!empty(Auth::user()->hasAnyPermission(App\Models\User::UPDATE_CATEGORY, App\Models\User::CREATE_CATEGORY)))
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
