@extends('admin.layouts.app')
@section('title')
    {{ $pageName }}
@endsection
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6">
                    <h5 class="text-uppercase">{{ $pageName }}</h5>
                    <nav class="breadcrumb-header float-start" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Bảng tin</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.service') }}">Các dịch vụ</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $pageName }}</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-12 col-md-6">
                </div>
            </div>
        </div>
        @if (session('response') && session('response')['status'] == 'success')
            <div class="alert key-bg-primary alert-dismissible fade show text-white" role="alert">
                <i class="fas fa-check"></i>
                {!! session('response')['msg'] !!}
                <button class="btn-close" data-bs-dismiss="alert" type="button" aria-label="Close">
                </button>
            </div>
        @elseif (session('response'))
            <div class="alert alert-danger alert-dismissible fade show text-white" role="alert">
                <i class="fa-solid fa-xmark"></i>
                {!! session('response')['msg'] !!}
                <button class="btn-close" data-bs-dismiss="alert" type="button" aria-label="Close">
                </button>
            </div>
        @elseif ($errors->any())
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger alert-dismissible fade show text-white" role="alert">
                    <i class="fa-solid fa-xmark"></i>
                    {{ $error }}
                    <button class="btn-close" data-bs-dismiss="alert" type="button" aria-label="Close">
                    </button>
                </div>
            @endforeach
        @endif
        @if (!empty(Auth::user()->can(App\Models\User::CREATE_SERVICE)))
            <section class="section">
                <form id="service-form" action="{{ route('admin.service.save') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-12 col-lg-9 mx-auto">
                            <div class="card card-body">
                                <div class="row mb-3">
                                    <div class="col-8 form-group">
                                        <label class="form-label" data-bs-toggle="tooltip" data-bs-title="Tên mô tả loại dịch vụ" for="service-name">Tên dịch vụ</label>
                                        <input class="form-control @error('name') is-invalid @enderror" id="service-name" name="name" type="text" value="{{ old('name') != null ? old('name') : (isset($service) ? $service->name : '') }}">
                                        @error('name')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-4 form-group">
                                        <label class="form-label" data-bs-toggle="tooltip" data-bs-title="Đơn vị tính của dịch vụ trên hóa đơn thanh toán" for="service-unit">Đơn vị tính</label>
                                        <input class="form-control @error('unit') is-invalid @enderror" id="service-unit" name="unit" type="text" value="{{ old('unit') != null ? old('unit') : (isset($service) ? $service->unit : '') }}"
                                            inputmode="numeric">
                                        @error('unit')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label data-bs-toggle="tooltip" data-bs-title="Thông tin ngắn gọn của dịch vụ" for="service-excerpt">Mô tả ngắn</label>
                                    <textarea class="form-control @error('excerpt') is-invalid @enderror" id="service-excerpt" name="excerpt" rows="3">{{ old('excerpt') != null ? old('excerpt') : (isset($service) ? $service->excerpt : '') }}</textarea>
                                    @error('excerpt')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label data-bs-toggle="tooltip" data-bs-title="Mô tả chi tiết về dịch vụ" for="service-description">Mô tả dịch vụ</label>
                                    @error('description')
                                        <span class="invalid-feedback d-inline-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <textarea class="form-control summernote @error('description') is-invalid @enderror" id="service-description" name="description" rows="100">{{ old('description') != null ? old('description') : (isset($service) ? $service->description : '') }}</textarea>
                                </div>
                            </div>
                            <div class="card card-body">
                                <h6 class="mb-0">Thiết lập dịch vụ</h6>
                                <hr class="horizontal dark">
                                <div class="row">
                                    <div class="col-12 col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label" data-bs-toggle="tooltip" data-bs-title="Số tiền mà khách phải chi trả cho dịch này" for="service-price">Giá dịch vụ</label>
                                            <input class="form-control money @error('price') is-invalid @enderror" id="service-price" name="price" type="text"
                                                value="{{ old('price') != null ? old('price') : (isset($service) ? $service->price : '') }}" inputmode="numeric">
                                            @error('price')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label" data-bs-toggle="tooltip" data-bs-title="Cơ số lương cho nhân viên thực hiện dịch vụ (số tiền hoặc phần trăm giá dịch vụ)" for="service-commission">Cơ số lương</label>
                                            <input class="form-control money @error('commission') is-invalid @enderror" id="service-commission" name="commission" type="text"
                                                value="{{ old('commission') != null ? old('commission') : (isset($service) ? $service->commission : '') }}" inputmode="numeric">
                                            @error('commission')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label mt-1" data-bs-toggle="tooltip" data-bs-title="Thứ tự mà dịch vụ sẽ hiển thị" for="service-sort">Thứ tự dịch vụ</label>
                                            <input class="form-control @error('sort') is-invalid @enderror" id="service-sort" name="sort" type="text" value="{{ old('sort') != null ? old('sort') : (isset($service) ? $service->sort : '') }}"
                                                placeholder="Thứ tự hiển thị của sản phẩm" autocomplete="off">
                                            @error('sort')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label mt-1" data-bs-toggle="tooltip" data-bs-title="Từ khóa giúp cải thiện khả năng tìm kiếm dịch vụ" for="service-keyword">Các từ khoá</label>
                                            <input class="form-control @error('keyword') is-invalid @enderror" id="service-keyword" name="keyword" type="text"
                                                value="{{ old('keyword') != null ? old('keyword') : (isset($service) ? $service->keyword : '') }}" placeholder="Từ khoá hỗ trợ tối ưu tìm kiếm" autocomplete="off">
                                            @error('keyword')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                            <div class="keyword-list"></div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label" data-bs-toggle="tooltip" data-bs-title="Thứ tự mà dịch vụ sẽ hiển thị" for="service-ticket">Mẫu phiếu</label>
                                            @php
                                                $tickets = [
                                                    'beauty' => 'Spa-Grooming',
                                                    'quicktest' => 'Kit test nhanh',
                                                    'ultrasound' => 'Siêu âm',
                                                    'bloodcell' => 'XNTB Máu',
                                                    'biochemical' => 'XNSH Máu',
                                                    'microscope' => 'Soi KHV',
                                                    'xray' => 'X-Quang',
                                                    'surgery' => 'Phẫu thuật',
                                                    'accommodation' => 'Điều trị nội trú',
                                                ];
                                            @endphp
                                            <select class="form-select" id="service-ticket" name="ticket">
                                                <option value="">Không có mẫu phiếu</option>
                                                @foreach ($tickets as $value => $ticket)
                                                    <option value="{{ $value }}" {{ old('ticket') != null || (isset($service) && $service->ticket == $value) ? 'selected' : '' }}>{{ $ticket }}</option>
                                                @endforeach
                                            </select>
                                            @error('ticket')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <div class="form-group">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" id="service-is_indicated" name="is_indicated" type="checkbox">
                                                <label class="form-check-label" for="service-is_indicated" data-bs-toggle="tooltip" data-bs-title="Dịch vụ phải được chỉ định của bác sĩ mới được cung cấp cho khách hàng">Phải có chỉ định</label>
                                            </div>
                                            @error('is_indicated')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- ======== CONSUMABLES =========== --}}
                            <div class="card card-body">
                                <h6 class="mb-0">Hàng hóa tiêu hao</h6>
                                <hr class="horizontal dark">
                                <div class="row">
                                    <div class="col-12 mb-2">
                                        <div class="dropdown ajax-search">
                                            <div class="form-group mb-0 has-icon-left">
                                                <div class="position-relative search-form">
                                                    <input class="form-control form-control-lg search-input" id="service_variable-search-input" data-url="{{ route('admin.unit') }}?key=search" type="text" autocomplete="off"
                                                        placeholder="Tìm kiếm hàng hóa">
                                                    <div class="form-control-icon">
                                                        <i class="bi bi-search"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <ul class="dropdown-menu shadow-lg overflow-auto w-100 search-result" id="service_variable-search-result" aria-labelledby="dropdownMenuButton" style="max-height: 45rem;max-width: 40rem">
                                                <!-- Search results will be appended here -->
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-borderless">
                                        <thead>
                                            <tr>
                                                <th class="text-info" data-bs-toggle="tooltip" data-bs-title="Tên sản phẩm tiêu hao" style="width: 60%">Sản phẩm</th>
                                                <th class="text-center text-info" data-bs-toggle="tooltip" data-bs-title="Đơn vị tính của sản phẩm" style="width: 15%">Đơn vị tính</th>
                                                <th class="text-center text-info" data-bs-toggle="tooltip" data-bs-title="Số lượng tiêu hao" style="width: 10%">Số lượng</th>
                                                <th class="text-center text-info" data-bs-toggle="tooltip" data-bs-title="Số lượng tiêu hao" style="width: 15%">Giá trị</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody id="service-consumables">
                                            @if (isset($service) && !empty($service->consumables))
                                                @foreach (json_decode($service->consumables) as $index => $consumable)
                                                    @php
                                                        $variable = $service->variables->where('id', $consumable->variable_id)->first();
                                                        $unit = optional($variable)
                                                            ->units->where('id', $consumable->unit_id)
                                                            ->first();
                                                    @endphp
                                                    <tr class="border consumables">
                                                        <td>
                                                            <p class="text-dark fs-5 mb-0">{!! optional($variable)->fullName !!}</p>
                                                            <small>{!! optional($variable)->_product->sku !!}</small>
                                                            <input class="form-control bg-white" name="consumable_variable_ids[]" type="hidden" value="{{ $consumable->variable_id }}">
                                                            <input class="form-control bg-white" name="consumable_unit_ids[]" type="hidden" value="{{ $consumable->unit_id }}">
                                                        </td>
                                                        <td>
                                                            <select class="form-control form-control-plaintext text-center" name="consumable_unit_rates[]">
                                                                @foreach ($variable->units as $item)
                                                                    <option data-id="{{ $item->id }}" data-price="{{ $item->price }}" value="{{ $item->rate }}" {{ $unit->rate == $item->rate ? 'selected' : '' }}>{{ $item->term }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <div class="input-group quantity-group">
                                                                <button class="btn btn-outline-primary rounded-circle mt-1 btn-dec" type="button"><i class="bi bi-dash"></i></button>
                                                                <input class="form-control-plaintext fs-5 money text-center" name="consumable_quantities[]" type="text" value="{{ $consumable->quantity }}" onclick="this.select()"
                                                                    placeholder="Số lượng" inputmode="numeric" required="">
                                                                <button class="btn btn-outline-primary rounded-circle mt-1 btn-inc" type="button"><i class="bi bi-plus"></i></button>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <input class="form-control form-control-plaintext text-end bg-transparent" name="consumable_unit_prices[]" value="{{ number_format($unit->price * $consumable->quantity) }}đ" readonly>
                                                        </td>
                                                        <td>
                                                            <form method="post" action="">
                                                                @csrf
                                                                <input name="choices[]" type="hidden">
                                                                <button class="btn btn-link px-0 btn-remove-consumable" type="submit">
                                                                    <i class="bi bi-trash"></i>
                                                                </button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="3">Tổng giá trị vật tư tiêu hao cho dịch vụ này</td>
                                                <td class="total-consumables text-end">0</td>
                                                <td></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                        {{-- ======== END CONSUMABLES =========== --}}
                        <div class="col-12 col-lg-3 mx-auto">
                            <!-- Publish card -->
                            <div class="card card-body mb-3">
                                <h6 class="mb-0">Đăng dịch vụ</h6>
                                <hr class="horizontal dark">
                                <div class="form-group">
                                    <label class="form-label mt-1" data-bs-toggle="tooltip" data-bs-title="Tình trạng hiện tại của dịch vụ trong hệ thống" for="service-status">Trạng thái</label>
                                    <select class="form-select @error('status') is-invalid @enderror" id="service-status" name="status">
                                        <option value="2" {{ (isset($service) && $service->status == 2) || old('status') === '2' ? 'selected' : '' }}>
                                            Hiện online</option>
                                        <option value="1" {{ (isset($service) && $service->status == 1) || old('status') === '1' ? 'selected' : '' }}>
                                            Hiện offline</option>
                                        <option value="0" {{ (isset($service) && $service->status == 0) || old('status') === '0' ? 'selected' : '' }}>
                                            Đã khóa</option>
                                    </select>
                                    @error('status')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="service-date">Thời gian</label>
                                    <div class="input-group">
                                        <input class="form-control @error('date') is-invalid @enderror" id="service-date" name="date" type="date"
                                            value="{{ old('date') != null ? old('date') : (isset($service) ? $service->createdDate() : Carbon\Carbon::now()->format('Y-m-d')) }}" aria-label="Ngày">
                                        <input class="form-control @error('time') is-invalid @enderror" id="service-time" name="time" type="time"
                                            value="{{ old('time') != null ? old('time') : (isset($service) ? $service->createdTime() : Carbon\Carbon::now()->format('H:i:s')) }}" aria-label="Giờ">
                                    </div>
                                </div>
                                @error('date')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                @error('time')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <input id="service-deleted_at" name="deleted_at" type="hidden" value="{{ isset($service) ? $service->deleted_at : '' }}">
                                <input id="service-id" name="id" type="hidden" value="{{ isset($service) ? ($service->revision ? $service->revision : $service->id) : '' }}">
                                <button class="btn btn-info" type="submit">{{ isset($service) ? 'Cập nhật' : 'Tạo dịch vụ' }}</button>
                            </div>
                            <!-- END Publish card -->
                            <!-- Major card -->
                            <div class="card card-body mb-3">
                                <h6 class="mb-0">Danh mục</h6>
                                <hr class="horizontal dark">
                                <div class="form-group major-select">
                                    <label class="form-label mt-1" data-bs-toggle="tooltip" data-bs-title="Dùng để gom nhóm dịch vụ hoặc loại mà dịch vụ này thuộc về" for="service-major_id">Danh mục</label>
                                    <select class="form-control select2 @error('major_id') is-invalid @enderror" id="service-major_id" name="major_id" data-ajax--url="{{ route('admin.major', ['key' => 'select2']) }}"
                                        data-placeholder="Hãy chọn một chuyên môn">
                                        @if (isset($service) && isset($service->major))
                                            <option value="{{ $service->major->id }}">{{ $service->major->name }}</option>
                                        @endif
                                    </select>
                                </div>
                                @error('majors')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <a class="btn btn-sm btn-link mt-3 btn-create-major">Thêm danh mục</a>
                            </div>
                            <!-- END Major card -->
                            <!-- Image card -->
                            <div class="card card-body mb-3">
                                <h6 class="mb-0">Ảnh đại diện</h6>
                                <hr class="horizontal dark my-3">
                                <label class="form-label select-image" for="service-avatar">
                                    <div class="ratio ratio-1x1">
                                        <img class="img-fluid rounded-4 object-fit-cover" src="{{ isset($service) ? $service->avatarUrl : asset('admin/images/placeholder.webp') }}" alt="Ảnh đại diện">
                                    </div>
                                </label>
                                <input class="hidden-image" id="service-avatar" name="avatar" type="hidden" value="{{ old('avatar') != null ? old('avatar') : (isset($service) ? $service->avatar : '') }}">
                                <button class="btn btn-outline-primary btn-remove-image d-none" type="button">Xoá</button>
                                @error('image')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <!-- END Image card -->

                            <!-- Criterial card -->
                            <div class="card card-body mb-3">
                                <h6 class="mb-0">Chỉ tiêu</h6>
                                <hr class="horizontal dark">
                                <div class="form-group criterial-select">
                                    <label class="form-label mt-1" data-bs-toggle="tooltip" data-bs-title="Các thông số hoặc cơ quan sẽ thực hiện xét nghiệm" for="service-criterial">Chỉ tiêu</label>
                                    <select class="form-control select2" id="service-criterial" name="criterial[]" data-ajax--url="{{ route('admin.criterial', ['key' => 'select2']) }}" data-placeholder="Hãy chọn các tiêu chí" multiple
                                        size="1">
                                        @if (isset($service))
                                            @foreach ($service->criterials as $criterial)
                                                <option value="{{ $criterial->id }}" selected>{{ $criterial->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <a class="btn btn-sm btn-link mt-3 btn-create-criterial">Thêm chỉ tiêu</a>
                            </div>
                            <!-- END Criterial card -->

                            {{-- @if (isset($service)) --}}
                            <!-- Revision card -->
                            {{-- <div class="card card-body">
                                    <h6 class="mb-0">Lịch sử chỉnh sửa</h6>
                                    <hr class="horizontal dark my-3">
                                    <div class="revision-timeline">
                                        <div class="timeline-card">
                                            <a class="btn {{ !$service->revision ? 'btn-outline-danger' : 'btn-outline-secondary' }} btn-sm" type="button"
                                                href="{{ route('admin.service', ['id' => $service->revision ? $service->revision : $service->id]) }}">{{ $service->updated_at->format('H:i:s d/m/Y') }}</a>
                                        </div>
                                        @foreach ($service->revisions as $old)
                                            <div class="timeline-card">
                                                <a class="btn {{ $old->id == $service->id ? 'btn-outline-danger' : 'btn-outline-secondary' }} btn-sm" type="button"
                                                    href="{{ route('admin.service', ['id' => $old->id]) }}">{{ $old->created_at->format('H:i:s d/m/Y') }}</a>
                                            </div>
                                        @endforeach
                                    </div>
                                </div> --}}
                            <!-- END Revision card -->
                            {{-- @endif --}}
                        </div>
                    </div>
                </form>
            </section>
        @else
            @include('admin.includes.access_denied')
        @endif
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.select2').select2(config.select2);
            $('input.select2-search__field').removeAttr('style')
            $('body').on('shown.bs.modal', '#criterial-modal, #major-modal', function() {
                $('#service-criterial').select2('destroy')
                $('#service-major_id').select2('destroy')
            })
            $('body').on('hidden.bs.modal', '#criterial-modal, #major-modal', function() {
                $('#service-criterial').attr('data-ajax--url', `{{ route('admin.criterial') }}`).select2(config.select2);
                $('#service-major_id').attr('data-ajax--url', `{{ route('admin.major') }}`).select2(config.select2);
            })

            $('[name=keyword]').keyup(function() {
                let keywordArr = $.map($(this).val().split(','), function(keyword) {
                    return `<span class="badge bg-light-primary my-2 ms-2">${keyword}</span>`;
                });
                $(this).parents('div').find('.keyword-list').html(keywordArr.join(''));
            })

            $(document).on('click', '.btn-select-variable', function() {
                htmlAddConsumable(JSON.parse($(this).find('input').val()));
                $(this).closest('.search-result').removeClass('show');
            })

            $(document).on('click', '.btn-remove-consumable', function(e) {
                e.preventDefault();
                $(this).closest('.consumables').remove()
                totalConsumables()
            })

            function htmlAddConsumable(unit) {
                let options = ``
                $.each(unit._variable.units, function(i, item) {
                    options += `<option value="${item.rate}" data-id="${item.id}" data-price="${item.price}" ${item.rate == unit.rate ? 'selected' : ''}>${item.term}</option>`
                })
                const str = `
                <tr class="border consumables">
                    <td>
                        <p class="text-dark fs-5 mb-0">${unit._variable._product.name}${unit._variable.name != null ? ' - ' + unit._variable.name : ''}</p><small>${unit._variable._product.sku != null ? unit._variable._product.sku : ''}</small>
                        <input type="hidden" class="form-control bg-white" name="consumable_variable_ids[]" value="${unit.variable_id}" required readonly />
                        <input type="hidden" class="form-control bg-white" name="consumable_unit_ids[]" value="${unit.id}" required readonly />
                    </td>
                    <td>
                        <select class="form-control form-control-plaintext text-center" name="consumable_unit_rates[]">${options}</select>
                    </td>
                    <td>
                        <div class="input-group quantity-group">
                                <button type="button" class="btn btn-outline-primary rounded-circle mt-1 btn-dec"><i class="bi bi-dash"></i></button>
                                <input type="text" name="consumable_quantities[]" class="form-control-plaintext fs-5 money text-center" onclick="this.select()" placeholder="Số" value="1" inputmode="numeric" required/>
                                <button type="button" class="btn btn-outline-primary rounded-circle mt-1 btn-inc"><i class="bi bi-plus"></i></button>
                        </div>
                    </td>
                    <td>
                        <input class="form-control form-control-plaintext text-end bg-transparent" name="consumable_unit_prices[]" value="${number_format(unit.price)}đ" readonly>
                    </td>
                    <td>
                        <button type="button" class="btn btn-link px-0 btn-remove-consumable">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>`
                $('#service-consumables').append(str)
                totalConsumables()
            }

            totalConsumables()
            $('tbody#service-consumables').change(function() {
                totalConsumables();
            })
            $(`[name='consumable_unit_rates[]']`).change(function() {
                const price = $(this).find('option:selected').attr('data-price')
                $(this).closest('tr').find(`[name='consumable_unit_prices[]']`).val(number_format(price) + 'đ')
            })

            function totalConsumables() {
                let total = $('tbody#service-consumables tr').toArray().reduce((sum, row) => {
                    let quantity = parseFloat($(row).find("input[name='consumable_quantities[]']").val()) || 0;
                    let price = parseFloat($(row).find("select[name='consumable_unit_rates[]'] option:selected").attr('data-price')) || 0;
                    return sum + (quantity * price);
                }, 0);
                $('.total-consumables').text(number_format(total) + 'đ');
            }
        })
    </script>
@endpush
