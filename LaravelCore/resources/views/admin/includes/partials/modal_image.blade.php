<!-- Modal Images -->
<form action="{{ route('admin.image.update') }}" data-bs-backdrop="static" method="post" id="quick_images-update-form" class="save-form">
    @csrf
    <div class="modal fade" id="image-modal" tabindex="-1" aria-labelledby="image-label">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h1 class="modal-title fs-5" id="image-label">Cập nhật hình ảnh</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="card text-bg-light ratio ratio-1x1">
                                <img src="" class="card-img object-fit-contain" alt="">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="image-name" data-bs-toggle="tooltip" data-bs-title="Tên của hình ảnh">Tên file</label>
                                <input type="text" class="form-control" name="name" id="image-name" placeholder="Nhập tên file" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label for="image-alt" data-bs-toggle="tooltip" data-bs-title="Dùng để mô tả nội dung khi nó không thể hiển thị do lỗi tải trang">Thay thế</label>
                                <input type="text" class="form-control" name="alt" id="image-alt" placeholder="Nhập nội dung thay thế (hỗ trợ SEO)" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label for="image-caption" data-bs-toggle="tooltip" data-bs-title="Dòng văn bản hoặc chú thích đi kèm với hình ảnh">Mô tả</label>
                                <textarea class="form-control" name="caption" id="image-caption" rows="10" placeholder="Nhập mô tả hình ảnh" autocomplete="off"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-end">
                    <input type="hidden" name="id" id="image-id">
                    <button type="submit" class="btn btn-primary">Lưu</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- END Images modals -->
