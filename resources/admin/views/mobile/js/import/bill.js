// ====================BILL CONTROL==========================
// VIEW FORM ADD
$('#main .menu .clsBill + ul').on('click', 'a.add', function(){		
	data = {onpage : currentPage('clsBill')};		
	ajaxPost(setUrl('bill', 'add'),formData(data),function(responsive){
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
// SET FORM ADD
$('#main').on('submit', '.theme-form.bill form.add', function(){
	data = formData(this);
	if(data){
		data.append('provinceid', $(this).find('[data-province]').attr('data-province'));
		data.append('districtid', $(this).find('[data-district]').attr('data-district'));
		data.append('wardid', $(this).find('[data-ward]').attr('data-ward'));
		if(data){
			popupConfirm(true, message.confirm, function(){
				ajaxPost(setUrl('bill', 'add'),data, function(responsive){
					popupConfirm(false);
					if(responsive.code == 200){						
						viewIconsHeader('back, right');
						beforeRows(responsive.rows);
						viewList(false).append(responsive.detail);
					}else{
						popupAlert(true, responsive.message);
					}
				});
			});
		}
	}else{
		popupAlert(true, message.require);
	}		
	return false;
});
// VIEW POPUP FB UID
$('#main').on('click', '.get-uid', function(){
	getPopup('uid', true);
	return false;
});
// GET FB UID
$('#popup').on('click', '.absolute.uid input[name="get-uid"]', function(){		
	parent = $(this).closest('form');
	data = formData(parent);		
	if(data){			
		ajaxPost(setUrl('facebook', 'getUid'),data, function(responsive){
			if(responsive.code == 200){
				$(parent).find('.result').html('<p class="success">'+responsive.uid+'</p>');
				$(parent).find('input[name="get-uid"]').attr({'name': 'use-uid', 'value': 'Sử dụng UID'});
			}else{
				$(parent).find('.result').html('<p class="error">'+responsive.message+'</p>');
			}				
		});
	}		
	return false;
});
// USE FB UID
$('#popup').on('click', '.absolute.uid input[name="use-uid"]', function(){
	uid = $(this).closest('form').find('.result p').text();
	if(uid){
		viewPopup('uid', false);
		$('#popup .absolute.uid .result p').remove();
		$('#popup .absolute.uid input[name="use-uid"]').attr({'name': 'get-uid', 'value': 'Thực hiện'});
		$('#main input[name="profileid"]').val(uid).focus();
	}
	return false;
});
// VIEW BILL DETAIL
$('#main').on('click', '.theme-list.bill li a', function(){
	id = $(this).attr('data-id');
	if(id && $.isNumeric(id)){
		ajaxPost(setUrl('bill', 'detail'),formData({'id': id}), function(responsive){
			if(responsive.code == 200){
				viewIconsHeader('back, right');
				viewList(false).append(responsive.detail);
				updateMenuRight();
			}else{
				popupAlert(true, responsive.message);
			}
		});
	}
	return false;
});
// VIEW BILL EDIT
$('#main .menu-right').on('click', 'a.bill-edit', function(){
	if(id = getId()){
		viewMenuRight(false);
		popupConfirm(true, message.confirm, function(){
			ajaxPost(setUrl('bill', 'edit'), formData({'id':id, 'onpage': true}), function(responsive){
				popupConfirm(false);
				if(responsive.code == 200){					
					viewIconsHeader('back');						
					viewList(false).append(responsive.edit);
				}else{
					popupAlert(true, responsive.message);
				}
			});
		});
	}	
});
// SET FORM EDIT
$('#main').on('submit', '.theme-form.bill form.edit', function(){
	data = formData(this);
	if(data){
		data.append('provinceid', $(this).find('[data-province]').attr('data-province'));
		data.append('districtid', $(this).find('[data-district]').attr('data-district'));
		data.append('wardid', $(this).find('[data-ward]').attr('data-ward'));
		if(data){
			popupConfirm(true, message.confirm, function(){
				ajaxPost(setUrl('bill', 'edit'),data, function(responsive){
					popupConfirm(false);
					if(responsive.code == 200){					
						viewIconsHeader('back, right');
						element = $(themeListSelector()+' a[data-cid="'+responsive.cid+'"]');
						element.find('h3').text(responsive.name);
						element.find('img').attr('src', responsive.image);
						element.find('.phone strong').text(responsive.phone);
						element.find('.address span').text(responsive.address);
						if(responsive.phone && responsive.address){
							element.find('span.warning').remove();
						}else{
							element.find('.item .row1').append('<span class="warning">Thông tin</span>');
						}
						viewList(false).append(responsive.detail);
					}else{
						popupAlert(true, responsive.message);
					}
				});
			});
		}
	}else{
		popupAlert(true, message.require);
	}		
	return false;
});
// SEARCH
$('#header .search.clsBill').on('submit', 'form', function(){
	data = formData(this);	
	if(data.get('keyword')){		
		ajaxPost(setUrl('bill', 'search'), data, function(responsive){
			if(responsive.code == 200){			
				htmlRows(responsive.rows);
			}else{
				popupAlert(true, responsive.message);
			}
		});
	}
	return false;
});
// LIST CUSTOMER
$('#main .menu-right').on('click', 'a.bill-csid', function(){
	if(cid = getCid()){
		ajaxPost(setUrl('bill', 'list'), formData({'cid':cid}), function(responsive){
			if(responsive.code == 200){
				viewMenuRight(false);
				viewIconsHeader('left, search');
				viewList(true).find('.theme-list ul').attr({
					'data-action': responsive.action,
					'data-scroll': responsive.scroll,
				}).html(responsive.rows);				
				changeUrl(responsive.url);
			}else{
				popupAlert(true, responsive.message);
			}
		});
	}	
});
// NOTE
$('#main .menu-right').on('click', 'a.bill-note', function(){
	viewMenuRight(false);
	element = getPopup('reason', true);	
	$(element).find('form').attr('class', 'sbnote');
	$(element).find('h3').text('Ghi chú');
	$(element).find('textarea').focus();
});
$('#popup').on('submit', '.reason form.sbnote', function(){
	if(cid = getCid()){
		if(data = formData(this)){
			viewPopup('reason', false);
			data.append('cid', cid);
			popupConfirm(true, message.confirm, function(){
				ajaxPost(setUrl('bill', 'note'), data, function(responsive){
					popupConfirm(false);
					if(responsive.code == 200){							
						$('#main .theme-detail.bill .note>*:first-child').before(responsive.note);	
						updateMenuRight();
					}else{
						popupAlert(true, responsive.message);
					}
				});
			});
		}
	}
	return false;
});
// CANCEL NOTE
$('#main .menu-right').on('click', 'a.bill-note-cancel', function(){
	if(cid = getCid()){
		viewMenuRight(false);		
		popupConfirm(true, message.confirm, function(){
			ajaxPost(setUrl('bill', 'note'), formData({'cid':cid, 'content':'cancel'}), function(responsive){
				popupConfirm(false);
				if(responsive.code == 200){
					viewPopup('reason', false);			
					$('#main .theme-detail.bill .note .notification').remove();	
					updateMenuRight();
				}else{
					popupAlert(true, responsive.message);
				}
			});
		});
	}
	
});
// VIEW COMMENT
$('#main .menu-right').on('click', 'a.bill-comment', function(){
	if(cid = getCid()){
		viewMenuRight(false);
		ajaxPost(setUrl('bill', 'comment'), formData({'cid':cid}), function(responsive){			
			if(responsive.code == 200){				
				$(getPopup('comment', true)).find('.content').attr('data-scroll', responsive.scroll).html(responsive.comment);				
			}else{
				popupAlert(true, responsive.message);
			}
		});
	}
});
// SCROLL COMMENT
$('#popup .comment .scrollbarY').scroll(function(){
	if(cid = getCid()){
		if((scroll = $(this).attr('data-scroll')) == 'true'){
			element = $(this);
			if (Math.round(element[0].clientHeight + element[0].scrollTop) == element[0].scrollHeight){
				console.log(element.find('tr').length);
				data = formData({
					'cid'	:cid,
					'begin' : element.find('tr').length
				});
				ajaxPost(setUrl('bill', 'scrollComment'), data, function(responsive){
					if(responsive.code == 200){
						element.attr('data-scroll', responsive.scroll).append(responsive.comment);
					}else{
						popupAlert(true, responsive.message);
					}
				});
			}
		}		
	}
});
// SEND BILL
$('#main .menu-right').on('click', 'a.bill-send', function(){
	if(cid = getCid()){
		viewMenuRight(false);
		popupAlert(true, 'Chưa làm phần này');
	}
});
// CREATED
$('#main .menu-right').on('click', 'a.bill-create', function(){	
	viewMenuRight(false);
	popupConfirm(true, message.confirm, function(){
		ajaxPost(setUrl('bill', 'created'), {}, function(responsive){
			popupConfirm(false);
			if(responsive.code == 200){
				deleteRows(responsive.id);
				beforeRows(responsive.rows);
				$('#main .theme-detail .customer .time .create').text(responsive.created)
			}else{
				popupAlert(true, responsive.message);
			}
		});
	});	
});
// COPY
$('#main .menu-right').on('click', 'a.bill-copy', function(){
	viewMenuRight(false);
	popupConfirm(true, message.confirm, function(){
		ajaxPost(setUrl('bill', 'copy'), {}, function(responsive){
			popupConfirm(false);
			if(responsive.code == 200){				
				beforeRows(responsive.rows);
				viewList(false).append(responsive.detail);
				updateMenuRight();
			}else{
				popupAlert(true, responsive.message);
			}
		});
	});	
});
// SPECIAL
$('#main .menu-right').on('click', 'a.bill-special', function(){
	viewMenuRight(false);
	element = getPopup('special', true);
	$(element).find('form').attr('class', $(this).attr('data-name'));
	$(element).find('h3').text($(this).text());
});
// BILL SALE
$('#popup').on('submit', '.special .sale', function(){
	if(data = formData(this)){
		if(price = data.get('price')){
			data.set('price', price);
			popupConfirm(true, message.confirm, function(){
				ajaxPost(setUrl('bill', 'sale'), data, function(responsive){
					if(responsive.code == 200){
						// code
						updateMenuRight();
					}else{
						popupAlert(true, responsive.message);
					}
				});
			});		
		}
	}else{
		popupAlert(true, message.require);
	}
	return false;
});
// BILL SURCHARGE
$('#popup').on('submit', '.special .surcharge', function(){
	if(data = formData(this)){
		if(price = data.get('price')){
			data.set('price', price);
			popupConfirm(true, message.confirm, function(){
				ajaxPost(setUrl('bill', 'surcharge'), data, function(responsive){
					if(responsive.code == 200){
						// code
						updateMenuRight();
					}else{
						popupAlert(true, responsive.message);
					}
				});
			});		
		}
	}else{
		popupAlert(true, message.require);
	}
	return false;
});
// BILL DEBT
$('#popup').on('submit', '.special .debt', function(){
	if(data = formData(this)){
		if(price = data.get('price')){
			data.set('price', price);
			popupConfirm(true, message.confirm, function(){
				ajaxPost(setUrl('bill', 'debt'), data, function(responsive){
					if(responsive.code == 200){
						// code
						updateMenuRight();
					}else{
						popupAlert(true, responsive.message);
					}
				});
			});		
		}
	}else{
		popupAlert(true, message.require);
	}
	return false;
});
// BILL TRANSFER
$('#popup').on('submit', '.special .transfer', function(){
	if(data = formData(this)){
		if(price = data.get('price')){
			data.set('price', price);
			popupConfirm(true, message.confirm, function(){
				ajaxPost(setUrl('bill', 'transfer'), data, function(responsive){
					if(responsive.code == 200){
						// code
						updateMenuRight();
					}else{
						popupAlert(true, responsive.message);
					}
				});
			});		
		}
	}else{
		popupAlert(true, message.require);
	}
	return false;
});
// VIEW PRODUCT LIST
$('#main').on('click', '.theme-detail.bill .addproduct', function(){
	if(element = getPopup('addproduct')){
		ajaxPost(setUrl('bill', 'product'), formData({'begin':0}), function(responsive){			
			if(responsive.code == 200){				
				$(element).find('.content ul').attr({'data-scroll': responsive.scroll}).html(responsive.rows);
			}else{
				viewPopup('addproduct', false);
				popupAlert(true, responsive.message);
			}
		});
		// Scroll		
		$(element).find('.scrollbarY').scroll(function(){
			current = $(this).find('ul');
			if(current.attr('data-scroll') == 'true'){			
				client = $(this)[0];
				if (Math.round(client.clientHeight + client.scrollTop) == client.scrollHeight){
					data = formData({
						'keyword' : $(current).closest('.addproduct').find('input[name="keyword"]').val(),
						'begin'	  : $(current).find('li').length			
					});
					ajaxPost(setUrl('bill', 'product'), data, function(responsive){			
						if(responsive.code == 200){				
							$(current).attr({'data-scroll': responsive.scroll}).append(responsive.rows);
						}
					});
				}
			}
		});
		// Search
		$(element).on('submit', '.title form', function(){
			current = $(this).closest('.addproduct').find('ul');
			data = formData(this);
			if(data.get('keyword')){
				ajaxPost(setUrl('bill', 'product'), data, function(responsive){			
					if(responsive.code == 200){				
						$(current).attr({'data-scroll': responsive.scroll}).html(responsive.rows);
					}
				});
			}else{
				popupAlert(true, message.require);
			}
			return false;
		});
		// Add product
		$(element).on('click', 'li a', function(){
			input = $(this).find('form.change input[type="text"]');
			if(!$(input).is(':focus')){
				if(id = $(this).attr('data-id')){	
					current = '';
					amount = parseInt(input.val()) + 1;		
					if(amount>1){
						current = 'true';
					}
					data = formData({					
						'action' 	: 'addproduct',
						'current'	: current,
						'productid' : id,
						'amount' 	: amount
					});
					ajaxPost(setUrl('bill', 'product'), data, function(responsive){			
						if(responsive.code == 200){		
							input.val(data.get('amount')).closest('li').addClass('active');
							viewList(false).append(responsive.detail);
						}else{
							popupAlert(true, responsive.message);
						}
					});
				}
			}			
			return false;
		});
		// Add Product
		$(element).on('submit', 'form.change input[type="text"]', function(){
			$(this).closest('a').click();
			return false;
		});
	}
});


// CLOSE ADD PRODUCT
$('#popup').on('click', '.absolute.addproduct .title button.bars-back', function(){
	viewPopup('addproduct', false);
});
$('.jhfklghjl').on('click', function(){
	console.log(this);
	return false;
});
$('.fdfkflg').on('click', function(){
	return false;
});
$('#popup').on('submit', '.absolute.addproduct form.change', function(){
	console.log($(this).find('input').val());
	return false;
});