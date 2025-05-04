<form class="save-form" id="surgery-form" method="post">
    @csrf
    <div class="modal fade" id="surgery-modal" data-bs-backdrop="static" aria-labelledby="surgery-modal-label">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h1 class="modal-title fs-5 text-white" id="surgery-modal-label">Phiếu Phẫu Thuật</h1>
                    <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card card-image border mb-2 p-2">
                        <div class="row">
                            <div class="col-6 col-lg-2">
                                <div class="ratio ratio-1x1">
                                    <img class="card-img object-fit-cover p-1 surgery-pet-image" src="">
                                </div>
                            </div>
                            <div class="col-6 col-lg-3 pt-3">
                                <p class="card-title fs-5 d-inline-block fs-5 fw-bold mb-0">
                                    <span class="surgery-pet-name" data-bs-toggle="tooltip" data-bs-title=""></span>
                                    <span class="badge bg-light-info fs-6 surgery-pet-infor"></span>
                                </p>
                                <p class="text-sm">
                                    Tuổi: <span class="fw-bold surgery-pet-age"></span><br>
                                    Giống: <span class="fw-bold surgery-pet-lineage"></span><br>
                                    Cân nặng: <span class="fw-bold surgery-pet-weight"></span><br>
                                </p>
                            </div>
                            <div class="col-12 col-lg-3 pt-3">
                                <p>
                                    <span class="fw-bold surgery-customer-name"></span> <span class="badge bg-light-info fs-6 surgery-customer-gender"><small></small> </span><br />
                                    <small class="surgery-customer-infor"></small>
                                </p>
                            </div>
                            <div class="col-12 col-lg-4 pt-3">
                                <p>
                                    Bác sĩ yêu cầu: <span class="fw-bold surgery-info-doctor"></span><br>
                                    Lý do đến khám: <span class="fw-bold surgery-info-requirements"></span><br>
                                    Chẩn đoán sơ bộ: <span class="fw-bold surgery-info-prelim_diag"></span><br>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="card border">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <h3 class="fs-6">Nội dung <span class="surgery-service-name"></span></h3>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="surgery-surgical_method">Phương pháp phẫu thuật</label>
                                        <input class="form-control" id="surgery-surgical_method" name="surgical_method" type="text" placeholder="Phương pháp phẫu thuật">
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="surgery-anesthesia_method">Phương pháp gây mê, gây tê</label>
                                        <input class="form-control" id="surgery-anesthesia_method" name="anesthesia_method" type="text" placeholder="Phương pháp gây mê, gây tê">
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="surgery-surgeon_id">Bác sĩ phẫu thuật</label>
                                        <select class="form-select surgery-doctor" id="surgery-surgeon_id" name="surgeon_id"></select>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="surgery-assistant_id">Bác sĩ phụ</label>
                                        <select class="form-select surgery-doctor" id="surgery-assistant_id" name="assistant_id"></select>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="surgery-anesthetist_id">Bác sĩ gây mê hồi sức</label>
                                        <select class="form-select surgery-doctor" id="surgery-anesthetist_id" name="anesthetist_id"></select>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="mb-3 pe-2">
                                            <label class="form-label" for="surgery-begin_at">Thời gian bắt đầu</label>
                                            <input class="form-control" id="surgery-begin_at" name="begin_at" type="datetime-local">
                                        </div>
                                        <div class="mb-3 pe-2">
                                            <label class="form-label" for="surgery-complete_at">Thời gian kết thúc</label>
                                            <input class="form-control" id="surgery-complete_at" name="complete_at" type="datetime-local">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card border">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-lg-6 mb-3">
                                    <h3 class="fs-6">Lược đồ phẫu thuật</h3>

                                </div>
                                <div class="col-12 col-lg-6 mb-3 text-end">
                                    <a class="btn btn-outline-info ms-2 mb-3 block btn-create-diagram">
                                        <i class="bi bi-plus-circle"></i>
                                        Thêm trình tự
                                    </a>
                                </div>
                                <div class="col-12 mb-3">
                                    <div class="table-responsive">
                                        <table class="table key-table text-center">
                                            <thead>
                                                <tr>
                                                    <th style="width: 20%">Thời gian</th>
                                                    <th>Trình tự thực hiện</th>
                                                    <th style="width: 5%"></th>
                                                </tr>
                                            </thead>
                                            <tbody class="surgery-diagrams"></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card border mb-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 d-flex justify-content-between mb-3">
                                    <h3 class="fs-6">Theo dõi</h3>
                                </div>
                                <div class="col-12 mb-3">
                                    <div class="table-responsive">
                                        <table class="table key-table text-center surgery-details">
                                            <thead>
                                                <tr></tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Hình ảnh trước phẫu thuật</label>
                                        <div class="row align-items-center border border-light-subtle rounded-1 m-0 surgery-gallery" data-gallery="surgery-images_before">
                                            <div class="col-6 col-lg-2 mt-2">
                                                <a class="btn-upload-images cursor-pointer" data-id="surgery-images_before">
                                                    <div class="card text-primary add-gallery object-fit-cover ratio ratio-1x1 mb-2">
                                                        <i class="bi bi-plus"></i>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <input class="d-none image-array" name="images_before[]" data-id="surgery-images_before" type="file" accept="image/*" multiple>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6 mb-3">
                                    <label class="form-label" for="surgery-diagnosis-after">Hình ảnh sau phẫu thuật</label>
                                    <div class="row align-items-center border border-light-subtle rounded-1 m-0 surgery-gallery" data-gallery="surgery-images_after">
                                        <div class="col-6 col-lg-2 mt-2">
                                            <a class="btn-upload-images cursor-pointer" data-id="surgery-images_after">
                                                <div class="card text-primary add-gallery object-fit-cover ratio ratio-1x1 mb-2">
                                                    <i class="bi bi-plus"></i>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                    <input class="d-none image-array" name="images_after[]" data-id="surgery-images_after" type="file" accept="image/*" multiple>
                                </div>
                                <div class="col-12 col-lg-6 mb-3">
                                    <label class="form-label" for="surgery-advice">Lời dặn của BS</label>
                                    <textarea class="form-control" id="surgery-advice" name="advice" placeholder="Lời dặn của BS" rows="3" autocomplete="off"></textarea>
                                </div>
                            </div>
                            <hr class="ms-2">
                            <div class="row">
                                <div class="col-12 col-lg-4 mb-3 mb-lg-0">
                                    <div class="btn-group w-100">
                                        <input class="btn-check" id="surgery-complete" name="status" type="radio" value="0" checked>
                                        <label class="btn btn-outline-info" for="surgery-complete">Đang chờ</label>
                                        <input class="btn-check" id="surgery-waiting" name="status" type="radio" value="1">
                                        <label class="btn btn-outline-success" for="surgery-waiting">Hoàn thành</label>
                                    </div>
                                </div>
                                <input name="id" type="hidden">
                                <div class="col-12 col-lg-8 text-end mb-3 mb-lg-0">
                                    <button class="btn btn-primary text-decoration-none btn-print print-commitment" data-template="commitment_a5" data-url="{{ getPath(route('admin.info')) }}" type="button">
                                        <i class="bi bi-printer-fill"></i> In cam kết
                                    </button>
                                    <a class="btn btn-success m-1 btn-print print-surgery" data-url="{{ getPath(route('admin.surgery')) }}">
                                        <i class="bi bi-printer"></i>
                                        In phiếu
                                    </a>
                                    <button class="btn btn-info m-1" type="submit">
                                        <i class="bi bi-floppy"></i>
                                        Lưu phiếu
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
