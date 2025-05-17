<form class="save-form" id="stock-form" name="stock" method="post">
    @csrf
    <div class="card mb-3">
        <div class="modal fade" id="stock-modal" aria-labelledby="stock-modal-label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title text-white fs-5" id="stock-modal-label">Stock Inventory</h1>
                        <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <select class="form-control select2" id="stock-variable_id" data-ajax--url="{{ route('admin.stock', ['key' => 'select2']) }}" data-placeholder="Select a product">
                            </select>
                        </div>
                        <div class="mb-3 form-group">
                            <label class="form-label" data-bs-toggle="tooltip" data-bs-title="Remaining quantity in stock" for="stock-quantity">Quantity</label>
                            <input class="form-control" id="stock-quantity" name="quantity" type="text" placeholder="Enter quantity" inputmode="numeric">
                        </div>
                        <div class="mb-3 form-group">
                            <label class="form-label" data-bs-toggle="tooltip" data-bs-title="Product price at import" for="stock-price">Import Price</label>
                            <input class="form-control" id="stock-price" name="price" type="text" placeholder="Enter price" inputmode="numeric">
                        </div>
                        <div class="mb-3 form-group">
                            <label class="form-label" data-bs-toggle="tooltip" data-bs-title="Imported batch" for="stock-lot">Batch</label>
                            <input class="form-control" id="stock-lot" name="lot" type="text" placeholder="Batch">
                        </div>
                        <div class="mb-3 form-group">
                            <label class="form-label" data-bs-toggle="tooltip" data-bs-title="Remaining shelf life of the product that can be used safely and effectively" for="stock-expired">Expiration Date</label>
                            <input class="form-control" id="stock-expired" name="expired" type="date" placeholder="Expiration date" inputmode="numeric">
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
                                        <button class="btn btn-primary" type="submit">Save</button>
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
                        <h1 class="modal-title text-white fs-5" id="render_stock-modal-label">Stock Inventory List</h1>
                        <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="render-stock">
                        <div class="row">
                            <div class="col-12 col-lg-3">
                                <div class="mb-3">
                                    <select class="form-control select2" id="render_stock-catalogue_id" data-ajax--url="{{ route('admin.catalogue', ['key' => 'select2']) }}" data-placeholder="Select a category">
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-lg-3">
                                <div class="mb-3">
                                    <select class="form-control select2" id="render_stock-warehouse_id" name="warehouse_id" data-ajax--url="{{ route('admin.warehouse', ['key' => 'select2']) }}" data-placeholder="Select a warehouse">
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-lg-3">
                                <div class="mb-3">
                                    <input class="form-control" id="render_stock-daterange" name="daterange" type="text" placeholder="Report period" size="25" />
                                </div>
                            </div>
                            <div class="col-12 col-lg-3">
                                <div class="btn-group w-100 gap-2" role="group">
                                    @if (!empty(Auth::user()->can(App\Models\User::PRINT_STOCK)))
                                        <button class="btn btn-primary btn-print-stock" type="button"><i class="bi bi-printer-fill"></i> Print</button>
                                    @endif
                                    @if (!empty(Auth::user()->can(App\Models\User::CREATE_IMPORT)) && !empty(Auth::user()->can(App\Models\User::CREATE_EXPORT)))
                                        <button class="btn btn-primary btn-sync-stock" type="button"><i class="bi bi-repeat"></i> Sync Stock</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-hover table-render-stock">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Product Name</th>
                                    <th>Opening Stock</th>
                                    <th>Stock In</th>
                                    <th>Stock Out</th>
                                    <th>Closing Stock</th>
                                    <th>Actual Stock</th>
                                    <th>Minimum Stock</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center" colspan="8">Select a category and warehouse to list</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

