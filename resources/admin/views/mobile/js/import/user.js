// ====================USER CONTROL==========================

// LOGIN====================	
// Thực hiện đăng nhập
$('#main .login').on('submit', 'form', function(){	
	email = $(this).find('input[name="email"]').attr('data-check');
	password = $(this).find('input[name="password"]').attr('data-check');
	if(email && password && (email == 'true') && (password == 'true')){
		return true;
	}
	return false;
});
// ADD====================
$('#main .menu .clsUser + ul').on('click', 'a.add', function(){	
	data = {onpage : currentPage('clsUser')};
	ajaxPost(setUrl('user', 'add'),formData(data),function(responsive){
		if(data.onpage == true){
			viewMenuLeft(false);
			if(responsive.code == 200){						
				viewIconsHeader('back');
				viewList(false).append(responsive.form);		
			}else{
				popupAlert(true, responsive.message);
			}
		}
	});
	return (data.onpage?false:true);
});
$('#main').on('submit', '.theme.user .form.add', function(){		
	data = formData(this);
	if(data){
		popupConfirm(true, message.confirm, function(){
			ajaxPost(setUrl('user', 'add'),data,function(responsive){
				popupAlert(true, responsive.message);
				if(responsive.code == 200){
					beforeRows(responsive.rows);
					viewList(false).append(responsive.permission);
				}
			});
		});
	}else{
		popupAlert(true, message.require);
	}
	return false;
});
// DETAIL====================
$('#main .theme-list.user').on('click', 'ul li a', function(){
	if((id = $(this).attr('data-id')) && $.isNumeric(id)){			
		ajaxPost(setUrl('user', 'detail'),formData({id: id}),function(responsive){
			if(responsive.code == 200){
				viewIconsHeader('back, right');
				viewList(false).append(responsive.detail);			
			}else{
				popupAlert(true, responsive.message);
			}
		});
	}
	return false;
});
// DELETE
$('#main .menu-right').on('click', '.user-delete', function(){
	viewMenuRight(false);		
	popupConfirm(true, message.confirm, function(){
		ajaxPost(setUrl('user', 'delete'),{}, function(responsive){
			popupConfirm(false);
			if(responsive.code == 200){				
				deleteRows(responsive.id);
				$('#header .icons button.bars-back').click();
			}else{
				popupAlert(true, responsive.message);
			}
		});
	});
});	
// PERMISSION VIEW
$('#main .menu-right').on('click', '.user-permission', function(){		
	ajaxPost(setUrl('user', 'permission'), formData({'get': 'true'}),function(responsive){
		viewMenuRight(false);	
		if(responsive.code == 200){
			viewIconsHeader('back');
			viewList(false).append(responsive.permission);		
		}else{
			popupAlert(true, responsive.message);
		}			
	});
	return false;
});
// PERMISSION SET
$('#main').on('click', '.submit-permission', function(){	
	var permission = [];
	$(this).closest('.theme.user').find('.permission input[type="checkbox"]:checked').each(function(index, value){
		permission[index] = $(value).val();
	});
	if(permission){		
		popupConfirm(true, message.confirm, function(){
			ajaxPost(
				setUrl('user', 'permission'),
				formData({
					'set': 'true', 
					'permission': permission
				}),
				function(responsive){						
					viewMenuRight(false);	
					popupAlert(true, responsive.message);			
				}
			);
		});
	}else{
		popupAlert(true, message.permission);
	}
	return false;
});
// CHOOSE PERMISSION
$('#main').on('click', '.label.parent-permission', function(){
	checked = ($(this).find('input:checked').length>0)?true:false;
	element = $(this).closest('li').find('div');		
	if(element.length>0){
		$(element).find('input[type="checkbox"]').each(function(){				
			$(this).prop('checked', checked);
		});
	}
});
// VIEW FORM CHANGE PASSWORD
$('#main .menu').on('click', 'a.changepassword', function(){
	viewMenuLeft(false);
	getPopup('password', true);
	return false;
});
// CHANGE PASSWORD
$('#popup').on('submit', '.absolute.password form', function(){		
	if(data = formData(this)){			
		popupConfirm(true, message.confirm, function(){
			ajaxPost(setUrl('user', 'changePassword'), data, function(responsive){
				popupAlert(true, responsive.message);
				if(responsive.code == 200){
					viewPopup('password', false, false);
				}
			});
		});
	}else{
		if($(this).find('input[name="password"]').val()){
			popupAlert(true, message.Invalid);
		}else{
			popupAlert(true, message.require);
		}
	}
	return false;
});
// SEARCH
$('#header .search.clsUser').on('submit', 'form', function(){
	if(data = formData(this)){
		ajaxPost(setUrl('user', 'search'), data, function(responsive){
			if(responsive.code == 200){			
				htmlRows(responsive.rows);
			}else{
				popupAlert(true, responsive.message);
			}
		});
	}
	return false;
});