// ====================PRODUCT CONTROL==========================	
// ADD UNIT
$('#popup').on('click', 'button.addunit', function () {
	if (name = $('#input-unitname').val()) {
		ajaxPost(setUrl('product', 'addUnit'), formData({ 'name': name }), function (responsive) {
			if (responsive.code == 200) {
				$('#input-unitname').val('').focus();
				$('#tr-list-unit').html(responsive.rows.tr);
				$('#select-list-units').html(responsive.rows.option);
			} else {
				popupAlert(true, responsive.message);
			}
		});
	} else {
		popupAlert(true, message.require);
	}
	return false;
});
// VIEW UNIT
$('#main').on('click', '.theme-form.product .popupunit', function () {
	if (getPopup('unit')) {
		ajaxPost(setUrl('product', 'unit'), {}, function (responsive) {
			if (responsive.code == 200) {
				$('#popup .absolute.unit .table tbody').html(responsive.rows.tr);
			}
		});
	}
});
// ADD====================
$('#main .menu .clsProduct + ul').on('click', 'a.add', function () {
	data = { onpage: currentPage('clsProduct') };
	ajaxPost(setUrl('product', 'add'), formData(data), function (responsive) {
		if (data.onpage == true) {
			viewMenuLeft(false);
			if (responsive.code == 200) {
				viewIconsHeader('back');
				viewList(false).append(responsive.form);
			} else {
				popupAlert(true, responsive.message);
			}
		}
	});
	return (data.onpage ? false : true);
});
$('#main').on('submit', '.theme.product .form.add', function () {
	data = formData(this);
	if (data) {
		if ((data.get('inventoryid') && data.get('inventoryid') == '0') || (data.get('unitid') && data.get('unitid') == '0')) {
			popupAlert(true, message.require);
		} else {
			data.append('action', $(this).attr('data-action'));
			data.set('price-import', getNumeric(data.get('price-import')));
			data.set('price-seller', getNumeric(data.get('price-seller')));
			data.set('amount', getNumeric(data.get('amount')));
			popupConfirm(true, message.confirm, function () {
				ajaxPost(
					setUrl('product', 'add'), data,
					function (responsive) {
						popupConfirm(false);
						if (responsive.code == 200) {
							viewIconsHeader('back, right');
							beforeRows(responsive.rows);
							viewList(false).append(responsive.detail);
						} else {
							popupAlert(true, responsive.message);
						}
					}
				);
			});
		}
	} else {
		popupAlert(true, message.require);
	}
	return false;
});
// VIEW DETAIL
$('#main').on('click', '.theme-list.product li a', function () {
	id = $(this).attr('data-id');
	if (id && $.isNumeric(id)) {
		ajaxPost(setUrl('product', 'detail'), formData({ 'id': id }), function (responsive) {
			if (responsive.code == 200) {
				viewIconsHeader('back, right');
				viewList(false).append(responsive.detail);
			} else {
				popupAlert(true, responsive.message);
			}
		});
	}
	return false;
});
// VIEW FORM EDIT
$('#main .menu-right').on('click', 'a.product-edit', function () {
	if (id = getId()) {
		viewMenuRight(false);
		popupConfirm(true, message.confirm, function () {
			ajaxPost(setUrl('product', 'edit'), formData({ 'id': id, 'onpage': true }), function (responsive) {
				popupConfirm(false);
				if (responsive.code == 200) {
					viewIconsHeader('back');
					viewList(false).append(responsive.edit);
					optionSelected();
				} else {
					popupAlert(true, responsive.message);
				}
			});
		});
	}
	return false;
});
// SET FORM EDIT
$('#main').on('submit', '.theme-form.product .form.edit', function () {
	if (data = formData(this)) {
		data.set('price-import', getNumeric(data.get('price-import')));
		data.set('price-seller', getNumeric(data.get('price-seller')));
		data.set('amount', getNumeric(data.get('amount')));
		popupConfirm(true, message.confirm, function () {
			ajaxPost(setUrl('product', 'edit'), data, function (responsive) {
				popupConfirm(false);
				if (responsive.code == 200) {
					viewIconsHeader('back, right');
					updateRows(responsive.id, responsive.rows);
					viewList(false).append(responsive.detail);
				} else {
					popupAlert(true, responsive.message);
				}
			});
		});
	}
	return false;
});
// DELETE
$('#main .menu-right').on('click', 'a.product-delete', function () {
	viewMenuRight(false);
	popupConfirm(true, message.confirm, function () {
		ajaxPost(setUrl('product', 'delete'), formData({}), function (responsive) {
			popupConfirm(false);
			if (responsive.code == 200) {
				deleteRows(responsive.id);
				viewIconsHeader('left, search');
				viewList(true);
			} else {
				popupAlert(true, responsive.message);
			}
		});
	});
});
// SEARCH
$('#header .search.clsProduct').on('submit', 'form', function () {
	if (data = formData(this)) {
		ajaxPost(setUrl('product', 'search'), data, function (responsive) {
			if (responsive.code == 200) {
				htmlRows(responsive.rows);
			} else {
				popupAlert(true, responsive.message);
			}
		});
	}
	return false;
});
// update image
$('#main').on('change', '#image_upload', function () {
	element = $(this).next('.view-img');
	data = new FormData();
	data.append('image', $(this)[0].files[0]);
	if (element.find('img').length > 0) {
		data.append('image_old', element.find('img').attr('src'));
	} else {
		data.append('image_old', '');
	}
	ajaxPost(setUrl('product', 'updateImage'), data, function (responsive) {
		if (responsive.code == 200) {
			element.html('<img src="' + responsive.image + '" alt=""/>');
		} else {
			popupAlert(true, responsive.message);
		}
	});
});