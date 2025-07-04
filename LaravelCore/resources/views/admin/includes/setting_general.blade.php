<div class="card mb-3">
    <form id="image-form" action="{{ route('admin.setting.image') }}" method="post">
        @csrf
        <div class="card-header d-flex justify-content-between">
            <h3>{{ __('messages.setting.logo_setting') }}</h3>
            <button class="btn btn-primary btn-save" type="submit">{{ __('messages.save') }}</button>
        </div>
        <div class="card-body">
            <div class="row justify-content-between align-items-stretch">
                <div class="col-12 col-md-4 col-lg mb-3">
                    <h6 class="text-secondary">{{ __('messages.setting.website_icon') }}</h6>
                    <label class="form-label select-image" for="favicon" style="height: 19rem !important"> <img
                            class="img-fluid rounded-4 object-fit-cover" alt="Ảnh đại diện" onerror="this.src='{{ asset('/admin/images/logo/favicon_key.png') }}';">
                    </label>
                    <input class="hidden-image" id="favicon" name="favicon" type="hidden" value="{{ $settings['favicon'] ?? old('favicon') }}">
                    <div class="d-grid mt-auto"> <button class="btn btn-outline-primary btn-remove-image d-none" type="button">{{__('messages.delete')}}</button>
                    </div>
                </div>
                <div class="col-12 col-md-4 col-lg mb-3">
                    <h6 class="text-secondary">{{ __('messages.setting.color') }}</h6>
                    <label class="form-label select-image" for="logo_horizon" style="height: 19rem !important"> <img
                            class="img-fluid rounded-4 object-fit-cover" alt="Ảnh đại diện" onerror="this.src='{{ asset('/admin/images/logo/logo_horizon_key.png') }}';">
                    </label>
                    <input class="hidden-image" id="logo_horizon" name="logo_horizon" type="hidden" value="{{ $settings['logo_horizon'] ?? old('logo_horizon') }}">
                    <div class="d-grid mt-auto"> <button class="btn btn-outline-primary btn-remove-image d-none" type="button">{{__('messages.delete')}}</button>
                    </div>
                </div>
                <div class="col-12 col-md-4 col-lg mb-3">
                    <h6 class="text-secondary">{{ __('messages.setting.square') }}</h6>
                    <label class="form-label select-image" for="logo_square" style="height: 19rem !important"> <img
                            class="img-fluid rounded-4 object-fit-cover" alt="Ảnh đại diện" onerror="this.src='{{ asset('/admin/images/logo/logo_square.png') }}';">
                    </label>
                    <input class="hidden-image" id="logo_square" name="logo_square" type="hidden" value="{{ $settings['logo_square'] ?? old('logo_square') }}">
                    <div class="d-grid mt-auto"> <button class="btn btn-outline-primary btn-remove-image d-none" type="button">{{__('messages.delete')}}</button>
                    </div>
                </div>
                <div class="col-12 col-md-4 col-lg mb-3">
                    <h6 class="text-secondary">{{ __('messages.setting.black_and_white') }}</h6>
                    <label class="form-label select-image" for="logo_horizon_bw" style="height: 19rem !important"> <img
                            class="img-fluid rounded-4 object-fit-cover" alt="Ảnh đại diện" onerror="this.src='{{ asset('/admin/images/logo/logo_horizon_bw_key.png') }}';">
                    </label>
                    <input class="hidden-image" id="logo_horizon_bw" name="logo_horizon_bw" type="hidden" value="{{ $settings['logo_horizon_bw'] ?? old('logo_square') }}">
                    <div class="d-grid mt-auto"> <button class="btn btn-outline-primary btn-remove-image d-none" type="button">{{__('messages.delete')}}</button>
                    </div>
                </div>
                <div class="col-12 col-md-4 col-lg mb-3">
                    <h6 class="text-secondary">{{ __('messages.setting.black_and_white_square') }}</h6>
                    <label class="form-label select-image" for="logo_square_bw" style="height: 19rem !important"> <img
                            class="img-fluid rounded-4 object-fit-cover" alt="Ảnh đại diện" onerror="this.src='{{ asset('/admin/images/logo/logo_square_bw_key.png') }}';">
                    </label>
                    <input class="hidden-image" id="logo_square_bw" name="logo_square_bw" type="hidden" value="{{ $settings['logo_square_bw'] ?? old('logo_square') }}">
                    <div class="d-grid mt-auto"> <button class="btn btn-outline-primary btn-remove-image d-none" type="button">{{__('messages.delete')}}</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<div class="card mb-3">
    <form id="pay-form" action="{{ route('admin.setting.pay') }}" method="post">
        @csrf
        <div class="card-header">
            <div class="row justify-content-between">
                <div class="col-12 col-md-4 col-lg-7">
                    <h3>{{ __('messages.setting.payment_setting') }}</h3>
                </div>
                <div class="col-12 col-md-4 col-lg-5 d-flex justify-content-between">
                    <button class="ms-auto btn btn-outline-primary btn-add-bank-account" type="button"><i class="bi bi-plus"></i> {{ __('messages.add') }}</button>
                    <button class="ms-2 btn btn-outline-primary btn-remove-bank-account" type="button"><i class="bi bi-dash"></i> {{ __('messages.delete') }}</button>
                    <button class="ms-2 btn btn-primary btn-save-pay_setting" type="submit">{{ __('messages.save') }}</button>
                </div>
            </div>
        </div>
        <div class="card-body bank-accounts">
            @php
                $accounts = collect(old('bank_ids', []))
                    ->zip(old('bank_accounts', []), old('bank_numbers', []))
                    ->map(function ($item, $key) {
                        return (object) ['bank_id' => $item[0], 'bank_account' => $item[1], 'bank_number' => $item[2]];
                    })
                    ->toArray();
                if (empty($accounts)) {
                    $accounts = json_decode($settings['bank_info']);
                }
            @endphp
            @if (isset($accounts))
                @foreach ($accounts as $i => $acc)
                    <div class="bank-account">
                        @if ($i != 0)
                            <hr>
                        @endif
                        <div class="mb-3 row">
                            <label class="col-sm-4 col-form-label" for="bank_id-{{ $i }}">
                                {{ __('messages.setting.bank') }}<br />
                                <small class="form-text text-muted" id="bank_id-help-{{ $i }}"> {{ __('messages.setting.placeholder') }} </small>
                            </label>
                            <div class="col-sm-8">
                                <div class="d-none bank-names-hidden">
                                    <input name="bank_names[{{ $i }}]" type="hidden" value="{{ optional($acc)->bank_name }}">
                                </div>
                                <select class="bank-selected form-select @error('bank_ids.' . $i) is-invalid @enderror" id="bank_id-{{ $i }}" name="bank_ids[{{ $i }}]">
                                    <option selected disabled hidden>{{ __('messages.setting.bank_select') }}</option>
                                    @foreach ($banks['data'] as $bank)
                                        @if ($bank['transferSupported'] == 1)
                                            <option data-bank_name="{{ $bank['short_name'] }}" value="{{ $bank['bin'] }}" {{ optional($acc)->bank_id == $bank['bin'] ? 'selected' : '' }}>
                                                {{ $bank['short_name'] }} -
                                                {{ $bank['name'] }} </option>
                                        @endif
                                    @endforeach
                                </select>
                                @error('bank_ids.' . $i)
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-4 col-form-label" for="bank_account-{{ $i }}">
                                {{ __('messages.setting.account') }}<br />
                                <small class="form-text text-muted" id="bank_account-help-{{ $i }}">{{ __('messages.setting.placeholder') }} </small>
                            </label>
                            <div class="col-sm-8">
                                <input class="form-control @error('bank_accounts.' . $i) is-invalid @enderror" id="bank_account-{{ $i }}" name="bank_accounts[{{ $i }}]" type="text"
                                    value="{{ optional($acc)->bank_account }}">
                                @error('bank_accounts.' . $i)
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-4 col-form-label" for="bank_number-{{ $i }}">
                                {{ __('messages.setting.account_number') }}<br />
                                <small class="form-text text-muted" id="bank_number-help-{{ $i }}">{{ __('messages.setting.placeholder') }} </small>
                            </label>
                            <div class="col-sm-8">
                                <input class="form-control @error('bank_numbers.' . $i) is-invalid @enderror" id="bank_number-{{ $i }}" name="bank_numbers[{{ $i }}]" type="text"
                                    value="{{ optional($acc)->bank_number }}">
                                @error('bank_numbers.' . $i)
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </form>
</div>

@if (Auth::user()->getRoleNames()[0] === 'Super Admin')
    <div class="card mb-3">
        <form id="email-form" action="{{ route('admin.setting.email') }}" method="post">
            @csrf
            <div class="card-header d-flex justify-content-between">
                <h3>{{ __('messages.setting.email_setting') }}</h3>
                <button class="btn btn-primary btn-save" type="submit">{{ __('messages.save') }}</button>
            </div>
            <div class="card-body">
                <div class="mb-3 row">
                    <label class="col-sm-4 col-form-label" for="app_name">{{ __('messages.setting.application_name') }}<br />
                        <small class="form-text text-muted" id="app_name-help">{{ __('messages.setting.application_placeholder') }}</small>
                    </label>
                    <div class="col-sm-8">
                        <input class="form-control @error('app_name') is-invalid @enderror" id="app_name" name="app_name" type="text" value="{{ config('app.name') }}">
                        @error('app_name')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-4 col-form-label" for="mail_from_address">{{ __('messages.setting.noti_email') }}<br />
                        <small class="form-text text-muted" id="mail_from_address-help">{{ __('messages.setting.noti_email_placeholder') }}</small>
                    </label>
                    <div class="col-sm-8">
                        <input class="form-control @error('mail_from_address') is-invalid @enderror" id="mail_from_address" name="mail_from_address" type="text" value="{{ config('mail.from.address') }}">
                        @error('mail_from_address')
                            <span class="invalid-feedback d-block" role="alert"> <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-4 col-form-label" for="mail_username">{{ __('messages.setting.user_email') }}<br />
                        <small class="form-text text-muted" id="mail_username-help">
                            {{ __('messages.setting.user_email_placeholder') }}
                        </small>
                    </label>
                    <div class="col-sm-8">
                        <input class="form-control @error('mail_username') is-invalid @enderror" id="mail_username" name="mail_username" type="text" value="{{ config('mail.mailers.smtp.username') }}">
                        @error('mail_username')
                            <span class="invalid-feedback d-block" role="alert"> <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-4 col-form-label" for="mail_password">{{ __('messages.setting.password') }}<br />
                        <small class="form-text text-muted" id="mail_password-help">
                         {{ __('messages.setting.password_placeholder') }}
                        </small>
                    </label>
                    <div class="col-sm-8">
                        <input class="form-control @error('mail_password') is-invalid @enderror" id="mail_password" name="mail_password" type="text" value="{{ config('mail.mailers.smtp.password') }}">
                        @error('mail_password')
                            <span class="invalid-feedback d-block" role="alert"> <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-4 col-form-label" for="mail_encryption">{{ __('messages.setting.smtp_encryption') }}<br />
                        <small class="form-text text-muted" id="mail_encryption-help">
                            {{ __('messages.setting.smtp_encryption_placeholder') }}
                        </small>
                    </label>
                    <div class="col-sm-8">
                        <input class="form-control @error('mail_encryption') is-invalid @enderror" id="mail_encryption" name="mail_encryption" type="text" value="{{ config('mail.mailers.smtp.encryption') }}">
                        @error('mail_encryption')
                            <span class="invalid-feedback d-block" role="alert"> <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-4 col-form-label" for="mail_driver">{{ __('messages.setting.mail_sending_protocol') }}<br />
                        <small class="form-text text-muted" id="mail_driver-help">
                           {{ __('messages.setting.mail_sending_protocol_placeholder') }}
                        </small>
                    </label>
                    <div class="col-sm-8">
                        <input class="form-control @error('mail_driver') is-invalid @enderror" id="mail_driver" name="mail_driver" type="text" value="{{ config('mail.mailers.smtp.transport') }}">
                        @error('mail_driver')
                            <span class="invalid-feedback d-block" role="alert"> <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-4 col-form-label" for="mail_port">{{ __('messages.setting.port') }}<br />
                        <small class="form-text text-muted" id="mail_port-help">
                            {{{ __('messages.setting.port_placeholder') }}}
                        </small>
                    </label>
                    <div class="col-sm-8">
                        <input class="form-control @error('mail_port') is-invalid @enderror" id="mail_port" name="mail_port" type="text" value="{{ config('mail.mailers.smtp.port') }}">
                        @error('mail_port')
                            <span class="invalid-feedback d-block" role="alert"> <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-4 col-form-label" for="mail_host">{{ __('messages.setting.mail_server') }}<br />
                        <small class="form-text text-muted" id="mail_host-help">{{ __('messages.setting.mail_server_placeholder') }}
                        </small>
                    </label>
                    <div class="col-sm-8">
                        <input class="form-control @error('mail_host') is-invalid @enderror" id="mail_host" name="mail_host" type="text" value="{{ config('mail.mailers.smtp.host') }}">
                        @error('mail_host')
                            <span class="invalid-feedback d-block" role="alert"> <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-4 col-form-label" for="expired_notification_frequency-preview">{{ __('messages.setting.mail_auto') }}<br />
                        <small class="form-text text-muted" id="expired_notification_frequency-preview-help">
                            {{ __('messages.setting.mail_auto_placeholder') }}
                        </small>
                    </label>
                    <div class="col-sm-8">
                        <input class="form-control @error('expired_notification_frequency') is-invalid @enderror" id="expired_notification_frequency-preview" type="text"
                            value="{{ isset($settings['expired_notification_frequency']) ? 'Every ' . $settings['expired_notification_frequency'] . ' days' : '' }}">
                        <input name="expired_notification_frequency" type="hidden" {{ isset($settings['expired_notification_frequency']) ? $settings['expired_notification_frequency'] : '' }}>
                        @error('expired_notification_frequency')
                            <span class="invalid-feedback d-block" role="alert"> <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>
        </form>
    </div>
@endif
<div class="card mb-3">
    <form id="social-form" action="{{ route('admin.setting.social') }}" method="post">
        @csrf
        <div class="card-header d-flex justify-content-between">
            <h3>{{ __('messages.setting.social_setting') }}</h3>
            <button class="btn btn-primary btn-save" type="submit">Save</button>
        </div>
        <div class="card-body">
            <div class="mb-3 row">
                <label class="col-sm-4 col-form-label" for="social_facebook">Facebook<br />
                    <small class="form-text text-muted" id="social_facebook-help">
                       {{ __('messages.setting.facebook') }}
                    </small>
                </label>
                <div class="col-sm-8">
                    <input class="form-control @error('social_facebook') is-invalid @enderror" id="social_facebook" name="social_facebook" type="text" value="{{ isset($settings['social_facebook']) ? $settings['social_facebook'] : '' }}">
                    @error('social_facebook')
                        <span class="invalid-feedback d-block" role="alert"> <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-4 col-form-label" for="social_zalo">Zalo<br />
                    <small class="form-text text-muted" id="social_zalo-help">
                        {{ __('messages.setting.zalo') }}
                    </small>
                </label>
                <div class="col-sm-8">
                    <input class="form-control @error('social_zalo') is-invalid @enderror" id="social_zalo" name="social_zalo" type="text" value="{{ isset($settings['social_zalo']) ? $settings['social_zalo'] : '' }}">
                    @error('social_zalo')
                        <span class="invalid-feedback d-block" role="alert"> <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-4 col-form-label" for="social_youtube">Youtube<br />
                    <small class="form-text text-muted" id="social_youtube-help">
                        {{ __('messages.setting.youtube') }}
                    </small>
                </label>
                <div class="col-sm-8">
                    <input class="form-control @error('social_youtube') is-invalid @enderror" id="social_youtube" name="social_youtube" type="text" value="{{ isset($settings['social_youtube']) ? $settings['social_youtube'] : '' }}">
                    @error('social_youtube')
                        <span class="invalid-feedback d-block" role="alert"> <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-4 col-form-label" for="social_telegram">Telegram<br />
                    <small class="form-text text-muted" id="social_telegram-help">
                        {{ __('messages.setting.telegram') }}
                    </small>
                </label>
                <div class="col-sm-8">
                    <input class="form-control @error('social_telegram') is-invalid @enderror" id="social_telegram" name="social_telegram" type="text" value="{{ isset($settings['social_telegram']) ? $settings['social_telegram'] : '' }}">
                    @error('social_telegram')
                        <span class="invalid-feedback d-block" role="alert"> <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-4 col-form-label" for="social_tiktok">TikTok<br />
                    <small class="form-text text-muted" id="social_tiktok-help">
                        {{ __('messages.setting.tiktok') }}
                    </small>
                </label>
                <div class="col-sm-8">
                    <input class="form-control @error('social_tiktok') is-invalid @enderror" id="social_tiktok" name="social_tiktok" type="text" value="{{ isset($settings['social_tiktok']) ? $settings['social_tiktok'] : '' }}">
                    @error('social_tiktok')
                        <span class="invalid-feedback d-block" role="alert"> <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
        </div>
    </form>
</div>