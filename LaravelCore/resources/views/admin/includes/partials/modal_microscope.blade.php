<form class="save-form" id="microscope-form" method="post">
    @csrf
    <div class="modal fade" id="microscope-modal" data-bs-backdrop="static" aria-labelledby="microscope-modal-label">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h1 class="modal-title fs-5 text-white" id="microscope-modal-label">Phiếu Soi Kính Hiển Vi <span class="microscope-code text-white"></span></h1>
                    <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card card-image border mb-2 p-2">
                        <div class="row">
                            <div class="col-6 col-lg-2">
                                <div class="ratio ratio-1x1">
                                    <img class="card-img object-fit-cover p-1 microscope-pet-image" src="">
                                </div>
                            </div>
                            <div class="col-6 col-lg-3 pt-3">
                                <p class="card-title fs-5 d-inline-block fs-5 fw-bold mb-0">
                                    <span class="microscope-pet-name" data-bs-toggle="tooltip" data-bs-title=""></span>
                                    <span class="badge bg-light-info fs-6 microscope-pet-infor"></span>
                                </p>
                                <p class="text-sm">
                                    Tuổi: <span class="fw-bold microscope-pet-age"></span><br>
                                    Giống: <span class="fw-bold microscope-pet-lineage"></span><br>
                                    Cân nặng: <span class="fw-bold microscope-pet-weight"></span><br>
                                </p>
                            </div>
                            <div class="col-12 col-lg-3 pt-3">
                                <p>
                                    <span class="fw-bold microscope-customer-name"></span> <span class="badge bg-light-info fs-6 microscope-customer-gender"><small></small> </span><br />
                                    <small class="microscope-customer-infor"></small>
                                </p>
                            </div>
                            <div class="col-12 col-lg-4 pt-3">
                                <p>
                                    Bác sĩ yêu cầu: <span class="fw-bold microscope-info-doctor"></span><br>
                                    Lý do đến khám: <span class="fw-bold microscope-info-requirements"></span><br>
                                    Chẩn đoán sơ bộ: <span class="fw-bold microscope-info-prelim_diag"></span><br>
                                    KTV thực hiện: <span class="fw-bold microscope-info-technician"></span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="card border mb-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <h3 class="fs-6">Nội dung <span class="microscope-service-name"></span></h3>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="microscope-sample">Mẫu kiểm tra</label>
                                        <input class="form-control" id="microscope-sample" name="sample" type="text" placeholder="Mẫu kiểm tra" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="microscope-method">Phương pháp kiểm tra</label>
                                        <input class="form-control" id="microscope-method" name="method" type="text" placeholder="Phương pháp kiểm tra" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="microscope-conclusion">Kết luận</label>
                                        <textarea class="form-control" id="microscope-conclusion" name="conclusion" placeholder="Kết luận" autocomplete="off"></textarea>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="microscope-recommendation">Khuyến cáo</label>
                                        <textarea class="form-control" id="microscope-recommendation" name="recommendation" placeholder="Khuyến cáo" autocomplete="off"></textarea>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-12">
                                    <div class="mb-3">
                                        <label class="form-label">Hình ảnh</label>
                                        <div class="row align-items-center border border-light-subtle rounded-1 m-0" data-gallery="microscope-images">
                                            <div class="col-6 col-lg-2 mt-2">
                                                <a class="btn-upload-images cursor-pointer" data-id="microscope-images">
                                                    <div class="card text-primary add-gallery object-fit-cover ratio ratio-1x1 mb-2">
                                                        <i class="bi bi-plus"></i>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <input class="d-none image-array" name="images[]" data-id="microscope-images" type="file" accept="image/*" multiple>
                                    </div>
                                </div>
                            </div>
                            <hr class="ms-2">
                            <div class="row align-items-center">
                                <div class="col-12 col-lg-4 btn-group mb-3 mb-lg-0">
                                    <input class="btn-check" id="microscope-complete" name="status" type="radio" value="0" checked>
                                    <label class="btn btn-outline-info" for="microscope-complete">Đang chờ</label>
                                    <input class="btn-check" id="microscope-waiting" name="status" type="radio" value="1">
                                    <label class="btn btn-outline-success" for="microscope-waiting">Hoàn thành</label>
                                </div>
                                <input name="id" type="hidden">
                                <div class="col-12 col-lg-8 text-end mb-3 mb-lg-0">
                                    <a class="btn btn-success m-1 btn-print print-microscope" data-url="{{ getPath(route('admin.microscope')) }}">
                                        <i class="bi bi-printer"></i>
                                        In phiếu
                                    </a>
                                    <button class="btn btn-info m-1" type="submit">
                                        <i class="bi bi-floppy"></i> Lưu phiếu
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
