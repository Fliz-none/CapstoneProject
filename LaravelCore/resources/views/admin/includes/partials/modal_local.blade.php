<form class="save-form" id="local-form" method="post">
    @csrf
    <div class="modal fade" id="local-modal" data-bs-backdrop="static" data-bs-backdrop="static" aria-labelledby="local-modal-label">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h1 class="modal-title text-white fs-5" id="local-modal-label">Các địa phương</h1>
                    <button class="btn-close text-white" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3 form-group">
                        <label class="form-label" for="local-city" data-bs-toggle="tooltip" data-bs-title="Tỉnh hoặc thành phố của địa phương">Tỉnh / Thành phố</label>
                        <input class="form-control" id="local-city" name="city" type="text" placeholder="Nhập tên tỉnh / thành phố">
                    </div>
                    <div class="mb-3 form-group">
                        <label class="form-label" for="local-district" data-bs-toggle="tooltip" data-bs-title="Quận hoặc huyện của địa phương">Quận / Huyện</label>
                        <textarea class="form-control" id="local-district" name="district" rows="6" placeholder="Nhập tên quận / huyện"></textarea>
                    </div>
                    <hr class="px-5">
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-12 text-end">
                                @if (!empty(Auth::user()->hasAnyPermission(App\Models\User::UPDATE_LOCAL, App\Models\User::CREATE_LOCAL)))
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
