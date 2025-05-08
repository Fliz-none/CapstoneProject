<div class="card mb-3">
    <form id="image-form" action="{{ route('admin.setting.image') }}" method="post">
        @csrf
        <div class="card-header d-flex justify-content-between">
            <h3>Thiết lập logo</h3>
            <button class="btn btn-primary btn-save" type="submit">Lưu</button>
        </div>
        <div class="card-body">
            <div class="row justify-content-between align-items-stretch">
                <div class="col-12 col-md-4 col-lg mb-3">
                    <h6 class="text-secondary">Biểu tượng web</h6>
                    <label class="form-label select-image" for="favicon" style="height: 19rem !important"> <img
                            class="img-fluid rounded-4 object-fit-cover" alt="Ảnh đại diện" onerror="this.src='{{ asset('/admin/images/logo/favicon_key.png') }}';">
                    </label>
                    <input class="hidden-image" id="favicon" name="favicon" type="hidden" value="{{ $settings['favicon'] ?? old('favicon') }}">
                    <div class="d-grid mt-auto"> <button class="btn btn-outline-primary btn-remove-image d-none" type="button">Xóa</button>
                    </div>
                </div>
                <div class="col-12 col-md-4 col-lg mb-3">
                    <h6 class="text-secondary">Logo màu</h6>
                    <label class="form-label select-image" for="logo_horizon" style="height: 19rem !important"> <img
                            class="img-fluid rounded-4 object-fit-cover" alt="Ảnh đại diện" onerror="this.src='{{ asset('/admin/images/logo/logo_horizon_key.png') }}';">
                    </label>
                    <input class="hidden-image" id="logo_horizon" name="logo_horizon" type="hidden" value="{{ $settings['logo_horizon'] ?? old('logo_horizon') }}">
                    <div class="d-grid mt-auto"> <button class="btn btn-outline-primary btn-remove-image d-none" type="button">Xóa</button>
                    </div>
                </div>
                <div class="col-12 col-md-4 col-lg mb-3">
                    <h6 class="text-secondary">Logo màu - vuông</h6>
                    <label class="form-label select-image" for="logo_square" style="height: 19rem !important"> <img
                            class="img-fluid rounded-4 object-fit-cover" alt="Ảnh đại diện" onerror="this.src='{{ asset('/admin/images/logo/logo_square.png') }}';">
                    </label>
                    <input class="hidden-image" id="logo_square" name="logo_square" type="hidden" value="{{ $settings['logo_square'] ?? old('logo_square') }}">
                    <div class="d-grid mt-auto"> <button class="btn btn-outline-primary btn-remove-image d-none" type="button">Xóa</button>
                    </div>
                </div>
                <div class="col-12 col-md-4 col-lg mb-3">
                    <h6 class="text-secondary">Logo trắng đen</h6>
                    <label class="form-label select-image" for="logo_horizon_bw" style="height: 19rem !important"> <img
                            class="img-fluid rounded-4 object-fit-cover" alt="Ảnh đại diện" onerror="this.src='{{ asset('/admin/images/logo/logo_horizon_bw_key.png') }}';">
                    </label>
                    <input class="hidden-image" id="logo_horizon_bw" name="logo_horizon_bw" type="hidden" value="{{ $settings['logo_horizon_bw'] ?? old('logo_square') }}">
                    <div class="d-grid mt-auto"> <button class="btn btn-outline-primary btn-remove-image d-none" type="button">Xóa</button>
                    </div>
                </div>
                <div class="col-12 col-md-4 col-lg mb-3">
                    <h6 class="text-secondary">Logo trắng đen - vuông</h6>
                    <label class="form-label select-image" for="logo_square_bw" style="height: 19rem !important"> <img
                            class="img-fluid rounded-4 object-fit-cover" alt="Ảnh đại diện" onerror="this.src='{{ asset('/admin/images/logo/logo_square_bw_key.png') }}';">
                    </label>
                    <input class="hidden-image" id="logo_square_bw" name="logo_square_bw" type="hidden" value="{{ $settings['logo_square_bw'] ?? old('logo_square') }}">
                    <div class="d-grid mt-auto"> <button class="btn btn-outline-primary btn-remove-image d-none" type="button">Xóa</button>
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
                    <h3>Thiết lập thanh toán</h3>
                </div>
                <div class="col-12 col-md-4 col-lg-5 d-flex justify-content-between">
                    <button class="ms-auto btn btn-outline-primary btn-add-bank-account" type="button"><i class="bi bi-plus"></i> Thêm</button>
                    <button class="ms-2 btn btn-outline-primary btn-remove-bank-account" type="button"><i class="bi bi-dash"></i> Xóa</button>
                    <button class="ms-2 btn btn-primary btn-save-pay_setting" type="submit">Lưu</button>
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
                                Ngân hàng<br />
                                <small class="form-text text-muted" id="bank_id-help-{{ $i }}"> Dùng xuất mã QR thanh toán theo đơn hàng </small>
                            </label>
                            <div class="col-sm-8">
                                <div class="d-none bank-names-hidden">
                                    <input name="bank_names[{{ $i }}]" type="hidden" value="{{ optional($acc)->bank_name }}">
                                </div>
                                <select class="bank-selected form-select @error('bank_ids.' . $i) is-invalid @enderror" id="bank_id-{{ $i }}" name="bank_ids[{{ $i }}]">
                                    <option selected disabled hidden>Vui lòng chọn một ngân hàng</option>
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
                                Tên tài khoản<br />
                                <small class="form-text text-muted" id="bank_account-help-{{ $i }}">Dùng xuất mã QR thanh toán theo đơn hàng </small>
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
                                Số tài khoản<br />
                                <small class="form-text text-muted" id="bank_number-help-{{ $i }}">Dùng xuất mã QR thanh toán theo đơn hàng </small>
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
                <h3>Thiết lập gửi email</h3>
                <button class="btn btn-primary btn-save" type="submit">Lưu</button>
            </div>
            <div class="card-body">
                <div class="mb-3 row">
                    <label class="col-sm-4 col-form-label" for="app_name">Tên ứng dụng<br />
                        <small class="form-text text-muted" id="app_name-help">Hiển thị trên tiêu đề trang web và email</small>
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
                    <label class="col-sm-4 col-form-label" for="mail_from_address">Email thông báo<br />
                        <small class="form-text text-muted" id="mail_from_address-help">Được sử dụng để gửi thông báo
                            đặt hàng và thông báo đặt dịch vụ</small>
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
                    <label class="col-sm-4 col-form-label" for="mail_username">Tên người dùng<br />
                        <small class="form-text text-muted" id="mail_username-help">
                            Tên đăng nhập máy chủ gửi đi của toàn bộ hệ thống email
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
                    <label class="col-sm-4 col-form-label" for="mail_password">Mật khẩu ứng dụng<br />
                        <small class="form-text text-muted" id="mail_password-help">
                            Mật khẩu đăng nhập máy chủ gửi tất cả email hệ thống
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
                    <label class="col-sm-4 col-form-label" for="mail_encryption">Loại mã hóa<br />
                        <small class="form-text text-muted" id="mail_encryption-help">
                            Áp dụng cho việc gửi email an toàn, bảo mật
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
                    <label class="col-sm-4 col-form-label" for="mail_driver">Trình điều khiển email<br />
                        <small class="form-text text-muted" id="mail_driver-help">
                            Giao thức áp dụng cho việc gửi tất cả các email hệ thống
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
                    <label class="col-sm-4 col-form-label" for="mail_port">Cổng mail<br />
                        <small class="form-text text-muted" id="mail_port-help">
                            Cổng truy cập máy chủ thư điện tử
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
                    <label class="col-sm-4 col-form-label" for="mail_host">Máy chủ thư<br />
                        <small class="form-text text-muted" id="mail_host-help">
                            Máy chủ lưu trữ thực hiện tất cả các hệ thống gửi email này
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
                    <label class="col-sm-4 col-form-label" for="expired_notification_frequency-preview">Tần suất gửi mail tự động<br />
                        <small class="form-text text-muted" id="expired_notification_frequency-preview-help">
                            Tần suất gửi mail thông báo các sản phẩm sắp hết hạn sử dụng
                        </small>
                    </label>
                    <div class="col-sm-8">
                        <input class="form-control @error('expired_notification_frequency') is-invalid @enderror" id="expired_notification_frequency-preview" type="text"
                            value="{{ isset($settings['expired_notification_frequency']) ? 'Mỗi ' . $settings['expired_notification_frequency'] . ' ngày' : '' }}">
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
            <h3>Thiết lập các kênh mạng xã hội</h3>
            <button class="btn btn-primary btn-save" type="submit">Lưu</button>
        </div>
        <div class="card-body">
            <div class="mb-3 row">
                <label class="col-sm-4 col-form-label" for="social_facebook">Facebook<br />
                    <small class="form-text text-muted" id="social_facebook-help">
                        Đường dẫn đến trang Facebook
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
                        Nhập số điện thoại đăng ký Zalo
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
                        Đường dẫn đến kênh Youtube
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
                        Đường dẫn đến tài khoản Telegram
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
                        Đường dẫn đến tài khoản TikTok
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
<div class="card mb-3">
    <form id="zalo-form" action="{{ route('admin.setting.zalo') }}" method="post">
        @csrf
        <div class="card-header d-flex justify-content-between">
            <h3>Thiết lập thông tin Zalo</h3>
            <button class="btn btn-primary btn-save" type="submit">Lưu</button>
        </div>
        <div class="card-body">
            <div class="mb-3 row">
                <label class="col-sm-4 col-form-label" for="has_zalo">
                    Sử dụng Zalo <br />
                    <small class="form-text text-muted">Bật tính năng tương tác với khách hàng qua tin nhắn thông báo trên Zalo</small>
                </label>
                <div class="col-sm-8">
                    <input name="has_zalo" type="hidden" value="0">
                    <input class="form-check-input @error('has_zalo') is-invalid @enderror" id="has_zalo" name="has_zalo" type="checkbox" value="1" {{ isset($settings['has_zalo']) && $settings['has_zalo'] == 1 ? 'checked' : '' }}>
                    @error('has_zalo')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-4 col-form-label" for="zalo_oa_id">Zalo OA ID<br />
                    <small class="form-text text-muted">ID tài khoản Zalo Official Account</small>
                </label>
                <div class="col-sm-8">
                    <input class="form-control @error('zalo_oa_id') is-invalid @enderror" id="zalo_oa_id" name="zalo_oa_id" type="text" value="{{ isset($settings['zalo_oa_id']) ? $settings['zalo_oa_id'] : '' }}">
                    @error('zalo_oa_id')
                        <span class="invalid-feedback d-block" role="alert"> <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-4 col-form-label" for="zalo_app_id">App ID<br />
                    <small class="form-text text-muted">ID của ứng dụng Zalo</small>
                </label>
                <div class="col-sm-8">
                    <input class="form-control @error('zalo_app_id') is-invalid @enderror" id="zalo_app_id" name="zalo_app_id" type="text" value="{{ isset($settings['zalo_app_id']) ? $settings['zalo_app_id'] : '' }}">
                    @error('zalo_app_id')
                        <span class="invalid-feedback d-block" role="alert"> <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-4 col-form-label" for="zalo_app_secret">App Secret<br />
                    <small class="form-text text-muted">Khóa bí mật của ứng dụng</small>
                </label>
                <div class="col-sm-8">
                    <input class="form-control @error('zalo_app_secret') is-invalid @enderror" id="zalo_app_secret" name="zalo_app_secret" type="text" value="{{ isset($settings['zalo_app_secret']) ? $settings['zalo_app_secret'] : '' }}">
                    @error('zalo_app_secret')
                        <span class="invalid-feedback d-block" role="alert"> <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-4 col-form-label" for="zalo_access_token">Access Token<br />
                    <small class="form-text text-muted">Mã truy cập để kết nối API</small>
                </label>
                <div class="col-sm-8">
                    <input class="form-control @error('zalo_access_token') is-invalid @enderror" id="zalo_access_token" name="zalo_access_token" type="text"
                        value="{{ isset($settings['zalo_access_token']) ? $settings['zalo_access_token'] : '' }}">
                    @error('zalo_access_token')
                        <span class="invalid-feedback d-block" role="alert"> <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-4 col-form-label" for="zalo_refresh_token">Refresh Token<br />
                    <small class="form-text text-muted">Token làm mới để duy trì kết nối</small>
                </label>
                <div class="col-sm-8">
                    <input class="form-control @error('zalo_refresh_token') is-invalid @enderror" id="zalo_refresh_token" name="zalo_refresh_token" type="text"
                        value="{{ isset($settings['zalo_refresh_token']) ? $settings['zalo_refresh_token'] : '' }}">
                    @error('zalo_refresh_token')
                        <span class="invalid-feedback d-block" role="alert"> <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-4 col-form-label" for="zalo_transaction_template">Mẫu Giao Dịch<br />
                    <small class="form-text text-muted">Cấu hình mẫu tin nhắn Zalo giao dịch thành công</small>
                </label>
                <div class="col-sm-8">
                    <input class="form-control @error('zalo_transaction_template') is-invalid @enderror" id="zalo_transaction_template" name="zalo_transaction_template" type="text"
                        value="{{ isset($settings['zalo_transaction_template']) ? $settings['zalo_transaction_template'] : '' }}">
                    @error('zalo_transaction_template')
                        <span class="invalid-feedback d-block" role="alert"> <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-4 col-form-label" for="zalo_booking_template">Mẫu đặt lịch<br />
                    <small class="form-text text-muted">Cấu hình mẫu tin nhắn Zalo đặt lịch dịch vụ</small>
                </label>
                <div class="col-sm-8">
                    <input class="form-control @error('zalo_booking_template') is-invalid @enderror" id="zalo_booking_template" name="zalo_booking_template" type="text"
                        value="{{ isset($settings['zalo_booking_template']) ? $settings['zalo_booking_template'] : '' }}">
                    @error('zalo_booking_template')
                        <span class="invalid-feedback d-block" role="alert"> <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-4 col-form-label" for="zalo_report_template">Mẫu Báo Cáo<br />
                    <small class="form-text text-muted">Cấu hình mẫu tin nhắn Zalo báo cáo nội trú</small>
                </label>
                <div class="col-sm-8">
                    <input class="form-control @error('zalo_report_template') is-invalid @enderror" id="zalo_report_template" name="zalo_report_template" type="text"
                        value="{{ isset($settings['zalo_report_template']) ? $settings['zalo_report_template'] : '' }}">
                    @error('zalo_report_template')
                        <span class="invalid-feedback d-block" role="alert"> <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-4 col-form-label" for="zalo_comeout_template">Mẫu xuất viện<br />
                    <small class="form-text text-muted">Cấu hình mẫu tin nhắn Zalo thông báo kết thúc dịch vụ</small>
                </label>
                <div class="col-sm-8">
                    <input class="form-control @error('zalo_comeout_template') is-invalid @enderror" id="zalo_comeout_template" name="zalo_comeout_template" type="text"
                        value="{{ isset($settings['zalo_comeout_template']) ? $settings['zalo_comeout_template'] : '' }}">
                    @error('zalo_comeout_template')
                        <span class="invalid-feedback d-block" role="alert"> <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
        </div>
    </form>
</div>
