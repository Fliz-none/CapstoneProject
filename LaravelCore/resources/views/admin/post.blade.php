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
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Bảng tin</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.post') }}">Các bài viết</a></li>
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
        @if (!empty(Auth::user()->can(App\Models\User::CREATE_POST)))
            <section class="section">
                <form id="post-form" action="{{ route('admin.post.save') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-12 col-lg-9 mx-auto">
                            <div class="card card-body">
                                <div class="form-group">
                                    <label class="form-label" for="post-title">Tiêu đề bài viết</label>
                                    <input class="form-control @error('title') is-invalid @enderror" id="post-title" name="title" type="text" value="{{ old('title') != null ? old('title') : (isset($post) ? $post->title : '') }}">
                                    @error('title')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="post-excerpt">Mô tả ngắn</label>
                                    <textarea class="form-control @error('excerpt') is-invalid @enderror" id="post-excerpt" name="excerpt" rows="3">{{ old('excerpt') != null ? old('excerpt') : (isset($post) ? $post->excerpt : '') }}</textarea>
                                    @error('excerpt')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="post-content">Nội dung bài viết</label>
                                    @error('content')
                                        <span class="invalid-feedback d-inline-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <textarea class="form-control summernote @error('content') is-invalid @enderror" id="post-content" name="content" rows="100">{{ old('content') != null ? old('content') : (isset($post) ? $post->content : '') }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-3 mx-auto">
                            <!-- Publish card -->
                            <div class="card card-body mb-3">
                                <h6 class="mb-0">Đăng bài viết</h6>
                                <hr class="horizontal dark">
                                <div class="form-group">
                                    <label class="form-label mt-1" for="post-status">Trạng thái</label>
                                    <select class="form-select @error('status') is-invalid @enderror" id="post-status" name="status">
                                        <option value="1" {{ (isset($post) && $post->status == 1) || old('status') === '1' ? 'selected' : '' }}>
                                            Xuất bản</option>
                                        <option value="2" {{ (isset($post) && $post->status == 2) || old('status') === '2' ? 'selected' : '' }}>
                                           Nổi bật</option>
                                        <option value="0" {{ (isset($post) && $post->status == 0) || old('status') === '0' ? 'selected' : '' }}>
                                            Không hiển thị</option>
                                    </select>
                                    @error('status')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="post-date">Thời gian</label>
                                    <div class="input-group">
                                        <input class="form-control @error('date') is-invalid @enderror" id="post-date" name="date" type="date"
                                            value="{{ old('date') != null ? old('date') : (isset($post) ? $post->createdDate() : Carbon\Carbon::now()->format('Y-m-d')) }}" aria-label="Ngày">
                                        <input class="form-control @error('time') is-invalid @enderror" id="post-time" name="time" type="time"
                                            value="{{ old('time') != null ? old('time') : (isset($post) ? $post->createdTime() : Carbon\Carbon::now()->format('H:i:s')) }}" aria-label="Giờ">
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
                                <input id="post-deleted_at" name="deleted_at" type="hidden" value="{{ isset($post) ? $post->deleted_at : '' }}">
                                <input id="post-id" name="id" type="hidden" value="{{ isset($post) ? ($post->revision ? $post->revision : $post->id) : '' }}">
                                <button class="btn btn-info" type="submit">{{ isset($post) ? 'Cập nhật' : 'Đăng bài' }}</button>
                            </div>
                            <!-- END Publish card -->
                            <!-- Catalog card -->
                            <div class="card card-body mb-3">
                                <h6 class="mb-0">Chuyên mục</h6>
                                <hr class="horizontal dark">
                                <div class="category-select">
                                    <ul class="list-group">
                                        @foreach ($categories as $key => $category)
                                            <li class="list-group-item border border-0" id="category-group-{{ $category->id }}">
                                                <input class="form-check-input me-1 @error('category') is-invalid @enderror" id="category-{{ $category->id }}" name="category_id" type="radio" value="{{ $category->id }}"
                                                    {{ (isset($post) && $post->category->pluck('id')->contains($category->id)) || collect(old('categories'))->contains($category->id) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="category-{{ $category->id }}">{{ $category->name }}</label>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                @error('categories')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <a class="btn btn-sm btn-link mt-3 btn-create-category">Thêm chuyên mục</a>
                            </div>
                            <!-- END Catalog card -->
                            <!-- Image card -->
                            <div class="card card-body mb-3">
                                <h6 class="mb-0">Ảnh đại diện</h6>
                                <hr class="horizontal dark my-3">
                                <label class="form-label select-image" for="post-image">
                                    <div class="ratio ratio-1x1">
                                        <img class="img-fluid rounded-4 object-fit-cover" src="{{ isset($post) ? $post->imageUrl : asset('admin/images/placeholder.webp') }}" alt="Ảnh đại diện">
                                    </div>
                                </label>
                                <input class="hidden-image" id="post-image" name="image" type="hidden" value="{{ old('image') != null ? old('image') : (isset($post) ? $post->image : '') }}">
                                <button class="btn btn-outline-primary btn-remove-image d-none" type="button">Xoá</button>
                                @error('image')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <!-- END Image card -->
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
        })
    </script>
@endpush
