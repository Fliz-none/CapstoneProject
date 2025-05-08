<form class="save-form" id="order-form" name="order" method="post">
    @csrf
    <div class="modal fade" id="order-modal" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="order-modal-label">
        <div class="modal-dialog modal-dialog-scrollable modal-fullscreen order-receipt">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h1 class="modal-title fs-5 text-white" id="order-modal-label">Đơn hàng</h1>
                    <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row align-items-stretch">
                        <div class="col-12 col-lg-9">
                            <div class="card card-product mb-3">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-12 d-flex justify-content-end">
                                            <div class="dropdown ajax-search">
                                                <div class="form-group mb-0 has-icon-left">
                                                    <div class="position-relative search-form">
                                                        <input class="form-control form-control-lg search-input" data-url="{{ route('admin.stock') }}?key=search" type="text" autocomplete="off" placeholder="Chọn một sản phẩm">
                                                        <div class="form-control-icon">
                                                            <i class="bi bi-search"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <ul class="dropdown-menu shadow-lg overflow-auto search-result" aria-labelledby="dropdownMenuButton" style="max-height: 45rem; max-width: 600px">
                                                    <!-- Search results will be appended here -->
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body order-details">
                                </div>
                            </div>
                            <div class="card card-transactions mb-3">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-9">
                                            <h5 class="text-secondary">Các giao dịch</h5>
                                        </div>
                                        <div class="col-3">
                                            @if (Auth::user()->can(App\Models\User::CREATE_TRANSACTION))
                                                <div class="d-grid gap-2">
                                                    <div class="btn-group btn-group-lg">
                                                        <button class="btn btn-outline-primary btn-create-transaction pay">
                                                            <i class="bi bi-plus-circle"></i> Thêm thanh toán
                                                        </button>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-wide table-bordered key-table" id="transactions-datatable">
                                            <thead>
                                                <tr>
                                                    <th>Mã</th>
                                                    <th>Nội dung</th>
                                                    <th class="text-center">Hình thức</th>
                                                    <th>Khách hàng</th>
                                                    <th>Thu ngân</th>
                                                    <th class="text-end">Số tiền</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody id="order-transactions">
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td class="text-end" colspan="5">Tổng giá trị đơn hàng</td>
                                                    <td class="text-end order-sum"></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td class="text-end" colspan="5">Tổng số tiền đã thanh toán</td>
                                                    <td class="text-end transaction-sum"></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td class="text-end" colspan="5"></td>
                                                    <td class="text-end transaction-remain"></td>
                                                    <td></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-3">
                            <div class="card sticky-top">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <input class="form-control form-control-plaintext bg-white text-start order-branch_name" id="order-branch_name" name="branch_name" type="text" readonly required>
                                        </div>
                                        <div class="col-sm-6">
                                            <input class="form-control form-control-plaintext bg-white text-end order-created_at" id="order-created_at" name="created_at" type="datetime-local" max="{{ date('Y-m-d') }}" inputmode="numeric"
                                                autocomplete="off" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-sm-4 mb-0 col-form-label d-flex align-items-center" data-bs-toggle="tooltip" data-bs-title="Khách hàng mua hàng" for="order-customer_id">
                                            Khách hàng&nbsp;
                                            <a class="btn btn-link btn-create-user rounded-pill p-0" type="button">
                                                <i class="bi bi-plus-circle"></i>
                                            </a>
                                        </label>
                                        <div class="col-sm-8">
                                            <select class="form-control-plaintext form-control select2 order-customer_id" id="order-customer_id" name="customer_id" data-ajax--url="{{ route('admin.user', ['key' => 'select2']) }}"
                                                data-placeholder="Chọn khách hàng (F4)" autocomplete="off">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3 p-2 bg-light rounded-3 customer-suggestions">
                                    </div>
                                    <div class="form-group">
                                        <div class="d-grid gap-2">
                                            <div class="btn-group" role="group">
                                                <input class="btn-check" id="order-status-waiting" name="status" type="radio" value="1">
                                                <label class="btn btn-outline-primary" for="order-status-waiting">Mới đặt</label>
                                                <input class="btn-check" id="order-status-processing" name="status" type="radio" value="2">
                                                <label class="btn btn-outline-info" for="order-status-processing">Đang xử lý</label>
                                                <input class="btn-check" id="order-status-done" name="status" type="radio" value="3">
                                                <label class="btn btn-outline-success" for="order-status-done">Hoàn thành</label>
                                                <input class="btn-check" id="order-status-cancel" name="status" type="radio" value="0">
                                                <label class="btn btn-outline-danger" for="order-status-cancel">Bị hủy</label>
                                            </div>
                                        </div>
                                    </div>
                                    <hr />
                                    <div class="row mb-3 row-total">
                                        <label class="col-sm-4 mb-0 col-form-label d-flex align-items-center" data-bs-toggle="tooltip" data-bs-title="Tổng giá số món hàng" for="order-total">Tổng <span class="order-count px-1">0</span>
                                            món</label>
                                        <div class="col-sm-8">
                                            <input class="form-control-lg bg-white text-end form-control bg-white money order-total" id="order-total" name="total" type="text" value="0" placeholder="Tổng tiền đơn hàng"
                                                autocomplete="off" readonly>
                                        </div>
                                    </div>
                                    <div class="row row-discount">
                                        <label class="col-sm-4 mb-0 col-form-label d-flex align-items-center" data-bs-toggle="tooltip" data-bs-title="Giảm giá sản phẩm (giá trị bé hơn hoặc bằng 100 sẽ giảm theo % giá trị đơn hàng)"
                                            for="order-discount">Giảm giá</label>
                                        <div class="col-sm-8">
                                            <input class="form-control-lg text-end form-control bg-white money order-discount" id="order-discount" name="discount" type="text" value="0" onclick="this.select()"
                                                placeholder="Số tiền hoặc phần trăm" autocomplete="off">
                                        </div>
                                    </div>
                                    <hr />
                                    <div class="row mb-3 row-summary">
                                        <label class="col-sm-4 mb-0 col-form-label d-flex align-items-center" data-bs-toggle="tooltip" data-bs-title="Số tiền khách cần phải thanh toán" for="order-summary">Phải thanh toán</label>
                                        <div class="col-sm-8">
                                            <input class="form-control-lg text-end form-control bg-white money order-summary" id="order-summary" name="summary" type="text" value="0" placeholder="Số tiền" autocomplete="off" readonly>
                                        </div>
                                    </div>
                                    <div class="order-payments" id="order-payments">
                                    </div>
                                    <div class="row mb-3 row-change d-none">
                                        <label class="col-sm-4 mb-0 col-form-label d-flex align-items-center" data-bs-toggle="tooltip" data-bs-title="Số tiền mà khách đã thanh toán" for="order-paid">Đã thanh toán</label>
                                        <div class="col-sm-8">
                                            <input class="form-control-lg text-end form-control bg-white money order-paid" id="order-paid" name="change" type="text" value="0" placeholder="Số tiền" autocomplete="off" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-3 row-due d-none">
                                        <label class="col-sm-4 mb-0 col-form-label d-flex align-items-center" data-bs-toggle="tooltip" data-bs-title="Tiền thừa còn lại của khách" for="order-due">Còn lại</label>
                                        <div class="col-sm-8">
                                            <input class="form-control-lg text-end form-control bg-white money order-due" id="order-due" name="due" type="text" value="0" placeholder="Số tiền" autocomplete="off" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <textarea class="form-control" id="order-note" name="note" rows="2" placeholder="Ghi chú đơn hàng"></textarea>
                                    </div>
                                    <div class="form-group mb-0">
                                        @if (!empty(Auth::user()->hasAnyPermission(App\Models\User::UPDATE_ORDER, App\Models\User::CREATE_ORDER)))
                                            <input name="id" type="hidden">
                                            <div class="d-grid">
                                                <div class="btn-group dropup">
                                                    <button class="btn btn-light btn-print print-order" data-bs-toggle="dropdown" type="button" aria-expanded="false">
                                                        <i class="bi bi-printer-fill"></i>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li><a class="dropdown-item cursor-pointer btn-print print-order" data-id="" data-url="{{ getPath(route('admin.order')) }}" data-template="a5">Khổ A5</a></li>
                                                        <li><a class="dropdown-item cursor-pointer btn-print print-order" data-id="" data-url="{{ getPath(route('admin.order')) }}" data-template="c80">Khổ 80mm</a></li>
                                                    </ul>
                                                    <button class="btn btn-lg btn-info w-75 btn-submit" type="submit">Lưu</button>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
