<form class="save-form" id="biochemical-form" method="post">
    @csrf
    <div class="modal fade" id="biochemical-modal" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="biochemical-modal-label" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h1 class="modal-title fs-5 text-white" id="biochemical-modal-label">Phiếu Xét Nghiệm Sinh Hóa Máu <span class="biochemical-code text-white"></span></h1>
                    <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card card-image border mb-2 p-2">
                        <div class="row">
                            <div class="col-6 col-lg-2">
                                <div class="ratio ratio-1x1">
                                    <img class="card-img object-fit-cover p-1 biochemical-pet-image thumb" src="">
                                </div>
                            </div>
                            <div class="col-6 col-lg-3 pt-3">
                                <p class="card-title fs-5 d-inline-block fs-5 fw-bold mb-0">
                                    <span class="biochemical-pet-name" data-bs-toggle="tooltip" data-bs-title=""></span>
                                    <span class="badge bg-light-info fs-6 biochemical-pet-infor"></span>
                                </p>
                                <p class="text-sm">
                                    Tuổi: <span class="fw-bold biochemical-pet-age"></span><br>
                                    Giống: <span class="fw-bold biochemical-pet-lineage"></span><br>
                                    Cân nặng: <span class="fw-bold biochemical-pet-weight"></span><br>
                                </p>
                            </div>
                            <div class="col-12 col-lg-3 pt-3">
                                <p>
                                    <span class="fw-bold biochemical-customer-name"></span> <span class="badge bg-light-info fs-6 biochemical-customer-gender"><small></small> </span><br />
                                    <small class="biochemical-customer-infor"></small>
                                </p>
                            </div>
                            <div class="col-12 col-lg-4 pt-3">
                                <p>
                                    Bác sĩ yêu cầu: <span class="fw-bold biochemical-info-doctor"></span><br>
                                    Lý do đến khám: <span class="fw-bold biochemical-info-requirements"></span><br>
                                    Chẩn đoán sơ bộ: <span class="fw-bold biochemical-info-prelim_diag"></span><br>
                                    KTV thực hiện: <span class="fw-bold biochemical-info-technician"></span>
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
                                            <label class="form-label fw-bold" data-bs-toggle="tooltip" data-bs-title="Chọn chỉ tiêu" for="biochemical-criterial-search">Chỉ tiêu</label>
                                            <a class="btn btn-link btn-sm btn-add-all btn-create-biochemical_details cursor-pointer">Thêm tất cả</a>
                                            <input class="form-control search-input" id="biochemical-criterial-search" placeholder="Tìm kiếm">
                                        </div>
                                        <div class="search-item overflow-auto" style="max-height: 500px">
                                            <ul class="list-group search-list biochemical-list">
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-9">
                                    <h3 class="fs-6">Nội dung <span class="biochemical-service-name"></span></h3>
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
                                            <tbody class="biochemical-details">
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-12 col-lg-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="biochemical-conclusion">Kết luận</label>
                                                <textarea class="form-control" id="biochemical-conclusion" name="conclusion" placeholder="Kết luận" autocomplete="off"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="biochemical-recommendation">Khuyến cáo</label>
                                                <textarea class="form-control" id="biochemical-recommendation" name="recommendation" placeholder="Khuyến cáo" autocomplete="off"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-12">
                                            <div class="mb-3">
                                                <label class="form-label">Hình ảnh</label>
                                                <div class="row align-items-center border border-light-subtle rounded-1 m-0" data-gallery="biochemical-images">
                                                    <div class="col-6 col-lg-2 mt-2">
                                                        <a class="btn-upload-images cursor-pointer" data-id="biochemical-images">
                                                            <div class="card text-primary add-gallery object-fit-cover ratio ratio-1x1 mb-2">
                                                                <i class="bi bi-plus"></i>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                                <input class="d-none image-array" name="images[]" data-id="biochemical-images" type="file" accept="image/*" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr class="ms-2">
                            <div class="row align-items-center">
                                <div class="col-12 col-lg-4 btn-group mb-3 mb-lg-0">
                                    <input class="btn-check" id="biochemical-complete" name="status" type="radio" value="0" checked>
                                    <label class="btn btn-outline-info" for="biochemical-complete">Đang chờ</label>
                                    <input class="btn-check" id="biochemical-waiting" name="status" type="radio" value="1">
                                    <label class="btn btn-outline-success" for="biochemical-waiting">Hoàn thành</label>
                                </div>
                                <input name="id" type="hidden">
                                <div class="col-12 col-lg-8 text-end mb-3 mb-lg-0">
                                    <a class="btn btn-success m-1 btn-print print-biochemical" data-url="{{ getPath(route('admin.biochemical')) }}">
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
