<form class="save-form" id="stock-form" name="stock" method="post">
    @csrf
    <div class="card mb-3">
        <div class="modal fade" id="stock-modal" aria-labelledby="stock-modal-label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title text-white fs-5" id="stock-modal-label">Tồn kho</h1>
                        <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <select class="form-control select2" id="stock-variable_id" data-ajax--url="{{ route('admin.stock', ['key' => 'select2']) }}" data-placeholder="Chọn một sản phẩm">
                            </select>
                        </div>
                        <div class="mb-3 form-group">
                            <label class="form-label" data-bs-toggle="tooltip" data-bs-title="Số lượng tồn lại trong kho" for="stock-quantity">Số lượng</label>
                            <input class="form-control" id="stock-quantity" name="quantity" type="text" placeholder="Nhập số lượng" inputmode="numeric">
                        </div>
                        <div class="mb-3 form-group">
                            <label class="form-label" data-bs-toggle="tooltip" data-bs-title="Giá sản phẩm khi nhập" for="stock-price">Giá nhập</label>
                            <input class="form-control" id="stock-price" name="price" type="text" placeholder="Nhập giá" inputmode="numeric">
                        </div>
                        <div class="mb-3 form-group">
                            <label class="form-label" data-bs-toggle="tooltip" data-bs-title="Lô hàng đã nhập" for="stock-lot">Lô hàng</label>
                            <input class="form-control" id="stock-lot" name="lot" type="text" placeholder="Lô hàng">
                        </div>
                        <div class="mb-3 form-group">
                            <label class="form-label" data-bs-toggle="tooltip" data-bs-title="Thời hạn còn lại của sản phẩm có thể được sử dụng an toàn và hiệu quả" for="stock-expired">Hạn sử dụng</label>
                            <input class="form-control" id="stock-expired" name="expired" type="date" placeholder="Hạn sử dụng" inputmode="numeric">
                        </div>
                        <hr class="px-5">
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-12 col-lg-6">
                                </div>
                                <div class="col-12 col-lg-6 text-end">
                                    @if (!empty(Auth::user()->can(App\Models\User::UPDATE_IMPORT)))
                                        <input name="id" type="hidden">
                                        <input name="variable_id" type="hidden">
                                        <button class="btn btn-primary" type="submit">Lưu</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<form class="save-form" id="render_stock-form" method="post">
    <div class="card mb-3">
        <div class="modal fade" id="render_stock-modal" aria-labelledby="render_stock-modal-label" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header bg-info">
                        <h1 class="modal-title text-white fs-5" id="render_stock-modal-label">Danh sách tồn kho</h1>
                        <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="render-stock">
                        <div class="row">
                            <div class="col-12 col-lg-3">
                                <div class="mb-3">
                                    <select class="form-control select2" id="render_stock-catalogue_id" data-ajax--url="{{ route('admin.catalogue', ['key' => 'select2']) }}" data-placeholder="Chọn một danh mục">
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-lg-3">
                                <div class="mb-3">
                                    <select class="form-control select2" id="render_stock-warehouse_id" name="warehouse_id" data-ajax--url="{{ route('admin.warehouse', ['key' => 'select2']) }}" data-placeholder="Chọn một kho">
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-lg-3">
                                <div class="mb-3">
                                    <input class="form-control" id="render_stock-daterange" name="daterange" type="text" placeholder="Thời gian báo cáo" size="25" />
                                </div>
                            </div>
                            <div class="col-12 col-lg-3">
                                <div class="btn-group w-100 gap-2" role="group">
                                    @if (!empty(Auth::user()->can(App\Models\User::PRINT_STOCK)))
                                        <button class="btn btn-primary btn-print-stock" type="button"><i class="bi bi-printer-fill"></i> In</button>
                                    @endif
                                    @if (!empty(Auth::user()->can(App\Models\User::CREATE_IMPORT)) && !empty(Auth::user()->can(App\Models\User::CREATE_EXPORT)))
                                        <button class="btn btn-primary btn-sync-stock" type="button"><i class="bi bi-repeat"></i> Đồng bộ kho</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-hover table-render-stock">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tên sản phẩm</th>
                                    <th>Tồn đầu kỳ</th>
                                    <th>Nhập trong kỳ</th>
                                    <th>Xuất trong kỳ</th>
                                    <th>Tồn cuối kỳ</th>
                                    <th>Thực tồn</th>
                                    <th>Tồn tối thiểu</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center" colspan="8">Chọn danh mục và kho hàng cần liệt kê</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
