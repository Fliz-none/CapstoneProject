
<div class="card mb-3">
    <form id="company-form" action="{{ route('admin.setting.shop') }}" method="post">
        @csrf
        <div class="card-header d-flex justify-content-between">
            <h3>{{ __('messages.shop_setting.shop_setting') }}</h3>
            <button class="btn btn-primary btn-save" type="submit">{{ __('messages.save') }}</button>
        </div>
        <div class="card-body">
            <div class="mb-3 row">
                <label class="col-sm-4 col-form-label" for="inventory_manage">{{ __('messages.shop_setting.inventory_management') }}<br />
                    <small class="form-text text-muted" id="inventory_manage-help">{{ __('messages.shop_setting.inventory_placeholder') }}</small>
                </label>
                <div class="col-sm-8">
                    <input class="form-control @error('inventory_manage') is-invalid @enderror" id="inventory_manage" name="inventory_manage" type="text" value="{{ $settings['inventory_manage'] }}">
                    @error('inventory_manage')
                        <span class="invalid-feedback d-block" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-4 col-form-label" for="scores_rate_exchange">{{ __('messages.shop_setting.reward') }}<br />
                    <small class="form-text text-muted" id="scores_rate_exchange-help">{{ __('messages.shop_setting.reward_placeholder') }}</small>
                </label>
                <div class="col-sm-8">
                    <input class="form-control @error('scores_rate_exchange') is-invalid @enderror" id="scores_rate_exchange" name="scores_rate_exchange" type="text" value="{{ $settings['scores_rate_exchange'] }}">
                    @error('scores_rate_exchange')
                        <span class="invalid-feedback d-block" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                </div>
            </div>
        </div>
    </form>
</div>
<div class="card mb-3">
    <form id="print-form" action="{{ route('admin.setting.print') }}" method="post">
        @csrf
        <div class="card-header d-flex justify-content-between">
            <h3>{{ __('messages.shop_setting.invoice') }}</h3>
            <button class="btn btn-primary btn-save" type="submit">{{ __('messages.save') }}</button>
        </div>
        <div class="card-body">
            <div class="mb-3 row">
                <label class="col-sm-4 col-form-label" for="print_order_bank_a5">
                    {{ __('messages.shop_setting.a5') }}<br />
                    <small class="form-text text-muted">{{ __('messages.shop_setting.a5_placeholder') }}</small>
                </label>
                <div class="col-sm-8">
                    <input name="print_order_bank_a5" type="hidden" value="0">
                    <input class="form-check-input @error('print_order_bank_a5') is-invalid @enderror" id="print_order_bank_a5" name="print_order_bank_a5" type="checkbox" value="1"
                        {{ isset($settings['print_order_bank_a5']) && $settings['print_order_bank_a5'] == 1 ? 'checked' : '' }}>
                    @error('print_order_bank_a5')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-4 col-form-label" for="print_order_bank_c80">
                    {{ __('messages.shop_setting.c80') }}<br />
                    <small class="form-text text-muted">{{ __('messages.shop_setting.c80_placeholder') }}</small>
                </label>
                <div class="col-sm-8">
                    <input name="print_order_bank_c80" type="hidden" value="0">
                    <input class="form-check-input @error('print_order_bank_c80') is-invalid @enderror" id="print_order_bank_c80" name="print_order_bank_c80" type="checkbox" value="1"
                        {{ isset($settings['print_order_bank_c80']) && $settings['print_order_bank_c80'] == 1 ? 'checked' : '' }}>
                    @error('print_order_bank_c80')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
        </div>
    </form>
</div>



<div class="card mb-3">
    <form id="expense-group-form" action="{{ route('admin.setting.expense') }}" method="post">
        @csrf
        <div class="card-header d-flex justify-content-between">
            <h3>{{ __('messages.shop_setting.setup_expense_voucher') }}</h3>
            <button class="ms-auto btn btn-outline-primary btn-add-expense" type="button"><i class="bi bi-plus"></i> Add</button>
            <button class="ms-2 btn btn-outline-primary btn-remove-expense" type="button"><i class="bi bi-dash"></i> Remove</button>
            <button class="ms-2 btn btn-primary btn-save" type="submit">Save</button>
        </div>
        <div class="card-body expense-group-container">
            @php
                $expenseGroups = json_decode($settings['expense_group'], true) ?? [];
            @endphp
            @foreach ($expenseGroups as $index => $group)
                <div class="mb-3 row expense-group-item">
                    <input class="form-control @error('expense_group.' . $index) is-invalid @enderror" name="expense_group[]" type="text" value="{{ old('expense_group.' . $index, $group) }}" placeholder="Enter expense content">
                    @error('expense_group.' . $index)
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            @endforeach
        </div>
    </form>
</div>





