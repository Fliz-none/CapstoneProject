<div class="banner-nav">
    <div class="banner-nav-list">
        <a href="{{ route('post', ['sub' => 'benh-vien-thu-y']) }}" title="dịch vụ thú y"
            class="banner-nav-item {{ ($pageName == __('Bệnh viện thú y')) ? 'active' : '' }}">
            Dịch vụ thú y
        </a>
        <a href="{{ route('post', ['sub' => 'spa-&-grooming']) }}" title="Spa & Grooming"
            class="banner-nav-item {{ ($pageName == __('Spa & Grooming')) ? 'active' : '' }}">
            Spa & Grooming
        </a>
        <a href="{{ route('post', ['sub' => 'khach-san-thu-cung']) }}" title="Khách sạn thú cưng"
            class="banner-nav-item {{ ($pageName == __('Khách sạn thú cưng')) ? 'active' : '' }}">
            Khách sạn thú cưng
        </a>
        <a href="{{ route('shop') }}" title="PetShop"
            class="banner-nav-item {{ ($pageName == __('Tất cả sản phẩm')) ? 'active' : '' }}">
            PetShop
        </a>
    </div>
</div>