<form method="POST" action="{{ route('login.auth') }}" id="login-form" class="save-form">
    <div class="modal fade" id="login-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Đăng nhập</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @csrf
                    <div class="row mb-3">
                        <label for="email" class="col-md-4 col-form-label text-md-end">Địa chỉ email</label>
                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control" name="email" required autocomplete="email">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="password" class="col-md-4 col-form-label text-md-end">Mật khẩu</label>
                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control" name="password" required autocomplete="current-password">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                <label class="form-check-label" for="remember">
                                    Tự động đăng nhập trong 30 ngày
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-0 justify-content-between">
                        <div class="col-md-8">
                            @if (Route::has('password.request'))
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    Tôi quên mật khẩu
                                </a>
                            @endif
                        </div>
                        <div class="col-md-4 text-end">
                            <button type="submit" class="btn btn-primary" id="submit-login-btn">
                                Đăng nhập
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
