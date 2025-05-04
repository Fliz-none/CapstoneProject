const header = {

    openMenu() {
        var btn = $('.hamburger');
        if (btn.length) {
            btn.on('click', function () {
                $('body').addClass('open');
                btn.parents('.header').find('.mb-backdrop').addClass('show');
                btn.parents('.header').find('.mb-header-content-wrapper').addClass('menu-open');
            })
        }
    },
    toggleMbSub() {
        var btn = $('.list-arrow');
        if (btn.length && $(window).width() < 1200) {
            btn.parents('.has-sub').find('.header-sub-list')
                .css({ display: 'none' });

            btn.on('click', function () {
                $(this).toggleClass('active');
                $(this).parents('.has-sub').find('.header-sub-list').slideToggle();
                $(this)
                    .parents('.has-sub')
                    .siblings()
                    .find('.header-sub-list')
                    .slideUp();
                $(this)
                    .parents('.has-sub')
                    .siblings()
                    .find('.list-arrow')
                    .removeClass('active');
            });
        }
    },
    searchInput() {
        var $wrapper = $('.header-search');

        if ($wrapper.length) {
            var $target = $wrapper.find('input');

            $wrapper.each(function (index, value) {
                let input = $(value).find('input');
                $(value).on('click', function () {
                    if (input.val() == '' && !$(this).hasClass('active')) {
                        $(this).addClass('active');
                    }
                    else if (input.val()) {
                        $(this).addClass('active');
                    }
                });
            });

            $(document).on('click', function (e) {
                if ($(e.target).closest('.header-search').length === 0) {
                    $wrapper.removeClass('active');
                    // $target.val('');
                }
            });
        }
    },
    closeMenu() {
        var btn_close = $('.menu-close');
        var backdrop = $('.mb-backdrop');

        function closeAction() {
            $('body').removeClass('open');
            backdrop.removeClass('show');
            $('.mb-header-content-wrapper').removeClass('menu-open');
        }

        if ($(window).width() < 1200) {
            btn_close.on('click', function () {
                closeAction();
            });

            backdrop.on('click', function () {
                closeAction();
            });
        }
    },
    init() {
        this.openMenu();
        this.toggleMbSub();
        this.closeMenu();
        this.searchInput();
    }
}

export default header;