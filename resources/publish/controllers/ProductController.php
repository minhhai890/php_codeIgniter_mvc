<?php

namespace resources\publish\controllers;

class ProductController extends \resources\publish\libs\Controller
{

	// Phương thức xử lý trang chủ
	public function index()
	{
		$this->_view->setTitle('Trang chi tiết sản phẩm');
		$this->_view->render('product.index');
	}
}
