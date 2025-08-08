{{-- <div class="card mb-3">
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
</div> --}}

@php
$scoreSettings = json_decode($settings['setting_score'] ?? '{}', true);
// Thêm mặc định nếu chưa có
//$scoreSettings['money_to_score'] = $scoreSettings['money_to_score'] ?? ['money' => '', 'score' => ''];
//$scoreSettings['score_to_money'] = $scoreSettings['score_to_money'] ?? ['score' => '', 'money' => ''];
@endphp
<div class="card mb-3">
    <form id="score-setting-form" action="{{ route('admin.setting.score') }}" method="post">
        @csrf
        <div class="card-header d-flex justify-content-between">
            <h3>{{ __('messages.shop_setting.shop_score') }}</h3>
            <button class="btn btn-primary btn-save" type="submit">{{ __('messages.save') }}</button>
        </div>
        <div class="card-body">
            <div class="mb-3 row">
                <label class="col-sm-4 col-form-label" for="check_score">
                    {{ __('messages.shop_setting.check') }}<br />
                    <small class="form-text text-muted" id="check_score-help">
                        {{ __('messages.shop_setting.check_placeholder') }}
                    </small>
                </label>

                <div class="col-sm-8">
                    <div class="btn-group" role="group" aria-label="Check Score Toggle">
                        <input type="radio" class="btn-check" name="check_score" id="check_score_1" value="1" autocomplete="off" {{ $scoreSettings['check_score'] == 1 ? 'checked' : ''}} >
                        <label class="btn btn-outline-primary" for="check_score_1">
                            {{ __('messages.shop_setting.open') }}
                        </label>
                        <input type="radio" class="btn-check" name="check_score" id="check_score_0" value="0" autocomplete="off" {{ $scoreSettings['check_score'] == 0 ? 'checked' : ''}}>
                        <label class="btn btn-outline-secondary" for="check_score_0">
                            {{ __('messages.shop_setting.close') }}
                        </label>
                    </div>
                </div>
            </div>

            <div class="mb-3 row {{ $scoreSettings['check_score'] == 0 ? 'd-none' : ''}}" id="money_to_score">
                <label class="col-sm-4 col-form-label" for="money_to_score">{{ __('messages.shop_setting.money_to_score') }}<br />
                    <small class="form-text text-muted"
                        id="money_to_score-help">{{ __('messages.shop_setting.money_to_score_placeholder') }}</small>
                </label>
                <div class="row col-sm-8">
                    <!-- money_to_score -->
                    <div class="col-sm-4">
                        <div class="input-group">
                            <input class="form-control money" id="money_to_score_money" name="money_to_score[money]" type="text"
                                value="{{ $scoreSettings['money_to_score']['money'] ?? '' }}">
                            <span class="input-group-text">{{ $config['currency'] }}</span>
                        </div>
                    </div>
                    <!-- Arrow icon -->
                    <div class="col-sm-auto d-flex justify-content-center">
                        <i class="bi bi-arrow-right fs-4 text-secondary"></i>
                    </div>
                    <div class="col-sm-4">
                        <div class="input-group">
                            <input class="form-control" id="money_to_score_score" name="money_to_score[score]" type="text"
                                value="{{ $scoreSettings['money_to_score']['score'] ?? '' }}">
                            <span class="input-group-text">{{ __('messages.shop_setting.score') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-3 row {{ $scoreSettings['check_score'] == 0 ? 'd-none' : ''}}" id="score_to_money">
                <label class="col-sm-4 col-form-label" for="score_to_money">{{ __('messages.shop_setting.score_to_money') }}<br />
                    <small class="form-text text-muted"
                        id="score_to_money-help">{{ __('messages.shop_setting.score_to_money_placeholder') }}</small>
                </label>
                <div class="row col-sm-8">
                    <!-- score_to_money -->
                    <div class="col-sm-4">
                        <div class="input-group">
                            <input class="form-control" id="score_to_money_score" name="score_to_money[score]" type="text"
                                value="{{ $scoreSettings['score_to_money']['score'] ?? '' }}">
                            <span class="input-group-text">{{  __('messages.shop_setting.score') }} </span>
                        </div>
                    </div>
                    <!-- Arrow icon -->
                    <div class="col-sm-auto d-flex justify-content-center">
                        <i class="bi bi-arrow-right fs-4 text-secondary"></i>
                    </div>
                    <div class="col-sm-4">
                        <div class="input-group">
                            <input class="form-control money" id="score_to_money_money" name="score_to_money[money]" type="text"
                                value="{{ $scoreSettings['score_to_money']['money'] ?? '' }}">
                            <span class="input-group-text">{{ $config['currency'] }}</span>
                        </div>

                    </div>
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





