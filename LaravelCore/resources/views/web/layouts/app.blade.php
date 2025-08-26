<!DOCTYPE html>
<html lang="vi">
    @php
        $pageName = $pageName ?? '';
    @endphp

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        @php
            if (cache()->get('settings')['favicon']) {
                $favicon = asset(env('FILE_STORAGE', '/storage') . '/' . cache()->get('settings')['favicon']);
            } else {
                $favicon = asset('admin/images/logo/favicon_key.png');
            }
        @endphp
        <link type="image/x-icon" href="{{ $favicon }}" rel="shortcut icon">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name') }} - @yield('title')</title>

        <link href="{{ asset('css/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
        <link href="{{ asset('vendors/bootstrap/css/bootstrap.css') }}" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet" />
        <link href="{{ asset('css/jquery.fancybox.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">
        <link href="{{ asset('css/key.css') }}" rel="stylesheet">
        <link href="{{ asset('css/chat.css') }}" rel="stylesheet">
        {{-- Toastify --}}
        <link href="{{ asset('admin/vendors/toastify/toastify.css') }}" rel="stylesheet">
        {{-- Include sweetalert2 --}}
        <link href="{{ asset('admin/vendors/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet">
        <link href="{{ asset('admin/vendors/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    </head>

    <body class="home">
        <div id="app">
            @include('web.includes.header')
            @yield('content')
            <!-- modal  -->
            @include('web.includes.partials.modal_login')
            @include('web.includes.partials.modal_register')
            @include('web.includes.partials.modal_cart')
            @include('web.includes.partials.modal_address')
            @include('web.includes.partials.modal_rate')
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
            <script type="text/javascript" src="{{ asset('vendors/jquery.fancybox.min.js') }}"></script>
            {{-- Chat box js --}}
            <script src="{{ asset('js/pusher.min.js') }}"></script>
            <script src="{{ asset('js/chat.js') }}"></script>
            {{-- Laravel Mix --}}
            <script src="{{ asset('js/app.js') }}"></script>
            {{-- Include MomentJS --}}
            <script src="{{ asset('admin/vendors/momentjs/moment.min.js') }}"></script>
            <script src="{{ asset('admin/vendors/momentjs/moment-with-locales.js') }}"></script>
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        </div>
        <script>
            $(document).ready(function() {

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                /**
                 * LANGUAGES
                 */
                $('.btn-change-language').on('click', function() {
                    const currentLocale = '{{ app()->getLocale() }}';

                    $('.mb-backdrop').removeClass('show');
                    $('.mb-header-content-wrapper').removeClass('menu-open');

                    Swal.fire({
                        title: '{{ __('messages.lang.select_language') }}',
                        html: `
            <select id="locale_selector" class="form-select">
                <option value="vn" ${currentLocale === 'vn' ? 'selected' : ''}>🇻🇳 {{ __('messages.lang.vi') }}</option>
                <option value="en" ${currentLocale === 'en' ? 'selected' : ''}>🇺🇸 {{ __('messages.lang.en') }}</option>
            </select>
        `,
                        showCancelButton: true,
                        confirmButtonText: '{{ __('messages.save') }}',
                        cancelButtonText: '{{ __('messages.cancel') }}',
                    }).then((result) => {
                        const newLocale = $('#locale_selector').val();
                        // Chỉ gửi request nếu ngôn ngữ thay đổi
                        if (newLocale && newLocale !== currentLocale) {
                            $.ajax({
                                url: "{{ route('change.language.ajax') }}",
                                method: 'POST',
                                data: {
                                    locale: newLocale,
                                    _token: '{{ csrf_token() }}'
                                },
                                success: function() {
                                    Swal.fire({
                                        icon: 'success',
                                        title: '{{ __('messages.lang.language_changed_success') }}',
                                        timer: 1500,
                                        showConfirmButton: false
                                    }).then(() => location.reload());
                                },
                                error: function() {
                                    Swal.fire({
                                        icon: 'error',
                                        title: '{{ __('messages.error_occurred') }}',
                                        text: '{{ __('messages.try_again_later') }}'
                                    });
                                }
                            });
                        }
                    });
                });



            });
            let config = {
                address: {
                    defaultLat: 10.0451618,
                    defaultLng: 105.765374
                },
            routes: {
                login: "{{ route('login.auth') }}",
                local: "{{ URL::to('locals') }}",
                pusher: {
                    broadcast: "{{ route('chat.broadcast') }}",
                },
                rasa_webhook_url: "{{ env('RASA_WEBHOOK_URL', 'http://localhost:8001/webhooks/smssolutions/webhook') }}"
            },
             user: {
                id: {{ Auth::check() ? Auth::id() : 'null' }}
            },
            sweetAlert: {
                confirm: {
                    title: "{{ __('messages.sweet_confirm_title') }}",
                    text: "{{ __('messages.sweet_confirm_text') }}",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "var(--bs-danger)",
                    cancelButtonColor: "var(--bs-primary)",
                    confirmButtonText: "{{ __('messages.sweet_confirm_button') }}",
                    cancelButtonText: "{{ __('messages.sweet_cancel_button') }}",
                    reverseButtons: false
                },
                delay: {
                    title: "{{ __('messages.sweet_delay_title') }}",
                    text: "{{ __('messages.sweet_delay_text') }}",
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    willOpen: () => {
                        Swal.showLoading();
                    },
                },
            },
        }

            let auth_id = @json(auth()->id());
            let offset = 0;
            let loading = false;
            let noMoreMessages = false; // Để chặn load khi hết tin nhắn

            function createChatLi(message, auth_id = null) {
                const type = message.sender_id == auth_id ? 'outgoing' : 'incoming';
                const avatar = (addition_class = '') => {
                    if (type == 'incoming') {
                        if (message.sender)
                            return `<img src="${message.sender.avatarUrl}" alt="avatar" class="rounded-circle ratio-1-1 img-fluid w-100 ${addition_class}">`;
                        else
                            return `<img src="{{ asset('images/sms_bot.png') }}" alt="Chat bot" class="rounded-circle ratio-1-1 img-fluid w-100 ${addition_class}"/>`;
                    } else {
                        return '';
                    }
                }

                const attachments = () => {
                    if (message.attachments) {
                        let html = '';
                        $.each(message.attachments, function(index, attachment) {
                            if (attachment.mime_type.startsWith('image/')) {
                                html += `<li class="chat ${type}">
                                        <span class="material-symbols-outlined bg-white" style="width: 40px;"></span>
                                        <div class="w-50 d-inline-block">
                                            <img src="${attachment.file_url}" alt="attachment" class="rounded thumb img-fluid w-100">
                                        </div>
                                    </li>`;
                            } //video
                            else if (attachment.mime_type.startsWith('video/')) {
                                html += `<li class="chat ${type}">
                                        <span class="material-symbols-outlined bg-white" style="width: 40px;">${avatar('opacity-0')}</span>
                                        <div class="w-50 d-inline-block">
                                            <video src="${attachment.file_url}" controls alt="attachment" class="rounded thumb img-fluid w-100">
                                        </div>
                                    </li>`;
                            } else {
                                //Open file with attachment file_url by browser
                                html += `<li class="chat ${type}">
                                            <span class="material-symbols-outlined bg-white" style="width: 40px;">${avatar('opacity-0')}</span>
                                            <a href="${attachment.file_url}" target="_blank"
                                            class="text-decoration-none text-truncate fs-6 border p-1 d-inline-block"
                                            style="max-width: 150px;" title="${attachment.file_name}">
                                            <i class="bi bi-file-earmark-fill"></i> ${attachment.file_name}</a>
                                        </li>`;
                            }
                        })
                        return html;
                    } else {
                        return '';
                    }
                }
                if (!message.content && !message.attachments) return '';
                if (!message.content && message.attachments) return attachments();
                const renderedData = () => {
                    if(message.json_data)
                        return `<li class="chat ${type}" style="display: block;">
                                    ${message.renderData}
                                </li>`
                    return ''
                }
                return `${attachments()}
                    <li class="chat ${type}">
                        <span class="material-symbols-outlined bg-white" style="width: 40px;">${avatar()}</span>
                        <p class="pb-1">${message.content}
                            <small class="m-1 fst-italic ${type == 'outgoing' ? 'float-end text-white' : 'float-start text-muted'}">${moment(message.created_at).fromNow()}</small>
                        </p>
                    </li>${renderedData()}`;
            }

            function loadMessages(reset = false) {
                if (loading || noMoreMessages) return;
                loading = true;

                $.get(`{{ route('chat', ['key' => 'messages']) }}`, {
                    offset: offset
                })
                .done(function(messages) {
                    const messagesArray = Object.values(messages);

                    // Nếu không còn tin nhắn nào trả về => chặn load tiếp
                    if (messagesArray.length === 0) {
                        noMoreMessages = true;
                        return;
                    }

                    let html = '';
                    for (let i = messagesArray.length - 1; i >= 0; i--) {
                        let message = messagesArray[i];
                        html += createChatLi(message, auth_id);
                    }

                    const chatbox = $('.chatbox');

                    if (reset) {
                        chatbox.html(html);
                        offset = messagesArray.length; // Reset lại offset theo số tin nhận được
                        chatbox.scrollTop(chatbox[0].scrollHeight);
                    } else {
                        const oldScrollHeight = chatbox[0].scrollHeight;
                        chatbox.prepend(html);
                        offset += messagesArray.length;
                        chatbox.scrollTop(chatbox[0].scrollHeight - oldScrollHeight);
                    }
                })
                .fail(function(xhr, status, error) {
                    console.error("Lỗi khi load tin nhắn:", error);
                })
                .always(function() {
                    loading = false; // Chỉ set lại false khi request xong
                });
            }

            $(document).ready(function() {
                @if (auth()->check())
                    loadMessages(true);
                @endif

                $(document).on('click', '.btn-login', function(event) {
                    let form = $('#loginForm');
                    submitForm(form).done(function(response) {
                        location.reload();
                    });
                });
                // Bắt sự kiện nhấn Enter trong input
                $('#loginForm input').on('keydown', function(e) {
                    if (e.key === 'Enter') {
                        let form = $('#loginForm');
                        submitForm(form).done(function(response) {
                            location.reload();
                        });
                    }
                });

                function submitLogoutForm() {
                    const form = $("#logout-form");
                    form.attr("action", "/logout");
                    submitForm(form).done(function(response) {
                        showLoginForm();
                        updateCsrfToken(response.token);
                    });
                }

                //Tổ hợp phím Ctrl + End
                $(document).on("keydown", function(e) {
                    if (e.ctrlKey && e.key === "End") {
                        e.preventDefault();
                        submitLogoutForm();
                    }
                });

                $(document).on('click', '.btn-register', function() {
                    let form = $('#registerForm');
                    submitForm(form);
                });

                // nhận tin nhắn
                window.Echo.channel('public')
                    .listen('.chat', (data) => {
                        const liHtml = createChatLi(data.message, auth_id);
                        $temp = $('.chatbox').find('.temp-sending');
                        if($temp.length > 0) $temp.remove();
                        $('.chatbox').append(liHtml);
                        $('.chatbox').scrollTop($('.chatbox')[0].scrollHeight);
                        document.getElementById('chatSound').play();
                    });

                // Scroll để load thêm tin nhắn
                $('.chatbox').on('scroll', function() {
                    if ($(this).scrollTop() == 0) {
                        loadMessages(false);
                    }
                });
                $(document).on('click', '.btn-select-attachments', function(e){
                    e.preventDefault();
                    $('#chatAttachments').click();
                })
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
                if ($('.mySwiper2').length && $('.mySwiper').length) {
                    var swiperV = new Swiper(".mySwiper", {
                        // loop: true,
                        spaceBetween: 5,
                        slidesPerView: 5,
                        freeMode: true,
                        watchSlidesProgress: true,
                    });
                    var swiper2 = new Swiper(".mySwiper2", {
                        loop: true,
                        spaceBetween: 30,
                        navigation: {
                            nextEl: ".swiper-button-next",
                            prevEl: ".swiper-button-prev",
                        },
                        thumbs: {
                            swiper: swiperV,
                        },
                        autoplay: {
                            delay: 5000,
                            disableOnInteraction: false,
                        },
                    });
                }

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
                        if (input && input.value === '' && !wrapper.classList.contains('active')) {
                            wrapper.classList.add('active');
                        } else if (input && input.value !== '') {
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
                    const form = $(this).closest('form');

                    // Kiểm tra điều kiện số lượng và đơn vị
                    if (form.find('[name=quantity]').val() <= 0 || form.find('.btn-select-unit.active').length <= 0) {
                        Toastify({
                            text: "{{ __('lang_web.cart.quantity_error') }}",
                            duration: 3000,
                            close: true,
                            gravity: "top",
                            position: "center",
                            stopOnFocus: true,
                        }).showToast();
                        return false;
                    }
                    const btn = $(this);
                    btn.prop("disabled", true).html('<span class="spinner-border spinner-border-sm"></span>');
                    // Lấy vị trí nếu có, không có thì vẫn submit form
                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(
                            function(position) {
                                form.find('[name=lat]').val(position.coords.latitude);
                                form.find('[name=lng]').val(position.coords.longitude);
                                submitCartForm(form, btn);
                            },
                            function(error) {
                                // Nếu người dùng từ chối hoặc có lỗi, vẫn submit
                                console.warn("Vị trí không lấy được, vẫn tiếp tục...");
                                submitCartForm(form, btn);
                            }, {
                                timeout: 5000
                            }
                        );
                    } else {
                        submitCartForm(form, btn); // Trình duyệt không hỗ trợ
                    }
                });

                function submitCartForm(form, btn) {
                    var offcanvasCart = new bootstrap.Offcanvas($('#offcanvasCart'));
                    offcanvasCart.show();
                    submitForm(form).done(function(response) {
                        form.find('[name=quantity]').val(1);
                        btn.prop("disabled", false).html(
                            '<i class="bi bi-basket3"></i> <span>{{ __('lang_web.product.add_to_cart') }}</span>'
                        );
                        updateMiniCart(response.cart);
                    });
                }

                function updateMiniCart(cart) {
                    // Gom nhóm các cart item theo unit_id
                    const groupedItems = {};

                    cart.items.forEach(function(item) {
                        const unitId = item.unit_id;
                        if (!groupedItems[unitId]) {
                            groupedItems[unitId] = {
                                ...item,
                                quantity: parseFloat(item.quantity),
                                sub_total: parseFloat(String(item.sub_total).replace(/,/g, ''))
                            };
                        } else {
                            // Cộng dồn quantity và sub_total
                            groupedItems[unitId].quantity += parseFloat(item.quantity);
                            groupedItems[unitId].sub_total += parseFloat(String(item.sub_total).replace(/,/g, ''));
                        }
                    });

                    // Tạo HTML từ các item đã gom nhóm
                    let miniCartHtml = '';
                    Object.values(groupedItems).forEach(function(item) {
                        const product = item.unit.variable.product;
                        miniCartHtml += `
                        <div class="mini-cart-item">
                            <div class="mini-cart-img">
                                <img src="${product.avatarUrl}" alt="${product.name}">
                                <form action="{{ route('cart.remove') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="unit_id" value="${item.unit_id}">
                                    <button class="mini-cart-item-delete just-icon" type="submit">
                                        <i class="bi bi-x"></i>
                                    </button>
                                </form>
                            </div>
                            <div class="mini-cart-info">
                                <h6>${product.name} - ${item.unit.variable.name} - ${item.unit.term}</h6>
                                <span class="mini-cart-quantity">
                                    ${item.quantity} × ${number_format(item.unit.price)} {{ $config['currency'] }}
                                </span>
                            </div>
                            <div class="mini-cart-price">
                                ${number_format(item.sub_total)} {{ $config['currency'] }}
                            </div>
                        </div>`;
                    });

                    $('.mini-cart-items').html(miniCartHtml);
                    $('.mini-cart-count').text(cart.count);
                    $('.mini-cart-total span').text(number_format(cart.total) + ' {{ $config['currency'] }}');
                }

                // Handle item removal from mini cart
                $(document).on('click', '.mini-cart-item-delete', function(e) {
                    e.preventDefault();
                    const form = $(this).closest('form')
                    submitForm(form).done(function(response) {
                        form.find('[type=submit]:last').prop("disabled", false).html('<i class="bi bi-x"></i>');
                        updateMiniCart(response.cart);
                    })
                })

                $(document).on('submit', '#remove-address-form', function(e) {
                    e.preventDefault();
                    const form = $(this);
                    submitForm(form).done(function(response) {
                        if (response.status === 'success') {
                            $(`input[name=user_address]:checked`).closest('.user-address').remove()
                            $('.address-action').addClass('d-none')
                        }
                    })
                })

                $(document).on('submit', '#address-map-form', function(e) {
                    e.preventDefault();
                    const form = $(this)
                    submitForm(form).done(function(response) {
                        if (form.attr('data-action') === "create") {
                            let count = parseInt($('#user-address-list input[type="radio"]').last().attr('data-index') ?? 0),
                                str = `<div class="user-address">
                                            <input type="radio" data-index="${count + 1}" hidden id="user-address-${count + 1}" name="user_address" class="btn-check" checked value='${JSON.stringify(response.address)}'>
                                            <label for="user-address-${count + 1}" class="btn btn-outline-primary mt-1 w-100 text-start"
                                                    data-recipient="${response.address['recipient_name']} - ${response.address['recipient_phone']}" data-address="${response.address['address']}">
                                                ${response.address['recipient_name']} - ${response.address['recipient_phone']} <br> ${response.address['address']}
                                            </label>
                                            <hr class="my-0">
                                        </div>`
                            $('#user-address-list').append(str);

                            $('.address-action').removeClass('d-none')
                            $('.btn-update-address').attr('data-id', JSON.stringify(response.address))
                            $('#remove-address-form [name=address]').val(JSON.stringify(response.address))

                            let $newLabel = $(`#user-address-${count + 1}`).next('label');
                            $newLabel.get(0).scrollIntoView({
                                behavior: 'smooth',
                                block: 'center'
                            });
                        } else {
                            const input = $(`input[name=user_address]:checked`);

                            $(input).val(response.address).prop('checked', true)
                            $(`label[for="${$(input).attr('id')}"]`).attr('data-recipient', `${response.address['recipient_name']} - ${response.address['recipient_phone']}`)
                                .attr('data-address', `${response.address['address']}`)
                                .html(`${response.address['recipient_name']} - ${response.address['recipient_phone']} <br> ${response.address['address']}`)

                        }
                    })
                })

                $(document).on('click', '.btn-view-address', function() {
                    const form = $('#user-address-form')
                    resetForm(form)
                    $('.address-action').addClass('d-none')
                    if ($(this).hasClass('btn-accept')) {
                        form.find('.modal-footer').removeClass('d-none')
                    } else {
                        form.find('.modal-footer').addClass('d-none')
                    }
                    form.find('.modal').modal('show')
                })

                $(document).on('click', '.btn-create-address', function() {
                    const form = $('#address-map-form')
                    resetForm(form)
                    form.find('[name=old_address]').val('')
                    form.attr('data-action', 'create')
                    form.find('.modal').modal('show')
                })

                $(document).on('click', '.btn-update-address', function() {
                    const form = $('#address-map-form'),
                        data_id = $(this).attr('data-id'),
                        address = JSON.parse(data_id)

                    resetForm(form)
                    form.attr('data-action', 'update')
                    form.find('#recipient-name').val(address.recipient_name)
                    form.find('#recipient-phone').val(address.recipient_phone)
                    form.find('#address-map-preview').val(address.address)
                    form.find('[name=address]').val(data_id)
                    form.find('[name=old_address]').val(data_id)
                    form.find('#address-default').prop('checked', address.default == "yes")
                    addressMap = initGoongMap({
                        defaultLat: address.lat,
                        defaultLng: address.lng,
                        containerId: 'address-map',
                        addressInputSelector: '#address-map-form input[name="address"]',
                        addressPreviewSelector: '#address-map-preview',
                        onLocationSelected: ({
                            lat,
                            lng,
                            address
                        }) => {
                            $('#address-map-form input[name="address"]').val(JSON.stringify({
                                lat,
                                lng,
                                address
                            }));
                        }
                    });
                    form.find('.modal').modal('show')
                })

                $(document).on('change', 'input[name=user_address]', function() {
                    if ($('input[name="user_address"]:checked').length > 0) {
                        const address = $('input[name="user_address"]:checked').val();
                        $('.address-action').removeClass('d-none')
                        $('.btn-update-address').attr('data-id', address)
                        $('#remove-address-form [name=address]').val(address)
                    } else {
                        $('.address-action').addClass('d-none')
                        $('.btn-update-address').attr('data-id', '')
                        $('#remove-address-form [name=address]').val('')
                    }
                })

                let addressMap = null;
                $('#address-map-modal').on('shown.bs.modal', function() {
                    if (!addressMap) {
                        addressMap = initGoongMap({
                            defaultLat: config.address.defaultLat,
                            defaultLng: config.address.defaultLng,
                            containerId: 'address-map',
                            addressInputSelector: '#address-map-form input[name="address"]',
                            addressPreviewSelector: '#address-map-preview',
                            onLocationSelected: ({
                                lat,
                                lng,
                                address
                            }) => {
                                $('#address-map-form input[name="address"]').val(JSON.stringify({
                                    lat,
                                    lng,
                                    address
                                }));
                            }
                        });
                    }
                });

                $('#address-map-modal').on('hidden.bs.modal', function() {
                    if (addressMap) {
                        addressMap = null;
                    }
                    $('#address-map').empty();
                    $('#address-map-form input[name="address"]').val('');
                    $('#address-map-preview').val('');
                });
            });
        </script>
        <link href="https://cdn.jsdelivr.net/npm/@goongmaps/goong-js@1.0.9/dist/goong-js.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/@goongmaps/goong-js@1.0.9/dist/goong-js.js"></script>

        <script>
            const GOONG_MAP_API_KEY = '{{ config('services.goong.map_key') }}';
            const GOONG_REST_API_KEY = '{{ config('services.goong.rest_key') }}';
        </script>

    </body>

</html>
