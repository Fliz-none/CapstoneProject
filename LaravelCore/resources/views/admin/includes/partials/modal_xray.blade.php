<form class="save-form" id="xray-form" method="post">
    @csrf
    <div class="modal fade" id="xray-modal" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="xray-modal-label" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h1 class="modal-title fs-5 text-white" id="xray-modal-label">Phiếu X-Quang <span class="xray-code text-white"></span></h1>
                    <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card card-image border mb-2 p-2">
                        <div class="row">
                            <div class="col-6 col-lg-2">
                                <div class="ratio ratio-1x1">
                                    <img class="card-img object-fit-cover p-1 xray-pet-image" src="">
                                </div>
                            </div>
                            <div class="col-6 col-lg-3 pt-3">
                                <p class="card-title fs-5 d-inline-block fs-5 fw-bold mb-0">
                                    <span class="xray-pet-name" data-bs-toggle="tooltip" data-bs-title=""></span>
                                    <span class="badge bg-light-info fs-6 xray-pet-infor"></span>
                                </p>
                                <p class="text-sm">
                                    Tuổi: <span class="fw-bold xray-pet-age"></span><br>
                                    Giống: <span class="fw-bold xray-pet-lineage"></span><br>
                                    Cân nặng: <span class="fw-bold xray-pet-weight"></span><br>
                                </p>
                            </div>
                            <div class="col-12 col-lg-3 pt-3">
                                <p>
                                    <span class="fw-bold xray-customer-name"></span> <span class="badge bg-light-info fs-6 xray-customer-gender"><small></small> </span><br />
                                    <small class="xray-customer-infor"></small>
                                </p>
                            </div>
                            <div class="col-12 col-lg-4 pt-3">
                                <p>
                                    Bác sĩ yêu cầu: <span class="fw-bold xray-info-doctor"></span><br>
                                    Lý do đến khám: <span class="fw-bold xray-info-requirements"></span><br>
                                    Chẩn đoán sơ bộ: <span class="fw-bold xray-info-prelim_diag"></span><br>
                                    KTV thực hiện: <span class="fw-bold xray-info-technician"></span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="card border mb-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-lg-3">
                                    <div class="position-relative overflow-auto mb-3">
                                        <div class="mb-3 position-relative search-container">
                                            <label class="form-label fw-bold" data-bs-toggle="tooltip" data-bs-title="Lựa chọn cơ quan siêu âm" for="xray-criterial-search">Cơ quan</label>
                                            <input class="form-control search-input" id="xray-criterial-search" placeholder="Tìm kiếm">
                                        </div>
                                        <div class="search-item overflow-auto" style="max-height: 500px">
                                            <ul class="list-group search-list xray-list"></ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-9">
                                    <h3 class="fs-6">Nội dung <span class="xray-service-name"></span></h3>
                                    <div class="xray-details"></div>
                                    <div class="row mt-3">
                                        <div class="col-12 col-lg-12">
                                            <div class="mb-3">
                                                <label class="form-label" for="xray-conclusion">Kết luận</label>
                                                <textarea class="form-control" id="xray-conclusion" name="conclusion" placeholder="Kết luận" rows="3" autocomplete="off"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr class="ms-2">
                            <div class="row align-items-center">
                                <div class="col-12 col-lg-4 btn-group mb-3 mb-lg-0">
                                    <input class="btn-check" id="xray-complete" name="status" type="radio" value="0" checked>
                                    <label class="btn btn-outline-info" for="xray-complete">Đang chờ</label>
                                    <input class="btn-check" id="xray-waiting" name="status" type="radio" value="1">
                                    <label class="btn btn-outline-success" for="xray-waiting">Hoàn thành</label>
                                </div>
                                <input name="id" type="hidden">
                                <div class="col-12 col-lg-8 text-end">
                                    <a class="btn btn-success m-1 btn-print print-xray" data-url="{{ getPath(route('admin.xray')) }}">
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
