<form class="save-form" id="warehouse-form" method="post">
    @csrf
    <div class="modal fade" id="warehouse-modal" data-bs-backdrop="static" aria-labelledby="warehouse-modal-label">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="warehouse-modal-label">Warehouse</h1>
                    <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3 form-group">
                        <label class="form-label fw-bold" for="warehouse-name" data-bs-toggle="tooltip" data-bs-title="Name of the warehouse">{{ __('messages.warehouses.name') }}</label>
                        <input class="form-control" id="warehouse-name" name="name" type="text" placeholder="{{ __('messages.warehouses.name') }}" autocomplete="off" required>
                    </div>
                    <div class="mb-3 form-group">
                        <label class="form-label fw-bold" for="warehouse-branch_id" data-bs-toggle="tooltip" data-bs-title="Branch to which the warehouse belongs">{{ __('messages.branches.branch') }}</label>
                        <select class="form-select select2" id="warehouse-branch_id" data-ajax--url="{{ route('admin.branch', ['key' => 'select2']) }}" data-placeholder="{{ __('messages.warehouses.select_branch') }}" name="branch_id">
                        </select>
                    </div>
                    <div class="mb-3 form-group">
                        <label class="form-label fw-bold" for="warehouse-address" data-bs-toggle="tooltip" data-bs-title="Address of the warehouse">{{ __('messages.warehouses.address') }}</label>
                        <input class="form-control" id="warehouse-address" name="address" type="text" autocomplete="off" placeholder="{{ __('messages.warehouses.address') }}">
                    </div>
                    <div class="mb-3 form-group">
                        <label class="form-label fw-bold" for="warehouse-status" data-bs-toggle="tooltip" data-bs-title="Warehouse status">{{ __('messages.warehouses.status') }}</label>
                        <select name="status" id="warehouse-status" class="form-control">
                            <option value="2">{{ __('messages.warehouses.on_sale') }}  </option>
                            <option value="1">{{ __('messages.warehouses.internal') }}  </option>
                            <option value="0">{{ __('messages.warehouses.lock') }}  </option>
                        </select>
                    </div>
                    <div class="mb-3 form-group">
                        <label class="form-label fw-bold" for="warehouse-note" data-bs-toggle="tooltip" data-bs-title="Notes or reminders about the warehouse">{{ __('messages.note') }}</label>
                        <textarea class="form-control" id="warehouse-note" name="note" autocomplete="off" placeholder="{{ __('messages.note') }}"></textarea>
                    </div>
                    <hr class="px-5">
                    <div class="mb-3 form-group">
                        <div class="row">
                            <div class="col-12 col-lg-12 text-end">
                                @if (!empty(Auth::user()->hasAnyPermission(App\Models\User::UPDATE_WAREHOUSE, App\Models\User::CREATE_WAREHOUSE)))
                                    <input name="id" type="hidden">
                                    <button class="btn btn-primary" type="submit">Save</button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
