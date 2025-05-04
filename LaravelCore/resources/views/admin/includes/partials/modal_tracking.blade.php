<form class="save-form" id="tracking-form" method="post">
    @csrf
    <div class="modal fade" id="tracking-modal" data-bs-backdrop="static" aria-labelledby="tracking-modal-label">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background: #1c50b7">
                    <h1 class="modal-title text-white fs-5" id="tracking-modal-label">Phiếu theo dõi</h1>
                    <button class="btn-close text-white" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card border">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table mb-3">
                                    <thead>
                                        <tr>
                                            <th>Chỉ tiêu theo dõi</th>
                                            <th>Kết quả</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody class="tracking-details">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <div class="mb-3">
                                <label class="form-label" for="tracking-note">Kết luận</label>
                                <textarea class="form-control" id="tracking-note" name="note" placeholder="Kết luận bằng lời" rows="2" autocomplete="off"></textarea>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Đánh giá bằng điểm</label>
                                <div class="rating">
                                    <input class="rating__control d-none" id="star-1" name="score" type="radio" value="1">
                                    <input class="rating__control d-none" id="star-2" name="score" type="radio" value="2">
                                    <input class="rating__control d-none" id="star-3" name="score" type="radio" value="3">
                                    <input class="rating__control d-none" id="star-4" name="score" type="radio" value="4">
                                    <input class="rating__control d-none" id="star-5" name="score" type="radio" value="5">
                                    <input class="rating__control d-none" id="star-6" name="score" type="radio" value="6">
                                    <input class="rating__control d-none" id="star-7" name="score" type="radio" value="7">
                                    <input class="rating__control d-none" id="star-8" name="score" type="radio" value="8">
                                    <input class="rating__control d-none" id="star-9" name="score" type="radio" value="9">
                                    <input class="rating__control d-none" id="star-10" name="score" type="radio" value="10">
                                    <label class="rating__item" for="star-1" title="1/10"><i class="bi bi-star-fill"></i></label>
                                    <label class="rating__item" for="star-2" title="2/10"><i class="bi bi-star-fill"></i></label>
                                    <label class="rating__item" for="star-3" title="3/10"><i class="bi bi-star-fill"></i></label>
                                    <label class="rating__item" for="star-4" title="4/10"><i class="bi bi-star-fill"></i></label>
                                    <label class="rating__item" for="star-5" title="5/10"><i class="bi bi-star-fill"></i></label>
                                    <label class="rating__item" for="star-6" title="6/10"><i class="bi bi-star-fill"></i></label>
                                    <label class="rating__item" for="star-7" title="7/10"><i class="bi bi-star-fill"></i></label>
                                    <label class="rating__item" for="star-8" title="8/10"><i class="bi bi-star-fill"></i></label>
                                    <label class="rating__item" for="star-9" title="9/10"><i class="bi bi-star-fill"></i></label>
                                    <label class="rating__item" for="star-10" title="10/10"><i class="bi bi-star-fill"></i></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <label class="form-label">Hình ảnh</label>
                                <div class="row align-items-center border border-light-subtle rounded-1 m-0" data-gallery="tracking-images">
                                    <div class="col-6 col-lg-2 mt-2">
                                        <a class="btn-upload-images cursor-pointer" data-id="tracking-images">
                                            <div class="card text-primary add-gallery object-fit-cover ratio ratio-1x1 mb-2">
                                                <i class="bi bi-plus"></i>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <input class="d-none image-array" name="images[]" data-id="tracking-images" type="file" accept="image/*" multiple>
                            </div>
                        </div>
                    </div>
                    <hr class="px-5">
                    <div class="row mb-3">
                        <div class="col-12 text-end">
                            <input name="accommodation_id" type="hidden">
                            <input name="id" type="hidden">
                            <button class="btn btn-info" type="submit">Cập nhật</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
