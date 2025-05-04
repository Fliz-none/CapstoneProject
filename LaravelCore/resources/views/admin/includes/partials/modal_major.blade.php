<form class="save-form" id="major-form" method="post">
    @csrf
    <div class="modal fade" id="major-modal" data-bs-backdrop="static" aria-labelledby="major-modal-label">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h1 class="modal-title text-white fs-5" id="major-modal-label">Danh mục</h1>
                    <button class="btn-close text-white" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <div class="sticky-top">
                                <label class="form-label select-image" for="major-avatar">
                                    <img class="img-fluid rounded-4 object-fit-cover" src="{{ asset('admin/images/placeholder.webp') }}" alt="Ảnh đại diện">
                                </label>
                                <input class="hidden-image" id="major-avatar" name="avatar" type="hidden">
                                <div class="d-grid">
                                    <button class="btn btn-outline-primary btn-remove-image d-none" type="button">Xoá</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="mb-3">
                                <label class="form-label" for="major-name">Tên</label>
                                <input class="form-control" id="major-name" name="name" type="text" placeholder="Tên danh mục" autocomplete="off" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="major-color-blue">Màu chỉ thị</label>
                                <div class="d-grid">
                                    <div class="btn-group">
                                        <input class="btn-check" id="major-color-blue" name="color" type="radio" value="blue" autocomplete="off">
                                        <label class="btn btn-outline-blue rounded-pill px-2 py-3 m-1" for="major-color-blue"></label>
                                        <input class="btn-check" id="major-color-indigo" name="color" type="radio" value="indigo" autocomplete="off">
                                        <label class="btn btn-outline-indigo rounded-pill px-2 py-3 m-1" for="major-color-indigo"></label>
                                        <input class="btn-check" id="major-color-purple" name="color" type="radio" value="purple" autocomplete="off">
                                        <label class="btn btn-outline-purple rounded-pill px-2 py-3 m-1" for="major-color-purple"></label>
                                        <input class="btn-check" id="major-color-pink" name="color" type="radio" value="pink" autocomplete="off">
                                        <label class="btn btn-outline-pink rounded-pill px-2 py-3 m-1" for="major-color-pink"></label>
                                        <input class="btn-check" id="major-color-red" name="color" type="radio" value="red" autocomplete="off">
                                        <label class="btn btn-outline-red rounded-pill px-2 py-3 m-1" for="major-color-red"></label>
                                        <input class="btn-check" id="major-color-orange" name="color" type="radio" value="orange" autocomplete="off">
                                        <label class="btn btn-outline-orange rounded-pill px-2 py-3 m-1" for="major-color-orange"></label>
                                        <input class="btn-check" id="major-color-yellow" name="color" type="radio" value="yellow" autocomplete="off">
                                        <label class="btn btn-outline-yellow rounded-pill px-2 py-3 m-1" for="major-color-yellow"></label>
                                        <input class="btn-check" id="major-color-green" name="color" type="radio" value="green" autocomplete="off">
                                        <label class="btn btn-outline-green rounded-pill px-2 py-3 m-1" for="major-color-green"></label>
                                        <input class="btn-check" id="major-color-teal" name="color" type="radio" value="teal" autocomplete="off">
                                        <label class="btn btn-outline-teal rounded-pill px-2 py-3 m-1" for="major-color-teal"></label>
                                        <input class="btn-check" id="major-color-cyan" name="color" type="radio" value="cyan" autocomplete="off">
                                        <label class="btn btn-outline-cyan rounded-pill px-2 py-3 m-1" for="major-color-cyan"></label>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="major-note">Mô tả</label>
                                <textarea class="form-control" id="major-note" name="note" rows="9" placeholder="Nhập nội dung mô tả"></textarea>
                            </div>
                        </div>
                    </div>
                    <hr class="px-5">
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-12 col-lg-6">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" id="major-status" name="status" type="checkbox" checked>
                                    <label class="form-check-label" for="major-status">Hoạt động</label>
                                </div>
                            </div>
                            <div class="col-12 text-end">
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
