// ====================INVENTORY CONTROL==========================	
// ADD====================
$('#main .menu .clsInventory + ul').on('click', 'a.add', function () {
	data = { onpage: currentPage('clsInventory') };
	ajaxPost(
		setUrl('inventory', 'add'),
		formData(data),
		function (responsive) {
			if (data.onpage == true) {
				viewMenuLeft(false);
				if (responsive.code == 200) {
					viewIconsHeader('back');
					viewList(false).append(responsive.form);
				} else {
					popupAlert(true, responsive.message);
				}
			}
		}
	);
	return (data.onpage ? false : true);
});
$('#main').on('submit', '.theme.inventory .form.add', function () {
	data = formData(this);
	if (data) {
		popupConfirm(true, message.confirm, function () {
			ajaxPost(
				setUrl('inventory', 'add'), data,
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
	} else {
		popupAlert(true, message.require);
	}
	return false;
});
// VIEW DETAIL
$('#main').on('click', '.theme-list.inventory li a', function () {
	id = $(this).attr('data-id');
	if (id && $.isNumeric(id)) {
		ajaxPost(setUrl('inventory', 'detail'), formData({ 'id': id }), function (responsive) {
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
$('#main .menu-right').on('click', 'a.inventory-edit', function () {
	if (id = getId()) {
		viewMenuRight(false);
		popupConfirm(true, message.confirm, function () {
			ajaxPost(setUrl('inventory', 'edit'), formData({ 'id': id, 'onpage': true }), function (responsive) {
				popupConfirm(false);
				if (responsive.code == 200) {
					viewIconsHeader('back');
					viewList(false).append(responsive.edit);
				} else {
					popupAlert(true, responsive.message);
				}
			});
		});
	}
	return false;
});
// SET FORM EDIT
$('#main').on('submit', '.theme-form.inventory .form.edit', function () {
	if (data = formData(this)) {
		popupConfirm(true, message.confirm, function () {
			ajaxPost(setUrl('inventory', 'edit'), data, function (responsive) {
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
// SEARCH
$('#header .search.clsInventory').on('submit', 'form', function () {
	if (data = formData(this)) {
		ajaxPost(setUrl('inventory', 'search'), data, function (responsive) {
			if (responsive.code == 200) {
				htmlRows(responsive.rows);
			} else {
				popupAlert(true, responsive.message);
			}
		});
	}
	return false;
});
