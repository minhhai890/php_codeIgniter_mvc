<?php

namespace libs;
// Chỉnh sửa lại phần upload cho phép upload 1 hay nhiều hình
class Upload
{

	// Biến lưu trữ tên tập tin
	private $_fileName;

	// Biến lưu trữ kích thước tập tin
	private $_fileSize;

	// Biến lưu trữ phần mỡ rộng của tập tin
	private $_fileExtension;

	// Biến lưu trữ đường dẫn tạm của tập tin
	private $_fileTmp;

	// Biến lưu trữ đường dẫn upload
	private $_uploadDir;

	// Biến lưu trữ các giá trị lỗi
	private $_errors = NULL;

	// Phương thức khởi tạo
	public function __construct($file)
	{
		$fileInfo = $_FILES[$file];
		$this->_fileName = $fileInfo['name'];
		$this->_fileSize = $fileInfo['size'];
		$this->_fileTmp = $fileInfo['tmp_name'];
		$this->_fileExtension = $this->getFileExtension();
	}

	// Phương thức lấy phần mở rộng
	public function getFileExtension()
	{
		$exten = strtolower(pathinfo($this->_fileName, PATHINFO_EXTENSION));
		return $exten;
	}

	// Phương thức get filename
	public function getFileName()
	{
		return $this->_fileName;
	}

	// Phương thức get fileTmp
	public function getFileTmp()
	{
		return $this->_fileTmp;
	}

	// Phương thức thiết lập phần mở rộng
	public function setFileExtension($strExtension)
	{
		if (strpos($strExtension, $this->_fileExtension) === false) {
			$this->_errors = "Định dạng tập tin không hợp lệ! ( " . $strExtension . " )";
		}
	}

	// Phương thức thiết lập kích thước tối thiều và kích thước tối đa (đơn vị tính B)
	public function setFileSize($max)
	{
		$maxNumber = $this->conSize(Func::getNumeric($max), Func::getString($max));
		if ($this->_fileSize > $maxNumber) {
			$this->_errors = "Kích thước tập tin không phù hợp! ( max: " . $max . ")";
		}
	}

	// Phương thức thiết lập đường dẫn đến folder
	public function setUploadDir($dir)
	{
		if (file_exists($dir)) {
			$this->_uploadDir = $dir;
		} else {
			$this->_errors = "Thư mục không hợp lệ!";
		}
	}

	// Phương thức kiểm tra điều kiện upload của tập tin
	public function isError()
	{
		$flag = true;
		if ($this->_errors == NULL) {
			$flag = false;
		}
		return $flag;
	}

	// Phương thức upload tập tin
	public function uploadFile($rename = true)
	{
		$filename = $this->_fileName;
		if ($rename == true) {
			$filename = $this->setFilename($filename);
			$destination = $this->_uploadDir . $filename;
		} else {
			$destination = $this->_uploadDir . $filename;
		}
		@move_uploaded_file($this->_fileTmp, $destination);
		return $filename;
	}

	// Phương thức hiển thị lỗi
	public function showError()
	{
		return $this->_errors;
	}

	// Phương thức random
	public function setFilename($filename)
	{
		$range = time();
		$search = '.' . $this->_fileExtension;
		$replace = '_' . time() . '.' . $this->_fileExtension;
		return str_replace($search, $replace, $filename);
	}

	// Phương thức chuyển đổi đơn vị của tập tin
	public function conSizeUnit($totalDigit = 2, $ditance = ' ')
	{
		$units 	= array('B', 'KB', 'MB', 'GB', 'TB');
		for ($i = 0; $i < count($units); $i++) {
			if ($this->_fileSize >= 1024) {
				$this->_fileSize = $this->_fileSize / 1024;
			} else {
				$unit = $units[$i];
				break;
			}
		}
		return round($this->_fileSize, $totalDigit) . $ditance . $unit;
	}

	// Phương thức chuyển đổi đơn vị của tập tin
	public function conSize($number, $unit)
	{
		$units 	= array('KB', 'MB', 'GB', 'TB');
		for ($i = 0; $i < count($units); $i++) {
			if ($units[$i] != strtoupper($unit)) {
				$number *= 1024;
			} else {
				$number *= 1024;
				break;
			}
		}
		return $number;
	}
}

//	Demo
//  <input type="file" name="intname" value="">
// 	$upload = new Upload('intname');
// 	$upload->setFileExtension('jpg,png');
// 	$upload->setFileSize('2Mb');
// 	$upload->setUploadDir(PATH_PUBLIC . 'upload/');
// 	if($upload->isError() == false){
// 		$newFilename = $upload->uploadFile();
// 	}

/* Hiển thị ảnh trước khi upload

 function readURL(input) {
	  if (input.files && input.files[0]) {
	    var reader = new FileReader();
	    
	    reader.onload = function(e) {
	      $('#viewImage').attr('src', e.target.result);
	    }
	    
	    reader.readAsDataURL(input.files[0]); // convert to base64 string
	  }
	}
	$("#uploadImage").change(function() {
	  readURL(this);
	});
 *  
 *  */
