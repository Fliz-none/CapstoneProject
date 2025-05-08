<form class="save-form" id="product-form" method="post">
    @csrf
    <div class="modal fade" id="product-modal" data-bs-backdrop="static" aria-labelledby="product-modal-label">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h1 class="modal-title fs-5 text-white" id="product-modal-label">Sản phẩm</h1>
                    <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-md-7 pe-2">
                            <div class="row">
                                <div class="col-12 col-lg-4">
                                    <div class="form-group mb-0">
                                        <label class="form-label ratio ratio-1x1 select-avatar" for="product-avatar">
                                            <img class="img-fluid rounded-4 object-fit-cover" id="product-avatar-preview" src="{{ asset('admin/images/placeholder.webp') }}" alt="Ảnh đại diện">
                                        </label>
                                        <input class="form-control" id="product-avatar" name="avatar" type="file" hidden accept="image/*">
                                        <div class="d-grid">
                                            <button class="btn btn-outline-primary btn-remove-image d-none" type="button">Xoá</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-8 pb-3">
                                    <div class="card shadow-none border mb-3 h-100">
                                        <div class="card-body pb-0">
                                            <div class="row align-items-center mb-3">
                                                <div class="col-12 form-group mb-0">
                                                    <label class="form-label mb-0" data-bs-toggle="tooltip" data-bs-title="Tên này sẽ được sử dụng để tìm kiếm nhanh sản phẩm" for="product-name">Tên sản phẩm</label>
                                                </div>
                                                <div class="col-12">
                                                    <input class="form-control" id="product-name" name="name" type="text" placeholder="Tên sản phẩm" autocomplete="off" required>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12 form-group">
                                                    <label class="form-label mb-0" data-bs-toggle="tooltip" data-bs-title="Từ khóa để gợi ý sản phẩm" for="product-sku" for="product-sku">Mã sản phẩm (Từ gợi ý)</label>
                                                    <input class="form-control" id="product-sku" name="sku" type="text" placeholder="Mã sản phẩm" autocomplete="off" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card card-variables shadow-none border mb-3 d-none">
                                <div class="card-body overflow-auto">
                                    <div class="row justify-content-between">
                                        <div class="col-auto">
                                            <h5 class="text-primary">Danh sách biến thể</h5>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group text-end">
                                                @if (Auth::user()->can(App\Models\User::CREATE_VARIABLE))
                                                    <a class="btn btn-outline-info btn-create-variable">
                                                        <i class="bi bi-plus-circle"></i>
                                                        Thêm
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <table class="table table-striped table-borderless" id="variables-datatable">
                                        <thead>
                                            <tr>
                                                <th class="text-start">Tên biến thể</th>
                                                <th class="text-center">Trạng thái</th>
                                                <th class="text-center"></th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-5 ps-2">
                            <div class="card shadow-none border mb-3 overflow-auto" style="height: 450px">
                                <div class="card-body">
                                    <div class="row align-items-center mb-3">
                                        <div class="col-12 form-group mb-0">
                                            <label class="form-label mb-0" data-bs-toggle="tooltip" data-bs-title="Trạng thái hiển thị của sản phẩm" for="product-status">Trạng thái</label>
                                        </div>
                                        <div class="col-12">
                                            <select class="form-select" id="product-status" name="status">
                                                <option value="0">Bị khóa</option>
                                                <option value="1">Chỉ bán offline</option>
                                                <option value="2">Hiển thị online</option>
                                                <option value="3">Nổi bật</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group search-container">
                                            <label class="form-label d-flex align-items-center text-info mb-0 me-3" data-bs-toggle="tooltip" data-bs-title="Dùng để phân loại các sản phẩm thành các nhóm" for="product-catalogue-select">Danh mục</label>
                                            <div class="w-25">
                                                <a class="btn btn-outline-primary btn-sm btn-refresh-catalogue rounded-pill">
                                                    <i class="bi bi-arrow-repeat"></i>
                                                </a>
                                            </div>
                                            <input class="form-control search-input ms-3" id="product-catalogue-select" type="text" placeholder="Tìm kiếm...">
                                        </div>
                                        <div class="catalogue-select search-item">
                                            <ul class="list-group search-list">
                                                @include('admin.includes.catalogue_recursion', [
                                                    'catalogues' => cache()->get('catalogues')->whereNull('parent_id'),
                                                    'product' => isset($product) ? $product : null,
                                                ])
                                            </ul>
                                        </div>
                                        <div class="d-grid gap-2 mt-3">
                                            <button class="btn btn-create-catalogue cursor-pointer px-1">
                                                Thêm danh mục
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 text-end">
                            @if (Auth::user()->hasAnyPermission(App\Models\User::CREATE_PRODUCT))
                                <input name="id" type="hidden">
                                <button class="btn btn-primary px-3 fw-bold" type="submit">Lưu</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
