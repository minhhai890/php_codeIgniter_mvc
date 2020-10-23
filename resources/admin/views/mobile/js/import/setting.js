// ====================SETTING CONTROL==========================
// SET INFORMATION
$('#main').on('click', '.theme.setting .setinfo', function(){		
	var data = formData($(this).closest('form'));	
	data.append('note1', CKEDITOR.instances.note1.getData());
	data.append('note2', CKEDITOR.instances.note2.getData());
	popupConfirm(true, message.confirm, function(){
		ajaxPost(setUrl('setting', 'info'),data,function(responsive){
			popupAlert(true, responsive.message);
		});
	});
	return false;
});
// SET PRINT
$('#main').on('click', '.theme.setting .setprint', function(){
	var data = formData($(this).closest('form'));
	popupConfirm(true, 'Bạn có chắc chắn không?', function(){
		ajaxPost(setUrl('setting', 'print'),data,function(responsive){
			popupAlert(true, responsive.message);
		});
	});
	return false;
});
// SET POST
$('#main').on('click', '.theme.setting .setpost', function(){
	var data = formData($(this).closest('form'));
	popupConfirm(true, message.confirm, function(){
		ajaxPost(setUrl('setting', 'post'),data,function(responsive){
			popupAlert(true, responsive.message);
		});
	});
	return false;
});
// SEARCH
$('#header .search.clsSetting').on('submit', 'form', function(){	
	return false;
});