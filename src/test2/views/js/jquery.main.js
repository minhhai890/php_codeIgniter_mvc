$(document).ready(function () {

    // Trả về giá trị số trong chuỗi
    $.fn.getNumeric = function (str) {
        if (typeof str == 'string') {
            return str.replace(/\D/g, '');
        }
        return false;
    }

    // Trả về giá trị chuỗi
    $.fn.getString = function (str) {
        if (typeof str == 'string') {
            return str.replace(/[^A-z]+/g, '');
        }
        return false;
    }

    // Hàm trả về một chuỗi ký tự ngẫu nhiên
    $.fn.strRandom = function (length) {
        var result = '';
        var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        var charactersLength = characters.length;
        for (var i = 0; i < length; i++) {
            result += characters.charAt(Math.floor(Math.random() * charactersLength));
        }
        return result;
    }

    // Hàm sao chép đoạn văn bản
    $.fn.strCopy = function (str) {
        var element = document.createElement('textarea');
        document.body.appendChild(element);
        element.value = str;
        element.focus();
        element.select();
        document.execCommand('Copy');
        element.remove();
    }

    // Hàm cho phép chọn một hoặc nhiều element
    $.fn.selectElement = function () {
        if ($(this).attr('class') != 'empty') {
            if ($(this).attr('data-multi') == 'false') {
                var offsetParent = $(this).offsetParent.className;
                offsetParent = '.' + offsetParent.replace(' ', '.');
                $(offsetParent + ' ' + $(this).prop("tagName")).removeClass('selected');
            }
            if ($(this).attr('class') == 'selected') {
                $(this).removeClass('selected');
            } else {
                $(this).addClass('selected');
            }
        }
    }

    // Hàm thiết lập Cookie
    $.fn.setCookie = function (name, value) {
        document.cookie = name + '=' + value + '; Path=/;';
    }

    // Hàm trả về giá trị Cookie
    $.fn.getCookie = function (name) {
        var match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
        if (match) return match[2];
    }

    // Hàm xóa Cookie
    $.fn.deleteCookie = function (name) {
        document.cookie = name + '=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
    }

    // Định dạng ngày tháng năm
    $.fn.formatDate = function (milisecond) {
        if (milisecond = parseInt(milisecond)) {
            date = new Date(parseInt(milisecond) * 1000);
            return date.getDate() + '/' + (date.getMonth() + 1) + '/' + date.getFullYear();
        }
    }

    // Auto focus
    $.fn.autoFocus = function () {
        $(document).find('.autofocus:visible').focus();
    }

    // Hàm reset form
    $.fn.resetForm = function (form) {
        if (form) {
            $(form).trigger("reset");
            $(form).find('i.fa, i.fas').remove();
            $.fn.autoFocus();
        }
    }

    // Hàm trả về chuỗi in hoa chữ cái đầu tiên
    $.fn.strUcfirst = function (str) {
        return str.charAt(0).toUpperCase() + str.slice(1);
    }

    // Hàm thay đổi url mà không load lại trang
    $.fn.changeUrl = function (url) {
        history.pushState({}, null, url);
    }

    // Thiết lập đường dẫn url xử lý ajax
    $.fn.setUrl = function (control, action, prefix = '') {
        if (!(url = $('base').attr('href'))) {
            url = location.origin + '/';
        }
        return url + 'post/v1/' + $.fn.strUcfirst(control) + '/' + action + prefix;
    }

    // Hàm thêm ký tự require * vào label
    $.fn.require = function () {
        $('input.require,select.require,textarea.require').prev('label').addClass('require');
    }

    // Hàm trả về giá trị input trong form
    // options: tag form hoặc {name: value,...}
    // params: {name: value,...}
    $.fn.getFormData = function (options = null, params = null) {
        data = false;
        if ($(options).prop("tagName") == 'FORM') {
            var data = new FormData($(options)[0]);
            $(options).find('input, textarea, select').each(function () {
                if (/require/.test($(this).attr('class'))) {
                    if (!$(this).val()) {
                        data = false;
                        return false;
                    }
                }
                if (/check\-fail/.test($(this).attr('class'))) {
                    data = false;
                    return false;
                }
            });
            if (data && params) {
                $.each(params, function (name, value) {
                    if (typeof (value) == 'object') {
                        $.each(value, function () {
                            data.append(name + '[]', this);
                        });
                    } else {
                        data.append(name, value);
                    }
                });
            }
        } else {
            if (typeof (options) == 'object') {
                var data = new FormData();
                $.each(options, function (name, value) {
                    if ((typeof (value) === 'object')) {
                        $.each(value, function () {
                            data.append(name + '[]', this);
                        });
                    } else {
                        data.append(name, value);
                    }
                });
            }
        }
        return data;
    }

    // Hàm xử lý ajax post
    $.fn.ajaxPost = function (url, data = {}, call = null, loading = true) {
        var settings = {
            'url': url,
            'method': 'POST',
            'timeout': 0,
            'headers': {},
            'processData': false,
            'mimeType': 'json',
            'cache': false,
            'contentType': false,
            'async': true,
            'data': data,
            'beforeSend': function (event) {
                if (loading) {
                    $.fn.loading(loading);
                    event.done(function () {
                        $.fn.loading(false);
                    });
                }
            }
        };
        $.ajax(settings).done(function (responsive) {
            if (typeof (call) == 'function') {
                call(responsive);
                $.fn.autoFocus();
            }
        });
    }

    // Mặt nạ popup
    $.fn.maskOverlay = function (mask = true) {
        var e = $(document).find('#popup');
        if (mask == true) {
            e.addClass('bg_opacity').fadeIn();
        } else {
            e.removeClass('bg_opacity').fadeOut();
        }
        return e;
    }

    // loadding
    $.fn.loading = function (load = true) {
        if (load == true) {
            $(document).find('#popup').show().find('div.loading').show();
        } else {
            if ($(document).find('#popup .absolute:visible').length > 1) {
                $(document).find('#popup div.loading').hide();
            } else {
                $(document).find('#popup').hide().find('div.loading').hide();
            }
        }
    }

    // Alert
    $.fn.alert = function (mess) {
        var e = $.fn.maskOverlay();
        e.show().find('div.alert').show().find('div.content').html('<p>' + mess + '</p>');
        e.find('div.alert div.foot').addClass('hidden');
        return e;
    }

    // Alert Error
    $.fn.alertError = function (mess) {
        $.fn.alert('<strong style="color: #F00">[Error]</strong>: ' + mess);
    }

    // Alert Success
    $.fn.alertSuccess = function (mess) {
        $.fn.alert('<strong style="color: #00F">[Success]</strong>: ' + mess);
    }

    // Alert Confirm
    $.fn.confirm = function (mess, call = null) {
        var e = $.fn.alert('<strong>[Confirm]</strong>: ' + mess);
        e.find('div.alert div.foot').removeClass('hidden');
        if (typeof (call) == 'function') {
            e.find('div.alert div.foot').on('click', 'button.continue', function () {
                return call();
            });
        }
    }

    // Trả về dữ liệu input trước khi hiển thị
    $.fn.inputValue = function (element, call) {
        return $(document).on("input keyup change", element, function () {
            if (value = call(this)) {
                if (value !== true) {
                    this.value = value;
                } else {
                    this.oldValue = this.value;
                    this.oldSelectionStart = this.selectionStart;
                    this.oldSelectionEnd = this.selectionEnd;
                }
            } else if (this.hasOwnProperty("oldValue")) {
                this.value = this.oldValue;
                this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
            } else {
                this.value = "";
            }
        });
    };

    // Hàm kiểm tra input hợp lệ
    $.fn.inputCheck = function (isCheck) {
        clsActive = '';
        $(this).removeClass('check-success check-fail');
        if (isCheck == false) {
            if ($(this).val() || /require/.test($(this).attr('class'))) {
                clsActive = 'check-fail';
            }
        } else {
            clsActive = 'check-success';
        }
        $(this).addClass(clsActive);
        $(this).next('span.icon-check').remove();
        if (clsActive) {
            $(this).closest('div.group').append('<span class="icon-check ' + clsActive + '"></span');
        }
    }

    // Đóng popup đang hiển thị
    $(document).on('click', '#popup button.close', function () {
        var e = $.fn.maskOverlay();
        if (e.find('div.absolute:visible').length > 1) {
            e.find('div.alert').fadeOut();
        } else {
            $.fn.maskOverlay(false);
            e.hide().find('div.absolute').fadeOut();
        }
    });

    // Kiểm tra dữ liệu không được rỗng 
    $(document).on('keyup', '.checkEmpty', function () {
        $(this).inputCheck(this.value ? true : false);
    });

    // Kiểm tra email hợp lệ
    $(document).on('keyup', 'input.checkEmail', function () {
        isCheck = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(this.value);
        $(this).inputCheck(isCheck);
    });

    // Kiểm tra phone hợp lệ
    $.fn.inputValue('input.checkPhone', function (e) {
        flag = false;
        if (/^\d*$/.test(e.value)) {
            if (/^0?((3|5|7|8|9)\d{8}|2\d{9})$/.test(e.value)) {
                flag = true;
            }
            $(e).inputCheck(flag);
            return true;
        }
        $(e).inputCheck(flag);
        return false;
    });

    // Kiểm tra username hợp lệ
    $(document).on('keyup', '.checkUsername', function () {
        isCheck = /^[A-z0-9]{5,32}$/.test(this.value);
        $(this).inputCheck(isCheck);
    });

    // Kiểm tra mật khẩu hợp lệ
    $(document).on('keyup', 'input.checkPassword', function () {
        isCheck = /^\S{6,}$/.test(this.value);
        $(this).inputCheck(isCheck);
    });

    // Kiểm tra mật khẩu hợp lệ
    $(document).on('keyup', 'input.confirmPassword', function () {
        password = $(this).closest('form').find('input.checkPassword').val();
        isCheck = this.value == password ? true : false;
        $(this).inputCheck(isCheck);
    });

    // Chỉ cho phép nhập số
    $.fn.inputValue('input.checkNumeric', function (e) {
        return /^((\d*)\.?(\d*))+$/.test(e.value);
    });

    // Chỉ cho phép nhập số và định dạng 
    $.fn.inputValue('input.formatNumeric', function (e) {
        if (num = $.fn.getNumeric(e.value)) {
            return num.replace(/^0+/, "").toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
        }
        return false;
    });

    /*===================BUILD SELECT HTML=============================*/
    // Building value select
    $.fn.buildingSelect = function (e) {
        var tagLi = '';
        var first = '';
        if (checked = $(e).attr('data-selected')) {
            $(e).find('option[value="' + checked + '"]').prop('selected', true);
        }
        $(e).addClass('hidden').find('option').each(function () {
            if (!first) {
                first = $(this).text();
            } else {
                if ($(this).prop('selected')) {
                    first = $(this).text();
                }
            }
            tagLi += '<li data-value="' + $(this).val() + '">' + $(this).text() + '</li>'
        });
        newSelect = '<div id="' + $.fn.strRandom(5) + '" class="ct_select"><div class="arrow-down">';
        if ($(e).attr('data-filter') == 'true') {
            newSelect += '<input type="text" value="' + first + '" class="input full" placeholder="Tìm kiếm...">';
        } else {
            newSelect += '<button type="button" class="input full alignleft">' + first + '</button>';
        }
        newSelect += '</div><ul class="scrollbarY">' + tagLi + '</ul>';
        $(newSelect).insertAfter(e);
    }
    // Restore value select
    $.fn.retoreSelect = function (eId) {
        if (eId !== false) {
            e = $('#' + eId);
            e.find('input.input').val(e.find('input.input').attr('data-cv')).removeAttr('data-cv');
            e.find('ul').slideUp('fast');
        }
    }
    var buildSelect = $(document).find('select.select');
    if (buildSelect.length > 0) {
        $.each(buildSelect, function () {
            $.fn.buildingSelect(this);
        });
    }
    // Hiển thị danh sách Select
    var sltv = false;
    $(document).on('click, focus', 'div.ct_select div.arrow-down', function () {
        $.fn.retoreSelect(sltv);
        sltv = $(this).closest('div.ct_select').attr('id');
        $('div.ct_select ul').hide();
        $(this).find('input').attr('data-cv', $(this).find('input').val()).val('');
        $(this).next('ul').slideDown('fast').find('li').show();
    });
    // Tìm giá trị thích hợp
    $(document).on('keyup', 'div.ct_select div.arrow-down input', function (e) {
        var value = $(this).val().toLowerCase();
        if (value) {
            $(this).closest('div.ct_select').find('ul li').filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        }
    });
    // Chọn giá trị trong danh sách Select
    $(document).on('click', 'div.ct_select ul li', function () {
        sltv = false;
        var parent = $(this).closest('.ct_select');
        parent.find('ul li').removeClass('active');
        text = $(this).addClass('active').text();
        if (parent.find('button').length > 0) {
            parent.find('button').text(text);
        } else {
            parent.find('input.input').val(text).removeAttr('data-cv');
        }
        parent.prev().find('option[value="' + $(this).attr('data-value') + '"]').prop('selected', true);
        $(this).closest('ul').slideUp('fast');
    });
    // Đóng danh sách Select
    $(document).on('click', function (e) {
        var container = $("div.ct_select");
        if (!container.is(e.target) && container.has(e.target).length === 0) {
            $.fn.retoreSelect(sltv);
            sltv = false;
        }
    });
    /*===================//END=============================*/
});