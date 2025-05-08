<div class="" id="sidebar">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header">
            <div class="d-flex justify-content-between">
                <div class="logo">
                    <a href="{{ route('home') }}"><img src="{{ cache()->get('logo_horizon') ?? '' }}" srcset="" alt="Logo" style="width: 100%; height: auto;"></a>
                </div>
                <div class="toggler">
                    <a class="sidebar-hide d-xl-none d-block" href="#"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            <div class="search-container">
                <input class="form-control form-control-lg form-control-plaintext border-bottom search-input ms-3" id="navbar-select" type="text" placeholder="Tìm kiếm chức năng">
            </div>
            <div class="search-item">
                <ul class="menu search-list">
                    @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::CREATE_ORDER)))
                        <li class="sidebar-item key-bg-primary" data-keyword="POS Bán Hàng">
                            <a class='sidebar-btn' href="{{ route('admin.order', ['key' => 'new']) }}">
                                <i class="bi bi-display"></i>
                                <span class="text-white">POS Bán Hàng</span>
                            </a>
                        </li>
                    @endif
                    {{--
                    @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_BOOKINGS)))
                        <li class="sidebar-item key-bg-success" data-keyword="Đặt dịch vụ">
                            <a class='sidebar-btn' href="{{ route('admin.booking') }}">
                                <i class="bi bi-clipboard-heart"></i>
                                <span class="text-white">Đặt Dịch Vụ</span>
                            </a>
                        </li>
                    @endif --}}
                    <li class="sidebar-title">Quản lý chung</li>
                    <li class="sidebar-item" data-keyword="Bảng tin">
                        <a class='sidebar-link' href="{{ route('admin.home') }}">
                            <i class="bi bi-grid-fill"></i>
                            <span>Bảng tin</span>
                        </a>
                    </li>
                    @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_ORDERS)))
                        <li class="sidebar-item" data-keyword="Đơn hàng bán hàng">
                            <a class='sidebar-link' href="{{ route('admin.order') }}">
                                <i class="bi bi-receipt-cutoff"></i>
                                <span>Đơn hàng</span>
                            </a>
                        </li>
                    @endif
                    @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_TRANSACTIONS)))
                        <li class="sidebar-item" data-keyword="Thanh toán">
                            <a class='sidebar-link' href="{{ route('admin.transaction') }}">
                                <i class="bi bi-coin"></i>
                                <span>Thanh toán</span>
                            </a>
                        </li>
                    @endif
                    @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_EXPENSES)))
                        <li class="sidebar-item" data-keyword="Phiếu chi">
                            <a class='sidebar-link' href="{{ route('admin.expense') }}">
                                <i class="bi bi-wallet"></i>
                                <span>Phiếu chi</span>
                            </a>
                        </li>
                    @endif
                    @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_DEBTS)))
                        <li class="sidebar-item" data-keyword="Đối soát">
                            <a class='sidebar-link' href="{{ route('admin.debt') }}">
                                <i class="bi bi-cash"></i>
                                <span>Đối soát</span>
                            </a>
                        </li>
                    @endif
                    @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_USERS)))
                        <li class="sidebar-item" data-keyword="Tài khoản">
                            <a class='sidebar-link' href="{{ route('admin.user') }}">
                                <i class="bi bi-people-fill"></i>
                                <span>Tài khoản</span>
                            </a>
                        </li>
                    @endif
                    @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_PRODUCTS)))
                        <li class="sidebar-item has-sub" data-keyword="Sản phẩm">
                            <a class='sidebar-link' href="#">
                                <i class="bi bi-stack"></i>
                                <span>Sản phẩm</span>
                            </a>
                            <ul class="submenu">
                                @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_PRODUCTS)))
                                    <li class="submenu-item" data-keyword="Các sản phẩm">
                                        <a href="{{ route('admin.product') }}">Các sản phẩm</a>
                                    </li>
                                @endif
                                @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_CATALOGUES)))
                                    <li class="submenu-item" data-keyword="Danh mục">
                                        <a href="{{ route('admin.catalogue') }}">Danh mục</a>
                                    </li>
                                @endif
                                @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_ATTRIBUTES)))
                                    <li class="submenu-item" data-keyword="Thuộc tính">
                                        <a href="{{ route('admin.attribute') }}">Thuộc tính</a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif
                    @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_STOCKS, app\Models\User::READ_IMPORTS, app\Models\User::READ_EXPORTS)))
                        <li class="sidebar-item has-sub" data-keyword="Quản lý kho">
                            <a class='sidebar-link' href="#">
                                <i class="bi bi-grid-1x2"></i>
                                <span>Quản lý kho</span>
                            </a>
                            <ul class="submenu">
                                @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_STOCKS)))
                                    <li class="submenu-item" data-keyword="Tồn kho">
                                        <a href="{{ route('admin.stock') }}">Tồn kho</a>
                                    </li>
                                @endif
                                @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_IMPORTS)))
                                    <li class="submenu-item" data-keyword="Nhập kho">
                                        <a href="{{ route('admin.import') }}">Nhập kho</a>
                                    </li>
                                @endif
                                @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_EXPORTS)))
                                    <li class="submenu-item" data-keyword="Xuất kho">
                                        <a href="{{ route('admin.export') }}">Xuất kho</a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif
                    @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_WORKS)))
                        <li class="sidebar-item" data-keyword="Lịch làm việc, chấm công, giờ công, giờ làm">
                            <a class='sidebar-link' href="{{ route('admin.work') }}">
                                <i class="bi bi-calendar3"></i>
                                <span>Bảng công</span>
                            </a>
                        </li>
                    @endif
                    <li class="sidebar-title">Website</li>
                    @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_POSTS)))
                        <li class="sidebar-item has-sub" data-keyword="Bài viết">
                            <a class='sidebar-link' href="#">
                                <i class="bi bi-pencil-square"></i>
                                <span>Bài viết</span>
                            </a>
                            <ul class="submenu">
                                @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_POSTS)))
                                    <li class="submenu-item" data-keyword="Tất cả bài viết">
                                        <a href="{{ route('admin.post') }}">Tất cả bài viết</a>
                                    </li>
                                @endif
                                @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_CATEGORIES)))
                                    <li class="submenu-item" data-keyword="Chuyên mục">
                                        <a href="{{ route('admin.category') }}">Chuyên mục</a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif
                    @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_IMAGES)))
                        <li class="sidebar-item" data-keyword="Thư viện ảnh">
                            <a class='sidebar-link' href="{{ route('admin.image') }}">
                                <i class="bi bi-images"></i>
                                <span>Thư viện ảnh</span>
                            </a>
                        </li>
                    @endif
                    <li class="sidebar-title">Thiết lập</li>
                    <li class="sidebar-item has-sub" data-keyword="Thuật ngữ chuyên môn">
                        <a class='sidebar-link' href="#">
                            <i class="bi bi-chat-square-quote-fill"></i>
                            <span>Các thuật ngữ</span>
                        </a>
                        <ul class="submenu">
                            @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_LOCALS)))
                                <li class="submenu-item" data-keyword="Địa phương">
                                    <a href="{{ route('admin.local') }}">Địa phương</a>
                                </li>
                            @endif
                        </ul>
                    </li>
                    <li class="sidebar-item has-sub" data-keyword="Thiết lập hệ thống">
                        <a class='sidebar-link' href="#">
                            <i class="bi bi-sliders"></i>
                            <span>Thiết lập hệ thống</span>
                        </a>
                        <ul class="submenu">
                            @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_BRANCHES)))
                                <li class="submenu-item" data-keyword="Chi nhánh">
                                    <a href="{{ route('admin.branch') }}">Chi nhánh</a>
                                </li>
                            @endif
                            @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_WAREHOUSES)))
                                <li class="submenu-item" data-keyword="Kho hàng">
                                    <a href="{{ route('admin.warehouse') }}">Kho hàng</a>
                                </li>
                            @endif
                            @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_SUPPLIERS)))
                                <li class="submenu-item" data-keyword="Nhà cung cấp">
                                    <a href="{{ route('admin.supplier') }}">Nhà cung cấp</a>
                                </li>
                            @endif
                            @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_ROLES)))
                                <li class="submenu-item" data-keyword="Phân quyền">
                                    <a href="{{ route('admin.role') }}">Phân quyền</a>
                                </li>
                            @endif
                            @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_SETTINGS)))
                                <li class="submenu-item" data-keyword="Cài đặt hệ thống">
                                    <a href="{{ route('admin.setting', ['key' => 'general']) }}">Cài đặt hệ thống</a>
                                </li>
                            @endif
                            @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_LOGS)))
                                <li class="submenu-item" data-keyword="Nhật ký hệ thống">
                                    <a href="{{ route('admin.log') }}">Nhật ký hệ thống</a>
                                </li>
                            @endif
                            @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_VERSIONS)))
                                <li class="submenu-item" data-keyword="Cập nhật phiên bản">
                                    <a href="{{ route('admin.version') }}">Cập nhật phiên bản</a>
                                </li>
                            @endif
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
    </div>
</div>
