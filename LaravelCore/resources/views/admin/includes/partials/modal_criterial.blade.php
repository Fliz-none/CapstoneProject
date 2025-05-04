<form class="save-form" id="criterial-form" method="post">
    @csrf
    <div class="modal fade" id="criterial-modal" data-bs-backdrop="static" aria-labelledby="criterial-modal-label">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="criterial-modal-label">Tiêu chí</h1>
                    <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3 row justify-content-center">
                        <div class="col-6">
                            <div class="row mb-3">
                                <label class="col-4 col-form-label fw-bold" for="criterial-name">Tên</label>
                                <div class="col-sm-8">
                                    <input class="form-control" id="criterial-name" name="name" type="text" placeholder="Tên" autocomplete="off">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-4 col-form-label fw-bold" for="criterial-unit">Đơn vị tính</label>
                                <div class="col-sm-8">
                                    <input class="form-control" id="criterial-unit" name="unit" placeholder="Nhập đơn vị tính" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            {{-- <label class="form-label fw-bold" for="criterial-description">Mô tả</label> --}}
                            <textarea class="form-control" id="criterial-description" name="description" rows="3" placeholder="Nội dung cần lưu ý khi thực hiện" autocomplete="off"></textarea>
                        </div>
                    </div>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <td class="fw-bold">Loài</td>
                                <td class="fw-bold">Độ tuổi tối đa</td>
                                <td class="fw-bold">Ngưỡng dưới</td>
                                <td class="fw-bold">Ngưỡng trên</td>
                                <td><a type="button" class="btn btn-link text-decoration-none btn-create-normal_index"><i class="bi bi-plus-circle"></i> Thêm</a></td>
                            </tr>
                        </thead>
                        <tbody id="criterial-normal_indexes">
                        </tbody>
                    </table>
                    <hr class="px-5">
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-12 col-lg-6">
                            </div>
                            <div class="col-12 col-lg-6 text-end">
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
