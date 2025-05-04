<!-- Modal sort -->
<div class="modal fade" id="sort-modal" aria-labelledby="sort-label">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title fs-5" id="sort-label">Sắp xếp thứ tự</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <h6 class="text-secondary">Chọn kiểu sắp xếp</h6>
                        <select name="type" id="sort-type" class="form-select">
                            <option hidden selected disabled>Chọn một kiểu sắp xếp</option>
                            <option value="time-az">Thời gian (cũ trước)</option>
                            <option value="time-za">Thời gian (mới trước)</option>
                            <option value="title-az">Tiêu đề (A-Z)</option>
                            <option value="title-za">Tiêu đề (Z-A)</option>
                        </select>
                        <hr class="px-5 mt-3">
                        <ul id="sortable" class="list-group mb-3">
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>