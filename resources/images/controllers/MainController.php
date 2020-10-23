<?php

namespace resources\images\controllers;

class MainController extends \libs\Controller
{
	// Phương thức khởi tạo
	public function __construct($params)
	{
		parent::__construct($params);
		$this->setView();
	}

	// Phương thức
	public function view()
	{
		$dir = DIR_RESOURCE . 'images' . DS . 'images' . DS;
		$filename = $dir . $this->_params['filename'];
		if (!is_file($filename)) {
			$filename = $dir . 'logo' . DS . 'elessi.png';
		}
		$image = file_get_contents($filename);
		header('Content-type: image/jpeg;');
		header("Content-Length: " . strlen($image));
		echo $image;
	}
}
