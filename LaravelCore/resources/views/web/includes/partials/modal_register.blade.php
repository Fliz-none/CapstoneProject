<form id="registerForm" method="POST" action="{{ route('register') }}">
    @csrf
    <div class="modal fade text-left" id="customerRegister" role="dialog" aria-labelledby="myModalLabel4" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content key-bg-white-transparent">
                <div class="modal-header" style="border-bottom: 1px solid #b1b1b1;">
                    <p class="modal-title fw-bold">Đăng nhập
                    </p>
                    <a class="close btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </a>
                </div>
                <div class="modal-body p-2 p-lg-4">
                    <div class="row mb-4">
                        <div class="col-12 mb-2">
                            <div class="form-group row align-items-center">
                                <div class="col-3">
                                    <label class="col-form-label" for="register-name">Họ và tên</label>
                                </div>
                                <div class="col-9">
                                    <input class="form-control" id="register-name" name="name" type="text" value="{{ old('name') }}" required autocomplete="off" autofocus placeholder="Tên khách hàng">
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mb-2">
                            <div class="form-group row align-items-center">
                                <div class="col-3">
                                    <label class="col-form-label" for="register-phone">Điện thoại</label>
                                </div>
                                <div class="col-9">
                                    <input class="form-control" id="register-phone" name="phone" type="text" value="{{ old('phone') }}" autocomplete="off" placeholder="Số điện thoại" inputmode="numeric">
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mb-2">
                            <div class="form-group row align-items-center">
                                <div class="col-3">
                                    <label class="col-form-label" for="register-email">Email</label>
                                </div>
                                <div class="col-9">
                                    <input class="form-control" id="register-email" name="email" type="email" value="{{ old('email') }}" required autocomplete="off" placeholder="Email đăng ký">
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mb-2">
                            <div class="form-group row align-items-center">
                                <div class="col-3">
                                    <label class="col-form-label" for="men">Giới tính</label>
                                </div>
                                <div class="col-9">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" id="men" name="gender" type="radio" value="0" checked>
                                        <label class="form-check-label cursor-pointer" for="men">
                                            Nam
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" id="women" name="gender" type="radio" value="1">
                                        <label class="form-check-label cursor-pointer" for="women">
                                            Nữ
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" id="other" name="gender" type="radio" value="2">
                                        <label class="form-check-label cursor-pointer" for="other">
                                            Khác
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mb-2">
                            <div class="form-group row align-items-center">
                                <div class="col-3">
                                    <label class="col-form-label" for="register-birthday">Ngày sinh</label>
                                </div>
                                <div class="col-9">
                                    <input class="form-control" id="register-birthday" name="birthday" type="date" value="{{ old('birthday') }}" max="{{ now()->format('Y-m-d') }}" >
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mb-2">
                            <div class="form-group row align-items-center">
                                <div class="col-3">
                                    <label class="col-form-label" for="register-address">Địa chỉ</label>
                                </div>
                                <div class="col-9">
                                    <input class="form-control" id="register-address" name="address" type="text" value="{{ old('address') }}" autocomplete="on" placeholder="Địa chỉ">
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mb-2">
                            <div class="form-group row align-items-center">
                                <div class="col-3">
                                    <label class="col-form-label" for="register-password">Mật khẩu</label>
                                </div>
                                <div class="col-9">
                                    <input class="form-control" id="register-password" name="password" type="password" required autocomplete="off" placeholder="Mật khẩu">
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mb-2">
                            <div class="form-group row align-items-center">
                                <div class="col-3">
                                    <label class="col-form-label" for="password-confirm">Xác nhận</label>
                                </div>
                                <div class="col-9">
                                    <input class="form-control" id="password-confirm" name="password_confirmation" type="password" placeholder="Xác nhận lại mật khẩu" required autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row ">
                        <div class="col-12 mb-3">
                            <button class="btn btn-warning btn-register" type="button">
                                <span class="">Đăng ký</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid #b1b1b1;">
                    <p>Đã có tài khoản? <a class="cursor-pointer" data-bs-toggle="modal" data-bs-backdrop="false" data-bs-target="#customerLogin">Đăng nhập</a></p>
                </div>
            </div>
        </div>
    </div>
</form>
