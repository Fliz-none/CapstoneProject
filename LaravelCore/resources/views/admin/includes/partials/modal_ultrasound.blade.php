<form class="save-form" id="ultrasound-form" method="post">
    @csrf
    <div class="modal fade" id="ultrasound-modal" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="ultrasound-modal-label" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h1 class="modal-title fs-5 text-white" id="ultrasound-modal-label">Phiếu Siêu Âm <span class="ultrasound-code text-white"></span></h1>
                    <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card card-image border mb-2 p-2">
                        <div class="row">
                            <div class="col-6 col-lg-2">
                                <div class="ratio ratio-1x1">
                                    <img class="card-img object-fit-cover p-1 ultrasound-pet-image" src="">
                                </div>
                            </div>
                            <div class="col-6 col-lg-3 pt-3">
                                <p class="card-title fs-5 d-inline-block fs-5 fw-bold mb-0">
                                    <span class="ultrasound-pet-name" data-bs-toggle="tooltip" data-bs-title=""></span>
                                    <span class="badge bg-light-info fs-6 ultrasound-pet-infor"></span>
                                </p>
                                <p class="text-sm">
                                    Tuổi: <span class="fw-bold ultrasound-pet-age"></span><br>
                                    Giống: <span class="fw-bold ultrasound-pet-lineage"></span><br>
                                    Cân nặng: <span class="fw-bold ultrasound-pet-weight"></span><br>
                                </p>
                            </div>
                            <div class="col-12 col-lg-3 pt-3">
                                <p>
                                    <span class="fw-bold ultrasound-customer-name"></span> <span class="badge bg-light-info fs-6 ultrasound-customer-gender"><small></small> </span><br />
                                    <small class="ultrasound-customer-infor"></small>
                                </p>
                            </div>
                            <div class="col-12 col-lg-4 pt-3">
                                <p>
                                    Bác sĩ yêu cầu: <span class="fw-bold ultrasound-info-doctor"></span><br>
                                    Lý do đến khám: <span class="fw-bold ultrasound-info-requirements"></span><br>
                                    Chẩn đoán sơ bộ: <span class="fw-bold ultrasound-info-prelim_diag"></span><br>
                                    KTV thực hiện: <span class="fw-bold ultrasound-info-technician"></span>
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
                                            <label class="form-label fw-bold" data-bs-toggle="tooltip" data-bs-title="Lựa chọn cơ quan siêu âm" for="ultrasound-criterial-search">Cơ quan</label>
                                            <input class="form-control search-input" id="ultrasound-criterial-search" placeholder="Tìm kiếm">
                                        </div>
                                        <div class="search-item overflow-auto" style="max-height: 500px">
                                            <ul class="list-group search-list ultrasound-list"></ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-9">
                                    <h3 class="fs-6">Nội dung <span class="ultrasound-service-name"></span></h3>
                                    <div class="ultrasound-details"></div>
                                    <div class="row mt-3">
                                        <div class="col-12 col-lg-12">
                                            <div class="mb-3">
                                                <label class="form-label" for="ultrasound-conclusion">Kết luận</label>
                                                <textarea class="form-control" id="ultrasound-conclusion" name="conclusion" placeholder="Kết luận" rows="3" autocomplete="off"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr class="ms-2">
                            <div class="row align-items-center">
                                <div class="col-12 col-lg-4 btn-group mb-3 mb-lg-0">
                                    <input class="btn-check" id="ultrasound-complete" name="status" type="radio" value="0" checked>
                                    <label class="btn btn-outline-info" for="ultrasound-complete">Đang chờ</label>
                                    <input class="btn-check" id="ultrasound-waiting" name="status" type="radio" value="1">
                                    <label class="btn btn-outline-success" for="ultrasound-waiting">Hoàn thành</label>
                                </div>
                                <input name="id" type="hidden">
                                <div class="col-12 col-lg-8 text-end">
                                    <a class="btn btn-success m-1 btn-print print-ultrasound" data-url="{{ getPath(route('admin.ultrasound')) }}">
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
