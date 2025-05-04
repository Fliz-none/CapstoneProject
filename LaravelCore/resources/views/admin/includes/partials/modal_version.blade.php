<form class="save-form" id="version-form" method="post">
    @csrf
    <div class="modal fade" id="version-modal" data-bs-backdrop="static" aria-labelledby="version-modal-label">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h1 class="modal-title text-white fs-5" id="version-modal-label">Phiên bản</h1>
                    <button class="btn-close text-white" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3 form-g">
                        <label class="form-label" for="version-name" data-bs-toggle="tooltip" data-bs-title="Tên phiên bản">Tên</label>
                        <input class="form-control" id="version-name" name="name" type="text" placeholder="Tên phiên bản">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="version-description" data-bs-toggle="tooltip" data-bs-title="Nội dung cập nhật của phiên bản này">Mô tả</label>
                        <textarea name="description" id="version-description" class="form-control summernote" placeholder="Nhập chi tiết các nội dung cập nhật" rows="20"></textarea>
                    </div>
                    <hr class="px-5">
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-12 text-end">
                                @if (!empty(Auth::user()->hasAnyPermission(App\Models\User::UPDATE_VERSION, App\Models\User::CREATE_VERSION)))
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