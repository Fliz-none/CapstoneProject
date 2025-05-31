<div class="" id="sidebar">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header">
            <div class="d-flex justify-content-between">
                <div class="logo">
                    <a href="{{ route('home') }}"><img src="{{ cache()->get('logo_horizon') ?? '' }}" srcset="" alt="Logo" style="width: 100%; height: auto;</a>
                </div>
                <div class="toggler">
                    <a class="sidebar-hide d-xl-none d-block" href="#"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            <div class="search-container">
                <input class="form-control form-control-lg form-control-plaintext border-bottom search-input ms-3" id="navbar-select" type="text" placeholder="Find something..." aria-label="Search">
            </div>
            <div class="search-item">
                <ul class="menu search-list">
                    @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::CREATE_ORDER)))
                        <li class="sidebar-item key-bg-primary" data-keyword="POS Sales">
                            <a class='sidebar-btn' href="{{ route('admin.order', ['key' => 'new']) }}">
                                <i class="bi bi-display"></i>
                                <span class="text-white">POS Sales</span>
                            </a>
                        </li>
                    @endif
                    <li class="sidebar-title">General Management</li>
                    <li class="sidebar-item" data-keyword="Dashboard">
                        <a class='sidebar-link' href="{{ route('admin.home') }}">
                            <i class="bi bi-grid-fill"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_ORDERS)))
                        <li class="sidebar-item" data-keyword="Orders order">
                            <a class='sidebar-link' href="{{ route('admin.order') }}">
                                <i class="bi bi-receipt-cutoff"></i>
                                <span>Orders</span>
                            </a>
                        </li>
                    @endif
                    @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_TRANSACTIONS)))
                        <li class="sidebar-item" data-keyword="Payments transaction">
                            <a class='sidebar-link' href="{{ route('admin.transaction') }}">
                                <i class="bi bi-coin"></i>
                                <span>Payments</span>
                            </a>
                        </li>
                    @endif
                    @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_EXPENSES)))
                        <li class="sidebar-item" data-keyword="Expense">
                            <a class='sidebar-link' href="{{ route('admin.expense') }}">
                                <i class="bi bi-wallet"></i>
                                <span>Expense</span>
                            </a>
                        </li>
                    @endif
                    @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_USERS)))
                        <li class="sidebar-item" data-keyword="User account">
                            <a class='sidebar-link' href="{{ route('admin.user') }}">
                                <i class="bi bi-people-fill"></i>
                                <span>Account</span>
                            </a>
                        </li>
                    @endif
                    @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_PRODUCTS)))
                        <li class="sidebar-item has-sub" data-keyword="Products">
                            <a class='sidebar-link' href="#">
                                <i class="bi bi-stack"></i>
                                <span>Products</span>
                            </a>
                            <ul class="submenu">
                                @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_PRODUCTS)))
                                    <li class="submenu-item" data-keyword="Products">
                                        <a href="{{ route('admin.product') }}">Products</a>
                                    </li>
                                @endif
                                @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_CATALOGUES)))
                                    <li class="submenu-item" data-keyword="Catalogue">
                                        <a href="{{ route('admin.catalogue') }}">Catalogue</a>
                                    </li>
                                @endif
                                @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_ATTRIBUTES)))
                                    <li class="submenu-item" data-keyword="Attributes">
                                        <a href="{{ route('admin.attribute') }}">Attributes</a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif
                    @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_STOCKS, app\Models\User::READ_IMPORTS, app\Models\User::READ_EXPORTS)))
                        <li class="sidebar-item has-sub" data-keyword="Stock management">
                            <a class='sidebar-link' href="#">
                                <i class="bi bi-grid-1x2"></i>
                                <span>Stock management</span>
                            </a>
                            <ul class="submenu">
                                @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_STOCKS)))
                                    <li class="submenu-item" data-keyword="Stock">
                                        <a href="{{ route('admin.stock') }}">Stock</a>
                                    </li>
                                @endif
                                @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_IMPORTS)))
                                    <li class="submenu-item" data-keyword="Import">
                                        <a href="{{ route('admin.import') }}">Import</a>
                                    </li>
                                @endif
                                @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_EXPORTS)))
                                    <li class="submenu-item" data-keyword="Export">
                                        <a href="{{ route('admin.export') }}">Export</a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif
                    @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_WORKS)))
                        <li class="sidebar-item" data-keyword="Work Schedule, Attendance Tracking, Working Hours, Work Hours">
                            <a class='sidebar-link' href="{{ route('admin.work') }}">
                                <i class="bi bi-calendar3"></i>
                                <span>Timesheet</span>
                            </a>
                        </li>
                    @endif
                    <li class="sidebar-title">Website</li>
                    @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_POSTS)))
                        <li class="sidebar-item has-sub" data-keyword="Posts">
                            <a class='sidebar-link' href="#">
                                <i class="bi bi-pencil-square"></i>
                                <span>Posts</span>
                            </a>
                            <ul class="submenu">
                                @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_POSTS)))
                                    <li class="submenu-item" data-keyword="All Posts">
                                        <a href="{{ route('admin.post') }}">All Posts</a>
                                    </li>
                                @endif
                                @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_CATEGORIES)))
                                    <li class="submenu-item" data-keyword="Categories">
                                        <a href="{{ route('admin.category') }}">Categories</a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif
                    @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_IMAGES)))
                        <li class="sidebar-item" data-keyword="Image library">
                            <a class='sidebar-link' href="{{ route('admin.image') }}">
                                <i class="bi bi-images"></i>
                                <span>Image library</span>
                            </a>
                        </li>
                    @endif
                    <li class="sidebar-title">Settings</li>
                    <li class="sidebar-item has-sub" data-keyword="Technical Terms">
                        <a class='sidebar-link' href="#">
                            <i class="bi bi-chat-square-quote-fill"></i>
                            <span>Technical Terms</span>
                        </a>
                        <ul class="submenu">
                            @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_LOCALS)))
                                <li class="submenu-item" data-keyword="Local">
                                    <a href="{{ route('admin.local') }}">Local</a>
                                </li>
                            @endif
                        </ul>
                    </li>
                    <li class="sidebar-item has-sub" data-keyword="System configuration">
                        <a class='sidebar-link' href="#">
                            <i class="bi bi-sliders"></i>
                            <span>System configuration</span>
                        </a>
                        <ul class="submenu">
                            @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_BRANCHES)))
                                <li class="submenu-item" data-keyword="Branch">
                                    <a href="{{ route('admin.branch') }}">Branch</a>
                                </li>
                            @endif
                            @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_WAREHOUSES)))
                                <li class="submenu-item" data-keyword="Warehouse">
                                    <a href="{{ route('admin.warehouse') }}">Warehouse</a>
                                </li>
                            @endif
                            @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_SUPPLIERS)))
                                <li class="submenu-item" data-keyword="Supplier">
                                    <a href="{{ route('admin.supplier') }}">Supplier</a>
                                </li>
                            @endif
                            @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_ROLES)))
                                <li class="submenu-item" data-keyword="Role">
                                    <a href="{{ route('admin.role') }}">Role</a>
                                </li>
                            @endif
                            @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_SETTINGS)))
                                <li class="submenu-item" data-keyword="System settings">
                                    <a href="{{ route('admin.setting', ['key' => 'general']) }}">System settings</a>
                                </li>
                            @endif
                            @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_LOGS)))
                                <li class="submenu-item" data-keyword="System logs">
                                    <a href="{{ route('admin.log') }}">System logs</a>
                                </li>
                            @endif
                            @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_VERSIONS)))
                                <li class="submenu-item" data-keyword="Version updates">
                                    <a href="{{ route('admin.version') }}">Version updates</a>
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
