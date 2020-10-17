<?php

namespace resources\home\controllers;

use libs\Upload;
use libs\ImageResize;
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
			// $file->setExtension(FILE_EXTENSION);		
			$result = $file->uploadMulti();
			echo '<pre>';
			print_r($result);
			echo '</pre>';
		}
	}

	public function resize()
	{
		$filename = DIR_UPLOAD . 'root.jpg';
		$newfile = DIR_UPLOAD . 'new_' . time() . '.jpg';
		$image = new ImageResize($filename);

		// Để chia tỷ lệ hình ảnh, trong trường hợp này là một nửa kích thước (tỷ lệ dựa trên tỷ lệ phần trăm):
		//$image->scale(50);

		//Để thay đổi kích thước hình ảnh theo một chiều (giữ nguyên tỷ lệ khung hình):
		//$image->resizeToHeight(100);
		//$image->resizeToWidth(300);

		//Để thay đổi kích thước hình ảnh theo một số đo nhất định mà không liên quan đến hướng của nó (giữ nguyên tỷ lệ khung hình):
		//$image->resizeToLongSide(500);
		//$image->resizeToShortSide(300);

		//Để thay đổi kích thước hình ảnh để phù hợp nhất với một tập hợp kích thước nhất định (giữ tỷ lệ aspet):
		// $image->resizeToBestFit(500, 400);

		//Nếu bạn hài lòng khi tự xử lý các tỷ lệ khung hình, bạn có thể trực tiếp thay đổi kích thước:
		// $image->resize(800, 600);

		//Để cắt hình ảnh:
		//$image->crop(200, 100);
		//$image->crop(200, 100, true, ImageResize::CROPTOP);

		//Ngoài ra còn có một cách để xác định vị trí cắt tùy chỉnh. Bạn có thể xác định $ x và $ y trong phương thức freecrop:
		//$image->freecrop(200, 200, $x =  200, $y = 20);

		// Chất lượng hình ảnh
		$image->quality_jpg = 100;

		// Thêm một logo vào ảnh
		$image18Plus = DIR_UPLOAD . 'facebook_1602911379.png';
		$image->addFilter(function ($imageDesc) use ($image18Plus) {
			$logo = imagecreatefrompng($image18Plus);
			$logo_width = imagesx($logo);
			$logo_height = imagesy($logo);
			$image_width = imagesx($imageDesc);
			$image_height = imagesy($imageDesc);
			$image_x = $image_width - $logo_width - 10;
			$image_y = $image_height - $logo_height - 10;
			imagecopy($imageDesc, $logo, $image_x, $image_y, 0, 0, $logo_width, $logo_height);
		});

		//$image->save($newfile);

		// Đổi định dạng file
		$image->save($newfile, IMAGETYPE_PNG);
	}
}

//test_upload@thunganonline.com
//Xxu4MJHPCpeJ
