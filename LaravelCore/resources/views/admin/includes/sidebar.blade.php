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
                <input class="form-control form-control-lg form-control-plaintext border-bottom search-input ms-3" id="navbar-select" type="text" placeholder="{{ __('messages.sidebar.findsomething') }}" aria-label="Search">
            </div>
            <div class="search-item">
                <ul class="menu search-list">
                    @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::CREATE_ORDER)))
                        <li class="sidebar-item key-bg-primary" data-keyword="POS Sales">
                            <a class='sidebar-btn' href="{{ route('admin.order', ['key' => 'new']) }}">
                                <i class="bi bi-display"></i>
                                <span class="text-white">{{ __('messages.sidebar.possales') }}</span>
                            </a>
                        </li>
                    @endif
                    {{-- @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_CHATS))) --}}
                        <li class="sidebar-item key-bg-secondary" data-keyword="Customer support">
                            <a class='sidebar-btn' href="{{ route('admin.chat') }}">
                                <i class="bi bi-calendar2-range"></i>
                                <span class="text-white">Customer support</span>
                            </a>
                        </li>
                    {{-- @endif --}}
                    <li class="sidebar-title">{{ __('messages.sidebar.general') }}</li>
                    <li class="sidebar-item" data-keyword="Dashboard">
                        <a class='sidebar-link' href="{{ route('admin.home') }}">
                            <i class="bi bi-grid-fill"></i>
                            <span>{{ __('messages.sidebar.dashboard') }}</span>
                        </a>
                    </li>
                    @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_ORDERS)))
                        <li class="sidebar-item" data-keyword="Orders order">
                            <a class='sidebar-link' href="{{ route('admin.order') }}">
                                <i class="bi bi-receipt-cutoff"></i>
                                <span>{{ __('messages.sidebar.order') }}</span>
                            </a>
                        </li>
                    @endif
                    @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_TRANSACTIONS)))
                        <li class="sidebar-item" data-keyword="Payments transaction">
                            <a class='sidebar-link' href="{{ route('admin.transaction') }}">
                                <i class="bi bi-coin"></i>
                                <span>{{ __('messages.sidebar.payment') }}</span>
                            </a>
                        </li>
                    @endif
                    @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_EXPENSES)))
                        <li class="sidebar-item" data-keyword="Expense">
                            <a class='sidebar-link' href="{{ route('admin.expense') }}">
                                <i class="bi bi-wallet"></i>
                                <span>{{ __('messages.sidebar.expense') }}</span>
                            </a>
                        </li>
                    @endif
                    @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_USERS)))
                        <li class="sidebar-item" data-keyword="User account">
                            <a class='sidebar-link' href="{{ route('admin.user') }}">
                                <i class="bi bi-people-fill"></i>
                                <span>{{ __('messages.sidebar.account') }}</span>
                            </a>
                        </li>
                    @endif
                    @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_PRODUCTS)))
                        <li class="sidebar-item has-sub" data-keyword="Products">
                            <a class='sidebar-link' href="#">
                                <i class="bi bi-stack"></i>
                                <span>{{ __('messages.sidebar.product') }}</span>
                            </a>
                            <ul class="submenu">
                                @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_PRODUCTS)))
                                    <li class="submenu-item" data-keyword="Products">
                                        <a href="{{ route('admin.product') }}">{{ __('messages.sidebar.product') }}</a>
                                    </li>
                                @endif
                                @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_CATALOGUES)))
                                    <li class="submenu-item" data-keyword="Categories">
                                        <a href="{{ route('admin.catalogue') }}">Categories</a>
                                    </li>
                                @endif
                                @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_ATTRIBUTES)))
                                    <li class="submenu-item" data-keyword="Attributes">
                                        <a href="{{ route('admin.attribute') }}">{{ __('messages.sidebar.attribute') }}</a>
                                    </li>
                                @endif
                                @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_DISCOUNTS)))
                                    <li class="submenu-item" data-keyword="Discounts">
                                        <a href="{{ route('admin.discount') }}">Discounts</a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif
                    @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_STOCKS, app\Models\User::READ_IMPORTS, app\Models\User::READ_EXPORTS)))
                        <li class="sidebar-item has-sub" data-keyword="Stocks">
                            <a class='sidebar-link' href="#">
                                <i class="bi bi-grid-1x2"></i>
                                <span>Stock management</span>
                            </a>
                            <ul class="submenu">
                                @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_STOCKS)))
                                    <li class="submenu-item" data-keyword="Stock">
                                        <a href="{{ route('admin.stock') }}">{{ __('messages.sidebar.stock') }}</a>
                                    </li>
                                @endif
                                @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_IMPORTS)))
                                    <li class="submenu-item" data-keyword="Import">
                                        <a href="{{ route('admin.import') }}">{{ __('messages.sidebar.import') }}</a>
                                    </li>
                                @endif
                                @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_EXPORTS)))
                                    <li class="submenu-item" data-keyword="Export">
                                        <a href="{{ route('admin.export') }}">{{ __('messages.sidebar.export') }}</a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif
                    @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_WORKS)))
                        <li class="sidebar-item" data-keyword="Work Schedule, Attendance Tracking, Working Hours, Work Hours">
                            <a class='sidebar-link' href="{{ route('admin.work') }}">
                                <i class="bi bi-calendar3"></i>
                                <span>{{ __('messages.sidebar.timesheet') }}</span>
                            </a>
                        </li>
                    @endif
                    <li class="sidebar-title">{{ __('messages.sidebar.website') }}</li>
                    @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_POSTS)))
                        <li class="sidebar-item has-sub" data-keyword="Posts">
                            <a class='sidebar-link' href="#">
                                <i class="bi bi-pencil-square"></i>
                                <span>{{ __('messages.sidebar.post') }}</span>
                            </a>
                            <ul class="submenu">
                                @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_POSTS)))
                                    <li class="submenu-item" data-keyword="All Posts">
                                        <a href="{{ route('admin.post') }}">{{ __('messages.sidebar.post') }}</a>
                                    </li>
                                @endif
                                @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_CATEGORIES)))
                                    <li class="submenu-item" data-keyword="Categories">
                                        <a href="{{ route('admin.category') }}">{{ __('messages.sidebar.category') }}</a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif
                    @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_IMAGES)))
                        <li class="sidebar-item" data-keyword="Image library">
                            <a class='sidebar-link' href="{{ route('admin.image') }}">
                                <i class="bi bi-images"></i>
                                <span>{{ __('messages.sidebar.image') }}</span>
                            </a>
                        </li>
                    @endif
                    <li class="sidebar-title">Settings</li>
                    <li class="sidebar-item has-sub" data-keyword="System configuration">
                        <a class='sidebar-link' href="#">
                            <i class="bi bi-sliders"></i>
                            <span>{{ __('messages.sidebar.system') }}</span>
                        </a>
                        <ul class="submenu">
                             @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_LOCALS)))
                                <li class="submenu-item" data-keyword="Local">
                                    <a href="{{ route('admin.local') }}">{{ __('messages.sidebar.local') }}</a>
                                </li>
                            @endif
                            @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_BRANCHES)))
                                <li class="submenu-item" data-keyword="Branch">
                                    <a href="{{ route('admin.branch') }}">{{ __('messages.sidebar.branch') }}</a>
                                </li>
                            @endif
                            @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_WAREHOUSES)))
                                <li class="submenu-item" data-keyword="Warehouse">
                                    <a href="{{ route('admin.warehouse') }}">{{ __('messages.sidebar.warehouse') }}</a>
                                </li>
                            @endif
                            @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_SUPPLIERS)))
                                <li class="submenu-item" data-keyword="Supplier">
                                    <a href="{{ route('admin.supplier') }}">{{ __('messages.sidebar.supplier') }}</a>
                                </li>
                            @endif
                            @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_ROLES)))
                                <li class="submenu-item" data-keyword="Role">
                                    <a href="{{ route('admin.role') }}">{{ __('messages.sidebar.role') }}</a>
                                </li>
                            @endif
                            @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_SETTINGS)))
                                <li class="submenu-item" data-keyword="System settings">
                                    <a href="{{ route('admin.setting', ['key' => 'general']) }}">{{ __('messages.sidebar.systemsetting') }}</a>
                                </li>
                            @endif
                            @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_LOGS)))
                                <li class="submenu-item" data-keyword="System logs">
                                    <a href="{{ route('admin.log') }}">{{ __('messages.sidebar.systemlog') }}</a>
                                </li>
                            @endif
                            @if (!empty(Auth::user()->hasAnyPermission(app\Models\User::READ_VERSIONS)))
                                <li class="submenu-item" data-keyword="Version updates">
                                    <a href="{{ route('admin.version') }}">{{ __('messages.sidebar.version') }}</a>
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
