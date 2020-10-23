// ====================IMPORT CONTROL==========================	
// VIEW FORM
$('#main').on('click', '.theme-list.import li a', function(){
	id = $(this).attr('data-id');
	if(id && $.isNumeric(id)){
		ajaxPost(setUrl('import', 'detail'),formData({'id': id}), function(responsive){
			if(responsive.code == 200){
				viewIconsHeader('back');
				viewList(false).append(responsive.theme);
			}else{
				popupAlert(true, responsive.message);
			}
		});
	}
	return false;
});
// CONFIRM
$('#main').on('submit', '.theme.import .form.confirmimport', function(){		
	if(data = formData(this)){
		data.set('amount', getNumeric(data.get('amount')));;
		popupConfirm(true, message.confirm, function(){
			ajaxPost(
				setUrl('import', 'confirm'),data,
				function(responsive){	
					popupConfirm(false);
					if(responsive.code == 200){						
						viewIconsHeader('back');
						updateRows(responsive.id, responsive.rows);
						viewList(false).append(responsive.detail);
					}else{
						popupAlert(true, responsive.message);
					}
				}
			);
		});
	}else{
		popupAlert(true, message.require);
	}		
	return false;
});