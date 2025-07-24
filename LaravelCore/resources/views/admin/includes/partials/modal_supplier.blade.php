<form class="save-form" id="supplier-form" method="post">
    @csrf
    <div class="modal fade" id="supplier-modal" data-bs-backdrop="static" aria-labelledby="supplier-modal-label">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h1 class="modal-title text-white fs-5" id="supplier-modal-label">{{ __('messages.supplier.supplier') }}</h1>
                    <button class="btn-close text-white" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-4">
                        <!-- LEFT: SUPPLIER FIELDS -->
                        <div class="col-12 col-md-6 order-2 order-md-1">
                            <div class="form-group row align-items-center">
                                <div class="col-12">
                                    <label for="supplier-name" class="form-label" data-bs-toggle="tooltip" data-bs-title="Name of the company, organization, or individual providing the products or services">{{ __('messages.supplier.name') }}</label>
                                </div>
                                <div class="col-12">
                                    <input type="text" id="supplier-name" name="name" class="form-control" placeholder="{{ __('messages.supplier.name') }}" autocomplete="off">
                                </div>
                            </div>

                            <div class="form-group row align-items-center mt-3">
                                <div class="col-12">
                                    <label for="supplier-phone" class="form-label" data-bs-toggle="tooltip" data-bs-title="Supplier's phone number">{{ __('messages.supplier.phone') }}</label>
                                </div>
                                <div class="col-12">
                                    <input type="text" id="supplier-phone" name="phone" class="form-control" placeholder="{{ __('messages.supplier.phone') }}" autocomplete="off">
                                </div>
                            </div>

                            <div class="form-group row align-items-center mt-3">
                                <div class="col-12">
                                    <label for="supplier-email" class="form-label" data-bs-toggle="tooltip" data-bs-title="Supplier's email address">Email</label>
                                </div>
                                <div class="col-12">
                                    <input type="text" id="supplier-email" name="email" class="form-control" placeholder="Email" autocomplete="off">
                                </div>
                            </div>

                            <div class="form-group row align-items-center mt-3">
                                <div class="col-12">
                                    <label for="supplier-address" class="form-label" data-bs-toggle="tooltip" data-bs-title="Supplier's address">{{ __('messages.supplier.address') }}</label>
                                </div>
                                <div class="col-12" style="position: relative">
                                    <input class="form-control" id="supplier-address-preview" type="text" placeholder="{{ __('messages.supplier.address') }}" autocomplete="off">
                                </div>
                            </div>

                            <div class="form-group row align-items-center mt-3">
                                <div class="col-12">
                                    <label for="supplier-note" class="form-label" data-bs-toggle="tooltip" data-bs-title="Notes or reminders about the supplier">{{ __('messages.note') }}</label>
                                </div>
                                <div class="col-12">
                                    <textarea name="note" id="supplier-note" rows="3" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- RIGHT: MAP -->
                        <div class="col-12 col-md-6 order-1 order-md-2 sticky-top">
                            <input type="hidden" name="address">
                            <div id="supplier-map" style="width: 100%; height: 350px; border: 1px solid #ccc; border-radius: 6px;"></div>
                        </div>
                    </div>

                    <hr>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-check form-switch ps-0">
                                <input type="checkbox" id="supplier-status" name="status" value="1" class="form-check-input ms-0 ms-md-1 me-1 me-md-2" role="switch" checked>
                                <label for="supplier-status" class="form-check-label" data-bs-toggle="tooltip" data-bs-title="Supplier status (can be changed later)">{{ __('messages.active') }}</label>
                            </div>
                        </div>
                        <div class="col-6 text-end">
                            @if (!empty(Auth::user()->hasAnyPermission(App\Models\User::UPDATE_SUPPLIER, App\Models\User::CREATE_SUPPLIER)))
                                <input name="id" type="hidden">
                                <button class="btn btn-primary px-3 fw-bold" type="submit">Save</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
