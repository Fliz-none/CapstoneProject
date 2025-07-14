<form class="save-form" id="discount-form" method="post">
    @csrf
    <div class="modal fade" id="discount-modal" data-bs-backdrop="static" aria-labelledby="discount-modal-label">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="discount-modal-label">{{ __('messages.discount_.discount') }}</h1>
                    <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3 form-group">
                        <label class="form-label fw-bold" for="discount-name">{{ __('messages.discount_.discount_name') }}</label>
                        <input class="form-control" id="discount-name" name="name" type="text" placeholder="{{ __('messages.discount_.discount_name') }}" required autocomplete="off">
                    </div>
                    <div class="mb-3 form-group">
                        <label class="form-label fw-bold" for="discount-branch_id">{{ __('messages.datatable.branch') }}</label>
                        <select class="form-select select2" id="discount-branch_id" name="branch_id" data-ajax--url="{{ route('admin.branch', ['key' => 'select2']) }}" data-placeholder="{{ __('messages.discount_.select_branch') }}">
                        </select>
                    </div>
                    <div class="mb-3 form-group">
                        <label class="form-label fw-bold" for="discount-type">{{ __('messages.discount_.type') }}</label>
                        <select class="form-select" id="discount-type" name="type">
                            <option selected hidden disabled>{{ __('messages.discount_.select_type') }}</option>
                            <option value="0">{{ __('messages.discount_.percent') }}</option>
                            <option value="1">{{ __('messages.discount_.fix_discount') }}</option>
                            <option value="2">{{ __('messages.discount_.buy') }}</option>
                        </select>
                    </div>

                    <div class="row d-none discount-type discount-price">
                        <div class="col-12 col-md-6 mb-3 form-group">
                            <label class="form-label fw-bold" for="discount-value">
                                {{ __('messages.discount_.value') }}
                            </label>
                            <div class="input-group">
                                <input class="form-control" id="discount-value" name="value" type="text" placeholder="Enter discount value" autocomplete="off">
                                <span class="input-group-text discount-value-type"></span>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 mb-3 form-group">
                            <label class="form-label fw-bold" for="discount-min_quantity">
                                {{ __('messages.discount_.quantity') }}
                            </label>
                            <input class="form-control" id="discount-min_quantity" name="min_quantity" type="number" value="1" min="1" placeholder="Buy at least..." autocomplete="off">
                        </div>
                    </div>

                    <div class="row d-none discount-type discount-buy_get">
                        <div class="col-12 col-md-6 mb-3 form-group">
                            <label class="form-label fw-bold" for="discount-buy_quantity">
                                {{ __('messages.discount_.quantity') }}
                            </label>
                            <div class="input-group">
                                <input class="form-control" id="discount-buy_quantity" name="buy_quantity" type="number" min="1" placeholder="E.g. Buy 2" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-12 col-md-6 mb-3 form-group">
                            <label class="form-label fw-bold" for="discount-get_quantity">
                                {{ __('messages.discount_.free') }} {{ __('messages.discount_.quantity') }}
                            </label>
                            <input class="form-control" id="discount-get_quantity" name="get_quantity" type="number" min="1" placeholder="E.g. Get 1 free" autocomplete="off">
                        </div>
                    </div>

                    <div class="row d-none discount-apply_type">
                        <div class="col-12 form-group">
                            <label class="form-label fw-bold">{{ __('messages.discount_.apply_type') }}</label><br>
                            <div class="btn-group pb-3">
                                <input class="btn-check" id="apply_type-once" name="apply_type" type="radio" value="once" checked>
                                <label class="btn btn-outline-primary" for="apply_type-once">{{ __('messages.discount_.once') }}</label>
                                <input class="btn-check" id="apply_type-multiple" name="apply_type" type="radio" value="multiple">
                                <label class="btn btn-outline-primary" for="apply_type-multiple">{{ __('messages.discount_.multiple') }}</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-md-6 mb-3 form-group">
                            <label class="form-label fw-bold" for="discount-start_date">{{ __('messages.discount_.start') }}</label>
                            <input class="form-control" id="discount-start_date" name="start_date" type="date">
                        </div>
                        <div class="col-12 col-md-6 mb-3 form-group">
                            <label class="form-label fw-bold" for="discount-end_date">{{ __('messages.discount_.end') }}</label>
                            <input class="form-control" id="discount-end_date" name="end_date" type="date">
                        </div>
                    </div>

                    <div class="card mb-3 h-100">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-12 mb-2 form-group">
                                    <label class="form-label fw-bold" for="discount_unit-search-input">
                                        {{ __('messages.discount_.apply') }}
                                    </label>
                                    <div class="dropdown ajax-search">
                                        <div class="form-group mb-0 has-icon-left">
                                            <div class="position-relative search-form">
                                                <input class="form-control form-control-lg search-input" id="discount_unit-search-input" data-url="{{ route('admin.unit') }}?key=search" type="text" autocomplete="off"
                                                    placeholder="{{ __('messages.datatable.search_placeholder') }}">
                                                <div class="form-control-icon">
                                                    <i class="bi bi-search"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <ul class="dropdown-menu shadow-lg overflow-auto w-100 search-result" id="discount_unit-search-result" aria-labelledby="dropdownMenuButton" style="max-height: 45rem;max-width: 40rem">
                                            <!-- Search results will be appended here -->
                                        </ul>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="card-body discount-units">

                        </div>
                    </div>
                    <div class="modal-footer p-0 pt-2">
                        <div class="row w-100">
                            <div class="col-12 col-md-6">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" id="discount-status" name="status" type="checkbox" checked>
                                    <label class="form-check-label" for="discount-status">{{ __('messages.active') }}</label>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 text-end">
                                @if (!empty(Auth::user()->hasAnyPermission(App\Models\User::UPDATE_DISCOUNT, App\Models\User::CREATE_DISCOUNT)))
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
