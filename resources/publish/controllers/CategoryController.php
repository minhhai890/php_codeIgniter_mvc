<?php

namespace resources\publish\controllers;

class CategoryController extends \resources\publish\libs\Controller
{

	// Phương thức xử lý trang chủ
	public function index()
	{
		$this->_view->setTitle('Trang chuyên mục sản phẩm');
		$this->_view->render('category.index');
	}
}
