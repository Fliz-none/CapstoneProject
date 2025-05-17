<form class="save-form" id="variable-form" method="post">
    @csrf
    <div class="modal fade" id="variable-modal" data-bs-backdrop="static" aria-labelledby="variable-modal-label">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h1 class="modal-title text-white fs-5" id="variable-modal-label">Variant</h1>
                    <button class="btn-close text-white" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-4">
                        <div class="overflow-auto col-12 col-md-3 form-group" style="max-height: 400px">
                            <span class="form-label text-info" for="variable-attribute-1">Attributes</span>
                            <div class="accordion" id="variable-accordion">
                                @php
                                    $attributes = cache()->get('attributes', []);
                                @endphp
                                @foreach ($attributes as $index => $attribute)
                                    @if ($index == 0 || $attribute->key != $attributes[$index - 1]->key)
                                        <div class="accordion-item">
                                            <h2 class="accordion-header">
                                                <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#variable-attributes-{{ $attribute->id }}" type="button" aria-expanded="false"
                                                    aria-controls="variable-attributes-{{ $attribute->id }}">
                                                    {{ $attribute->key }}
                                                </button>
                                            </h2>
                                            <div class="accordion-collapse collapse" id="variable-attributes-{{ $attribute->id }}" data-bs-parent="#variable-accordion">
                                                <div class="accordion-body">
                                    @endif
                                    <input class="btn-check variable-attribute" id="variable-attribute-{{ $attribute->id }}" name="attributes[]" type="checkbox" value="{{ $attribute->id }}" autocomplete="off">
                                    <label class="btn btn-outline-primary mb-1" for="variable-attribute-{{ $attribute->id }}">{{ $attribute->value }}</label>
                                    @if ($index == count($attributes) - 1 || $attribute->key != $attributes[$index + 1]->key)
                        </div>
                    </div>
                </div>
                @endif
                @endforeach
            </div>
        </div>
        <div class="col-12 col-md-9 d-flex flex-column">
            <div class="card card-body shadow-none border mb-3">
                <div class="row">
                    <div class="col-12 col-md-8 form-group">
                        <label class="form-label" data-bs-toggle="tooltip" data-bs-title="Represents the specification, attribute or option of the product" for="variable-name">Variant Name</label>
                        <input class="form-control" id="variable-name" name="name" type="text" placeholder="Variant Name" autocomplete="off">
                    </div>
                    <div class="col-12 col-md-4 form-group">
                        <label class="form-label" data-bs-toggle="tooltip" data-bs-title="Minimum stock quantity. If below this, a notification will be triggered" for="variable-stock_limit">Minimum Stock</label>
                        <input class="form-control" id="variable-stock_limit" name="stock_limit" type="text" placeholder="Enter a number" autocomplete="off" inputmode="numeric" required>
                    </div>
                </div>
                <div class="form-group align-items-center">
                    <label class="form-label" data-bs-toggle="tooltip" data-bs-title="Detailed description of the variant, displayed on the website" for="variable-description">Description</label>
                    <textarea class="form-control" id="variable-description" name="description" rows="3"></textarea>
                </div>
            </div>
            <div class="card shadow-none border mb-3">
                <div class="card-body">
                    <div class="text-end">
                        <a class="btn btn-outline-info ms-2 mb-3 block btn-append-unit">
                            <i class="bi bi-plus-circle"></i>
                            Add Unit
                        </a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-borderless table-wide table-detail">
                            <thead>
                                <tr>
                                    <th data-bs-toggle="tooltip" data-bs-title="Barcode printed on product packaging; each packaging method has a different barcode">Barcode</th>
                                    <th data-bs-toggle="tooltip" data-bs-title="Name of the unit representing packaging method">Unit</th>
                                    <th data-bs-toggle="tooltip" data-bs-title="Selling price of the product per unit">Price</th>
                                    <th data-bs-toggle="tooltip" data-bs-title="Conversion rate of the product; at least one unit must have a rate of 1">Rate</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="variable-units">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-6">
            <div class="form-check form-switch ps-0">
                <input class="form-check-input ms-0 ms-md-1 me-1 me-md-2" id="variable-status" name="status" type="checkbox" value="1" role="switch" checked>
                <label class="form-check-label" for="variable-status">Active</label>
            </div>
        </div>
        <div class="col-6 text-end">
            @if (!empty(Auth::user()->hasAnyPermission(App\Models\User::UPDATE_VARIABLE, App\Models\User::CREATE_VARIABLE)))
                <input name="id" type="hidden">
                <input name="product_id" type="hidden">
                <button class="btn btn-primary px-3 fw-bold" type="submit">Save</button>
            @endif
        </div>
    </div>
</div>
</div>
</div>
</div>
</form>
