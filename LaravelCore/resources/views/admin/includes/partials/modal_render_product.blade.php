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
                <h1 class="modal-title fs-5 text-white" id="render-product-modal-label">{{ __('messages.product.export_excel') }}</h1>
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
                                    {{ __('messages.product.select_catalogue') }}
                                </label>
                                <select class="form-select select2" id="col_catalogue" name="catalogues[]" multiple required>
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
                                    {{ __('messages.product.product_name') }}
                                </label>
                            </div>
                        </div>
                        <div class="col-12 p-1 m-0">
                            <div class="form-check p-0">
                                <input class="form-check-input render-checkbox" id="col_sku" name="selected_columns" type="checkbox" value="sku">
                                <label class="form-check-label render-label" for="col_sku">
                                    SKU
                                </label>
                            </div>
                        </div>
                        <div class="col-12 p-1 m-0">
                            <div class="form-check p-0">
                                <input class="form-check-input render-checkbox" id="col_price" name="selected_columns" type="checkbox" value="price">
                                <label class="form-check-label render-label" for="col_price">
                                    {{ __('messages.product.price') }}
                                </label>
                            </div>
                        </div>
                        <div class="col-12 p-1 m-0">
                            <div class="form-check p-0">
                                <input class="form-check-input render-checkbox" id="col_sum_stock" name="selected_columns" type="checkbox" value="sum_stock">
                                <label class="form-check-label render-label" for="col_sum_stock">
                                    {{ __('messages.product.total_stock') }}
                                </label>
                            </div>
                        </div>
                        <div class="col-12 p-1 m-0">
                            <div class="form-check p-0">
                                <input class="form-check-input render-checkbox" id="col_quantity_sold" name="selected_columns" type="checkbox" value="quantity_sold">
                                <label class="form-check-label render-label" for="col_quantity_sold">
                                    {{ __('messages.product.quantity_sold') }}
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 text-end">
                            <button class="btn btn-primary px-3 fw-bold btn-export-confirm" type="button">{{ __('messages.product.export') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $(document).on('shown.bs.modal', '#render-product-modal', function() {
            const $select = $('#col_catalogue');
            if ($select.hasClass("select2-hidden-accessible")) {
                $select.select2('destroy');
            }

            $select.select2({
                placeholder: 'Chọn danh mục',
                width: '100%',
                dropdownParent: $('#render-product-modal')
            });
        });
    });
</script>
