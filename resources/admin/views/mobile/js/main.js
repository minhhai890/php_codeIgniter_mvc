// FUNCTION DEFAULT=======================
$('#main .menu-right .content ul li a.space').closest('li').css({ 'margin-top': '15px', 'border-top': '1px solid #E8E8E8' });
// Hàm kiểm tra input hợp lệ
$.fn.inputCheck = function (check) {
	var eltParent = $(this).closest('div');
	$(eltParent).find('i').remove();
	$(this).attr('data-check', check);
	if (check == true) {
		$(eltParent).append('<i class="fa fa-check" aria-hidden="true"></i>');
	} else {
		if (!$(this).val()) {
			if ($(this).attr('data-require') == 'true') {
				$(eltParent).append('<i class="fa fa-times" aria-hidden="true"></i>');
			}
		} else {
			$(eltParent).append('<i class="fa fa-times" aria-hidden="true"></i>');
		}
	}
}

// input requirer
function inputRequire() {
	$('.checkinput [data-require="true"]').each(function () {
		if ($(this).val()) {
			$(this).inputCheck(true);
		} else {
			$(this).inputCheck(false);
			$(this).next('i').remove();
		}
	});
	$('.checkinput [data-require="true"]').closest('div').find('label').addClass('require');
}

// Trả về value trước khi nhập
$.fn.inputValue = function (clselement, call) {
	return this.on("input keyup", clselement, function () {
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

// Trả về giá trị số trong chuỗi
function getNumeric(string) {
	if (typeof string == 'string') {
		return string.replace(/\D/g, '');
	}
	return false;
}

// Trả về giá trị chuỗi
function getString(string) {
	if (typeof string == 'string') {
		return string.replace(/[^A-z]+/g, '');
	}
	return false;
}

// FORMAT DATE
function formatDate(second) {
	if (second = parseInt(second)) {
		date = new Date(parseInt(second) * 1000);
		return date.getDate() + '/' + (date.getMonth() + 1) + '/' + date.getFullYear();
	}
}

// Hàm trả về một chuỗi ký tự ngẫu nhiên
function strRandom(length) {
	var result = '';
	var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
	var charactersLength = characters.length;
	for (var i = 0; i < length; i++) {
		result += characters.charAt(Math.floor(Math.random() * charactersLength));
	}
	return result;
}

// Hàm sao chép đoạn văn bản
function strCopy(string) {
	var element = document.createElement('textarea');
	document.body.appendChild(element);
	element.value = string;
	element.focus();
	element.select();
	document.execCommand('Copy');
	element.remove();
}

// Hàm xóa dấu chấm
function removeDot(str) {
	return (str ? str.replace(/[\D\s\._\-]+/g, '') : '');
}

// Hàm trả về chuỗi in hoa chữ cái đầu tiên
function capitalizeFirstLetter(string) {
	return string.charAt(0).toUpperCase() + string.slice(1);
}

// Hàm trả về giá trị cookie
function getCookie(name) {
	var match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
	if (match) return match[2];
}

// Thiết lập đường dẫn url xử lý ajax
function setUrl(control, action, prefix = '') {
	url = $('base').attr('href');
	if (url) {
		return url + '/api/v1/' + capitalizeFirstLetter(control) + '/' + action + prefix;
	}
	return '';
}

// Hàm thay đổi url mà không load lại trang
function changeUrl(url) {
	history.pushState({}, null, url);
}

// Hàm xử lý ajax post
function ajaxPost(url, data = {}, call = null, loading = true) {
	var settings = {
		'url': url,
		'method': 'POST',
		'timeout': 0,
		'headers': {},
		'processData': false,
		'mimeType': 'json',
		'cache': false,
		'contentType': false,
		'async': false,
		'data': data,
		'beforeSend': function (event) {
			if (loading) {
				popupLoading(loading);
				event.done(function () {
					popupLoading(false);
				});
			}
		}
	};
	$.ajax(settings).done(function (responsive) {
		if (typeof (call) == 'function') {
			call(responsive);
			inputRequire();
			autofocus();
		}
	});
}

// Auto focus
function autofocus() {
	$('body').find('[data-autofocus="true"]:visible').focus();
}

// Hàm reset form
function resetForm(selector) {
	if (selector) {
		$(selector).trigger("reset");
		$(selector).find('i.fa, i.fas').remove();
		autofocus();
	}
}

// Hàm hiển thị popup hoặc ẩn popup
function getPopup(name) {
	ajaxPost(setUrl('modal', 'get'), formData({ 'name': name }), function (responsive) {
		if (responsive.code == 200) {
			$('#popup .relative').append(responsive.template);
			viewPopup(name, true);
		}
	}, false);
	return '#popup .absolute.' + name;
}

// Hàm hiển thị hoặc ẩn popup
function viewPopup(name, display, all = true) {
	if (display == true) {
		cls = ((name == 'loading' && all === true) ? 'fixed' : 'fixed bgcolor');
		$('#popup').attr('class', cls).show().find('.absolute.' + name).show();
		$('#popup .absolute.auto.' + name).append('<button class="btnclose"><i class="fas fa-times"></i></button>');
		resetForm($('#popup .absolute.' + name + ' form'));
	} else {
		if (all == false) {
			$('#popup .absolute.' + name).hide();
			$('#popup .absolute.auto.' + name).remove();
		} else {
			$('#popup').hide().find('.absolute').hide();
			$('#popup .absolute.auto').remove();
		}
	}
	return '#popup .absolute.' + name;
}

// Popup loading
function popupLoading(display) {
	closeAll = ($('#popup .absolute:visible').length > (display ? 0 : 1)) ? false : true;
	viewPopup('loading', display, closeAll);
}

// Popup Alert
function popupAlert(display, content = '') {
	if (display == true) {
		element = '#popup .absolute.alert';
		$(element).find('.content p').html(content);
		$(document.activeElement).addClass('alert_auto_focus');
		$(element).find('.control .popupClose').focus();
	} else {
		viewPopup('confirm', display, false);
		$('.alert_auto_focus').removeClass('alert_auto_focus').focus();
	}
	viewPopup('alert', display, ($('#popup').find('.absolute:visible').length > 1 ? false : true));
}

// Popup Confirm	
function popupConfirm(display, content = '', call = null) {
	var element = viewPopup('confirm', display, ($('#popup').find('.absolute:visible').length > 1 ? false : true));
	$(element).find('.content p').html(content);
	$(element).find('.control .continue').focus();
	if (typeof (call) == 'function') {
		newClass = strRandom(5);
		$(element).find('.control').addClass('control ' + newClass);
		$(element).on('click', '.control.' + newClass + ' .continue', function () {
			$(element).find('.control').removeClass(newClass);
			return call();
		});
	}
}

// Hiển thị icon header vd:viewIconsHeader('left, search')
function viewIconsHeader(icon) {
	if (icon) {
		$('#header .icons button').addClass('hidden');
		$.each(icon.split(','), function () {
			$('#header .icons button.bars-' + this.trim()).removeClass('hidden');
		});
		$('#header .search').hide();
	}
}

// Hàm hiển thị hoặc đóng menu left
function viewMenuLeft(display) {
	if (display == !0) {
		$('#main .menu-left').addClass('show').find('.content').scrollTop(0).animate({ left: '0' }, 100)
	}
	if (display == !1) {
		$('#main .menu-left').find('.content').animate({ left: '-220px' }, 100);
		setTimeout(function () {
			$('#main .menu-left').removeClass('show');
		}, 100);
	}
}

// Hàm hiển thị hoặc đóng menu left
function viewMenuRight(display) {
	if (display == !0) {
		if ($('#main .menu-right .category ul').length > 0) {
			$('#main .menu-right').addClass('show').find('.content').scrollTop(0).animate({ right: '0' }, 100);
		}
	}
	if (display == !1) {
		$('#main .menu-right').find('.content').animate({ right: '-200px' }, 100);
		setTimeout(function () {
			$('#main .menu-right').removeClass('show');
		}, 100);
	}
}

// Active menuleft
function activeMenuLeft(clsname = null) {
	if (clsname == null) {
		clsname = $('#main .menu').attr('data-active');
	}
	if (clsname) {
		var selector = '#main .menu-left .category > ul > li ';
		$(selector + 'ul').slideUp();
		$(selector + 'a').removeClass('active');
		$(selector).find('.fa-chevron-down').removeClass('fa-chevron-down').addClass('fa-chevron-up');
		$(selector + 'a.' + clsname).addClass('active').find('.fa-chevron-up').removeClass('fa-chevron-up').addClass('fa-chevron-down');
		$(selector + 'a.' + clsname).next().slideToggle();
	}
	return false;
}

// Hàm trả về chuỗi selector danh sách
function themeListSelector() {
	return '#main .theme.theme-list ul';
}

// Hàm xóa một hàng dữ liệu rỗng
function removeRowEmpty() {
	$(themeListSelector() + ' li.empty').remove();
}

// Cập nhật một danh sách mới
function htmlRows(rows) {
	$(themeListSelector()).html(rows);
}

// Thêm mới một hoặc nhiều dòng vào đầu danh sách
function beforeRows(rows) {
	$(themeListSelector()).find('li:first').before(rows);
	removeRowEmpty();
}

// Thêm mới một hoặc nhiều dòng vào cuối danh sách
function appendRows(rows) {
	$(themeListSelector()).append(rows);
	removeRowEmpty();
}

// Cập nhật một dòng dữ liệu trong danh sách
function updateRows(id, row) {
	element = $(themeListSelector() + ' li a[data-id="' + id + '"]').closest('li');
	if (element.length > 0) {
		element.before(row).remove();
	}
}

// Xóa một hoặc nhiều dòng trong danh sách
function deleteRows(id) {
	if (typeof (id) == 'object') {
		$.each(id, function () {
			$(themeListSelector() + ' li a[data-id="' + this + '"]').closest('li').remove();
		});
	} else {
		$(themeListSelector() + ' li a[data-id="' + id + '"]').closest('li').remove();
	}
}

// Hiển thị hoặc ẩn danh sách
function viewList(display) {
	element = '#main .theme.theme-list';
	$(element + '+div').remove();
	if (display == true) {
		$(element).removeClass('hidden');
	} else {
		$(element).addClass('hidden');
	}
	return $(element).closest('.container');
}

// Hàm trả về giá trị input trong form
// options: tag form hoặc {name: value,...}
// params: {name: value,...}
function formData(options = null, params = null) {
	data = false;
	if ($(options).prop("tagName") == 'FORM') {
		var data = new FormData($(options)[0]);
		var notTypes = ['reset', 'submit', 'button', 'hidden'];
		$(options).find('input, textarea, select').each(function () {
			type = $(this).attr('type');
			if ($.inArray(type, notTypes) == -1) {
				value = $(this).val();
				check = $(this).attr('data-check');
				if (!value && check && check == 'false') {
					if ($(this).attr('data-require') == 'true') {
						data = false;
						return false;
					}
				} else {
					if (type == 'checkbox' || type == 'radio') {
						if (this.checked == true) {
							data.append($(this).attr('name'), value);
						}
					} else {
						data.append($(this).attr('name'), value);
					}
				}
			}
		});
		if (data && params) {
			$.each(params, function (name, value) {
				data.append(name, value);
			});
		}
	} else {
		if (typeof (options)) {
			var data = new FormData();
			$.each(options, function (name, value) {
				if ((typeof (value) === 'object' && value !== null) || Array.isArray(value)) {
					data.append(name, JSON.stringify(value));
				} else {
					data.append(name, value);
				}
			});
		}
	}
	return data;
}

// Hàm trả về true nếu là page hiện tại false ngược lại
function currentPage(name) {
	if ($('#main .menu').attr('data-active') == name) {
		return true;
	}
	return false;
}

// Hàm trả về id
function getId() {
	return $('#jsdetailid').attr('data-id');
}

// Hàm trả về cid
function getCid() {
	return $('#jsdetailid').attr('data-cid');
}

function optionSelected() {
	$('body select[data-selected]').each(function () {
		$(this).find('option[value="' + $(this).attr('data-selected') + '"]').attr('selected', 'selected');
	});
}
optionSelected();

// Nội dung thông thông báo
var message = {
	'require': 'Vui lòng nhập đầy đủ thông tin *',
	'confirm': 'Bạn có chắc chắn không?',
	'reset': 'Bạn có muốn RESET FORM nhập liệu không?',
	'permission': 'Bạn vui lòng chọn quyền cần thiết lập!',
	'Invalid': 'Dữ liệu không hợp lệ!'
};

// ==============================================

$(window).resize(function () {
	image = $('#popup .loading img');
	button = $('#popup .alert .popupClose');
	if ($(document).width() > $(document).height()) {
		image.hide();
		button.hide();
		popupLoading(true);
		popupAlert(true, 'Xin lỗi! ứng dụng chỉ sử dụng được trên màn hình dọc.');
	} else {
		popupLoading(false);
		popupAlert(false);
		image.show();
		button.show();
	}
});

// Hiển thị popup theo thuộc tính
$('body').on('click', '[data-popup]', function () {
	if (name = $(this).attr('data-popup')) {
		getPopup(name);
	}
	return false;
});

// Đóng popup
$('#popup').on('click', '.popupClose,button.btnclose', function () {
	if (!$('#popup .absolute.loading').is(':visible')) {
		if ($('#popup .absolute.alert').is(':visible')) {
			popupAlert(false);
		} else if ($('#popup .absolute.confirm').is(':visible')) {
			popupConfirm(false);
		} else {
			popupLoading(false);
		}
	}
});

// Thiết lập input data-check = false
inputRequire();
// Kiểm tra dữ liệu không được rỗng
$('body').on('keyup', '[data-require="true"]', function () {
	var strVal = $(this).val();
	$(this).inputCheck((strVal) ? true : false);
});

// Kiểm tra dữ liệu không được rỗng
$('body').on('keyup', '.checkEmpty', function () {
	var strVal = $(this).val();
	$(this).inputCheck((strVal) ? true : false);
});

// Kiểm tra email hợp lệ
$('body').on('keyup', '.checkEmail', function () {
	check = false;
	if (strVal = $(this).val()) { // Hàm kiểm tra email hợp lệ	
		if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(strVal)) {
			check = true;
		}
	}
	$(this).inputCheck(check);
});

// Kiểm tra username hợp lệ
$('body').on('keyup', '.checkUsername', function () {
	check = false;
	if (/^[A-z0-9]{5,32}$/.test($(this).val())) {
		check = true;
	}
	$(this).inputCheck(check);
});

// Kiểm tra phone hợp lệ
$("body").inputValue('input.checkPhone', function (event) {
	flag = false;
	value = $(event).val();
	if (/^\d*$/.test(value)) {
		if (/^0\d{9}$/.test(value)) {
			flag = true;
		}
		$(event).inputCheck(flag);
		return true;
	}
	$(event).inputCheck(flag);
	return false;
});

// Kiểm tra mật khẩu hợp lệ
$("body").on('keyup', 'input.checkPassword', function () {
	flag = false;
	if (value = $(this).val()) {
		flag = /^\S{6,}$/.test(value)
	}
	$(this).inputCheck(flag);
});

// Kiểm tra mật khẩu hợp lệ
$("body").on('keyup', 'input.confirmPassword', function () {
	flag = false;
	password = $(this).closest('form').find('input.checkPassword').val();
	if ($(this).val() == password) {
		flag = true;
	}
	$(this).inputCheck(flag);
});
// Cho phép nhập dữ liệu phải là số	
$("body").inputValue('input.checkNumeric', function (event) {
	return /^((\d*)\.?(\d*))+$/.test(event.value);
});

// Cho phép nhập dữ liệu phải là số	và định dạng số tiền
$("body").inputValue('input.formatNumeric', function (event) {
	if (num = getNumeric(event.value)) {
		return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
	}
	return false;
});
// Hiển thị lịch
$(document).on("focus", ".datepick", function () {
	$(".datepick").datepicker({
		'showAnim': 'slideDown',
		'dateFormat': 'dd/mm/yy'
	});
});
$(document).on("change", ".datepick", function () {
	var inputVal = $(this).val();
	if (inputVal) {
		tmp = inputVal.split('/');
		inputVal = tmp[1] + '/' + tmp[0] + '/' + tmp[2];
		if ($(this).attr('name') == 'timeto') {
			inputVal += ' 23:59:59';
		}
		$(this).attr('data-millisecond', Math.floor((new Date(inputVal).getTime()) / 1000));
	} else {
		$(this).attr('data-millisecond', '');
	}
	return !1
});

// Reset form
$('body').on('click', 'input[type="reset"]', function () {
	form = $(this).closest('form');
	popupConfirm(true, message.reset, function () {
		resetForm(form);
		popupConfirm(false);
	});
	return false;
});

// ==============================================	
// Hiển thị icon mặc định
viewIconsHeader($('#main .theme:visible').attr('data-baricon'));
// Icon back
$('#header .icons').on('click', 'button.bars-back', function () {
	viewList(true);
	viewIconsHeader('left,search');
	ajaxPost(setUrl('user', 'deleteDetail'));
});
// Hiển thị menu left
$('#header .icons').on('click', 'button.bars-left', function () {
	viewMenuLeft(true);
});
// Đóng menu left
$('#main .menu-left').on('click', '.popupClose', function () {
	viewMenuLeft(false);
});
activeMenuLeft();
$('#main .menu-left .category > ul > li > a').click(function () {
	if ($(this).next().length > 0) {
		if ($(this).attr('class').indexOf('active') == -1) {
			activeMenuLeft($(this).attr('class'));
		}
		return false;
	}
});
// Hiển thị menu right
$('#header .icons').on('click', 'button.bars-right', function () {
	viewMenuRight(true);
});
// Đóng menu right
$('#main .menu-right').on('click', '.popupClose', function () {
	viewMenuRight(false);
});
// Hiển thị input tìm kiếm
$('#header .icons').on('click', 'button.bars-search', function () {
	viewIconsHeader('back');
	$('#header .search').show().find('input').val('').focus();
});
$.each(['Bill'], function () {
	$('#header .search.cls' + this).find('button[name="setting"]').removeClass('hidden');
});
// Hiển thị danh sách
if ($('#main .theme.theme-list + div').length == 0) {
	$('#main .theme.theme-list').removeClass('hidden');
	viewIconsHeader($('#main .theme:visible').attr('data-baricon'));
}
// Lựa chọn params search
function convertDate(millisecond) {
	if (millisecond) {
		date = new Date(millisecond * 1000);
		return date.getDate() + '/' + (date.getMonth() + 1) + '/' + date.getFullYear();
	}
	return;
}
$('#searchvalue').find('input[name="column"][value="' + $('#searchvalue').attr('data-column') + '"]').prop('checked', true);
if (status = $('#searchvalue').attr('data-status')) {
	$('#searchvalue').find('input[name="status"]').each(function () {
		if (status.indexOf($(this).val()) > -1) {
			$(this).prop('checked', true);
		} else {
			$(this).prop('checked', false);
		}
	});
}
timefrom = $('#searchvalue').attr('data-timefrom');
timeto = $('#searchvalue').attr('data-timeto');
$('#searchvalue').find('input[name="timefrom"]').val(convertDate(timefrom)).attr('data-millisecond', timefrom);
$('#searchvalue').find('input[name="timeto"]').val(convertDate(timeto)).attr('data-millisecond', timeto);
// CHOOSE ADDRESS
$('#main').on('click', '.listaddress li', function () {
	parent = $(this).closest('.form-address');
	node = this.attributes[0];
	if (node) {
		$(parent).find('input').attr(node.nodeName, node.nodeValue).val($(this).text()).focus();
	}
	$(parent).find('.listaddress').remove();
});
// ADDRESS PROVINCE
$('#main').on('keyup', '.form-address input[name="province"]', function () {
	keyword = $(this).val();
	if (keyword.length > 1) {
		$(this).closest('form').find('[data-autofocus="true"]').attr('data-autofocus', 'false');
		parent = $(this).closest('.form-address');
		ajaxPost(
			setUrl('address', 'provinces'),
			formData({ 'keyword': keyword }),
			function (responsive) {
				$(parent).find('.listaddress').remove();
				if (responsive.code == 200) {
					$(parent).append(responsive.rows);
				}
			},
			false
		)
	}
});
// ADDRESS DISTRICT
$('#main').on('keyup', '.form-address input[name="district"]', function () {
	keyword = $(this).val();
	if (keyword.length > 1) {
		$(this).closest('form').find('[data-autofocus="true"]').attr('data-autofocus', 'false');
		parent = $(this).closest('.form-address');
		ajaxPost(
			setUrl('address', 'districts'),
			formData({ 'provinceid': $('input[name="province"]').attr('data-province'), 'keyword': keyword }),
			function (responsive) {
				$(parent).find('.listaddress').remove();
				if (responsive.code == 200) {
					$(parent).append(responsive.rows);
				}
			},
			false
		)
	}
});
// ADDRESS WARDS
$('#main').on('keyup', '.form-address input[name="ward"]', function () {
	keyword = $(this).val();
	if (keyword.length > 1) {
		$(this).closest('form').find('[data-autofocus="true"]').attr('data-autofocus', 'false');
		parent = $(this).closest('.form-address');
		ajaxPost(
			setUrl('address', 'wards'),
			formData({ 'districtid': $('input[name="district"]').attr('data-district'), 'keyword': keyword }),
			function (responsive) {
				$(parent).find('.listaddress').remove();
				if (responsive.code == 200) {
					$(parent).append(responsive.rows);
				}
			},
			false
		)
	}
});
// SCROLL LIST
$('#main>.scrollbarY').scroll(function () {
	element = $(this).find('.theme-list:visible');
	if (element.length > 0) {
		scroll = element.find('ul').attr('data-scroll');
		if (scroll == 'true') {
			client = $(this)[0];
			if (Math.round(client.clientHeight + client.scrollTop) == client.scrollHeight) {
				action = element.find('ul').attr('data-action');
				control = element.attr('class').replace(/theme-list|theme/gi, '').trim();
				if (control) {
					data = formData({
						'action': action,
						'begin': element.find('li').length
					});
					ajaxPost(setUrl(control, 'scroll'), data, function (responsive) {
						if (responsive.code == 200) {
							element.find('ul').attr('data-scroll', responsive.scroll).append(responsive.rows);
						}
					});
				}
			}
		}
	}
});
// CẬP NHẬT MENU RIGHT
function updateMenuRight() {
	menu = $('#main .menu');
	// Menu right bill
	if (menu.attr('data-active') == 'clsBill') {
		detail = $('#main .theme-detail');
		// Ghi chú
		if (detail.find('.notification').length > 0) {
			e = menu.find('a.bill-note').attr('class', 'bill-note-cancel').text('Hủy ghi chú');
		} else {
			e = menu.find('a.bill-note-cancel').attr('class', 'bill-note').text('Ghi chú');
		}
	}
}
updateMenuRight();
// VIEW POPUP SEARCH
$('#header .search').on('click', 'button[name="setting"]', function () {
	if (element = getPopup('search', true)) {
		if ($(element).length > 0) {
			element = $(element).find('.content');
			element.find('input[name="column"][value="' + element.attr('data-column') + '"]').prop('checked', true);
			if (status = element.attr('data-status')) {
				$.each(status.split(','), function () {
					element.find('input[name="status"][value="' + this + '"]').prop('checked', true);
				});
			}
			timefrom = element.attr('data-timefrom');
			element.find('input[name="timefrom"]').attr({ 'data-millisecond': timefrom, 'value': formatDate(timefrom) });
			timeto = element.attr('data-timeto');
			element.find('input[name="timeto"]').attr({ 'data-millisecond': timeto, 'value': formatDate(timeto) });
		}
	}
});
// SET PARAMS SEARCH
$('#popup').on('submit', '.search form', function () {
	element = $(this).closest('.search');
	column = $(element).find('input[name="column"]:checked').val();
	var status = [];
	$(element).find('input[name="status"]:checked').each(function (key, elm) {
		status[key] = $(elm).val();
	});
	var timefrom = $(element).find('input[name="timefrom"]').attr('data-millisecond');
	var timeto = $(element).find('input[name="timeto"]').attr('data-millisecond');
	if (column && status) {
		data = formData({ 'column': column, 'status': status, 'timefrom': timefrom, 'timeto': timeto });
		ajaxPost(setUrl('setting', 'searchParams'), data, function (responsive) {
			if (responsive.code == 200) {
				viewPopup('search', false);
			} else {
				popupAlert(true, responsive.message);
			}
		});
	} else {
		popupAlert(true, message.require);
	}
	return false;
});
