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
                            <li class="breadcrumb-item"><a href="{{ route('admin.product') }}">Các sản phẩm</a></li>
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
        <section class="section">
            @if (!empty(Auth::user()->hasAnyPermission(App\Models\User::UPDATE_PRODUCT, App\Models\User::CREATE_PRODUCT)))
                <form id="product-form" action="{{ route('admin.product.save') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-12 col-lg-9 mx-auto">
                            <div class="card card-body">
                                <div class="form-group">
                                    <label class="form-label" for="product-name" data-bs-toggle="tooltip" data-bs-title="Tên gọi của sản phẩm dùng để phân biệt nó với các sản phẩm khác">Tên sản phẩm</label>
                                    <input class="form-control @error('name') is-invalid @enderror" id="product-name" name="name" type="text" value="{{ old('name') != null ? old('name') : (isset($product) ? $product->name : '') }}">
                                    @error('name')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="product-excerpt" data-bs-toggle="tooltip" data-bs-title="Thông tin ngắn gọn của sản phẩm">Mô tả ngắn</label>
                                    <textarea class="form-control @error('excerpt') is-invalid @enderror" id="product-excerpt" name="excerpt" rows="3">{{ old('excerpt') != null ? old('excerpt') : (isset($product) ? $product->excerpt : '') }}</textarea>
                                    @error('excerpt')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="product-description" data-bs-toggle="tooltip" data-bs-title="Mô tả chi tiết các đặc điểm và công dụng của sản phẩm">Nội dung sản phẩm</label>
                                    @error('description')
                                        <span class="invalid-feedback d-inline-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <textarea class="form-control summernote @error('description') is-invalid @enderror" id="product-description" name="description" rows="100">{{ old('description') != null ? old('description') : (isset($product) ? $product->description : '') }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="product-images" data-bs-toggle="tooltip" data-bs-title="Bộ hình ảnh của sản phẩm">Gallery ảnh sản phẩm</label>
                                    <input id="product-images" name="gallery" type="hidden" value="{{ old('gallery') != null ? old('gallery') : (isset($product) ? $product->gallery : '') }}">
                                    <div class="row gallery align-items-center pt-2">
                                    </div>
                                </div>
                            </div>
                            <div class="card card-body">
                                <div class="form-group">
                                    <h6 class="mb-3">Thông số kỹ thuật</h6>
                                    <div class="border border-1 rounded-3 p-3">
                                        <textarea class="form-control air @error('specs') is-invalid @enderror" id="product-specs" name="specs" rows="3" placeholder="Bảng thông số kỹ thuật, thông tin thành phần v.v...">{{ old('specs') != null ? old('specs') : (isset($product) ? $product->specs : '') }}</textarea>
                                    </div>
                                    @error('specs')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            @if (isset($product))
                                <div class="card card-body">
                                    <div class="form-group">
                                        @if (Auth::user()->can(App\Models\User::CREATE_VARIABLE))
                                            <a class="btn k-btn-info mb-3 block btn-create-variable" data-product="{{ isset($product) ? ($product->revision ? $product->revision : $product->id) : '' }}">
                                                <i class="bi bi-plus-circle"></i>
                                                Thêm
                                            </a>
                                        @endif
                                    </div>
                                    <table class="table table-striped table-borderless" id="variables-datatable">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Tên biến thể</th>
                                                <th class="text-center">Trạng thái</th>
                                                <th class="text-center"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        @else
                            @include('admin.includes.access_denied')
            @endif
    </div>
    <div class="col-12 col-lg-3 mx-auto">
        <!-- Publish card -->
        <div class="card card-body mb-3">
            <h6 class="mb-0">Đăng bài</h6>
            <hr class="horizontal dark">
            <div class="form-group">
                <label class="form-label mt-1" for="product-status" data-bs-toggle="tooltip" data-bs-title="Tình trạng hiện tại của sản phẩm trong hệ thống">Trạng thái</label>
                <select class="form-select @error('status') is-invalid @enderror" id="product-status" name="status">
                    <option value="0" {{ (isset($product) && $product->status == 0) || old('status') == 0 ? 'selected' : '' }}>
                        Bị khóa</option>
                    <option value="1" {{ (isset($product) && $product->status == 1) || old('status') == 1 ? 'selected' : '' }}>
                        Bán offline</option>
                    <option value="2" {{ (isset($product) && $product->status == 2) || old('status') == '2' ? 'selected' : '' }}>
                        Bán online</option>
                    <option value="3" {{ (isset($product) && $product->status == 3) || old('status') == '3' ? 'selected' : '' }}>
                        Nổi bật</option>
                </select>
                @error('status')
                    <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label class="form-label" for="product-date">Thời gian</label>
                <div class="input-group">
                    <input class="form-control @error('date') is-invalid @enderror" id="product-date" name="date" type="date"
                        value="{{ old('date') != null ? old('date') : (isset($product) ? $product->createdDate() : Carbon\Carbon::now()->format('Y-m-d')) }}" aria-label="Ngày">
                    <input class="form-control @error('time') is-invalid @enderror" id="product-time" name="time" type="time"
                        value="{{ old('time') != null ? old('time') : (isset($product) ? $product->createdTime() : Carbon\Carbon::now()->format('H:i:s')) }}" aria-label="Giờ">
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
            <input id="product-deleted_at" name="deleted_at" type="hidden" value="{{ isset($product) ? $product->deleted_at : '' }}">
            <input id="product-id" name="id" type="hidden" value="{{ isset($product) ? ($product->revision ? $product->revision : $product->id) : '' }}">
            <button class="btn btn-info" type="submit">{{ isset($product) ? 'Cập nhật' : 'Đăng sản phẩm' }}</button>
        </div>
        <!-- END Publish card -->
        <!-- Catalog card -->
        <div class="card card-body mb-3">
            <div class="input-group search-container">
                <label class="form-label d-flex align-items-center text-info mb-0 me-3" data-bs-toggle="tooltip" data-bs-title="Dùng để phân loại các sản phẩm thành các nhóm" for="product-catalogue-select">Danh mục</label>
                <div class="w-25">
                    <a class="btn btn-outline-primary btn-sm btn-refresh-catalogue rounded-pill">
                        <i class="bi bi-arrow-repeat"></i>
                    </a>
                </div>
                <input class="form-control search-input ms-3" id="product-catalogue-select" type="text" placeholder="Tìm kiếm...">
            </div>
            <hr class="horizontal dark">
            <div class="catalogue-select search-item overflow-auto" style="max-height: 450px">
                <ul class="list-group search-list">
                    @include('admin.includes.catalogue_recursion', [
                        'catalogues' => $catalogues,
                        'product' => isset($product) ? $product : null,
                    ])
                </ul>
            </div>
            @error('catalogues')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            <a class="btn btn-sm btn-link mt-3 btn-create-catalogue">Thêm danh mục</a>
        </div>
        <!-- END Catalog card -->
        <!-- Setting product -->
        <div class="card card-body">
            <h6 class="mb-0">Thiết lập sản phẩm</h6>
            <hr class="horizontal dark">
            <div class="form-group">
                <label class="form-label mt-1" for="product-sku" data-bs-toggle="tooltip" data-bs-title="Mã định danh ngắn gọn để quản lý sản phẩm">Mã sản phẩm (SKU) </label>
                <input class="form-control @error('sku') is-invalid @enderror" id="product-sku" name="sku" type="text" value="{{ old('sku') != null ? old('sku') : (isset($product) ? $product->sku : '') }}" placeholder="Mã sản phẩm"
                    autocomplete="off">
                @error('sku')
                    <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label class="form-label mt-1" for="product-keyword" data-bs-toggle="tooltip" data-bs-title="Từ khóa giúp cải thiện khả năng tìm kiếm sản phẩm">Các từ khoá</label>
                <input class="form-control @error('keyword') is-invalid @enderror" id="product-keyword" name="keyword" type="text" value="{{ old('keyword') != null ? old('keyword') : (isset($product) ? $product->keyword : '') }}"
                    placeholder="Từ khoá hỗ trợ tối ưu tìm kiếm" autocomplete="off">
                @error('keyword')
                    <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <div class="keyword-list"></div>
            </div>
            <div class="form-group">
                <label class="form-label mt-1" for="product-stock_limit" data-bs-toggle="tooltip" data-bs-title="Số lượng tồn kho tối thiểu. Nếu ít hơn số lượng này sẽ nhận được thông báo">Tồn kho tối thiểu</label>
                <input class="form-control @error('stock_limit') is-invalid @enderror" id="product-stock_limit" name="stock_limit" type="text" value="{{ old('stock_limit') != null ? old('stock_limit') : (isset($product) ? $product->stock_limit : '0') }}"
                    placeholder="Nhập số lượng" autocomplete="off">
                @error('stock_limit')
                    <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group mt-3">
                <div class="form-check">
                    <input class="form-check-input form-check-info form-check-glow @error('allow_review') is-invalid @enderror" id="product-allow_review" name="allow_review" type="checkbox"
                        {{ (isset($product) && $product->allow_review) || old('allow_review') ? 'checked' : '' }} autocomplete="off">
                    <label class="form-check-label" for="product-allow_review">Cho phép đánh giá</label>
                </div>
                @error('allow_review')
                    <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
    </div>
    <!-- END Setting product -->
    </div>
    </form>
    </section>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            @if (isset($product))
                showVariables({{ $product->revision ? $product->revision : $product->id }})
            @endif

            viewProductImages()

            $('#product-name').keyup(function() {
                $('.head-name').text($(this).val());
            })

            $(document).on('click', '.add-gallery', function() {
                openQuickImages('product-images', false)
            })

            $('[type=submit]').click(function() {
                $(this).prop('disabled', true).html(
                        '<span class="spinner-border spinner-border-sm" id="spinner-form" role="status"></span>')
                    .parents('form').submit()
            })

            $('#product-images').change(function() {
                viewProductImages()
            })

            $('[name=keyword]').keyup(function() {
                let keywordArr = $.map($(this).val().split(','), function(keyword) {
                    return `<span class="badge bg-light-primary my-2 ms-2">${keyword}</span>`;
                });
                $(this).parents('div').find('.keyword-list').html(keywordArr.join(''));
            })

            function showAttributes(attribute) {
                let text =
                    `
            <input type="checkbox" class="btn-check attribute" name="attributes[]" value="${ attribute.id }" id="attribute-${ attribute.id }" autocomplete="off">
            <label class="btn btn-outline-primary btn-sm mb-2" for="attribute-${ attribute.id }">${ attribute.value }</label>`
                if ($('.attribute-select').find(`button[data-key='${ attribute.key }']`).length) {
                    $(`button[data-key='${ attribute.key }']`).parents('.accordion-body').find('.list-attribute').append(text)
                } else {
                    $('.attribute-select').prepend(`
            <div class="accordion-item">
                <h2 class="accordion-header" id="attribute-heading-${ attribute.id }">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#attributes-${ attribute.id }" aria-expanded="true" aria-controls="attributes-${ attribute.id }">
                        ${attribute.key}
                    </button>
                </h2>
                <div id="attributes-${ attribute.id }" class="accordion-collapse collapse show" aria-labelledby="attributes-heading-${ attribute.id }">
                    <div class="accordion-body">
                        <div class="list-attribute">
                            ${text}
                        </div>
                        <button type="button" class="btn btn-primary btn-sm mb-2 ms-1 pt-0 btn-create-attribute" data-key="${ attribute.key }"><i class="bi bi-plus"></i></button>
                    </div>
                </div>
            </div>
            `)
                }
            }

            function viewProductImages() {
                let text = ''
                $.each($('#product-images').val().split('|'), function(index, image) {
                    if (!image == '') {
                        text += `
                    <div class="col-4 col-md-3 col-lg-2">
                        <div class="card card-image text-bg-dark mb-2">
                            <button type="button" class="btn-close btn-remove-images" data-index="${index}" aria-label="Close"></button>
                            <div class="ratio ratio-1x1">
                                <img src="{{ asset(env('FILE_STORAGE', '/storage')) }}/${image}" class="card-img img-gallery thumb cursor-pointer">
                            </div>
                        </div>
                    </div>`
                    } else {
                        text += `
                    <div class="col-4 col-md-3 col-lg-2">
                        <div class="card text-primary add-gallery object-fit-cover ratio ratio-1x1 mb-2">
                            <i class="bi bi-plus"></i>
                        </div>
                    </div>`
                    }
                })
                $('.row.gallery').html(text)
            }
        })
    </script>
@endpush
