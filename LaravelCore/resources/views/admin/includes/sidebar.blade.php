<div class="" id="sidebar">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header">
            <div class="d-flex justify-content-between">
                <div class="logo">
                    <a href="{{ route('home') }}"><img src="{{ Auth::user()->company->logo_horizon }}" srcset="" alt="Logo" style="width: 100%; height: auto;"></a>
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
                    @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::CREATE_ORDER)) && Auth::user()->company->has_shop)
                        <li class="sidebar-item key-bg-primary" data-keyword="POS Bán Hàng">
                            <a class='sidebar-btn' href="{{ route('admin.order', ['key' => 'new']) }}">
                                <i class="bi bi-display"></i>
                                <span class="text-white">POS Bán Hàng</span>
                            </a>
                        </li>
                    @endif
                    @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::CREATE_INFO)) && Auth::user()->company->has_clinic)
                        <li class="sidebar-item key-bg-secondary" data-keyword="Tạo phiếu khám">
                            <a class='sidebar-btn' href="{{ route('admin.info', ['key' => 'new']) }}">
                                <i class="bi bi-calendar2-range"></i>
                                <span class="text-white">Tạo Phiếu Khám</span>
                            </a>
                        </li>
                    @endif
                    @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_BOOKINGS)) && Auth::user()->company->has_booking)
                        <li class="sidebar-item key-bg-success" data-keyword="Đặt dịch vụ">
                            <a class='sidebar-btn' href="{{ route('admin.booking') }}">
                                <i class="bi bi-clipboard-heart"></i>
                                <span class="text-white">Đặt Dịch Vụ</span>
                            </a>
                        </li>
                    @endif
                    <li class="sidebar-title">Quản lý chung</li>
                    <li class="sidebar-item" data-keyword="Bảng tin">
                        <a class='sidebar-link' href="{{ route('admin.home') }}">
                            <i class="bi bi-grid-fill"></i>
                            <span>Bảng tin</span>
                        </a>
                    </li>
                    @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_ORDERS)) && Auth::user()->company->has_shop)
                        <li class="sidebar-item" data-keyword="Đơn hàng bán hàng">
                            <a class='sidebar-link' href="{{ route('admin.order') }}">
                                <i class="bi bi-receipt-cutoff"></i>
                                <span>Đơn hàng</span>
                            </a>
                        </li>
                    @endif
                    @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_TRANSACTIONS)) && Auth::user()->company->has_shop)
                        <li class="sidebar-item" data-keyword="Thanh toán">
                            <a class='sidebar-link' href="{{ route('admin.transaction') }}">
                                <i class="bi bi-coin"></i>
                                <span>Thanh toán</span>
                            </a>
                        </li>
                    @endif
                    @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_EXPENSES)) && Auth::user()->company->has_shop)
                        <li class="sidebar-item" data-keyword="Phiếu chi">
                            <a class='sidebar-link' href="{{ route('admin.expense') }}">
                                <i class="bi bi-wallet"></i>
                                <span>Phiếu chi</span>
                            </a>
                        </li>
                    @endif
                    @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_DEBTS)) && Auth::user()->company->has_shop)
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
                    @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_PETS)) && Auth::user()->company->has_clinic)
                        <li class="sidebar-item" data-keyword="Thú cưng">
                            <a class='sidebar-link' href="{{ route('admin.pet') }}">
                                <i class="bi bi-github"></i>
                                <span>Thú cưng</span>
                            </a>
                        </li>
                    @endif
                    @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_SERVICES)) && Auth::user()->company->has_clinic)
                        <li class="sidebar-item has-sub" data-keyword="Dịch vụ">
                            <a class='sidebar-link' href="#">
                                <i class="bi bi-circle-square"></i>
                                <span>Dịch vụ</span>
                            </a>
                            <ul class="submenu">
                                @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_SERVICES)))
                                    <li class="submenu-item" data-keyword="Các dịch vụ">
                                        <a href="{{ route('admin.service') }}">Các dịch vụ</a>
                                    </li>
                                @endif
                                @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_MAJORS)))
                                    <li class="submenu-item" data-keyword="Danh mục">
                                        <a href="{{ route('admin.major') }}">Danh mục</a>
                                    </li>
                                @endif
                                @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_CRITERIALS)))
                                    <li class="submenu-item" data-keyword="Tiêu chí">
                                        <a href="{{ route('admin.criterial') }}">Tiêu chí</a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif
                    @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_PRODUCTS)) && Auth::user()->company->has_shop)
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
                    @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_STOCKS, app\Models\User::READ_IMPORTS, app\Models\User::READ_EXPORTS)) && Auth::user()->company->has_warehouse)
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
                    @if (Auth::user()->company->has_clinic)
                        <li class="sidebar-title">Khám chữa</li>
                    @endif
                    @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_INFOS)) && Auth::user()->company->has_clinic)
                        <li class="sidebar-item" data-keyword="phiếu khám cơ bản">
                            <a class='sidebar-link' href="{{ route('admin.info') }}">
                                <i class="bi bi-journal-plus"></i>
                                <span>Phiếu khám</span>
                            </a>
                        </li>
                    @endif
                    @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_QUICKTESTS)) && Auth::user()->company->has_clinic)
                        <li class="sidebar-item" data-keyword="kit test nhanh">
                            <a class='sidebar-link' href="{{ route('admin.quicktest') }}">
                                <i class="bi bi-ticket-detailed-fill"></i>
                                <span>Kit test nhanh</span>
                            </a>
                        </li>
                    @endif
                    @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_BLOODCELLS)) && Auth::user()->company->has_clinic)
                        <li class="sidebar-item" data-keyword="xét nghiệm tế bào XNTB máu">
                            <a class='sidebar-link' href="{{ route('admin.bloodcell') }}">
                                <i class="bi bi-droplet-fill"></i>
                                <span>XNTB máu</span>
                            </a>
                        </li>
                    @endif
                    @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_BIOCHEMICALS)) && Auth::user()->company->has_clinic)
                        <li class="sidebar-item" data-keyword="xét nghiệm sinh hóa XNSH máu">
                            <a class='sidebar-link' href="{{ route('admin.biochemical') }}">
                                <i class="bi bi-moisture"></i>
                                <span>XNSH máu</span>
                            </a>
                        </li>
                    @endif
                    @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_MICROSCOPES)) && Auth::user()->company->has_clinic)
                        <li class="sidebar-item" data-keyword="soi khv kính hiển vi">
                            <a class='sidebar-link' href="{{ route('admin.microscope') }}">
                                <i class="bi bi-virus2"></i>
                                <span>Soi KHV</span>
                            </a>
                        </li>
                    @endif
                    @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_ULTRASOUNDS)) && Auth::user()->company->has_clinic)
                        <li class="sidebar-item" data-keyword="siêu âm">
                            <a class='sidebar-link' href="{{ route('admin.ultrasound') }}">
                                <i class="bi bi-radar"></i>
                                <span>Siêu âm</span>
                            </a>
                        </li>
                    @endif
                    @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_XRAYS)) && Auth::user()->company->has_clinic)
                        <li class="sidebar-item" data-keyword="x quang">
                            <a class='sidebar-link' href="{{ route('admin.xray') }}">
                                <i class="bi bi-hr"></i>
                                <span>X Quang</span>
                            </a>
                        </li>
                    @endif
                    @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_SURGERIES)) && Auth::user()->company->has_clinic)
                        <li class="sidebar-item" data-keyword="phiếu phẫu thuật mổ">
                            <a class='sidebar-link' href="{{ route('admin.surgery') }}">
                                <i class="bi bi-scissors"></i>
                                <span>Phẫu thuật</span>
                            </a>
                        </li>
                    @endif
                    @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_PRESCRIPTIONS)) && Auth::user()->company->has_clinic)
                        <li class="sidebar-item" data-keyword="đơn thuốc toa thuốc">
                            <a class='sidebar-link' href="{{ route('admin.prescription') }}">
                                <i class="bi bi-capsule-pill"></i>
                                <span>Đơn thuốc</span>
                            </a>
                        </li>
                    @endif
                    @if (Auth::user()->company->has_beauty)
                        <li class="sidebar-title">Chăm sóc</li>
                    @endif
                    @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_BEAUTIES)) && Auth::user()->company->has_beauty)
                        <li class="sidebar-item" data-keyword="spa grooming làm đẹp">
                            <a class='sidebar-link' href="{{ route('admin.beauty') }}">
                                <i class="bi bi-stars"></i>
                                <span>Làm đẹp</span>
                            </a>
                        </li>
                    @endif
                    @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_WORKS)) && Auth::user()->company->has_attendance)
                        <li class="sidebar-item" data-keyword="Lịch làm việc, chấm công, giờ công, giờ làm">
                            <a class='sidebar-link' href="{{ route('admin.work') }}">
                                <i class="bi bi-calendar3"></i>
                                <span>Bảng công</span>
                            </a>
                        </li>
                    @endif
                    @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_ACCOMMODATIONS)) && Auth::user()->company->has_clinic)
                        <li class="sidebar-item" data-keyword="Lưu trú">
                            <a class='sidebar-link' href="{{ route('admin.accommodation') }}">
                                <i class="bi bi-mailbox"></i>
                                <span>Lưu trú</span>
                            </a>
                        </li>
                    @endif
                    @if (Auth::user()->company->has_website)
                        <li class="sidebar-title">Website</li>
                    @endif
                    @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_POSTS)) && Auth::user()->company->has_website)
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
                            @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_SYMPTOMS)) && Auth::user()->company->has_clinic)
                                <li class="submenu-item" data-keyword="Triệu chứng">
                                    <a href="{{ route('admin.symptom') }}">Triệu chứng</a>
                                </li>
                            @endif
                            @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_DISEASES)) && Auth::user()->company->has_clinic)
                                <li class="submenu-item" data-keyword="Bệnh">
                                    <a href="{{ route('admin.disease') }}">Bệnh</a>
                                </li>
                            @endif
                            @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_MEDICINES)) && Auth::user()->company->has_clinic)
                                <li class="submenu-item" data-keyword="Thuốc">
                                    <a href="{{ route('admin.medicine') }}">Thuốc</a>
                                </li>
                            @endif
                            @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_ANIMALS)) && Auth::user()->company->has_clinic)
                                <li class="submenu-item" data-keyword="Động vật">
                                    <a href="{{ route('admin.animal') }}">Động vật</a>
                                </li>
                            @endif
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
                            @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_BRANCHES)) && Auth::user()->company->has_shop)
                                <li class="submenu-item" data-keyword="Chi nhánh">
                                    <a href="{{ route('admin.branch') }}">Chi nhánh</a>
                                </li>
                            @endif
                            @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_WAREHOUSES)) && Auth::user()->company->has_warehouse)
                                <li class="submenu-item" data-keyword="Kho hàng">
                                    <a href="{{ route('admin.warehouse') }}">Kho hàng</a>
                                </li>
                            @endif
                            @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_SUPPLIERS)) && Auth::user()->company->has_shop)
                                <li class="submenu-item" data-keyword="Nhà cung cấp">
                                    <a href="{{ route('admin.supplier') }}">Nhà cung cấp</a>
                                </li>
                            @endif
                            @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_ROLES)))
                                <li class="submenu-item" data-keyword="Phân quyền">
                                    <a href="{{ route('admin.role') }}">Phân quyền</a>
                                </li>
                            @endif
                            @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_COMPANIES)))
                                <li class="submenu-item" data-keyword="Công ty">
                                    <a href="{{ route('admin.company') }}">Công ty</a>
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
