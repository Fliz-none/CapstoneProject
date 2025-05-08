<form class="save-form" id="export-form" name="export" method="post">
    @csrf
    <div class="modal fade" id="export-modal" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="export-modal-label">
        <div class="modal-dialog modal-fullscreen modal-dialog-scrollable export-receipt">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h1 class="modal-title fs-5 text-white" id="export-modal-label">Xuất kho</h1>
                    <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row h-100 align-items-stretch">
                        <div class="col-12 col-lg-9">
                            <div class="card mb-3 h-100">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-3">
                                            <select class="form-select form-control-lg" name="export_warehouse" type="text">
                                                @foreach (cache()->get('warehouses')->whereIn('id', Auth::user()->warehouses->pluck('id')) as $warehouse)
                                                    <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-9 d-flex justify-content-end">
                                            @php
                                                $my_warehouses = Auth::user()->warehouses;
                                            @endphp
                                            <div class="dropdown ajax-search">
                                                <div class="form-group mb-0 has-icon-left">
                                                    <div class="position-relative search-form">
                                                        <input class="form-control form-control-lg search-input" id="export-search-input"
                                                            data-url="{{ route('admin.stock') }}?key=search{{ $my_warehouses->count() ? '&warehouse_id=' . $my_warehouses->first()->id : '' }}&action=export" type="text" autocomplete="off"
                                                            placeholder="Tìm kiếm sản phẩm">
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
                                <div class="card-body export-details">
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-3 d-flex flex-column">
                            <div class="form-group">
                                <label data-bs-toggle="tooltip" data-bs-title="Thông tin về các mặt hàng hoặc lý do xuất hàng" for="export-note">Nội dung</label>
                                <input class="form-control form-control-lg" id="export-note" name="note" type="note" required autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label data-bs-toggle="tooltip" data-bs-title="Ngày mà hàng hóa hoặc sản phẩm được chuyển ra khỏi kho" for="export-date">Ngày xuất</label>
                                <input class="form-control form-control-lg" id="export-date" name="date" type="date" value="{{ date('Y-m-d') }}" max="{{ date('Y-m-d') }}" required inputmode="numeric">
                            </div>
                            <div class="form-group">
                                <label data-bs-toggle="tooltip" data-bs-title="Kho tiếp nhận các sản phẩm được nhập vào" for="export-to_warehouse_id">Kho nhận</label>
                                <select class="form-select form-control-lg select2" id="export-to_warehouse_id" name="to_warehouse_id" data-ajax--url="{{ route('admin.warehouse', ['key' => 'select2']) }}" data-placeholder="Chọn kho tiếp nhập"
                                    autocomplete="off"> </select>
                            </div>
                            <div class="form-group">
                                <label data-bs-toggle="tooltip" data-bs-title="Người tiếp nhận hàng hóa nhập" for="export-receiver_id">Người nhận</label>
                                <select class="form-select form-control-lg select2" id="export-receiver_id" name="receiver_id" data-ajax--url="{{ route('admin.user', ['key' => 'select2']) }}" data-placeholder="Chọn người nhận" required
                                    autocomplete="off">
                                </select>
                            </div>
                            <div class="form-group">
                                <label data-bs-toggle="tooltip" data-bs-title="Trạng thái thú cưng (Có thể thay đổi sau)" for="export-status-waiting">Trạng thái</label>
                                <div class="form-group">
                                    <div class="d-grid gap-2">
                                        <div class="btn-group btn-group-lg" role="group">
                                            <input class="btn-check" id="export-status-waiting" name="status" type="radio" value="0">
                                            <label class="btn btn-outline-danger" for="export-status-waiting">Đang chờ</label>
                                            <input class="btn-check" id="export-status-exported" name="status" type="radio" value="1">
                                            <label class="btn btn-outline-success" for="export-status-exported">Đã xuất</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mt-auto">
                                @if (!empty(Auth::user()->hasAnyPermission(App\Models\User::UPDATE_EXPORT, App\Models\User::CREATE_EXPORT)))
                                    <input name="id" type="hidden">
                                    <input name="prescription_id" type="hidden">
                                    <input name="detail_id" type="hidden">
                                    <input name="order_id" type="hidden">
                                    <div class="d-grid">
                                        <div class="btn-group">
                                            <button class="btn btn-light btn-print print-export" data-url="{{ getPath(route('admin.export')) }}" type="button">
                                                <i class="bi bi-printer-fill"></i>
                                            </button>
                                            <a class="btn btn-lg btn-info w-75 btn-submit-export">Lưu</a>
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
</form>
