<form id="loginForm" method="POST" action="{{ route('login') }}">
    @csrf
    <div class="modal fade text-left" id="customerLogin" role="dialog" aria-labelledby="myModalLabel4" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content key-bg-white-transparent">
                <div class="modal-header" style="border-bottom: 1px solid #b1b1b1;">
                    <p class="modal-title fw-bold">Đăng nhập
                    </p>
                    <a class="close btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </a>
                </div>
                <div class="modal-body p-4 p-lg-4">
                    <div class="row mb-4">
                        <div class="col-12 mb-2">
                            <div class="form-group row align-items-center">
                                <div class="col-4">
                                    <label class="col-form-label" for="login-email">Email</label>
                                </div>
                                <div class="col-8">
                                    <input class="form-control" id="login-email" name="email" type="email" value="{{ old('email') }}" required autocomplete="off" autofocus placeholder="Email đăng nhập">
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mb-2">
                            <div class="form-group row align-items-start">
                                <div class="col-4">
                                    <label class="col-form-label" for="login-password">Mật khẩu</label>
                                </div>
                                <div class="col-8">
                                    <input class="form-control" id="login-password" name="password" type="password" required autocomplete="off" placeholder="Mật khẩu">
                                    <div class="form-check mt-2">
                                        <input class="form-check-input cursor-pointer" id="showPasswordCheckbox" type="checkbox" value="">
                                        <label class="form-check-label cursor-pointer" for="showPasswordCheckbox">
                                            Hiện mật khẩu
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row ">
                        <div class="col-12 mb-3">
                            <button class="btn btn-warning btn-login" type="button">
                                <span class="">Đăng nhập</span>
                            </button>
                            <a class="ms-2" href="{{ route('forgot') }}">Quên mật khẩu</a>
                        </div>
                    </div>
                </div>
                @if (Route::has('register'))
                    <div class="modal-footer" style="border-top: 1px solid #b1b1b1;">
                        <p>Chưa có tài khoản?</p>
                        <a class="cursor-pointer" data-bs-toggle="modal" data-bs-backdrop="false" data-bs-target="#customerRegister">Đăng ký</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</form>
