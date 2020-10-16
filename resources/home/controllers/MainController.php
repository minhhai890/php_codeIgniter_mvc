<?php

namespace resources\home\controllers;

use libs\Upload;
use resources\home\libs as home;

class MainController extends home\Controller
{

	// Phương thức xử lý trang chủ
	public function home()
	{
	}

	public function upload()
	{
		echo '<form action="" method="post" enctype="multipart/form-data">
		<input type="file" name="image[]" value="" multiple>
		<input type="submit" value="Upload">
		</form>';

		if (isset($_FILES['image'])) {
			$br = '</br>';
			$file = new Upload();
			$file->init('image');
			$file->setDir(DIR_UPLOAD);
			$file->setFileSize(FILE_SIZE);
			$file->setExtension(FILE_EXTENSION);
			//$file->setFileExtension('jpg');			
			$result = $file->fileUpload();
			echo '<pre>';
			print_r($result);
			echo '</pre>';
		}
	}
}

//test_upload@thunganonline.com
//Xxu4MJHPCpeJ
