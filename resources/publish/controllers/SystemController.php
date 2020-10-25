<?php

namespace resources\publish\controllers;

class SystemController extends \resources\publish\libs\Controller
{
	// Phương thức
	public function viewimage()
	{
		$dir = $this->_view->getFolderImage(true, false);
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
