$(document).ready(function () {

    // Hàm hiển thị backgroup pupop
    function maskOverlay(display = true, bg = true) {
        var e = $('#popup');
        if (display == true) {
            if (bg == true) {
                e.addClass('bg_opcity').fadeIn();
            } else {
                e.fadeIn();
            }
        } else {
            e.fadeOut();
        }
        return e;
    }

    // Hàm fix chiều cao product view right
    function fn_pvright(height) {
        $('#main .product-view-right.is-fixed .content').css({
            'height': (height - 95) + 'px'
        });
    }
    // Hàm fix chiều cao product view right
    function fn_pvrightTop(top) {
        $('#main .product-view-right.is-fixed').css({
            'top': top + 'px'
        });
    }
    fn_pvright($(window).height());

    // header fixed
    $(document).scroll(function () {
        var scrollTop = $(this).find('html').get(0).scrollTop;
        if (scrollTop > 65) {
            $(this).find('#header .header-center').addClass('header-fixed');
        } else {
            $(this).find('#header .header-center').removeClass('header-fixed');
        }
        if ($(this).find('.product-detail').length > 0) {
            var titleOffsetTop = $(this).find('.is-fixed').attr('data-offsetTop');
            if (titleOffsetTop == undefined) {
                var titleOffsetTop = $(this).find('.is-fixed').get(0).offsetTop;
            }
            if ((scrollTop + 60) >= titleOffsetTop) {
                $(this).find('.is-fixed').attr('data-offsetTop', titleOffsetTop);
                $(this).find('.is-fixed').addClass('title-fixed');
                var ftOffsetTop = $(this).find('#footer').get(0).offsetTop;
                if (scrollTop + $(window).height() >= ftOffsetTop) {
                    fn_pvrightTop(ftOffsetTop + 48 - (scrollTop + $(window).height()));
                } else {
                    fn_pvrightTop(60);
                    fn_pvright($(window).height());
                }
                $('#main .product-view-right.is-fixed').css({
                    'right': ($(this).width() - $(this).find('#main').width()) / 2
                });
            } else {
                $(this).find('.is-fixed').removeClass('title-fixed');
            }
        }
    });

    // Fix menu
    $('div.subcate').hover(function () {
        $(this).closest('li').addClass('active');
    }, function () {
        $(this).closest('li').removeClass('active');
    });
    $('div.subcate .content > ul > li').hover(function () {
        $('div.subcate .content > ul > li').removeClass('active');
        $(this).addClass('active');
        var contentWidth = 250;
        var contentHeight = $('div.subcate .content').height();
        var subLength = $(this).find('.sub2 ul').length;
        $(this).find('.sub2').css('width', subLength * contentWidth - 1).find('ul').css({
            'width': (subLength * contentWidth - 22) / subLength,
            'height': contentHeight
        });
    }, function () {
        if (!$(this).find('ul').is('visible')) {
            $('div.subcate .content > ul > li').removeClass('active');
        }
    });

    // Login tab
    function loginTab(id) {
        var e = 'div.member-form';
        $(e + ' ul.tab a').removeClass('active');
        $(e + ' form').hide();
        $(e + ' ul.tab a[data-action="' + id + '"]').addClass('active');
        $(e).fadeIn();
        $(id).show().find('[data-focus="true"]').focus();
    }

    // Hiển thị popup login and register
    $('a.viewlogin').on('click', function () {
        maskOverlay(true);
        loginTab('#login-form');
        return false;
    });

    // Control tab login and register
    $('div.member-form ul.tab a').on('click', function () {
        loginTab($(this).attr('data-action'));
        return false;
    });

    // Đóng popup login
    $('button.closelogin').on('click', function () {
        $('div.member-form').fadeOut();
        maskOverlay(false);
    });

    // show add to cart
    function addToCart() {
        var e = maskOverlay(true, false);
        e.find('.add-to-cart').show();
        setTimeout(function () {
            e.find('.add-to-cart').fadeOut();
            maskOverlay(false);
        }, 2000);
    }

    $('.product-detail .addcart').click(function () {
        addToCart();
        return false;
    });

    // Fix col left category
    function fixColLeft() {
        var leftHeight = $('div.category-products .col-left').height();
        var rightHeight = $('div.category-products .col-right').height();
        if (leftHeight < rightHeight) {
            $('div.category-products .col-left').css(
                'height', rightHeight
            );
        }
    }
    fixColLeft();

    // Fix big image product detail
    function fixImageDetail() {
        $('div.big-image').css('height', $('div.big-image').width() + 22);
    }
    fixImageDetail();


    $(window).resize(function () {
        fixColLeft();
        fixImageDetail();
    });

});