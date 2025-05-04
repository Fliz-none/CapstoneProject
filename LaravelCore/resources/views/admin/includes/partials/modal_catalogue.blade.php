<form class="save-form" id="catalogue-form" method="post">
    @csrf
    <div class="modal fade" id="catalogue-modal" data-bs-backdrop="static" aria-labelledby="catalogue-modal-label">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h1 class="modal-title text-white fs-5" id="catalogue-modal-label">Danh mục</h1>
                    <button class="btn-close text-white" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <div class="sticky-top">
                                <label class="form-label select-image" for="catalogue-avatar">
                                    <img class="img-fluid rounded-4 object-fit-cover" src="{{ asset('admin/images/placeholder.webp') }}" alt="Ảnh đại diện">
                                </label>
                                <input class="hidden-image" id="catalogue-avatar" name="avatar" type="hidden">
                                <div class="d-grid">
                                    <button class="btn btn-outline-primary btn-remove-image d-none" type="button">Xoá</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="mb-3">
                                <label class="form-label" for="catalogue-name" data-bs-toggle="tooltip" data-bs-title="Tên dùng danh mục dùng để nhóm hoặc phân loại">Tên</label>
                                <input class="form-control" id="catalogue-name" name="name" type="text" placeholder="Tên danh mục" autocomplete="off">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="catalogue-parent_id" data-bs-toggle="tooltip" data-bs-title="Tên danh mục lơn hơn có thể chứa các danh mục con">Danh mục cha</label>
                                <select class="form-control select2" id="catalogue-parent_id" name="parent_id" data-ajax--url="{{ route('admin.catalogue', ['key' => 'select2']) }}" data-placeholder="Chọn danh mục cha" type="text">
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="catalogue-note"  data-bs-toggle="tooltip" data-bs-title="Mô tả chi tiết về danh mục này">Mô tả</label>
                                <textarea class="form-control" id="catalogue-note" name="note" rows="6" placeholder="Nhập nội dung mô tả"></textarea>
                            </div>
                        </div>
                    </div>
                    <hr class="px-5">
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-12 col-lg-6">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" id="catalogue-status" name="status" type="checkbox" checked>
                                    <label class="form-check-label" for="catalogue-status" data-bs-toggle="tooltip" data-bs-title="Trạng thái danh mục, nếu tắt thì không thể thêm sản phẩm, nhập hàng và bán hàng">Hoạt động</label>
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
