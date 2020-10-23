<?php

namespace resources\publish\controllers;

class HomeController extends \resources\publish\libs\Controller
{

	// Phương thức xử lý trang chủ
	public function index()
	{
		$slider = [1, 2, 3];


		echo $this->route('images/view', ['filename' => 'product/product-01.png']);

		$this->_view->setData('slider', $slider);


		$this->_view->setTitle('Chào mừng bạn đến website của Hải');
		$this->_view->setJsTags('js/slider.js');
		$this->_view->render('home.index');
	}
}
