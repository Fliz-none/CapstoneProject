<form class="save-form" id="pet-form" method="post">
    @csrf
    <div class="modal fade" id="pet-modal" data-bs-backdrop="static" aria-labelledby="pet-modal-label">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h1 class="modal-title fs-5 text-white" id="pet-modal-label">Thú cưng</h1>
                    <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-md-4">
                            <div class="sticky-top">
                                <div class="form-group mb-3">
                                    <label class="form-label ratio ratio-1x1 select-avatar" for="pet-avatar">
                                        <img class="img-fluid rounded-4 object-fit-cover" id="pet-avatar-preview" src="{{ asset('admin/images/placeholder.webp') }}" alt="Ảnh đại diện">
                                    </label>
                                    <input class="form-control" id="pet-avatar" name="avatar" type="file" hidden accept="image/*">
                                    <div class="d-grid">
                                        <button class="btn btn-outline-primary btn-remove-image d-none" data-url="{{ getPath(route('admin.pet.remove.avatar')) }}" type="button">Xoá</button>
                                    </div>
                                </div>
                                <div class="accordion accordion-pet-stat" id="pet-stat">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="pet-stat-heading-vaccination">
                                            <button class="accordion-button p-2" data-bs-toggle="collapse" data-bs-target="#pet-stat-vaccination" type="button" aria-expanded="true" aria-controls="pet-stat-vaccination">
                                                Sổ tiêm chủng
                                            </button>
                                        </h2>
                                        <div class="accordion-collapse collapse show" id="pet-stat-vaccination" data-bs-parent="#pet-stat" aria-labelledby="pet-stat-heading-vaccination">
                                            <div class="accordion-body p-2">
                                                <ul class="list-group pet-stat-list-vaccination mb-1 overflow-auto" style="max-height: 450px"></ul>
                                                <div class="d-grid">
                                                    <div class="btn-group btn-group-sm">
                                                        <div class="btn btn-outline-primary btn-create-vaccination"><i class="bi bi-plus-circle"></i> Thêm</div>
                                                        <div class="btn btn-outline-danger btn-remove-vaccination"><i class="bi bi-trash"></i></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="pet-stat-heading-diag">
                                            <button class="accordion-button p-2 collapsed" data-bs-toggle="collapse" data-bs-target="#pet-stat-diag" type="button" aria-expanded="false" aria-controls="pet-stat-diag">
                                                Các chẩn đoán gần nhất
                                            </button>
                                        </h2>
                                        <div class="accordion-collapse collapse" id="pet-stat-diag" data-bs-parent="#pet-stat" aria-labelledby="pet-stat-heading-diag">
                                            <div class="accordion-body p-2">
                                                <ul class="list-group pet-stat-list-diag overflow-auto" style="max-height: 450px"></ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="pet-stat-heading-indication">
                                            <button class="accordion-button p-2 collapsed" data-bs-toggle="collapse" data-bs-target="#pet-stat-indication" type="button" aria-expanded="false" aria-controls="pet-stat-indication">
                                                Các dịch vụ gần nhất
                                            </button>
                                        </h2>
                                        <div class="accordion-collapse collapse" id="pet-stat-indication" data-bs-parent="#pet-stat" aria-labelledby="pet-stat-heading-indication">
                                            <div class="accordion-body p-2">
                                                <ul class="list-group pet-stat-list-indication overflow-auto" style="max-height: 450px"></ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-8">
                            <div class="form-group">
                                <label class="form-label" data-bs-toggle="tooltip" data-bs-title="Tên thú cưng mà người khách hàng cung cấp" for="pet-name">Tên thú cưng</label>
                                <input class="form-control" id="pet-name" name="name" type="text" placeholder="Tên thú cưng" autocomplete="off" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label" data-bs-toggle="tooltip" data-bs-title="Số tuổi của thú cưng" for="pet-birthday">Tuổi</label>
                                <div class="input-group">
                                    <input class="form-control" id="pet-birthday" name="birthday" type="text" autocomplete="off" inputmode="numeric" placeholder="Số tháng tuổi">
                                    <span class="input-group-text">tháng</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label" data-bs-toggle="tooltip" data-bs-title="Thú cưng thuộc sở hữu của khách hàng này" for="pet-customer_id">Khách hàng</label>
                                <select class="form-select select2" id="pet-customer_id" name="customer_id" data-ajax--url="{{ route('admin.user', ['key' => 'select2']) }}" data-placeholder="Chọn một khách hàng" autocomplete="off"
                                    required></select>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-6">
                                        <label class="form-label" data-bs-toggle="tooltip" data-bs-title="Loài vật của thú cưng" for="pet-specie">Loài vật</label>
                                        <select class="form-select select2 text-dark" id="pet-specie" name="specie" data-ajax--url="{{ route('admin.animal', ['key' => 'species']) }}" data-placeholder="Chọn một loài" autocomplete="off"
                                            required></select>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label" data-bs-toggle="tooltip" data-bs-title="Giống của thú cưng" for="pet-animal_id">Giống</label>
                                        <select class="form-select select2 text-dark" id="pet-animal_id" name="animal_id" data-ajax--url="{{ route('admin.animal', ['key' => 'lineages']) }}" data-placeholder="Chọn một giống" autocomplete="off"
                                            required></select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-6">
                                        <label class="form-label" data-bs-toggle="tooltip" data-bs-title="Kiểu lông của thú cưng" for="pet-fur_type">Kiểu lông</label>
                                        <input class="form-control text-dark" id="pet-fur_type" name="fur_type" type="text" autocomplete="fur_type">
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label" data-bs-toggle="tooltip" data-bs-title="Màu lông của thú cưng" for="pet-fur_color">Màu lông</label>
                                        <input class="form-control text-dark" id="pet-fur_color" name="fur_color" type="text" autocomplete="fur_color">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mt-3">
                                <label class="form-label" data-bs-toggle="tooltip" data-bs-title="Giới tính của thú cưng" for="pet-gender-male">Giới tính</label>
                                <div class="btn-group w-100">
                                    <input class="btn-check" id="pet-gender-male" name="gender" type="radio" value="1" autocomplete="off">
                                    <label class="btn btn-outline-info" for="pet-gender-male">Đực</label>
                                    <input class="btn-check" id="pet-gender-female" name="gender" type="radio" value="2" autocomplete="off">
                                    <label class="btn btn-outline-info" for="pet-gender-female">Cái</label>
                                    <input class="btn-check" id="pet-gender-other" name="gender" type="radio" value="0" autocomplete="off">
                                    <label class="btn btn-outline-info" for="pet-gender-other">Khác</label>
                                </div>
                            </div>
                            <div class="form-group mt-3">
                                <label class="form-label" data-bs-toggle="tooltip" data-bs-title="Thông tin triệt sản của thú cưng" for="pet-neuter-true">Triệt sản / Thiến</label>
                                <div class="btn-group w-100">
                                    <input class="btn-check" id="pet-neuter-true" name="neuter" type="radio" value="1" autocomplete="off">
                                    <label class="btn btn-outline-info" for="pet-neuter-true">Chưa</label>
                                    <input class="btn-check" id="pet-neuter-false" name="neuter" type="radio" value="2" autocomplete="off">
                                    <label class="btn btn-outline-info" for="pet-neuter-false">Rồi</label>
                                    <input class="btn-check" id="pet-neuter-other" name="neuter" type="radio" value="0" autocomplete="off">
                                    <label class="btn btn-outline-info" for="pet-neuter-other">Khác</label>
                                </div>
                            </div>
                            <div class="form-group mt-3">
                                <div class="col-12">
                                    <label class="form-label" data-bs-toggle="tooltip" data-bs-title="Ghi chú để gợi nhớ hoặc lưu ý về thú cung" for="pet-note">Ghi chú</label>
                                    <textarea class="form-control" id="pet-note" name="note" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-6 form-check form-switch">
                            <input class="form-check-input ms-0 ms-md-1 me-1 me-md-2" id="pet-status" name="status" type="checkbox" value="1" role="switch" checked>
                            <label class="form-check-label" data-bs-toggle="tooltip" data-bs-title="Trạng thái thú cưng (Có thể thay đổi sau)" for="pet-status">Hoạt động</label>
                        </div>
                        <div class="col-6 text-end">
                            @if (!empty(Auth::user()->hasAnyPermission(App\Models\User::UPDATE_PET, App\Models\User::CREATE_PET)))
                                <input name="id" type="hidden">
                                <button class="btn btn-primary" type="submit">Lưu</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
