<form class="save-form" id="import-form" name="import" method="post">
    @csrf
    <div class="modal fade" id="import-modal" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="import-modal-label">
        <div class="modal-dialog modal-fullscreen modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h1 class="modal-title fs-5 text-white" id="import-modal-label">Import Stock</h1>
                    <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row h-100 align-items-stretch">
                        <div class="col-12 col-lg-9">
                            <div class="card mb-3 h-100">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-12 mb-2">
                                            <div class="dropdown ajax-search">
                                                <div class="form-group mb-0 has-icon-left">
                                                    <div class="position-relative search-form">
                                                        <input class="form-control form-control-lg search-input" id="import_variable-search-input" data-url="{{ route('admin.unit') }}?key=search" type="text" autocomplete="off"
                                                            placeholder="{{ __('messages.datatable.search_placeholder') }}">
                                                        <div class="form-control-icon">
                                                            <i class="bi bi-search"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <ul class="dropdown-menu shadow-lg overflow-auto w-100 search-result" id="import_variable-search-result" aria-labelledby="dropdownMenuButton" style="max-height: 45rem;max-width: 40rem">
                                                    <!-- Search results will be appended here -->
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-borderless table-detail">
                                            <thead>
                                                <tr>
                                                    <th style="width: 57%">{{ __('messages.product.product') }}</th>
                                                    <th class="text-center" style="width: 8%">{{ __('messages.stock.unit') }}</th>
                                                    <th class="text-center" style="width: 12%">{{ __('messages.stock.quantity') }}</th>
                                                    <th style="width: 10%">{{ __('messages.stock.price') }}</th>
                                                    <th style="width: 13%">{{ __('messages.stock.batch') }}</th>
                                                    <th style="width: 6%">{{ __('messages.stock.exp') }}</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody id="import-stocks">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-3 d-flex flex-column">
                            <div class="form-group">
                                <label for="import-created_at">{{ __('messages.import.import_date') }}</label>
                                <input class="form-control form-control-lg" id="import-created_at" name="created_at" type="datetime-local" value="{{ date('Y-m-d H:i') }}" inputmode="numeric" required autocomplete="off" required>
                            </div>
                            <div class="form-group">
                                <label for="import-note">{{ __('messages.note') }}</label>
                                <textarea class="form-control form-control-lg" id="import-note" name="note" rows="1" placeholder="Note"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="import-summary">{{ __('messages.import.import_total') }}</label>
                                <input class="form-control form-control-lg money" id="import-summary" name="summary" type="text" placeholder="{{ __('messages.import.import_total') }}">
                            </div>
                            <div class="form-group">
                                <label for="import-warehouse_id">{{ __('messages.stock.warehouse') }}</label>
                                <select class="form-select form-control-lg select2" id="import-warehouse_id" name="warehouse_id" data-ajax--url="{{ route('admin.warehouse', ['key' => 'select2']) }}?user_id={{ Auth::id() }}"
                                    data-placeholder="{{ __('messages.stock.warehouse_select') }}" required autocomplete="off"> </select>
                            </div>
                            <div class="form-group">
                                <label for="import-supplier_id">{{ __('messages.stock.supplier') }}</label>
                                <select class="form-select form-control-lg select2" id="import-supplier_id" name="supplier_id" data-ajax--url="{{ route('admin.supplier', ['key' => 'select2']) }}" data-placeholder="{{ __('messages.stock.supplier_select') }}" autocomplete="off">
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="import-status-waiting">{{ __('messages.datatable.status') }}</label>
                                <div class="form-group">
                                    <div class="d-grid gap-2">
                                        <div class="btn-group btn-group-lg" role="group">
                                            <input class="btn-check" id="import-status-waiting" name="status" type="radio" value="0">
                                            <label class="btn btn-outline-danger" for="import-status-waiting">{{ __('messages.stock.waiting') }}</label>
                                            <input class="btn-check" id="import-status-imported" name="status" type="radio" value="1">
                                            <label class="btn btn-outline-success" for="import-status-imported">{{ __('messages.stock.imported') }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mt-auto">
                                @if (!empty(Auth::user()->hasAnyPermission(App\Models\User::UPDATE_IMPORT, App\Models\User::CREATE_IMPORT)))
                                    <input name="id" type="hidden">
                                    <div class="d-grid">
                                        <div class="btn-group">
                                            <button class="btn btn-light btn-print print-import" data-url="{{ getPath(route('admin.import')) }}" type="button">
                                                <i class="bi bi-printer-fill"></i>
                                            </button>
                                            <button class="btn btn-lg btn-info w-75" type="submit">Save</button>
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
