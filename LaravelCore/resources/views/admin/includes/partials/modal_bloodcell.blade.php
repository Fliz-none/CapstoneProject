<form class="save-form" id="bloodcell-form" method="post">
    @csrf
    <div class="modal fade" id="bloodcell-modal" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="bloodcell-modal-label" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h1 class="modal-title fs-5 text-white" id="bloodcell-modal-label">Phiếu Xét Nghiệm Đếm Tế Bào Máu <span class="bloodcell-code text-white"></span></h1>
                    <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card card-image border mb-2 p-2">
                        <div class="row">
                            <div class="col-6 col-lg-2">
                                <div class="ratio ratio-1x1">
                                    <img class="card-img object-fit-cover p-1 bloodcell-pet-image thumb" src="">
                                </div>
                            </div>
                            <div class="col-6 col-lg-3 pt-3">
                                <p class="card-title fs-5 d-inline-block fs-5 fw-bold mb-0">
                                    <span class="bloodcell-pet-name" data-bs-toggle="tooltip" data-bs-title=""></span>
                                    <span class="badge bg-light-info fs-6 bloodcell-pet-infor"></span>
                                </p>
                                <p class="text-sm">
                                    Tuổi: <span class="fw-bold bloodcell-pet-age"></span><br>
                                    Giống: <span class="fw-bold bloodcell-pet-lineage"></span><br>
                                    Cân nặng: <span class="fw-bold bloodcell-pet-weight"></span><br>
                                </p>
                            </div>
                            <div class="col-12 col-lg-3 pt-3">
                                <p>
                                    <span class="fw-bold bloodcell-customer-name"></span> <span class="badge bg-light-info fs-6 bloodcell-customer-gender"><small></small> </span><br />
                                    <small class="bloodcell-customer-infor"></small>
                                </p>
                            </div>
                            <div class="col-12 col-lg-4 pt-3">
                                <p>
                                    Bác sĩ yêu cầu: <span class="fw-bold bloodcell-info-doctor"></span><br>
                                    Lý do đến khám: <span class="fw-bold bloodcell-info-requirements"></span><br>
                                    Chẩn đoán sơ bộ: <span class="fw-bold bloodcell-info-prelim_diag"></span><br>
                                    KTV thực hiện: <span class="fw-bold bloodcell-info-technician"></span>
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
                                            <label class="form-label fw-bold" data-bs-toggle="tooltip" data-bs-title="Chọn chỉ tiêu" for="bloodcell-criterial-search">Chỉ tiêu</label>
                                            <a class="btn btn-link btn-sm btn-add-all btn-create-bloodcell_details cursor-pointer">Thêm tất cả</a>
                                            <input class="form-control search-input" id="bloodcell-criterial-search" placeholder="Tìm kiếm">
                                        </div>
                                        <div class="search-item overflow-auto" style="max-height: 500px">
                                            <ul class="list-group search-list bloodcell-list">
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-9">
                                    <h3 class="fs-6">Nội dung <span class="bloodcell-service-name"></span></h3>
                                    <div class="table-responsive">
                                        <table class="table key-table" style="min-width: 500px">
                                            <thead>
                                                <tr>
                                                    <th>Chỉ tiêu</th>
                                                    <th style="width: 18%">Kết quả</th>
                                                    <th style="width: 18%">Đánh giá</th>
                                                    <th style="width: 7%"></th>
                                                </tr>
                                            </thead>
                                            <tbody class="bloodcell-details">
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-12 col-lg-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="bloodcell-conclusion">Kết luận</label>
                                                <textarea class="form-control" id="bloodcell-conclusion" name="conclusion" placeholder="Kết luận" autocomplete="off"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="bloodcell-recommendation">Khuyến cáo</label>
                                                <textarea class="form-control" id="bloodcell-recommendation" name="recommendation" placeholder="Khuyến cáo" autocomplete="off"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-12">
                                            <div class="mb-3">
                                                <label class="form-label">Hình ảnh</label>
                                                <div class="row align-items-center border border-light-subtle rounded-1 m-0" data-gallery="bloodcell-images">
                                                    <div class="col-6 col-lg-2 mt-2">
                                                        <a class="btn-upload-images cursor-pointer" data-id="bloodcell-images">
                                                            <div class="card text-primary add-gallery object-fit-cover ratio ratio-1x1 mb-2">
                                                                <i class="bi bi-plus"></i>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                                <input class="d-none image-array" name="images[]" data-id="bloodcell-images" type="file" accept="image/*" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr class="ms-2">
                            <div class="row align-items-center">
                                <div class="col-12 col-lg-4 btn-group mb-3 mb-lg-0">
                                    <input class="btn-check" id="bloodcell-complete" name="status" type="radio" value="0" checked>
                                    <label class="btn btn-outline-info" for="bloodcell-complete">Đang chờ</label>
                                    <input class="btn-check" id="bloodcell-waiting" name="status" type="radio" value="1">
                                    <label class="btn btn-outline-success" for="bloodcell-waiting">Hoàn thành</label>
                                </div>
                                <input name="id" type="hidden">
                                <div class="col-12 col-lg-8 text-end mb-3 mb-lg-0">
                                    <a class="btn btn-success m-1 btn-print print-bloodcell" data-url="{{ getPath(route('admin.bloodcell')) }}">
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
