<form class="save-form" id="booking-form" method="post">
    @csrf
    <div class="modal fade" id="booking-modal" data-bs-keyboard="false" data-bs-backdrop="static" aria-labelledby="booking-modal-label">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h1 class="modal-title fs-5 text-white" id="booking-modal-label"></h1>
                    <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <div class="mb-3 form-group">
                                <label class="form-label" for="booking-name">Tiêu đề</label>
                                <input class="form-control" id="booking-name" name="name" type="text" placeholder="Chủ đề cuộc hẹn" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="col-lg-6 form-group">
                            <label class="form-label" for="booking-service_id">Dịch vụ</label>
                            <select class="form-control select2" id="booking-service_id" name="service_id" data-ajax--url="{{ route('admin.service') }}/select2" data-placeholder="Chọn dịch vụ"></select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <div class="mb-3 form-group">
                                <label class="form-label" for="booking-description">Mô tả (gửi khách)</label>
                                <textarea class="form-control" id="booking-description" name="description" rows="3" placeholder="Nhập mô tả gửi cho khách hàng"></textarea>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="mb-3 form-group">
                                <label class="form-label" for="booking-note">Ghi chú (nội bộ)</label>
                                <textarea class="form-control" id="booking-note" name="note" rows="3" placeholder="Nhập ghi chú cuộc hẹn"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 form-group">
                        <label class="form-label" for="booking-appointment_hour-07">Chọn giờ hẹn</label>
                        <div class="d-grid table-responsive">
                            <div class="btn-group p-1" role="group" aria-label="Chọn giờ hẹn">
                                <input class="btn-check" id="booking-appointment_hour-07" name="appointment_hour" type="radio" value="07:00" autocomplete="off">
                                <label class="btn btn-outline-info fw-bold" for="booking-appointment_hour-07">07
                                    <hr class="my-1">giờ
                                </label>
                                <input class="btn-check" id="booking-appointment_hour-08" name="appointment_hour" type="radio" value="08:00" autocomplete="off">
                                <label class="btn btn-outline-info fw-bold" for="booking-appointment_hour-08">08
                                    <hr class="my-1">giờ
                                </label>
                                <input class="btn-check" id="booking-appointment_hour-09" name="appointment_hour" type="radio" value="09:00" autocomplete="off">
                                <label class="btn btn-outline-info fw-bold" for="booking-appointment_hour-09">09
                                    <hr class="my-1">giờ
                                </label>
                                <input class="btn-check" id="booking-appointment_hour-10" name="appointment_hour" type="radio" value="10:00" autocomplete="off">
                                <label class="btn btn-outline-info fw-bold" for="booking-appointment_hour-10">10
                                    <hr class="my-1">giờ
                                </label>
                                <input class="btn-check" id="booking-appointment_hour-11" name="appointment_hour" type="radio" value="11:00" autocomplete="off">
                                <label class="btn btn-outline-info fw-bold" for="booking-appointment_hour-11">11
                                    <hr class="my-1">giờ
                                </label>
                                <input class="btn-check" id="booking-appointment_hour-12" name="appointment_hour" type="radio" value="12:00" autocomplete="off">
                                <label class="btn btn-outline-info fw-bold" for="booking-appointment_hour-12">12
                                    <hr class="my-1">giờ
                                </label>
                                <input class="btn-check" id="booking-appointment_hour-13" name="appointment_hour" type="radio" value="13:00" autocomplete="off">
                                <label class="btn btn-outline-info fw-bold" for="booking-appointment_hour-13">13
                                    <hr class="my-1">giờ
                                </label>
                                <input class="btn-check" id="booking-appointment_hour-14" name="appointment_hour" type="radio" value="14:00" autocomplete="off">
                                <label class="btn btn-outline-info fw-bold" for="booking-appointment_hour-14">14
                                    <hr class="my-1">giờ
                                </label>
                                <input class="btn-check" id="booking-appointment_hour-15" name="appointment_hour" type="radio" value="15:00" autocomplete="off">
                                <label class="btn btn-outline-info fw-bold" for="booking-appointment_hour-15">15
                                    <hr class="my-1">giờ
                                </label>
                                <input class="btn-check" id="booking-appointment_hour-16" name="appointment_hour" type="radio" value="16:00" autocomplete="off">
                                <label class="btn btn-outline-info fw-bold" for="booking-appointment_hour-16">16
                                    <hr class="my-1">giờ
                                </label>
                                <input class="btn-check" id="booking-appointment_hour-17" name="appointment_hour" type="radio" value="17:00" autocomplete="off">
                                <label class="btn btn-outline-info fw-bold" for="booking-appointment_hour-17">17
                                    <hr class="my-1">giờ
                                </label>
                                <input class="btn-check" id="booking-appointment_hour-18" name="appointment_hour" type="radio" value="18:00" autocomplete="off">
                                <label class="btn btn-outline-info fw-bold" for="booking-appointment_hour-18">18
                                    <hr class="my-1">giờ
                                </label>
                                <input class="btn-check" id="booking-appointment_hour-19" name="appointment_hour" type="radio" value="19:00" autocomplete="off">
                                <label class="btn btn-outline-info fw-bold" for="booking-appointment_hour-19">19
                                    <hr class="my-1">giờ
                                </label>
                                <input class="btn-check" id="booking-appointment_hour-20" name="appointment_hour" type="radio" value="20:00" autocomplete="off">
                                <label class="btn btn-outline-info fw-bold" for="booking-appointment_hour-20">20
                                    <hr class="my-1">giờ
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-lg-6 form-group">
                            <label class="form-label" for="booking-remind_at">Nhắc nhở (khách hàng)</label>
                            <select class="form-control" id="booking-remind_at" name="remind_at" autocomplete="off" required>
                                <option value="0">Ngay lúc hẹn</option>
                                <option value="60">Trước 1 giờ</option>
                                <option value="1440">Trước 1 ngày</option>
                                <option value="4320">Trước 3 ngày</option>
                                <option value="10080">Trước 1 tuần</option>
                            </select>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="mb-3 form-group">
                                <label class="form-label" for="booking-date">Ngày hẹn</label>
                                <input class="form-control" id="booking-date" name="appointment_date" type="date" autocomplete="off" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-lg-6 form-group">
                            <label class="form-label" for="booking-frequency">Tự động lặp lại</label>
                            <select class="form-control" id="booking-frequency" name="frequency" autocomplete="off" required>
                                <option value="0">Không nhắc</option>
                                <option value="1">Sau 1 giờ</option>
                                <option value="24">Sau 1 ngày</option>
                                <option value="48">Sau 2 ngày</option>
                                <option value="72">Sau 3 ngày</option>
                                <option value="168">Sau 1 tuần</option>
                                <option value="336">Sau 2 tuần</option>
                                <option value="504">Sau 3 tuần</option>
                                <option value="730">Sau 1 tháng</option>
                                <option value="1460">Sau 2 tháng</option>
                                <option value="2190">Sau 3 tháng</option>
                                <option value="8760">Sau 1 năm</option>
                            </select>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <div class="d-grid">
                                    <label class="form-label" for="status-1">Trạng thái</label>
                                    <div class="btn-group" role="group" aria-label="Chọn trạng thái">
                                        <input class="btn-check" id="status-0" name="status" type="radio" value="0">
                                        <label class="btn btn-outline-danger" for="status-0">Bị hủy</label>
                                        <input class="btn-check" id="status-1" name="status" type="radio" value="1">
                                        <label class="btn btn-outline-primary" for="status-1">Đang chờ</label>
                                        <input class="btn-check" id="status-2" name="status" type="radio" value="2">
                                        <label class="btn btn-outline-info" for="status-2">Sẽ tới</label>
                                        <input class="btn-check" id="status-3" name="status" type="radio" value="3">
                                        <label class="btn btn-outline-success" for="status-3">Đã tới</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12 col-lg-6">
                            <div class="ajax-search mb-3">
                                <div class="form-group has-icon-left">
                                    <label class="form-label" for="booking-pet_id">Thú cưng</label>
                                    <div class="position-relative search-form">
                                        <input class="form-control search-input" id="booking-pet_id" data-url="{{ route('admin.pet') }}?key=search" type="text" autocomplete="off" placeholder="Tìm kiếm theo kh. hàng hoặc tên thú cưng.">
                                        <div class="form-control-icon">
                                            <i class="bi bi-search"></i>
                                        </div>
                                    </div>
                                </div>
                                <ul class="overflow-auto w-100 search-result" style="max-height: 10rem">
                                    <!-- Search results will be appended here -->
                                </ul>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="ajax-search mb-3">
                                <div class="form-group has-icon-left">
                                    <label class="form-label" for="booking-doctor_id">Bác sĩ / Kĩ thuật viên</label>
                                    <div class="position-relative search-form">
                                        <input class="form-control search-input" id="booking-doctor_id" data-url="{{ route('admin.user') }}?key=staff" type="text" autocomplete="off" placeholder="Tìm kiếm bác sĩ / kĩ thuật viên">
                                        <div class="form-control-icon">
                                            <i class="bi bi-search"></i>
                                        </div>
                                    </div>
                                </div>
                                <ul class="overflow-auto w-100 search-result" style="max-height: 10rem">
                                    <!-- Search results will be appended here -->
                                </ul>
                            </div>
                        </div>
                    </div>
                    <hr class="px-5">
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-12 col-lg-12 text-end">
                                @if (Auth::user()->can(App\Models\User::SEND_ZNS_BOOKING))
                                    <div class="d-inline-block form-check">
                                        <input class="form-check-input" id="booking-send_zns" name="send_zns" type="checkbox">
                                        <label class="form-check-label" for="booking-send_zns">
                                            Đồng thời gửi Zalo khách hàng
                                        </label>
                                    </div>
                                @endif
                                @if (!empty(Auth::user()->hasAnyPermission(App\Models\User::UPDATE_BOOKING, App\Models\User::CREATE_BOOKING)))
                                    <input name="id" type="hidden">
                                    <button class="btn btn-primary" type="submit">Lưu</button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
