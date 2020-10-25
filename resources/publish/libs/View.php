<?php

namespace resources\publish\libs;

use libs\Cookie;

class View extends \libs\View
{

	// Phương thức khởi tạo
	public function __construct($params)
	{
		parent::__construct($params);
		$this->setNewImagePath();
		$this->setMetaTags('<meta http-equiv="Content-Type" content="text/html; charset=utf-8">');
		$this->setMetaTags('<meta http-equiv="x-ua-compatible" content="ie=edge">');
		$this->setMetaTags('<meta name="viewport" content="width=device-width, initial-scale=1.0">');
		$this->setCssTags('css/reset.css');
		$this->setCssTags('css/fontawesome.min.css');
		$this->setCssTags('css/style.css');
		$this->setJsTags('js/jquery.min.js');
		$this->setJsTags('js/main.js');
	}

	// Phương thức trả về đường dẫn thư mục hình ảnh
	public function setNewImagePath()
	{
		$this->setData('dirImage', $this->route('system/image') . DS);
	}
}
