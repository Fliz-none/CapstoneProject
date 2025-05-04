@extends('admin.layouts.app')
@section('title')
    {{ $pageName }}
@endsection
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>{{ $pageName }}</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav class="breadcrumb-header float-start float-lg-end" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $pageName }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="row gutters-sm">
                <div class="col-md-4 mb-3">
                    @include('admin.includes.profile_beside')
                </div>
                <div class="col-md-8">
                    <form action="{{ route('admin.profile.change_settings') }}" method="post">
                        @csrf
                        <div class="card mb-3 py-5">
                            @if (session('response'))
                                <div class="alert alert-{{ session('response')['status'] }} alert-dismissible fade show text-white" role="alert">
                                    <i class="fas fa-check"></i>
                                    {!! session('response')['msg'] !!}
                                    <button class="btn-close" data-bs-dismiss="alert" type="button" arial-label="Close"></button>
                                </div>
                            @endif
                            <div class="card-body">
                                <div class="row align-items-center mb-4">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0" data-bs-toggle="tooltip" data-bs-title="Tên hiển thị trên toàn hệ thống TRUONGDUNG PET">Tên hiển thị</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input class="form-control @error('name') is-invalid @enderror" id="profile-name" name="name" type="text" value="{{ Auth::user()->name ?? old('name') }}">
                                        @error('name')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row align-items-center mb-4">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0" data-bs-toggle="tooltip" data-bs-title="Chọn giới tính để thuận tiện xưng hô và hiển thị nội dung">Giới tính</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <div class="btn-group" role="group" aria-label="Giới tính">
                                            <input class="btn-check" id="gender-male" name="gender" type="radio" value="0" autocomplete="off" {{ Auth::user()->gender == '0' || old('gender') == '0' ? 'checked' : '' }}>
                                            <label class="btn btn-outline-primary" for="gender-male">Nam giới</label>
                                            <input class="btn-check" id="gender-female" name="gender" type="radio" value="1" autocomplete="off" {{ Auth::user()->gender == '1' || old('gender') == '1' ? 'checked' : '' }}>
                                            <label class="btn btn-outline-primary" for="gender-female">Nữ giới</label>
                                            <input class="btn-check" id="gender-other" name="gender" type="radio" value="2" autocomplete="off" {{ Auth::user()->gender == '2' || old('gender') == '2' ? 'checked' : '' }}>
                                            <label class="btn btn-outline-primary" for="gender-other">Không tiết lộ</label>
                                        </div>
                                        @error('gender')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row align-items-center mb-4">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0" data-bs-toggle="tooltip" data-bs-title="Dùng để đăng nhập và nhận các thông báo hệ thống">Địa chỉ email</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input class="form-control @error('email') is-invalid @enderror" id="profile-email" name="email" type="email" value="{{ Auth::user()->email ?? old('email') }}" inputmode="email">
                                        @error('email')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row align-items-center mb-4">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0" data-bs-toggle="tooltip" data-bs-title="Dùng để liên lạc khi cần thiết">Số điện thoại</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input class="form-control @error('phone') is-invalid @enderror" id="profile-phone" name="phone" type="text" value="{{ Auth::user()->phone ?? old('phone') }}" inputmode="numeric">
                                        @error('phone')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row align-items-center mb-4">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0" data-bs-toggle="tooltip" data-bs-title="Dùng cho việc giao nhận hàng hóa và vật nuôi">Địa chỉ</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input class="form-control @error('address') is-invalid @enderror @error('address') is-invalid @enderror" id="profile-address" name="address" type="text"
                                            value="{{ Auth::user()->address ?? old('address') }}">
                                        @error('address')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row align-items-center mb-4">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0" data-bs-toggle="tooltip" data-bs-title="Dùng để xác minh bạn là chủ tài khoản đang cập nhật">Mật khẩu của bạn</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input class="form-control @error('password') is-invalid @enderror" id="profile-password" name="password" type="password" placeholder="Nhập mật khẩu để xác nhận bạn là chủ của tài khoản này">
                                        @error('password')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row align-items-center">
                                    <div class="col-sm-12 d-flex justify-content-center">
                                        <input name="id" type="hidden" value="{{ Auth::user()->id }}">
                                        <button class="btn btn-primary " type="submit">{{ __('Update') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection


@push('scripts')
    <script>
        $('#profile-avatar').change(function(e) {
            e.preventDefault()
            const form = $(this).parents('form')
            src = URL.createObjectURL(document.getElementById('profile-avatar').files[0])
            $(this).parents('form').find('img').attr('src', src)
            submitForm(form)

        })
    </script>
@endpush
