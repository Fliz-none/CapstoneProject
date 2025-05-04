<form class="save-form" id="prescription-form" method="post">
    @csrf
    <div class="modal fade" id="prescription-modal" data-bs-backdrop="static" aria-labelledby="prescription-modal-label">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h1 class="modal-title fs-5 text-white" id="prescription-modal-label">
                        Chi tiết đơn thuốc <span class="prescription-name text-white"></span>
                    </h1>
                    <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="datalist-medicine"></div>
                    <input class="form-control my-2" name="name" type="text"placeholder="Tên đơn thuốc" autocomplete="off">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Tên thuốc</th>
                                    <th>Liều dùng/lần</th>
                                    <th>Số lần/ngày</th>
                                    <th>Số ngày</th>
                                    <th>Đường cấp</th>
                                    <th>Ghi chú</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    <div class="row mt-5 px-2">
                        <div class="col-6">
                            <textarea class="form-control border-0 border-bottom" name="message" placeholder="Ghi chú đơn thuốc" rows="2" autocomplete="off"></textarea>
                        </div>
                        <div class="col-6 d-flex align-items-end justify-content-end">
                            <input name="order_id" type="hidden">
                            <input name="info_id" type="hidden">
                            <input name="id" type="hidden">
                            <a class="btn btn-primary btn-create-booking me-2" data-service_id="{{ optional(cache()->get('services_' . Auth::user()->company_id)->where('ticket', 'prescription')->first())->id }}">
                                <i class="bi bi-calendar-check me-2"></i>
                                Đặt lịch hẹn
                            </a>
                            <a class="btn btn-success btn-print print-prescription me-2" data-url="{{ getPath(route('admin.prescription')) }}">
                                <i class="bi bi-printer me-2"></i>
                                In toa thuốc
                            </a>
                            @if (Auth::user()->can(App\Models\User::UPDATE_PRESCRIPTION))
                                <button class="btn btn-info" data-text="Lưu toa thuốc" type="submit"> <i class="bi bi-floppy me-2"></i>Lưu toa thuốc</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
