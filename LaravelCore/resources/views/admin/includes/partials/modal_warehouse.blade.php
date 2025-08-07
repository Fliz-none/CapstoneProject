<form class="save-form" id="warehouse-form" method="post">
    @csrf
    <div class="modal fade" id="warehouse-modal" data-bs-backdrop="static" aria-labelledby="warehouse-modal-label">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="warehouse-modal-label">Warehouse</h1>
                    <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-4">
                        <!-- THÔNG TIN KHO (BÊN TRÁI) -->
                        <div class="col-12 col-md-6 order-2 order-md-1">
                            <div class="form-group row align-items-center">
                                <div class="col-12">
                                    <label class="form-label" for="warehouse-name" data-bs-toggle="tooltip" data-bs-title="Name of the warehouse">{{ __('messages.warehouses.name') }}</label>
                                </div>
                                <div class="col-12">
                                    <input class="form-control" id="warehouse-name" name="name" type="text" placeholder="{{ __('messages.warehouses.name') }}" autocomplete="off" required>
                                </div>
                            </div>

                            <div class="form-group row align-items-center mt-3">
                                <div class="col-12">
                                    <label class="form-label" for="warehouse-branch_id" data-bs-toggle="tooltip" data-bs-title="Branch to which the warehouse belongs">{{ __('messages.branches.branch') }}</label>
                                </div>
                                <div class="col-12">
                                    <select class="form-select select2" id="warehouse-branch_id" data-ajax--url="{{ route('admin.branch', ['key' => 'select2']) }}" data-placeholder="{{ __('messages.warehouses.select_branch') }}" name="branch_id">
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row align-items-center mt-3">
                                <div class="col-12">
                                    <label class="form-label" for="warehouse-address-preview" data-bs-toggle="tooltip" data-bs-title="Address of the warehouse">{{ __('messages.warehouses.address') }}</label>
                                </div>
                                <div class="col-12">
                                    <input class="form-control" id="warehouse-address-preview" type="text" autocomplete="off" placeholder="{{ __('messages.warehouses.address') }}">
                                </div>
                            </div>

                            <div class="form-group row align-items-center mt-3">
                                <div class="col-12">
                                    <label class="form-label" for="warehouse-status" data-bs-toggle="tooltip" data-bs-title="Warehouse status">{{ __('messages.warehouses.status') }}</label>
                                </div>
                                <div class="col-12">
                                    <select name="status" id="warehouse-status" class="form-control">
                                        <option value="2">{{ __('messages.warehouses.on_sale') }}</option>
                                        <option value="1">{{ __('messages.warehouses.internal') }}</option>
                                        <option value="0">{{ __('messages.warehouses.lock') }}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row align-items-center mt-3">
                                <div class="col-12">
                                    <label class="form-label" for="warehouse-note" data-bs-toggle="tooltip" data-bs-title="Notes or reminders about the warehouse">{{ __('messages.note') }}</label>
                                </div>
                                <div class="col-12">
                                    <textarea class="form-control" id="warehouse-note" name="note" rows="3" autocomplete="off" placeholder="{{ __('messages.note') }}"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-6 order-1 order-md-2 sticky-top">
                            <input type="hidden" name="address">
                            <div id="warehouse-map" style="width: 100%; height: 350px; border: 1px solid #ccc; border-radius: 6px;"></div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-6">
                        </div>
                        <div class="col-6 text-end">
                            @if (!empty(Auth::user()->hasAnyPermission(App\Models\User::UPDATE_WAREHOUSE, App\Models\User::CREATE_WAREHOUSE)))
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
