<form class="save-form" id="beauty-form" method="post">
    @csrf
    <div class="modal fade" id="beauty-modal" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="beauty-modal-label" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h1 class="modal-title fs-5 text-white" id="beauty-modal-label">Phiếu Spa & Grooming <span class="beauty-code text-white"></span></h1>
                    <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card card-image border mb-2 p-2">
                        <div class="row">
                            <div class="col-6 col-lg-2">
                                <div class="ratio ratio-1x1">
                                    <img class="card-img object-fit-cover p-1 beauty-pet-image thumb" src="http://petclinic.test/admin/images/placeholder_key.png" alt="Cherry">
                                </div>
                            </div>
                            <div class="col-6 col-lg-3 pt-3">
                                <p class="card-title fs-5 d-inline-block fs-5 fw-bold mb-0">
                                    <span class="beauty-pet-name" data-bs-toggle="tooltip" data-bs-title="Cherry" data-bs-original-title="" title="">Cherry</span>
                                    <span class="badge bg-light-info fs-6 beauty-pet-infor"><small>Mèo </small></span>
                                </p>
                                <p class="text-sm">
                                    Tuổi: <span class="fw-bold beauty-pet-age">Không rõ</span><br>
                                    Giống: <span class="fw-bold beauty-pet-lineage">khác</span><br>
                                    Cân nặng: <span class="fw-bold beauty-pet-weight">3.5 kg</span><br>
                                </p>
                            </div>
                            <div class="col-12 col-lg-3 pt-3">
                                <p>
                                    <span class="fw-bold beauty-customer-name">Anh Nam</span> <span class="badge bg-light-info fs-6 beauty-customer-gender"><small>Nam</small> </span><br>
                                    <small class="beauty-customer-infor">0939819191 <br> </small>
                                </p>
                            </div>
                            <div class="col-12 col-lg-4 pt-3">
                                <p>
                                    Bác sĩ yêu cầu: <span class="fw-bold beauty-info-doctor">BSTY. ĐẶNG QUANG VINH</span><br>
                                    Lý do đến khám: <span class="fw-bold beauty-info-requirements">Làm đẹp </span><br>
                                    Chẩn đoán sơ bộ: <span class="fw-bold beauty-info-prelim_diag">Chưa ghi nhận bất thường</span><br>
                                    KTV thực hiện: <span class="fw-bold beauty-info-technician"></span>
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
                                            <label class="form-label fw-bold" data-bs-toggle="tooltip" data-bs-title="Chọn chỉ tiêu" data-bs-original-title="" for="beauty-criterial-search" title="">Chỉ tiêu</label>
                                            <a class="btn btn-link btn-sm btn-add-all btn-create-beauty_details cursor-pointer">Thêm tất cả</a>
                                            <input class="form-control search-input" id="beauty-criterial-search" placeholder="Tìm kiếm">
                                        </div>
                                        <div class="search-item overflow-auto" style="max-height: 500px">
                                            <ul class="list-group search-list beauty-list">
                                                <li class="list-group-item list-group-item-action rounded-3 border-0 cursor-pointer beauty-criterial p-1 py-2" data-name="Vệ sinh tai" data-id="">
                                                    <label>Vệ sinh tai</label>
                                                </li>
                                                <li class="list-group-item list-group-item-action rounded-3 border-0 cursor-pointer beauty-criterial p-1 py-2" data-name="Nhổ lông tai" data-id="">
                                                    <label>Nhổ lông tai</label>
                                                </li>
                                                <li class="list-group-item list-group-item-action rounded-3 border-0 cursor-pointer beauty-criterial p-1 py-2" data-name="Cắt móng" data-id="">
                                                    <label>Cắt móng</label>
                                                </li>
                                                <li class="list-group-item list-group-item-action rounded-3 border-0 cursor-pointer beauty-criterial p-1 py-2" data-name="Mài móng" data-id="">
                                                    <label>Mài móng</label>
                                                </li>
                                                <li class="list-group-item list-group-item-action rounded-3 border-0 cursor-pointer beauty-criterial p-1 py-2" data-name="Cạo bàn chân" data-id="">
                                                    <label>Cạo bàn chân</label>
                                                </li>
                                                <li class="list-group-item list-group-item-action rounded-3 border-0 cursor-pointer beauty-criterial p-1 py-2" data-name="Cạo long bụng" data-id="">
                                                    <label>Cạo long bụng</label>
                                                </li>
                                                <li class="list-group-item list-group-item-action rounded-3 border-0 cursor-pointer beauty-criterial p-1 py-2" data-name="Cạo lông hậu môn" data-id="">
                                                    <label>Cạo lông hậu môn</label>
                                                </li>
                                                <li class="list-group-item list-group-item-action rounded-3 border-0 cursor-pointer beauty-criterial p-1 py-2" data-name="Vắt tuyến hôi" data-id="">
                                                    <label>Vắt tuyến hôi</label>
                                                </li>
                                                <li class="list-group-item list-group-item-action rounded-3 border-0 cursor-pointer beauty-criterial p-1 py-2" data-name="Tắm" data-id="">
                                                    <label>Tắm</label>
                                                </li>
                                                <li class="list-group-item list-group-item-action rounded-3 border-0 cursor-pointer beauty-criterial p-1 py-2" data-name="Sấy lông" data-id="">
                                                    <label>Sấy lông</label>
                                                </li>
                                                <li class="list-group-item list-group-item-action rounded-3 border-0 cursor-pointer beauty-criterial p-1 py-2" data-name="Chảy lông" data-id="">
                                                    <label>Chảy lông</label>
                                                </li>
                                                <li class="list-group-item list-group-item-action rounded-3 border-0 cursor-pointer beauty-criterial p-1 py-2" data-name="Mùi" data-id="">
                                                    <label>Mùi</label>
                                                </li>
                                                <li class="list-group-item list-group-item-action rounded-3 border-0 cursor-pointer beauty-criterial p-1 py-2" data-name="Gỡ rối" data-id="">
                                                    <label>Gỡ rối</label>
                                                </li>
                                                <li class="list-group-item list-group-item-action rounded-3 border-0 cursor-pointer beauty-criterial p-1 py-2" data-name="Trầy xước" data-id="">
                                                    <label>Trầy xước</label>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-9">
                                    <h3 class="fs-6">Nội dung <span class="beauty-service-name">Combo 9B</span></h3>
                                    <div class="table-responsive">
                                        <table class="table key-table" style="min-width: 500px">
                                            <thead>
                                                <tr>
                                                    <th>Chỉ tiêu</th>
                                                    <th class="text-center" style="width: 30%">Đánh giá</th>
                                                    <th style="width: 7%"></th>
                                                </tr>
                                            </thead>
                                            <tbody class="beauty-details">
                                                <tr class="beauty-detail" data-criterial-id="">
                                                    <td><strong>Tắm</strong>
                                                    </td>
                                                    <td class="text-center">
                                                        <input class="form-check-input criterial-review" id="beauty_detail[0][review]" name="beauty_detail[0][review]" type="checkbox" value="">
                                                        <label class="form-check-label" for="beauty_detail[0][review]">
                                                            Đạt
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-link text-decoration-none btn-remove-criterial">
                                                            <i class="bi bi-trash3"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                <tr class="beauty-detail" data-criterial-id="">
                                                    <td><strong>Chải lông</strong>
                                                    </td>
                                                    <td class="text-center">
                                                        <input class="form-check-input criterial-review" id="beauty_detail[1][review]" name="beauty_detail[1][review]" type="checkbox" value="">
                                                        <label class="form-check-label" for="beauty_detail[1][review]">
                                                            Đạt
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-link text-decoration-none btn-remove-criterial">
                                                            <i class="bi bi-trash3"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                <tr class="beauty-detail" data-criterial-id="">
                                                    <td>
                                                        <input class="form-control" type="text" placeholder="Thêm chỉ tiêu"  autocomplete="off">    
                                                    </td>
                                                    <td> </td>
                                                    <td> </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-12 col-lg-12">
                                            <div class="mb-3">
                                                <label class="form-label">Hình ảnh</label>
                                                <div class="row align-items-center border border-light-subtle rounded-1 m-0" data-gallery="beauty-images">
                                                    <div class="col-6 col-lg-2 mt-2">
                                                        <a class="btn-upload-images cursor-pointer" data-id="beauty-images">
                                                            <div class="card text-primary add-gallery object-fit-cover ratio ratio-1x1 mb-2">
                                                                <i class="bi bi-plus"></i>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                                <input class="d-none image-array" name="images[]" data-id="beauty-images" type="file" accept="image/*" multiple>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="mb-3">
                                                <label class="form-label" for="beauty-note">Ghi chú</label>
                                                <textarea class="form-control" id="beauty-note" name="note" placeholder="Ghi chú" autocomplete="off"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr class="ms-2">
                            <div class="row align-items-center">
                                <div class="col-12 col-lg-4 btn-group mb-3 mb-lg-0">
                                    <input class="btn-check" id="beauty-complete" name="status" type="radio" value="0" checked>
                                    <label class="btn btn-outline-info" for="beauty-complete">Đang chờ</label>
                                    <input class="btn-check" id="beauty-waiting" name="status" type="radio" value="1">
                                    <label class="btn btn-outline-success" for="beauty-waiting">Hoàn thành</label>
                                </div>
                                <input name="id" type="hidden">
                                <div class="col-12 col-lg-8 text-end mb-3 mb-lg-0">
                                    <a class="btn btn-success m-1 btn-print print-beauty" data-url="{{ getPath(route('admin.beauty')) }}">
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
