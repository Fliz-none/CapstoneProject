<header class="header">
    <div class="header-left">
        <div class="d-flex align-items-center">
            <div class="circle-btn home-btn me-4">
                <a href="{{ route('home') }}" title="PHÒNG KHÁM THÚ Y TRUONGDUNG">
                    <img class="img-fluid" src="{{ asset('images/img/home.png') }}" alt="">
                </a>
            </div>
            <div class="header-search">
                <form action="{{ route('search') }}">
                    <input name="q" type="text" value="" placeholder="Nhập từ khóa tìm kiếm....">
                    <button class="border-0 bg-transparent p-0" type="submit">
                        <img src="{{ asset('images/img/search.png') }}" alt="">
                    </button>
                </form>
            </div>
        </div>
    </div>
    <div class="header-content">
        <div class="container">
            <div class="header-content--inner">
                <div class="hamburger mb-show cursor-pointer">
                    <img class="img-fluid" src="{{ asset('images/img/menu.png') }}" alt="">
                </div>
                <div class="header-main">
                    <a class="header-logo" href="{{ route('home') }}" title="">
                        <img class="img-fluid" src="{{ asset('images/logo-main.svg') }}" alt="">
                    </a>
                    <ul class="header-list">
                        <li class="header-list-item">
                            <a class="header-item-link {{ $pageName == __('Cửa hàng') ? 'active' : '' }}" href="{{ route('shop') }}" title="Cửa hàng">
                                Cửa hàng
                            </a>
                        </li>
                        <li class="header-list-item">
                            <a class="header-item-link {{ $pageName == __('Bài viết') ? 'active' : '' }}" href="{{ route('post', ['sub' => 'posts']) }}" title="Bài viết">
                                Bài viết
                            </a>
                        </li>
                        <li class="header-list-item">
                            <a class="header-item-link {{ $pageName == __('Tất cả sản phẩm') ? 'active' : '' }}" href="{{ route('product') }}" title="Sản phẩm">
                                Sản phẩm
                            </a>
                        </li>
                    </ul>
                    <ul class="header-list">
                        <li class="header-list-item has-sub">
                            <a class="header-item-link {{ $pageName == __('Về TRUONGDUNG PET') ? 'active' : '' }}" href="{{ route('post', ['sub' => 've-truongdung-pet']) }}" title="Về TruongDungPet">
                                Về TruongDungPet
                            </a>
                        </li>
                        <li class="header-list-item has-sub">
                            <a class="header-item-link {{ $pageName == __('Chăm sóc boss') ? 'active' : '' }}" href="{{ route('post', ['sub' => 'posts', 'category' => 'cham-soc-boss']) }}" title="Chăm sóc boss">
                                Chăm sóc boss
                            </a>
                        </li>
                        <li class="header-list-item has-sub">
                            <a class="header-item-link {{ $pageName == __('Liên hệ') ? 'active' : '' }}" href="{{ route('contact') }}" title="Liên hệ">
                                Liên hệ
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="header-search mb-header-search mb-show">
                    <div class="header-login circle-btn home-btn mini-cart-icon">
                        <a data-bs-toggle="offcanvas" data-bs-target="#offcanvasCart" aria-controls="offcanvasCart">
                            <img class="img-fluid" src="{{ asset('images/cart3.svg') }}" alt="">
                            <span class="mini-cart-count">{{ Auth::check() && Auth::user()->cart ? Auth::user()->cart->count : '0'  }}</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="header-right">
        <div class="header-login circle-btn home-btn me-4">
            @guest
                @if (Route::has('login'))
                    <a class="cursor-pointer" data-bs-toggle="modal" data-bs-target="#customerLogin">
                        <img class="img-fluid" src="{{ asset('images/person.svg') }}" alt="">
                    </a>
                @endif
            @else
                <a class="cursor-pointer" href="{{ route('profile') }}">
                    <img class="img-fluid" src="{{ asset('images/person.svg') }}" alt="">
                </a>
            @endguest
        </div>
        <div class="header-login circle-btn home-btn mini-cart-icon">
            <a class="cursor-pointer" data-bs-toggle="offcanvas" data-bs-target="#offcanvasCart" aria-controls="offcanvasCart">
                <img class="img-fluid" src="{{ asset('images/cart3.svg') }}" alt="">
                <span class="mini-cart-count">{{ Auth::check() && Auth::user()->cart ? Auth::user()->cart->count : '0' }}</span>
            </a>
        </div>
    </div>
    <div class="mb-backdrop mb-show"></div>
    <div class="mb-header-content-wrapper mb-show">
        <div class="menu-close">
            <img class="img-fluid" src="{{ asset('images/img/close.png') }}" alt="">
        </div>
        <div class="mb-header-content--inner">
            <div class="mb-logo">
                <a href="index.html" title="">
                    <img class="img-fluid" src="{{ asset('images/logo-main.svg') }}" alt="">
                </a>
            </div>
            <div class="mb-widget-wrapper">
                <div class="d-flex justify-content-between overflow-auto">
                    <div class="header-search mb-show">
                        <form action="{{ route('search') }}">
                            <input name="q" type="text" value="" placeholder="Nhập từ khóa tìm kiếm....">
                            <button class="border-0 bg-transparent p-0" type="submit">
                                <img src="{{ asset('images/img/search.png') }}" alt="">
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="mb-header-content">
                <ul class="mb-header-list">
                    <li class="mb-header-list-item">
                        <div class="list-item-head">
                            <a class="header-item-link {{ $pageName == __('Trang chủ') ? 'active' : '' }}" href="{{ route('home') }}" title="Shop">
                                Trang chủ
                            </a>
                        </div>
                    </li>
                    <li class="mb-header-list-item">
                        <div class="list-item-head">
                            <a class="header-item-link {{ $pageName == __('Cửa hàng') ? 'active' : '' }}" href="{{ route('shop') }}" title="Cửa hàng">
                                Cửa hàng
                            </a>
                        </div>
                    </li>
                    <li class="mb-header-list-item">
                        <div class="list-item-head">
                            <a class="header-item-link {{ $pageName == __('Bài viết') ? 'active' : '' }}" href="{{ route('post', ['sub' => 'posts']) }}" title="Bài viết">
                                Bài viết
                            </a>
                        </div>
                    </li>
                    <li class="mb-header-list-item ">
                        <div class="list-item-head">
                            <a class="header-item-link {{ $pageName == __('Tất cả sản phẩm') ? 'active' : '' }}" href="{{ route('product') }}" title="Sản phẩm">
                                Sản phẩm
                            </a>
                        </div>
                    </li>
                    <li class="mb-header-list-item">
                        <div class="list-item-head">
                            <a class="header-item-link {{ $pageName == __('Về TRUONGDUNG PET') ? 'active' : '' }}" href="{{ route('post', ['sub' => 've-truongdung-pet']) }}" title="Về TruongDungPet">
                                Về TruongDungPet
                            </a>
                        </div>
                    </li>
                    <li class="mb-header-list-item">
                        <div class="list-item-head">
                            <a class="header-item-link {{ $pageName == __('Chăm sóc boss') ? 'active' : '' }}" href="{{ route('post', ['sub' => 'posts', 'category' => 'cham-soc-boss']) }}" title="Chăm sóc boss">
                                Chăm sóc boss
                            </a>
                        </div>
                    </li>
                    <li class="mb-header-list-item">
                        <div class="list-item-head">
                            <a class="header-item-link {{ $pageName == __('Liên hệ') ? 'active' : '' }}" href="{{ route('contact') }}" title="Liên hệ">
                                Liên hệ
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
            
            <div class="header-login circle-btn home-btn">
                @guest
                    @if (Route::has('login'))
                        <a class="d-flex w-100 cursor-pointer" data-bs-toggle="modal" data-bs-target="#customerLogin">
                            <img class="img-fluid" src="{{ asset('images/person.svg') }}" alt="">
                        </a>
                    @endif
                @else
                    <a class="d-flex w-100" href="{{ route('profile') }}">
                        <img class="img-fluid" src="{{ asset('images/person.svg') }}" alt="">
                        <span class="ps-2">{{ Auth::user()->name }}</span>
                    </a>
                @endguest
            </div>
        </div>
    </div>
</header>
