@extends('web.layouts.app')
@section('title')
    {{ $pageName }}
@endsection
@php
    $settings = cache()->get('settings');
    $user = Auth::check() ? Auth::user() : null;
@endphp

<style>
    .star-rating {
        direction: rtl;
        display: inline-flex;
        font-size: 1.5rem;
    }

    .star-rating input[type="radio"] {
        display: none;
    }

    .star-rating label {
        color: #ccc;
        cursor: pointer;
        transition: color 0.2s;
    }

    .star-rating input[type="radio"]:checked~label,
    .star-rating label:hover,
    .star-rating label:hover~label {
        color: #ffc107;
    }

    .rating-box {
        border: 1px solid #ddd;
        background-color: #fafafa;
        padding: 15px;
        margin-top: 15px;
        border-radius: 5px;
    }

    .form-textarea {
        resize: none;
        height: 100px;
    }
</style>
@section('content')
    <div class="master-wrapper">
        <div class="container-fluid p-5 mt-5">
            <div class="row">
                <div class="col-12 col-md-4 col-lg-3 col-xl-2">
                    <div class="profile-wrapper">
                        <div class="profile-content">
                            <div class="row align-items-center justify-content-start">
                                <div class="col-2 col-md-4">
                                    <div class="profile-avatar py-2">
                                        <img class="img-fluid rounded-circle border border-1 w-100" src="{{ $user->avatarUrl }}" alt="Avatar" referrerpolicy="no-referrer">
                                    </div>
                                </div>
                                <div class="col-10 col-md-8 px-0 cursor-pointer text-dark">
                                    <p class="fw-semibold mb-0">{{ $user->name }}</p>
                                    <small class="mb-0">{{ $user->phone ?? '' }}</small>
                                    </a>
                                </div>
                                <hr>
                                <ul class="nav flex-column text-dark ps-4" role="tablist">
                                    <li class="nav-item cursor-pointer">
                                        <a class="nav-link text-nowrap active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" role="tab">
                                            <i class="bi bi-person me-2"></i> Thông tin cá nhân
                                        </a>
                                    </li>
                                    <li class="nav-item cursor-pointer">
                                        <a class="nav-link text-nowrap" id="user-order-tab" data-bs-toggle="tab" data-bs-target="#user-order" role="tab">
                                            <i class="bi bi-receipt-cutoff me-2"></i> Đơn hàng
                                        </a>
                                    </li>
                                    @if ($user->hasAnyPermission(\App\Models\User::ACCESS_ADMIN))
                                        <li class="nav-item cursor-pointer">
                                            <a class="nav-link text-nowrap" href="{{ route('admin.home') }}">
                                                <i class="bi bi-house-check me-2"></i> {{ __('lang_web.profile.access_admin') }}
                                            </a>
                                        </li>
                                    @endif
                                    <li class="nav-item cursor-pointer">
                                        <a class="nav-link text-nowrap text-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="bi bi-box-arrow-right me-2"></i> {{ __('messages.profile.logout') }}
                                        </a>
                                        <form class="d-none" id="logout-form" action="{{ route('logout') }}" method="POST">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-8 col-lg-9 col-xl-10 px-5">
                    <div class="tab-content mt-3">
                        <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            @if (Auth::check())
                                <form class="save-form" id="profile-web-form" method="post" enctype="multipart/form-data" action="{{ route('profile.change_infor') }}">
                                    @csrf
                                    <div class="row justify-content-between align-items-center mt-3">
                                        <div class="col-12 col-sm-8 col-lg-9 d-flex">
                                            <h5 class="mb-3" for="name">Cập nhật thông tin cá nhân</h5>
                                            <button class="btn-success-custom ms-auto" type="submit">Lưu</button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-sm-8 col-lg-9">
                                            <div class="row g-3">
                                                <!-- Name -->
                                                <div class="col-md-6">
                                                    <label class="form-label" for="name">{{ __('lang_web.profile.fullname') }}</label>
                                                    <input class="form-control" id="name" name="name" type="text" value="{{ $user->name ?? '' }}" required>
                                                </div>

                                                <!-- Phone -->
                                                <div class="col-md-6">
                                                    <label class="form-label" for="phone">{{ __('lang_web.profile.phone') }}</label>
                                                    <input class="form-control" id="phone" name="phone" type="text" value="{{ $user->phone ?? '' }}">
                                                </div>

                                                <!-- Email -->
                                                <div class="col-md-6">
                                                    <label class="form-label" for="email">Email</label>
                                                    <input class="form-control" id="email" name="email" type="email" value="{{ $user->email ?? '' }}" required>
                                                </div>

                                                <!-- Gender -->
                                                <div class="col-md-6">
                                                    <label class="form-label" for="gender">{{ __('lang_web.profile.gender') }}</label>
                                                    <select class="form-select" id="gender" name="gender">
                                                        <option value="0" {{ $user->gender === 0 ? 'selected' : '' }}>{{ __('lang_web.profile.gender_male') }}</option>
                                                        <option value="1" {{ $user->gender === 1 ? 'selected' : '' }}>{{ __('lang_web.profile.gender_female') }}</option>
                                                        <option value="2" {{ $user->gender === 2 ? 'selected' : '' }}>{{ __('lang_web.profile.gender_other') }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center mt-3">
                                                <a class="btn btn-view-address border border-1"><i class="bi bi-geo-alt"></i> {{ __('lang_web.profile.user_address') }}</a>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-4 col-lg-3">
                                            <div class="row">
                                                <!-- Avatar -->
                                                <div class="col-md-12 text-center">
                                                    <label class="avt cursor-pointer ratio-1x1" for="profile-avatar">
                                                        <img class="rounded-circle img-fluid border border-1" id="avatar-preview" src="{{ Auth::user()->avatarUrl ?? asset('admin/images/placeholder.webp') }}" alt="Admin" style="object-fit: cover;">
                                                    </label>
                                                    <input class="d-none" id="profile-avatar" name="avatar" type="file" accept="image/*">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <hr class="mx-3 my-4">
                                <form class="change-password-form" action="{{ route('profile.update_password') }}" method="post">
                                    <div class="row justify-content-between align-items-center mt-3">
                                        <div class="col-12 col-sm-8 col-lg-9 d-flex">
                                            <h5 class="mb-3" for="old-password">Đổi mật khẩu</h5>
                                            <button class="btn-success-custom ms-auto" type="submit">Lưu</button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-sm-8 col-lg-9">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="old-password">Mật khẩu</label>
                                                <input class="form-control" id="old-password" name="old_password" type="password" placeholder="Nhập mật khẩu hiện tại" required autocomplete="off">
                                            </div>
                                            <div class="mb-3">
                                                <label for="new-password">Mật khẩu mới</label>
                                                <input class="form-control" id="new-password" name="new_password" type="password" placeholder="Nhập mật khẩu mới" required autocomplete="off">
                                            </div>
                                            <div class="mb-3">
                                                <label for="password-confirm">Xác nhận</label>
                                                <input class="form-control" id="password-confirm" name="password_confirmation" type="password" placeholder="Xác nhận" required autocomplete="off">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            @endif
                        </div>
                        <div class="tab-pane fade" id="user-order" role="tabpanel" aria-labelledby="user-order-tab" style="min-height: 70vh">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs nav-tabs-horizontal fw-bold mb-3" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="order-all-tab" data-bs-toggle="tab" data-bs-target="#order-all" type="button" role="tab">Tất cả</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="order-processing-tab" data-bs-toggle="tab" data-bs-target="#order-processing" type="button" role="tab">Đang xử lý</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="order-completed-tab" data-bs-toggle="tab" data-bs-target="#order-completed" type="button" role="tab">Đã nhận</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="order-canceled-tab" data-bs-toggle="tab" data-bs-target="#order-canceled" type="button" role="tab">Đã hủy</button>
                                </li>
                            </ul>
                            @php
                                $orders = $user->orders->reverse();
                            @endphp
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <!-- Tab 1: Tất cả đơn hàng -->
                                <div class="tab-pane fade show active overflow-auto" id="order-all" role="tabpanel" aria-labelledby="order-all-tab" style="max-height: 80vh">
                                    @foreach ($orders as $order)
                                        <div class="card p-3 shadow mb-4">
                                            <div class="d-flex justify-content-between align-items-end">
                                                <div class="order-info">
                                                    <p class="fw-bold mb-0">Mã đơn: {{ $order->code }}</p>
                                                    <small>{{ $order->created_at->format('d/m/Y H:i') }}</small>
                                                </div>
                                                <p class="text-{{ $order->statusStr['color'] }} fw-bold mb-1">{{ $order->statusStr['string'] }}</p>
                                            </div>
                                            @php
                                                $groupedDetails = collect($order->details)
                                                    ->groupBy(function ($detail) {
                                                        return $detail->unit->id;
                                                    })
                                                    ->map(function ($details) {
                                                        $first = $details->first();
                                                        $quantity = $details->sum('quantity');
                                                        $total = $details->sum(function ($item) {
                                                            return (float) $item->total;
                                                        });
                                                        $originalTotal = $details->sum(function ($item) {
                                                            return (float) $item->originalTotal;
                                                        });

                                                        return (object) [
                                                            'unit' => $first->unit,
                                                            'variable' => $first->unit->variable,
                                                            'product' => $first->unit->variable->product,
                                                            'quantity' => $quantity,
                                                            'total' => $total,
                                                            'originalTotal' => $originalTotal,
                                                        ];
                                                    });
                                            @endphp

                                            @foreach ($groupedDetails as $detail)
                                                @php
                                                    $unit = $detail->unit;
                                                    $variable = $detail->variable;
                                                    $product = $detail->product;
                                                @endphp

                                                <hr class="mt-1">
                                                <div class="row mb-3">
                                                    <div class="col-3 col-md-2 col-lg-1">
                                                        <img class="img-fluid object-fit-contain w-75" src="{{ $product->avatarUrl }}" alt="">
                                                    </div>
                                                    <div class="col-9 col-md-10 col-lg-11">
                                                        <p class="mb-0">{{ $product->name }} - {{ $variable->name }}</p>
                                                        <div class="d-flex justify-content-between">
                                                            <small>Số lượng: {{ $detail->quantity }} {{ $unit->term }}</small>
                                                            <small class="fs-6">
                                                                @if ($detail->originalTotal != $detail->total)
                                                                    <s class="small text-muted me-4">{{ number_format($detail->originalTotal) }}</s><br>
                                                                @endif
                                                                <small class="{{ $detail->originalTotal != $detail->total ? 'text-danger' : '' }}">
                                                                    {{ number_format($detail->total) }} VND
                                                                </small>
                                                            </small>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                            <hr class="mt-0">
                                            <div class="row">
                                                <div class="col-4 d-flex align-items-center">
                                                    @if ($order->status == 3 && !$order->details[0]->reviews)
                                                        <button class="btn-success-custom btn-rate-order me-5" data-id="{{ $order->id }}">Đánh giá</button>
                                                    @elseif (in_array($order->status, [1, 2]))
                                                        <button class="key-btn-danger btn-cancel-order me-5" data-id="{{ $order->id }}">Hủy đơn hàng</button>
                                                    @endif
                                                </div>
                                                <div class="col-8 order-total">
                                                    @if ($order->discount)
                                                        <p class="text-end mb-0">Giảm giá: {{ number_format($order->discount) }} VND</p>
                                                    @endif
                                                    <p class="text-end mb-0">Thành tiền: <strong class="text-danger fs-5">{{ number_format($order->total) }}</strong> VND</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Tab 2: Đơn hàng đang xử lý -->
                                <div class="tab-pane fade" id="order-processing" role="tabpanel" aria-labelledby="order-processing-tab">
                                    @foreach ($orders->whereIn('status', [1, 2]) as $order)
                                        <div class="card p-3 shadow mb-4">
                                            <div class="order-info">
                                                <p class="fw-bold mb-0">Mã đơn: {{ $order->code }}</p>
                                                <small>{{ $order->created_at->format('d/m/Y H:i') }}</small>
                                            </div>
                                            @php
                                                $groupedDetails = collect($order->details)
                                                    ->groupBy(function ($detail) {
                                                        return $detail->unit->id;
                                                    })
                                                    ->map(function ($details) {
                                                        $first = $details->first();
                                                        $quantity = $details->sum('quantity');
                                                        $total = $details->sum(function ($item) {
                                                            return (float) $item->total;
                                                        });
                                                        $originalTotal = $details->sum(function ($item) {
                                                            return (float) $item->originalTotal;
                                                        });

                                                        return (object) [
                                                            'unit' => $first->unit,
                                                            'variable' => $first->unit->variable,
                                                            'product' => $first->unit->variable->product,
                                                            'quantity' => $quantity,
                                                            'total' => $total,
                                                            'originalTotal' => $originalTotal,
                                                        ];
                                                    });
                                            @endphp

                                            @foreach ($groupedDetails as $detail)
                                                @php
                                                    $unit = $detail->unit;
                                                    $variable = $detail->variable;
                                                    $product = $detail->product;
                                                @endphp

                                                <hr class="mt-1">
                                                <div class="row mb-3">
                                                    <div class="col-3 col-md-2 col-lg-1">
                                                        <img class="img-fluid object-fit-contain w-75" src="{{ $product->avatarUrl }}" alt="">
                                                    </div>
                                                    <div class="col-9 col-md-10 col-lg-11">
                                                        <p class="mb-0">{{ $product->name }} - {{ $variable->name }}</p>
                                                        <div class="d-flex justify-content-between">
                                                            <small>Số lượng: {{ $detail->quantity }} {{ $unit->term }}</small>
                                                            <small class="fs-6">
                                                                @if ($detail->originalTotal != $detail->total)
                                                                    <s class="small text-muted me-4">{{ number_format($detail->originalTotal) }}</s><br>
                                                                @endif
                                                                <small class="{{ $detail->originalTotal != $detail->total ? 'text-danger' : '' }}">
                                                                    {{ number_format($detail->total) }} VND
                                                                </small>
                                                            </small>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                            <hr class="mt-0">
                                            <div class="row">
                                                <div class="col-4 d-flex align-items-center">
                                                    <button class="key-btn-danger btn-cancel-order me-5" data-id="{{ $order->id }}">Hủy đơn hàng</button>
                                                </div>
                                                <div class="col-8 order-total">
                                                    @if ($order->discount)
                                                        <p class="text-end mb-0">Giảm giá: {{ number_format($order->discount) }} VND</p>
                                                    @endif
                                                    <p class="text-end mb-0">Thành tiền: <strong class="text-danger fs-5">{{ number_format($order->total) }}</strong> VND</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Tab 3: Đơn hàng đã nhận -->
                                <div class="tab-pane fade" id="order-completed" role="tabpanel" aria-labelledby="order-completed-tab">
                                    @foreach ($orders->where('status', 3) as $order)
                                        <div class="card p-3 shadow mb-4">
                                            <div class="order-info">
                                                <p class="fw-bold mb-0">Mã đơn: {{ $order->code }}</p>
                                                <small>{{ $order->created_at->format('d/m/Y H:i') }}</small>
                                            </div>
                                            @php
                                                $groupedDetails = collect($order->details)
                                                    ->groupBy(function ($detail) {
                                                        return $detail->unit->id;
                                                    })
                                                    ->map(function ($details) {
                                                        $first = $details->first();
                                                        $quantity = $details->sum('quantity');
                                                        $total = $details->sum(function ($item) {
                                                            return (float) $item->total;
                                                        });
                                                        $originalTotal = $details->sum(function ($item) {
                                                            return (float) $item->originalTotal;
                                                        });

                                                        return (object) [
                                                            'unit' => $first->unit,
                                                            'variable' => $first->unit->variable,
                                                            'product' => $first->unit->variable->product,
                                                            'quantity' => $quantity,
                                                            'total' => $total,
                                                            'originalTotal' => $originalTotal,
                                                        ];
                                                    });
                                            @endphp

                                            @foreach ($groupedDetails as $detail)
                                                @php
                                                    $unit = $detail->unit;
                                                    $variable = $detail->variable;
                                                    $product = $detail->product;
                                                @endphp

                                                <hr class="mt-1">
                                                <div class="row mb-3">
                                                    <div class="col-3 col-md-2 col-lg-1">
                                                        <img class="img-fluid object-fit-contain w-75" src="{{ $product->avatarUrl }}" alt="">
                                                    </div>
                                                    <div class="col-9 col-md-10 col-lg-11">
                                                        <p class="mb-0">{{ $product->name }} - {{ $variable->name }}</p>
                                                        <div class="d-flex justify-content-between">
                                                            <small>Số lượng: {{ $detail->quantity }} {{ $unit->term }}</small>
                                                            <small class="fs-6">
                                                                @if ($detail->originalTotal != $detail->total)
                                                                    <s class="small text-muted me-4">{{ number_format($detail->originalTotal) }}</s><br>
                                                                @endif
                                                                <small class="{{ $detail->originalTotal != $detail->total ? 'text-danger' : '' }}">
                                                                    {{ number_format($detail->total) }} VND
                                                                </small>
                                                            </small>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                            <hr class="mt-0">
                                            <div class="row">
                                                <div class="col-4 d-flex align-items-center">
                                                    @if (!$order->details[0]->reviews)
                                                        <button class="btn-success-custom btn-rate-order me-5" data-id="{{ $order->id }}">Đánh giá</button>
                                                    @endif
                                                </div>
                                                <div class="col-8 order-total">
                                                    @if ($order->discount)
                                                        <p class="text-end mb-0">Giảm giá: {{ number_format($order->discount) }} VND</p>
                                                    @endif
                                                    <p class="text-end mb-0">Thành tiền: <strong class="text-danger fs-5">{{ number_format($order->total) }}</strong> VND</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Tab 4: Đơn hàng đã hủy -->
                                <div class="tab-pane fade" id="order-canceled" role="tabpanel" aria-labelledby="order-canceled-tab">
                                    @foreach ($orders->where('status', 0) as $order)
                                        <div class="card p-3 shadow mb-4">
                                            <div class="order-info">
                                                <p class="fw-bold mb-0">Mã đơn: {{ $order->code }}</p>
                                                <small>{{ $order->created_at->format('d/m/Y H:i') }}</small>
                                            </div>
                                            @php
                                                $groupedDetails = collect($order->details)
                                                    ->groupBy(function ($detail) {
                                                        return $detail->unit->id;
                                                    })
                                                    ->map(function ($details) {
                                                        $first = $details->first();
                                                        $quantity = $details->sum('quantity');
                                                        $total = $details->sum(function ($item) {
                                                            return (float) $item->total;
                                                        });
                                                        $originalTotal = $details->sum(function ($item) {
                                                            return (float) $item->originalTotal;
                                                        });

                                                        return (object) [
                                                            'unit' => $first->unit,
                                                            'variable' => $first->unit->variable,
                                                            'product' => $first->unit->variable->product,
                                                            'quantity' => $quantity,
                                                            'total' => $total,
                                                            'originalTotal' => $originalTotal,
                                                        ];
                                                    });
                                            @endphp

                                            @foreach ($groupedDetails as $detail)
                                                @php
                                                    $unit = $detail->unit;
                                                    $variable = $detail->variable;
                                                    $product = $detail->product;
                                                @endphp

                                                <hr class="mt-1">
                                                <div class="row mb-3">
                                                    <div class="col-3 col-md-2 col-lg-1">
                                                        <img class="img-fluid object-fit-contain w-75" src="{{ $product->avatarUrl }}" alt="">
                                                    </div>
                                                    <div class="col-9 col-md-10 col-lg-11">
                                                        <p class="mb-0">{{ $product->name }} - {{ $variable->name }}</p>
                                                        <div class="d-flex justify-content-between">
                                                            <small>Số lượng: {{ $detail->quantity }} {{ $unit->term }}</small>
                                                            <small class="fs-6">
                                                                @if ($detail->originalTotal != $detail->total)
                                                                    <s class="small text-muted me-4">{{ number_format($detail->originalTotal) }}</s><br>
                                                                @endif
                                                                <small class="{{ $detail->originalTotal != $detail->total ? 'text-danger' : '' }}">
                                                                    {{ number_format($detail->total) }} VND
                                                                </small>
                                                            </small>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                            <hr class="mt-0">
                                            <div class="text-end">
                                                @if ($order->discount)
                                                    <p class="text-end mb-0">Giảm giá: {{ number_format($order->discount) }} VND</p>
                                                @endif
                                                <p class="text-end mb-0">Thành tiền: <strong class="text-danger fs-5">{{ number_format($order->total) }}</strong> VND</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $('.header').addClass('pb-2').attr('style', 'background-color: #00e6e6')

        $(document).ready(function() {
            $('.nav-link[data-bs-toggle="tab"]').on('shown.bs.tab', function(e) {
                let target = $(e.target).data('bs-target');
                history.replaceState(null, null, target); // không gây scroll như window.location.hash
            });

            // Sau khi toàn bộ trang và asset load xong → mới kích hoạt lại tab
            let hash = window.location.hash;
            if (hash) {
                let tabLink = $(`.nav-link[data-bs-target="${hash}"]`);
                if (tabLink.length) {
                    let tab = new bootstrap.Tab(tabLink[0]);
                    tab.show();
                }
            }

            $(document).on('click', '.btn-rate-order', function() {
                const form = $('#order-rate-form'),
                    id = $(this).attr('data-id');
                resetForm(form)
                $.get(`{{ route('profile.index') }}/${id}`, function(order) {
                    let str = ``,
                        renderedProductIds = [];
                    $.each(order.details, function(index, detail) {
                        const variable = detail._stock.import_detail._variable,
                            product = variable._product;

                        if (renderedProductIds.includes(product.id)) {
                            return; // continue vòng lặp
                        }

                        // Đánh dấu product.id đã được xử lý
                        renderedProductIds.push(product.id);

                        str += `<div class="card shadow mb-3 p-3">
                                    <div class="d-flex">
                                        <img class="img-fluid object-fit-contain" src="${ product.avatarUrl }" style="width: 4rem">
                                        <span class="ms-3">
                                            <p class="mb-0">${product.name } - ${variable.name}</p>
                                            <small class="text-muted">${product.excerpt ?? ''}</small>
                                        </span>
                                    </div>
                                    <div class="order-rating">
                                        <input type="hidden" name="detail_ids[${index}]" value="${detail.id}">
                                        <strong>Chất lượng sản phẩm:</strong>
                                        <div class="star-rating">
                                            <input id="detail_${index}_star5" name="order_rating[${index}]" type="radio" value="5"><label for="detail_${index}_star5">★</label>
                                            <input id="detail_${index}_star4" name="order_rating[${index}]" type="radio" value="4"><label for="detail_${index}_star4">★</label>
                                            <input id="detail_${index}_star3" name="order_rating[${index}]" type="radio" value="3"><label for="detail_${index}_star3">★</label>
                                            <input id="detail_${index}_star2" name="order_rating[${index}]" type="radio" value="2"><label for="detail_${index}_star2">★</label>
                                            <input id="detail_${index}_star1" name="order_rating[${index}]" type="radio" value="1" checked><label for="detail_${index}_star1">★</label>
                                        </div>
                                        <span class="text-warning ms-2" id="rating-text">Tuyệt vời</span>
                                    </div>
                                    <div class="rating-box mt-3">
                                        <p class="mt-3"><strong>Nhận xét:</strong></p>
                                        <textarea class="form-control form-textarea" name="order_comment[${index}]" placeholder="Hãy chia sẻ những điều bạn thích về sản phẩm này với những người mua khác nhé."></textarea>
                                    </div>
                                </div>`
                    })
                    form.find('input[name=id]').val(order.id)
                    form.find('.modal-body').html(str)
                    form.find('.modal').modal('show')
                })
            })

            $(document).on('click', '.btn-cancel-order', function(e) {
                const id = $(this).attr('data-id'),
                    card = $(this).closest('card'),
                    cardHtml = card.prop('outerHTML');

                Swal.fire({
                    title: 'Lưu ý!',
                    text: "Bạn có chắc chắn muốn hủy đơn hàng này?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: "var(--bs-danger)",
                    cancelButtonColor: "var(--bs-primary)",
                    confirmButtonText: 'Có, hủy đơn!',
                    cancelButtonText: 'Không',
                    reverseButtons: true
                }).then((result) => {
                    console.log("Swal version:", Swal?.version);
                    console.log('isConfirmed:', result.isConfirmed);

                    if (result.isConfirmed) {
                        $.post(`{{ route('profile.order_cancel') }}/${id}`, function(response) {
                            pushToastify(response.msg, response.status)
                            setTimeout(() => {
                                location.reload();
                            }, 500);
                        })
                    }
                });
            })


            $(document).on('submit', '#order-rate-form', function(e) {
                e.preventDefault();
                submitForm($(this)).done(function(response) {
                    if (response.status == "success") {
                        $(`.btn-rate-order[data-id=${response.order_id}]`).remove()
                    }
                })
            })
        })

        function submitLogoutForm() {
            const form = $("#logout-form");
            form.attr("action", "/logout");
            submitForm(form).done(function(response) {
                window.location.reload();
            });
        }

        $(document).on('submit', '#profile-web-form', function(e) {
            e.preventDefault();
            const form = $(this);
            submitForm(form).done(function(response) {
                resetForm(form);
                setTimeout(() => {
                    location.reload();
                }, 500);
            });
        });

        //Preview avatar
        $('#profile-avatar').on('change', function(e) {
            const file = e.target.files[0];

            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#avatar-preview').attr('src', e.target.result);
                };
                reader.readAsDataURL(file);
            } else {
                alert("Vui lòng chọn một tệp hình ảnh hợp lệ.");
            }
        });

        $(document).on('submit', '.change-password-form', function(e) {
            e.preventDefault();
            const form = $(this);
            submitForm(form).done(function(response) {
                resetForm(form);
            });
        })
    </script>
@endpush
