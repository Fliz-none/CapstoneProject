@php
    $user = Auth::check() ? Auth::user() : null;
@endphp

@if (Auth::check())
    <form class="save-form" id="profile-web-form" method="post" enctype="multipart/form-data" action="{{ route('profile.change_infor') }}">
    @csrf
    <div class="modal fade" id="profile-web-modal" data-bs-backdrop="static" aria-labelledby="profile-web-modal-label">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h1 class="modal-title text-white fs-5" id="profile-web-modal-label">Thay đổi thông tin</h1>
                    <button class="btn-close text-white" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <div class="row g-3">
                                <!-- Name -->
                                <div class="col-md-6">
                                    <label class="form-label" for="name">Họ tên</label>
                                    <input class="form-control" id="name" type="text" name="name" value="{{ $user->name ?? '' }}" required>
                                </div>

                                <!-- Phone -->
                                <div class="col-md-6">
                                    <label class="form-label" for="phone">Số điện thoại</label>
                                    <input class="form-control" id="phone" type="text" name="phone" value="{{ $user->phone ?? '' }}">
                                </div>

                                <!-- Email -->
                                <div class="col-md-6">
                                    <label class="form-label" for="email">Email</label>
                                    <input class="form-control" id="email" type="email" name="email" value="{{ $user->email ?? '' }}" required>
                                </div>

                                <!-- Gender -->
                                <div class="col-md-6">
                                    <label class="form-label" for="gender">Giới tính</label>
                                    <select class="form-select" id="gender" name="gender">
                                        <option value="0" {{ $user->gender === 0 ? 'selected' : ''  }}>Nam</option>
                                        <option value="1" {{ $user->gender === 1 ? 'selected' : '' }}>Nữ</option>
                                        <option value="2" {{ $user->gender === 2 ? 'selected' : '' }}>Khác</option>
                                    </select>
                                </div>

                                <!-- Address -->
                                <div class="col-12">
                                    <label class="form-label" for="address">Địa chỉ</label>
                                    <textarea class="form-control" id="address" name="address" rows="3">{{ $user->address ?? '' }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="row">
                                <!-- Avatar -->
                                <div class="col-md-12 text-center">
                                    <label class="avt cursor-pointer" for="profile-avatar">
                                        <img id="avatar-preview" class="rounded-circle" src="{{ Auth::user()->avatarUrl ?? asset('admin/images/placeholder.webp') }}" alt="Admin" style="object-fit: cover; width: 160px; height: 160px;">
                                    </label>
                                    <input class="d-none" id="profile-avatar" name="avatar" type="file" accept="image/*">
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-12 text-end">
                            <input type="hidden" name="id" value="{{ $user->id }}">
                            <button class="key-btn-dark" type="submit">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@else
@endif


