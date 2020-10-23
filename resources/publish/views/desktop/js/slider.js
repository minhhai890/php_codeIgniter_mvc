function slider(element, options = {}) {
    options = $.extend({
        slide_move: 'right',
        slide_time: 3000
    }, options);
    var startX = 0;
    var endX = 0;
    var slideWidth = 0;
    // Tính kích thước
    calculator = function () {
        slideWidth = $(element + ' ul li').width();
        var slideCount = $(element + ' ul li').length;
        var slideHeight = $(element + ' ul li').height();
        var sliderUlWidth = slideCount * slideWidth;
        // Slider css
        $(element).css({ width: slideWidth, height: slideHeight });
        $(element + ' ul').css({ width: sliderUlWidth, marginLeft: - slideWidth });
        $(element + ' ul li').css({ width: slideWidth });
        $(element + ' ul li:last-child').prependTo(element + ' ul');
    }
    // Tính kích thước
    calculator();
    // Khởi động slider
    var sliderSession;
    sliderStart = function () {
        sliderSession = setInterval(function () {
            sliderMove(options.slide_move);
        }, options.slide_time);
    }

    // Hàm dừng slider
    sliderStop = function () {
        clearInterval(sliderSession);
    }

    // Hàm di chuyển slider phải left | right
    sliderMove = function (move) {
        var swidth;
        if (move == 'left') {
            swidth = + slideWidth;
        }
        if (move == 'right') {
            swidth = - slideWidth;
        }
        if (swidth) {
            $(element + ' ul').animate({
                left: swidth
            }, 200, function () {
                $(element + ' ul li:first-child').appendTo(element + ' ul');
                $(element + ' ul').css('left', '');
            });
        }
    };

    // Ngưng slider khi hover chuột
    $(element).mouseover(function () {
        sliderStop();
    });

    // Ngưng slider khi nhấp giữ chuột
    $(element).mousemove(function () {
        sliderStop();
    });

    // Chạy slider khi không còn hover chuột
    $(element).mouseleave(function () {
        sliderStart();
    });

    // Trở về slider trước
    $(element + ' .prev').click(function () {
        sliderStop();
        sliderMove('left');
        sliderStart();
        return false;
    });

    // Tiếp theo slider sau
    $(element + ' .next').click(function () {
        sliderStop();
        sliderMove('right');
        sliderStart();
        return false;
    });

    // Mobile vuốt chuột       
    $(element).on('touchstart', function (e) {
        sliderStop();
        startX = e.originalEvent.changedTouches[0].pageX;        
    });
    $(element).on('touchmove', function (e) {
        sliderStop();
        endX = e.originalEvent.changedTouches[0].pageX;
    });
    $(element).on('touchend', function (e) {
        sliderStop();
        if (startX > endX) {
            sliderMove('right')
        }
        if (startX < endX) {
            sliderMove('left')
        }
        sliderStart();
    });
    sliderStart();
    $(window).resize(function () {
        $(element + ',' + element + ' li').css({ 'width': $('#main').width() + 'px' });
        sliderStop();
        calculator();
        sliderStart();
    });
}

// Chạy slider home
slider('#main .slider', {
    'slide_time': 4000,
    'slide_move': 'right'
});