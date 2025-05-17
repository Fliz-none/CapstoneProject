<!-- Modal -->
<style>
    .render-checkbox {
        display: none;
    }

    .render-label {
        width: 100%;
        display: block;
        padding: 10px 20px;
        border: 1px solid #95b7bd;
        border-radius: 6px;
        cursor: pointer;
        margin-bottom: 10px;
        transition: background-color 0.3s, box-shadow 0.3s;
        text-align: center;
    }

    .render-checkbox:checked+.render-label {
        background-color: #5a75d7;
        color: white;
        box-shadow: 0px 0px 10px #b7f3ff;
    }

    .render-label:hover {
        background-color: #daf9ff;
    }
</style>
<div class="modal fade" id="render-product-modal" data-bs-backdrop="static" aria-labelledby="render-product-modal-label">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h1 class="modal-title fs-5 text-white" id="render-product-modal-label">Select columns to export to Excel</h1>
                <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="modal-body">
                    <div class="row justify-content-start align-items-center">
                        <div class="col-12 p-1 m-0">
                            <div class="form-group p-0">
                                @php
                                    $catalogues = Cache::get('catalogues') ?? '[]';
                                @endphp
                                <label class="form-label" for="col_catalogue">
                                    Select a catalogue
                                </label>
                                <select class="form-select" id="col_catalogue" name="catalogue" required>
                                    <option disabled hidden selected>Select catalogue</option>
                                    @foreach ($catalogues as $catalogue)
                                        <option value="{{ $catalogue->id }}">{{ $catalogue->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-12 p-1 m-0">
                            <div class="form-check p-0">
                                <input class="form-check-input render-checkbox" id="col_name" name="selected_columns" type="checkbox" value="name">
                                <label class="form-check-label render-label" for="col_name">
                                    Product name
                                </label>
                            </div>
                        </div>
                        <div class="col-12 p-1 m-0">
                            <div class="form-check p-0">
                                <input class="form-check-input render-checkbox" id="col_price" name="selected_columns" type="checkbox" value="price">
                                <label class="form-check-label render-label" for="col_price">
                                    Price
                                </label>
                            </div>
                        </div>
                        <div class="col-12 p-1 m-0">
                            <div class="form-check p-0">
                                <input class="form-check-input render-checkbox" id="col_sum_stock" name="selected_columns" type="checkbox" value="sum_stock">
                                <label class="form-check-label render-label" for="col_sum_stock">
                                    Total stock
                                </label>
                            </div>
                        </div>
                        <div class="col-12 p-1 m-0">
                            <div class="form-check p-0">
                                <input class="form-check-input render-checkbox" id="col_stock_limit" name="selected_columns" type="checkbox" value="stock_limit">
                                <label class="form-check-label render-label" for="col_stock_limit">
                                    Out of stock threshold
                                </label>
                            </div>
                        </div>
                        <div class="col-12 p-1 m-0">
                            <div class="form-check p-0">
                                <input class="form-check-input render-checkbox" id="col_created_at" name="selected_columns" type="checkbox" value="created_at">
                                <label class="form-check-label render-label" for="col_created_at">
                                    Creation date
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 text-end">
                            <button class="btn btn-primary px-3 fw-bold btn-export-confirm" type="button">Export Excel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
