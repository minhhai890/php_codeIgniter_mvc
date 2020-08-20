$( document ).ready(function() {

    // Kiểm tra giá trị tồn tại
	$.fn_isset = function(variable){
		if( typeof(variable) !== 'undefined'){
			return true;
		}
		return false;
	}

	// Trả về giá trị số trong chuỗi
	$.fn_getNumber = function(strVal){
		if(typeof strVal == 'string'){
			return strVal.replace(/\D/g, '');		
		}
		return false;
	}

	// Trả về số ngày xác định từ from đến to
	$.fn_getDay = function(from, to){
		return Math.ceil((to - from) / 86400);
	}

	// Chuyển đối tượng mảng thàng chuỗi thuộc tính cho thẻ Tag
	$.fn_convertAttr = function(obj){
		var str = '';
		if(typeof obj == 'object'){		
			$.each(obj, function(name, value){
				str += name + '="'+ value +'" ';
			});
		}
		return str;
	}

	// Hàm sao chép đoạn văn bản
	$.fn_copyText = function(text){
		var element = document.createElement('textarea');
		document.body.appendChild(element);
		element.value = text;
		element.focus();
		element.select();
		document.execCommand('Copy');
		element.remove();
	}

	// Hàm định dạn giá tiền
	$.fn_numericFormat = function(number){
		if(number){
			return number.replace(/\./g,'');
		}
		return '';
	}

	// Hàm cho phép chọn một hoặc nhiều element
	$.fn_select = function(tagElement, multiple = false){		
		if($(tagElement).attr('class') != 'empty'){
			if(multiple == false){
				var offsetParent = tagElement.offsetParent.className;
				offsetParent = '.' + offsetParent.replace(' ', '.');
				$(offsetParent + ' ' + $(tagElement).prop("tagName")).removeClass('selected');
			}
  			if( $(tagElement).attr('class') == 'selected' ){
				$(tagElement).removeClass('selected');
			}else{
				$(tagElement).addClass('selected');
			}
  		}  	
	}

	// Hàm kiểm tra email hợp lệ
	$.fn_isEmail = function(email){
		if(email){
			if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)){
		    	return true;
		  	}
		}
		return false;
	}

	// Hàm kiểm tra mật khẩu hợp lệ
	$.fn_isPassword = function(password){
		if(password){
			if (/^\S{6,}$/.test(password)){
		    	return true;
		  	}
		}
		return false;
	}

	// Hàm kiểm tra username hợp lệ
	$.fn_isUsername = function(username){
		if(username){
			if (/^[A-z0-9]{5,}$/.test(username)){
		    	return true;
		  	}
		}
		return false;
	}

	// Hàm hiển thị loading khi xử lý ajax
	$.fn_loading = function(display = true){
		var top = '-100%';
		if(display == true){
			top = '0';			
		}		
		$('#page-preloader').css({
			'background':'transparent',
			'transition':'none',
			'-webkit-transform': 'translate3d(0, '+top+', 0)',
			'transform': 'translate3d(0, '+top+', 0)'
		});	
	}

	// Hàm hiển thị popup thông báo
	$.fn_alert = function(display = true, content = ''){		
		if(display == true){
			$(document.activeElement).addClass('alert_auto_focus');
			$('#popup').show().find('.alert').show().find('.content p').text(content);
			$('#popup .alert .closePopup').focus();
		}
		if(display == false){	
			$('#popup').hide().find('.alert').hide().find('.content p').text('');			
			$('.alert_auto_focus').removeClass('alert_auto_focus').focus();
		}
	}

	// Hàm hiển thị popup confirm
	$.fn_confirm = function(display = true, attrObj = {}, content = ''){
		if(display == true){
			$(document.activeElement).addClass('alert_auto_focus');
			$('#popup').show().find('.confirm').show().find('.content p').text(content);
			if(Object.keys(attrObj).length > 0){
				if($.fn_isset(attrObj.class)){
					attrObj.class = 'control ' + attrObj.class;
					$('#popup .confirm .control').attr('class', attrObj.class);
					delete attrObj.class;
				}
				if(Object.keys(attrObj).length > 0){
					$('#popup .confirm .control .continue').attr(attrObj).focus();
				}else{
					$('#popup .confirm .control .continue').focus();
				}
			}	
		}
		if(display == false){
			$('#popup').hide().find('.confirm').hide().find('.content p').text('');
			$('.alert_auto_focus').removeClass('alert_auto_focus').focus();			
		}		
	}

	$.fn.inputFilter = function(inputFilter) {
	    return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function() {
	      if (inputFilter(this.value)) {
	        this.oldValue = this.value;
	        this.oldSelectionStart = this.selectionStart;
	        this.oldSelectionEnd = this.selectionEnd;
	      } else if (this.hasOwnProperty("oldValue")) {
	        this.value = this.oldValue;
	        this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
	      } else {
	        this.value = "";
	      }
	    });
	  };
	// Hàm xóa dấu chấm
	$.fn_removeDot = function(str) {
        return (str ? str.replace(/[\D\s\._\-]+/g, '') : '')
    }
	
	// Kiểm tra độ dài của input hoặc texteara
	$('body').on('keyup', '.checkMaxLength', function(){
		$.fn_checkMaxLength(this);
	});
	$.fn_checkMaxLength = function(event, classView = 'checkMaxLengthView'){
		var inmax = $(event).attr('maxlength');
		var text = $(event).attr('data-text');
		var inval = $(event).val();
		if(inmax){
			$(event).closest('.form_group').find('.'+classView).text(((inval)?inval.length:0) +'/'+ inmax +' '+ (text?text:''));
		}
	}
	$('body').on('keyup', '.checkMaxLength1', function(){
		$.fn_checkMaxLength(this, 'checkMaxLengthView1');
	});
	$('body').on('keyup', '.checkMaxLength2', function(){
		$.fn_checkMaxLength(this, 'checkMaxLengthView2');
	});
	
	// Hàm chỉ cho nhập số
	$.fn_inputnumber = function(event){
		var theEvent = event || window.event;
		var keycode = String.fromCharCode(event.keyCode ? event.keyCode : event.which);	
		var regex = /[0-9]|\,/;
		if( !regex.test(keycode) ) {
			theEvent.returnValue = false;			
			theEvent.preventDefault();			
		}	
		return keycode;	
	}
	// Hàm chỉ cho nhập số
	$.fn_inputformatprice = function(numeric, ditance){	
		if(numeric){			
			numeric = numeric.toString();
			numeric = numeric.replace(/[^0-9]/g, '');	
			numeric = parseFloat(numeric);	
			numeric = numeric.toString();
			if(numeric.length<12){
				var pattern = /(-?\d+)(\d{3})/;
			    while (pattern.test(numeric)){
			    	numeric = numeric.replace(pattern, "$1" + ditance + "$2");
			    }
			    return numeric;
			}		    
		}
	    return '';
	}
	// Chỉ cho nhập số
	$('body').on('keypress', '.v-numeric', function(event){
		$.fn_inputnumber(event);
	});
	// Định dạng số tiền
	$('body').on('keypress', '.v-numericprice', function(event){
		var keycode = $.fn_inputnumber(event);
		if($.isNumeric(keycode)){			
			var result = $.fn_inputformatprice($(event.target).val() + keycode, ',');
			if(result){
				$(this).val(result.substr(0,(result.length-1)));
			}else{
				event.returnValue = false;			
				event.preventDefault();
			}
		}
	});
	// Định dạng số tiền
	$('body').on('keyup', '.v-numericprice', function(event){		
		if((event.keyCode ? event.keyCode : event.which)==8){			
			$(this).val($.fn_inputformatprice($(this).val(), ','));
		}		
	});
	
	// Trả về giá trị chuỗi
	function getString(string){	
		if(typeof string == 'string'){
			return string.replace(/[^A-z]+/g, '');		
		}
		return false;
	}

	// Hàm trả về chuỗi in hoa chữ cái đầu tiên
	function capitalizeFirstLetter(string) {
		return string.charAt(0).toUpperCase() + string.slice(1);
	}

	// Hàm trả về giá trị cookie
	function getCookie(name){	
		var match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
		if (match) return match[2];
	}
	
	// Thiết lập đường dẫn url xử lý ajax
	function setUrl(control, action, prefix = 'Ajax'){		
		url = $('base').attr('href');
		if(url){
			return url + '/api/v1/' + capitalizeFirstLetter(control) + '/' + action + prefix
		}
		return '';
	}
	
	// Hàm xử lý ajax post
	function ajaxPost(url, data, call = null, loading = true, uploadFile = false){	
		var params = {
			url: url,				
			cache: false,
			type: "post",
			data: data,
			async: true,
			dataType: 'json',
			beforeSend: function() {
				$.fn_loading(loading);
			},
			complete: function() {
				if(loading == true){				
					$.fn_loading(false);
				}
			},
			success:function(result){				
				if(typeof(call) == 'function'){
					return call(result);					
				}					
			}					
		};
		if(uploadFile == true){
			params.contentType = false;
			params.processData = false;        	
		}		
		$.ajax(params);		
	}

	// Hàm kiểm tra input hợp lệ
	$.fn_check = function(event, check){
		var eltParent = $(event).closest('div');
		$(eltParent).find('i').remove();
		if(check == true){		
			$(event).attr('data-check', true);	
			$(eltParent).append('<i class="fa fa-check" aria-hidden="true"></i>');
		}else{
			$(event).attr('data-check', false);	
			$(eltParent).append('<i class="fa fa-times" aria-hidden="true"></i>');
		}
	}

	// Kiểm tra email hợp lệ
	$('form').on('keyup', '.checkEmail', function(){
		var strVal = $(this).val();
		if(strVal){
			$.fn_check(this, $.fn_isEmail(strVal));
		}
	});

	// Kiểm tra dữ liệu không được rỗng
	$('form').on('keyup','.checkEmpty', function(){
		var strVal = $(this).val();
		$.fn_check(this, (strVal)?true:false);
	});

	// Kiểm tra username hợp lệ
	$('form').on('keyup','.checkUsername', function(){	
		var strVal = $(this).val();
		var input = this;		
		if($.fn_isUsername(strVal)){			
			ajaxPost(
				setUrl('main', 'checkUsername'), 
				{'username': strVal}, 
				function(result){
					$.fn_check(input, result.flag);
				}, 
				false
			);				
		}else{
			$.fn_check(input, false);
		}
	});

	// Kiểm tra mật khẩu hợp lệ
	$('form').on('keyup','.checkPassword', function(){		
		$.fn_check(this, $.fn_isPassword($(this).val()));
	});

	// Kiểm tra mật khẩu trùng khớp
	$('form').on('keyup','.confirmPassword', function(){
		var password = $(this).closest('form').find('input[name="password"]').val();		
		$.fn_check(this, ((password == $(this).val())?true:false));
	});

	// Cho phép nhập dữ liệu phải là số	
	$("input.checkNumeric").inputFilter(function(value) {
	   return /^\d*$/.test(value);
	});
	
	// Đóng popup
	$('#popup').on('click','.closePopup', function(){
		if($(this).attr('data-condition') == 'autologin'){
			window.location.href = $('#autologin').attr('href');	
		}else{
			$('#popup').hide().find('.pstabsolute').hide().find('.content p').text('');
			$('.alert_auto_focus').removeClass('alert_auto_focus').focus();
		}		
	});

	/*=====================================================*/
	/*						Contact form    				*/

	$('#contact-form').submit(function(){
		var conname = $(this).find('input[name="conname"]').val();
		var conemail = $(this).find('input[name="conemail"]').val();
		var conphone = $(this).find('input[name="conphone"]').val();
		var conmessage = $(this).find('textarea[name="conmessage"]').val();		
		if(conname && conemail && conphone && conmessage && $.fn_isEmail(conemail)){
			ajaxPost(
				setUrl('main', 'contact'), 
				{
					'conname':conname,
					'conemail':conemail,
					'conphone':conphone,
					'conmessage':conmessage
				}, 
				function(result){
					if(result.flag == true){
						$('#contact-form .checkinput i').remove();
						$('#contact-form')[0].reset();
					}
					$.fn_alert(true, result.error);
				}
			);
		}else{
			$.fn_alert(true, 'Bạn vui lòng nhập đầy đủ thông tin!');
		}
		return false;
	});

	/*=====================================================*/
	/*						Register form    				*/

	// Thay đổi thời gian sử dụng
	$('div.checkout-cart-total .select').change(function(){
		var month = $(this).val();
		if(month && $.isNumeric(month)){
			ajaxPost(
				setUrl('main', 'changeMonth'), 
				{'month':month}, 
				function(result){
					if(result.flag == true){
						var vnd = '<sup>đ</sup>';
						$('div.checkout-cart-total .checkout-sale span').html(result.sale+'<sup>%</sup>');
						$('div.checkout-cart-total .checkout-total span').html(result.total+'<sup>đ</sup>');
					}else{
						window.location.reload();
					}
				},
				false
			);
		}

	});

	// Chọn sử dụng miễm phí
	$('div.checkout-cart-free input').change(function(){		
		if($(this)[0].checked){
			var freeVnd = '<sup>0đ</sup>';
			$('div.checkout-cart-total .select option').addClass('hidden');
			$('div.checkout-cart-total .select option[value="0"]').removeClass('hidden').get(0).selected = true;
			$('div.checkout-cart-total .checkout-sale span').html('0<sup>%</sup>');
			$('div.checkout-cart-total .checkout-total span').html('0<sup>đ</sup>');
		}else{
			$('div.checkout-cart-total .select option').removeClass('hidden');
			$('div.checkout-cart-total .select option[value="0"]').addClass('hidden').removeAttr('selected');
			$('div.checkout-cart-total .select option[selected="selected"]').get(0).selected = true;
			$('div.checkout-cart-total .select').change();
		}
	});

	// Thực hiện quá trình đăng ký mới
	$('form.checkout-form').on('submit', function(){
		var uname = $(this).find('input[name="name"]').val();
		var uemail = $(this).find('input[name="email"]').val();
		var uphone = $(this).find('input[name="phone"]').val();
		var sname = $(this).find('input[name="storename"]').val();		
		var upassword = $(this).find('input[name="password"]').val();		
		var month = $(this).find('select option:selected').val();
		if(uname && uemail && uphone && sname && month && upassword){
			ajaxPost(
				setUrl('main', 'register'),
				{
					'uname':uname,
					'uemail':uemail,
					'uphone':uphone,
					'sname':sname,
					'month':month,
					'upassword': upassword
				}, 
				function(result){
					if(result.flag == true){
						$('form.checkout-form').get(0).reset();
					}
					$.fn_alert(true, result.error);
				}
			);
		}else{
			$.fn_alert(true, 'Bạn vui lòng nhập đầy đủ thông tin.');
		}	
		return false;
	});

	// Thực hiện quá trình tạo mới tài khoản
	$('div.login-form-wrapper form').on('submit', function(){		
		var password = $(this).find('input[name="password"]').val();		
		if(password){
			if($.fn_isPassword(password)){
				if($(this).find('input.confirmPassword').attr('data-check') != 'true'){
					$.fn_alert(true, 'Mật khẩu không trùng khớp.');
				}else{		
					ajaxPost(		
						setUrl('main', 'confirm'),						
						{'password':password}, 
						function(result){
							$.fn_alert(true, result.error);
							if(result.flag == true){
								$('#popup .alert .closePopup').attr('data-condition','autologin');
								$('div.login-form-wrapper form').get(0).reset();
							}	
						}
					);					
				}
			}else{
				$.fn_alert(true, 'Tên đăng nhập hoặc mật khẩu không hợp lệ.');
			}			
		}else{
			$.fn_alert(true, 'Bạn vui lòng nhập đầy đủ thông tin.');
		}	
		return false;
	});
    
});