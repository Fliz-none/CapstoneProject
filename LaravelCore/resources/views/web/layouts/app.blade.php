<!DOCTYPE html>
<html lang="vi">
@php
    $pageName = $pageName ?? '';
@endphp

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta property="fb:app_id" content="">
    <link type="image/x-icon" href="{{ asset('images/logo-main.svg') }}" rel="shortcut icon">
    <title>{{ config('app.name') }} - @yield('title')</title>

    <meta property="og:url" content="https://truongdungpet.com">
    <link href="{{ asset('css/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/bootstrap/css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('wow/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/jquery.fancybox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/key.css') }}" rel="stylesheet">
    {{-- Toastify --}}
    <link href="{{ asset('admin/vendors/toastify/toastify.css') }}" rel="stylesheet">
    {{-- Include sweetalert2 --}}
    <link href="{{ asset('admin/vendors/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/vendors/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">

</head>

<body class="home">

    <div id="app">
        @include('web.includes.header')
        @yield('content')
        <!-- modal  -->
        @include('web.includes.partials.modal_login')
        @include('web.includes.partials.modal_register')
        @include('web.includes.partials.modal_cart')
        <!-- end modal  -->
        <!-- footer -->
        @include('web.includes.footer')

        <!-- Bootstrap and necessary plugins -->
        <script type="text/javascript" src="{{ asset('vendors/jquery/jquery.min.js') }}"></script>
        {{-- <script type="text/javascript" src="{{ asset('vendors/bootstrap/popper.min.js') }}"></script> --}}
        <script type="text/javascript" src="{{ asset('vendors/bootstrap/js/bootstrap.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('vendors/swiper/swiper-bundle.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('vendors/wow/wow.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('vendors/js/core.js') }}"></script>
        <script src="{{ asset('js/main.js') }}"></script>
        <script src="{{ asset('admin/vendors/toastify/toastify.js') }}"></script>
        {{-- Include sweetalert2 --}}
        <script src="{{ asset('admin/vendors/sweetalert2/sweetalert2.all.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('vendors/js/library/sweetalert2.all.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('vendors/jquery.fancybox.min.js') }}"></script>
    </div>

    <script>
        let config = {
            routes: {
                login: "{{ route('login.auth') }}",
                local: "{{ URL::to('locals') }}",
            },
        }
        $(document).ready(function() {
            $(document).on('click', '.btn-login', function() {
                let form = $('#loginForm');
                // submitForm(form);
            });

            $(document).on('click', '.btn-register', function() {
                let form = $('#registerForm');
                submitForm(form);
            });
        });
    </script>

    <script>
        $(window).bind('load', function() {
            const featureProduct = new Swiper('.home-banner-wrapper .swiper', {
                speed: 1000,
                lazy: true,
                autoplay: {
                    delay: 4000,
                    disableOnInteraction: false,
                },

                // pagination
                pagination: {
                    el: '.home-banner-wrapper .swiper-pagination',
                    clickable: true,
                    renderBullet: function(index, className) {
                        return `
                                <button class="${className} circle">
                                    <svg class="progresss" width="36" height="36">
                                        <circle class="circle-origin" r="16" cx="17" cy="19"></circle>
                                    </svg>
                                    <span>0${(index + 1)}</span>
                                </button>
                                `;
                    },
                },
            });

            const homenewsSlider = new Swiper('.home-news-wrapper .swiper', {
                // Optional parameters
                slidesPerView: 'auto',
                spaceBetween: 20,


                // Navigation arrows
                navigation: {
                    nextEl: '.home-news-wrapper .swiper-button-next',
                    prevEl: '.home-news-wrapper .swiper-button-prev',
                },

            });
            // productSliders();

            const newsHomeSlider = new Swiper('.home-news-wrapper .swiper', {
                // Optional parameters
                slidesPerView: 'auto',
                spaceBetween: 20,


                // Navigation arrows
                navigation: {
                    nextEl: '.home-news-wrapper .swiper-button-next',
                    prevEl: '.home-news-wrapper .swiper-button-prev',
                },
                breakpoints: {
                    1200: {
                        slidesPerView: 3,
                        spaceBetween: 20,
                    },
                }
            });

            const newsSlider = new Swiper('.news-relative-wrapper .swiper', {
                // Optional parameters
                slidesPerView: 'auto',
                spaceBetween: 20,


                // Navigation arrows
                navigation: {
                    nextEl: '.news-relative-wrapper .swiper-button-next',
                    prevEl: '.news-relative-wrapper .swiper-button-prev',
                },

            });

            var factoryswiperThumb = new Swiper("#factory-thumb .swiper", {
                spaceBetween: 36,
                slidesPerView: 'auto',
                freeMode: true,
                watchSlidesProgress: true,
                watchOverflow: true,
            });

            var factoryswiperMain = new Swiper("#factory-main .swiper", {
                spaceBetween: 10,
                watchOverflow: true,
                simulateTouch: false,
                effect: "fade",
                fadeEffect: {
                    crossFade: true
                },
                thumbs: {
                    swiper: factoryswiperThumb,
                },
            });

            const classSlider = new Swiper('.class-reg-list .swiper', {
                // Optional parameters
                slidesPerView: 'auto',
                spaceBetween: 24,


                // Navigation arrows
                navigation: {
                    nextEl: '.class-reg-list .swiper-button-next',
                    prevEl: '.class-reg-list .swiper-button-prev',
                },

            });

            const productSlider = new Swiper('.product-slide-wrapper-3 .swiper', {
                // Optional parameters
                slidesPerView: 1,
                spaceBetween: 50,
                loop: true,


                // Navigation arrows
                navigation: {
                    nextEl: '.product-slide-wrapper-3 .swiper-button-next',
                    prevEl: '.product-slide-wrapper-3 .swiper-button-prev',
                },

                breakpoints: {
                    768: {
                        slidesPerView: 2,
                    },
                    1200: {
                        spaceBetween: 20,
                        slidesPerView: 3,
                    }
                }
            });
            const relatedProductSlider = new Swiper('.related-product-slide-wrapper .swiper', {
                // Optional parameters
                slidesPerView: 1,
                spaceBetween: 50,
                loop: true,
                autoplay: {
                    delay: 6000,
                    disableOnInteraction: false,
                },


                // Navigation arrows
                navigation: {
                    nextEl: '.related-product-slide-wrapper .swiper-button-next',
                    prevEl: '.related-product-slide-wrapper .swiper-button-prev',
                },

                breakpoints: {
                    768: {
                        slidesPerView: 3,
                    },
                    1200: {
                        spaceBetween: 20,
                        slidesPerView: 4,
                    }
                }
            });
            var swiper = new Swiper(".mySwiper", {
                // loop: true,
                spaceBetween: 5,
                slidesPerView: 5,
                freeMode: true,
                watchSlidesProgress: true,
            });
            var swiper2 = new Swiper(".mySwiper2", {
                loop: true,
                spaceBetween: 30,
                // navigation: {
                //     nextEl: ".swiper-button-next",
                //     prevEl: ".swiper-button-prev",
                // },
                thumbs: {
                    swiper: swiper,
                },
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false,
                },
            });

            // function outsideContainer() {
            var container = $('.container').width();
            var broswerW = $(document).width();
            var space;
            var layoutW;
            var spaceL = $('.outside-container-left');
            var spaceR = $('.outside-container-right');

            if (spaceL.length) {
                space = Math.floor((broswerW - container) / 2);
                layoutW = broswerW - space;

                if ($(window).width() >= 1200) {
                    spaceL.each(function() {
                        $(this).css({
                            width: layoutW,
                            'margin-left': space
                        });
                    });
                }
            }

            if (spaceR.length) {
                space = Math.floor((broswerW - container) / 2);
                layoutW = broswerW - space;

                if ($(window).width() >= 1200) {
                    spaceR.each(function() {
                        $(this).css({
                            width: layoutW,
                            'margin-right': space
                        });
                    });
                }
            }
            // }
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var btn = document.querySelector('.hamburger');
            if (btn) {
                btn.addEventListener('click', function() {
                    document.body.classList.add('open');
                    var header = btn.closest('.header');
                    if (header) {
                        header.querySelector('.mb-backdrop').classList.add('show');
                        header.querySelector('.mb-header-content-wrapper').classList.add('menu-open');
                    }
                });

                var menuClose = document.querySelector('.menu-close');
                if (menuClose) {
                    menuClose.addEventListener('click', function() {
                        document.body.classList.remove('open');
                        var header = btn.closest('.header');
                        if (header) {
                            header.querySelector('.mb-backdrop').classList.remove('show');
                            header.querySelector('.mb-header-content-wrapper').classList.remove(
                                'menu-open');
                        }
                    });
                }
            }
        });
        document.addEventListener('DOMContentLoaded', function() {
            var wrappers = document.querySelectorAll('.header-search');
            wrappers.forEach(function(wrapper) {
                var input = wrapper.querySelector('input');

                wrapper.addEventListener('click', function() {
                    if (input.value === '' && !wrapper.classList.contains('active')) {
                        wrapper.classList.add('active');
                    } else if (input.value !== '') {
                        wrapper.classList.add('active');
                    }
                });
            });

            document.addEventListener('click', function(e) {
                var closestWrapper = e.target.closest('.header-search');
                if (!closestWrapper) {
                    wrappers.forEach(function(wrapper) {
                        wrapper.classList.remove('active');
                    });
                }
            });
        });
        document.addEventListener('DOMContentLoaded', function() {
            var btns = document.querySelectorAll('.list-arrow');
            if (btns.length && window.innerWidth < 1200) {
                btns.forEach(function(btn) {
                    var parentHasSub = btn.closest('.has-sub');
                    var subList = parentHasSub.querySelector('.header-sub-list');

                    subList.style.display = 'none';

                    btn.addEventListener('click', function() {
                        this.classList.toggle('active');
                        var siblings = parentHasSub.parentElement.querySelectorAll('.has-sub');
                        siblings.forEach(function(sibling) {
                            var siblingArrow = sibling.querySelector('.list-arrow');
                            var siblingSubList = sibling.querySelector('.header-sub-list');
                            if (sibling !== parentHasSub) {
                                siblingSubList.style.display = 'none';
                                siblingArrow.classList.remove('active');
                            }
                        });
                        subList.style.display = subList.style.display === 'none' ? 'block' : 'none';
                    });
                });
            }
        });
        document.addEventListener('DOMContentLoaded', function() {
            var fixedEle = document.querySelector('.fixed-ele');

            window.addEventListener('scroll', function() {
                var scrollPosition = window.scrollY || window.pageYOffset;
                var triggerPosition = document.body.scrollHeight * 0.3; // 30% of document height

                if (scrollPosition > triggerPosition) {
                    fixedEle.classList.add('show');
                } else {
                    fixedEle.classList.remove('show');
                }
            });
        });
        document.getElementById("showPasswordCheckbox").addEventListener("change", function() {
            var passwordInput = document.getElementById("login-password");
            if (this.checked) {
                passwordInput.type = "text";
            } else {
                passwordInput.type = "password";
            }
        });

        // Xử lý khi người dùng click vào hình ảnh bất kỳ
        $(document).on("click", "img.thumb", function() {
            Swal.fire({
                imageUrl: $(this).attr("src"),
                padding: 0,
                showConfirmButton: false,
                background: "transparent",
            });
        });
    </script>
    @stack('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $(document).on('click', '.btn-add-to-cart', function(e) {
                e.preventDefault();

                // Mở modal Bootstrap
                var offcanvasCart = new bootstrap.Offcanvas(document.getElementById('offcanvasCart'));
                offcanvasCart.show();
                const form = $(this).closest('form');
                submitForm(form).done(function(response) {
                    form.find('[type=submit]:last').prop("disabled", false).html(
                        '<i class="bi bi-basket3"></i> <span>Thêm vào giỏ hàng</span>');
                    updateMiniCart(response.cart);

                });
            });

            function updateMiniCart(cart) {
                // Update mini cart icon
                $('.mini-cart-icon sup').add('.ltn__utilize-buttons sup').text(cart.count);
                $('.mini-cart-icon h6 .ltn__secondary-color').text(number_format(cart.total) + 'đ');

                // Update cart menu
                var miniCartHtml = '';
                cart.items.forEach(function(item) {
                    miniCartHtml += `
                        <div class="mini-cart-item clearfix">
                            <div class="mini-cart-img">
                                <a href="${item.variable.product.url}"><img src="${item.variable.product.imageUrl}" alt="${item.variable.product.sku + (item.variable.sub_sku != null ? item.variable.sub_sku : '')} - ${item.variable.product.name + (item.variable.name != null ? ' - ' + item.variable.name : '')}"></a>
                                <form action="{{ route('cart.remove') }}" method="post">
                                    @csrf
                                    <input name="variable_id" type="hidden" value="${item.variable_id}">
                                    <button class="mini-cart-item-delete" type="submit"><i class="icon-cancel"></i></button>
                                </form>
                            </div>
                            <div class="mini-cart-info">
                                <h6><a href="${item.variable.product.url}">${item.variable.product.sku + (item.variable.sub_sku != null ? item.variable.sub_sku : '')} - ${item.variable.product.name + (item.variable.name != null ? ' - ' + item.variable.name : '')}</a></h6>
                                <span class="mini-cart-quantity">${item.quantity} &times; ${number_format(item.price)}đ</span>
                            </div>
                        </div>`;
                });
                $('.mini-cart-product-area').html(miniCartHtml);

                // Update subtotal
                $('.mini-cart-sub-total span').text(number_format(cart.total) + 'đ');
            }

            // Handle item removal from mini cart
            $(document).on('click', '.mini-cart-item-delete', function(e) {
                e.preventDefault();
                const form = $(this).closest('form')
                submitForm(form).done(function(response) {
                    form.find('[type=submit]:last').prop("disabled", false).html(
                        '<i class="icon-cancel"></i>');
                    updateMiniCart(response.cart);
                })
            })
        });
    </script>
</body>

</html>
