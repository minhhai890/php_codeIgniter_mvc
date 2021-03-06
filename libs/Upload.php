<?php

namespace libs;

class Upload
{
	// Biến lưu tên tập tin
	protected $_name;

	// Biến lưu kích thước tập tin
	protected $_size;

	// Biến lưu phần mỡ rộng của tập tin
	protected $_exten;

	// Biến lưu trữ đường dẫn tạm của tập tin
	protected $_tmp;

	// type = file(input file) hoặc type=content(base64)
	protected $_type;

	// Chuyển đổi tập tin hình ảnh sang định dạng webp
	protected $_webp;

	// Biến lưu dữ liệu
	protected $_data;

	// Biến lưu trữ đường dẫn upload
	protected $_dir;

	// Biến lưu trữ đường dẫn upload file tạm
	protected $_dirTmp;

	// Biến lưu kích thước tập tin tối da
	protected $_maxSize;

	// Biến lưu phần mỡ rộng của tập tin được phép
	protected $_isExten;

	// Biến lưu phần thay đổi kích thước ảnh
	protected $_resize;

	// Biến lưu phần tên tập tin đã thay đổi
	protected $_rename;

	// Biến lưu Ftp Server
	protected $_ftp;

	// Biến lưu trữ các giá trị lỗi
	protected $_errors;

	// Biến lưu đơn vị kích thước
	protected $_units;

	// Phương thức khơi tạo
	public function __construct()
	{
		$this->_units = ['B', 'KB', 'MB', 'GB', 'TB'];
	}

	// Phương thức kiểm tra và trả về dữ liệu tập tin file input
	protected function checkFileInput($files)
	{
		if (is_array($files['name'])) { // Multi
			foreach ($files['name'] as $key => $name) {
				$this->_data[] = [
					'name' => $name,
					'tmp' => @$files['tmp_name'][$key],
					'size' => @$files['size'][$key],
					'type' => @$files['type'][$key],
					'exten' => '',
					'error' => @$files['error'][$key],
				];
			}
		} else { // Single
			$this->_data[] = [
				'name' => @$files['name'],
				'tmp' => @$files['tmp_name'],
				'size' => @$files['size'],
				'type' => @$files['type'],
				'exten' => '',
				'error' => @$files['error']
			];
		}
	}

	// Phương thức kiểm tra và trả về dữ liệu tập tin từ content base64
	protected function checkFileContent($content)
	{
		if (preg_match('/^data:image\/(\w+);base64,(\S+)/', $content, $match)) {
			return [
				'name' => '',
				'tmp' => $match[2],
				'size' => (int) (strlen($match[2]) * 3 / 4),
				'type' => '',
				'exten' => $match[1],
				'error' => 0,
			];
		}
		$this->_errors = 'Sai định dạng!';
		return false;
	}

	// Phương thức đổi tên tập tin upload
	protected function rename()
	{
		return $this->_name . $this->_rename . '.' . $this->_exten;
	}

	// Phương thức thiết lập tham số trước khi tải tập tin
	protected function setParams($options)
	{
		if (!$this->isError()) {
			if ($options['error'] > 0) {
				$this->_errors = 'Lỗi tải tập tin!';
			} else {
				$this->_name = @$options['name'];
				$this->_tmp = @$options['tmp'];
				$this->_size = @$options['size'];
				$this->_exten = @$options['exten'];
				if (!$this->_exten && $this->_name) {
					$pathinfo = pathinfo($this->_name);
					if (isset($pathinfo['extension'])) {
						$this->_exten = $pathinfo['extension'];
					} else {
						$this->_errors = 'Lỗi phần mở rộng của tập tin!';
					}
				}
				$this->_rename = '-' . time();
			}
		}
	}

	// Phương thức init
	// $option: $_FILES[$option] -> input type="file"
	// $option: content base64
	public function init($option, $file = true)
	{
		$this->_data = null;
		if ($file == true) {	// Upload tập tin từ form input type file
			$this->_type = 'file';
			if (isset($_FILES[$option])) {
				$this->checkFileInput($_FILES[$option]);
			}
		} else {				// Upload tập tin từ content base64
			$this->_type = 'base64';
			if (is_array($option)) { // content multi file
				foreach ($option as $value) {
					if ($item = $this->checkFileContent($value)) {
						$this->_data[] = $item;
					}
				}
			} else {
				// content single file
				if ($item = $this->checkFileContent($option)) {
					$this->_data[] = $item;
				}
			}
		}
		// chọn tập tin
		if ($this->_data) {
			if ($item = array_shift($this->_data)) {
				$this->setParams($item);
			}
		}
	}

	// Phương thức thiết lập file name
	public function setName($name)
	{
		$this->_name = $name;
	}

	// Phương thức get filename
	public function getName()
	{
		return $this->_name;
	}

	// Phương thức thiết lập resize kích thức hình ảnh
	public function resize($width, $height)
	{
		$this->_resize[] = [
			'width' => $width,
			'height' => $height,
			'filename' => '-' . $width . 'x' . $height . $this->_rename
		];
	}

	// Phương thức thiết lập chuyển đổi định dạng tập tin sang webp
	public function convertWebp()
	{
		$this->_webp = true;
	}

	// Phương thức thiết lập phần mở rộng
	public function setExtension($exten)
	{
		$this->_isExten = $exten;
	}

	// Phương thức lấy phần mở rộng
	public function getExtension()
	{
		return $this->_exten;
	}

	// Phương thức thiết lập phần mở rộng
	public function isExtension()
	{
		if ($this->_exten) {
			if ($this->_isExten) {
				if (strpos($this->_isExten, $this->_exten) === false) {
					$this->_errors = "Định dạng tập tin không hợp lệ! ( " . $this->_isExten . " )";
				}
			}
		} else {
			$this->_errors = 'Vui lòng chọn tập tin!';
		}
	}

	// Phương thức thiết lập kích thước tối thiều và kích thước tối đa (đơn vị tính B)
	public function maxSize($size)
	{
		$this->_maxSize = $size;
	}

	// Phương thức trả về kích thước của tập tin
	public function getSize()
	{
		return $this->_size;
	}

	// Phương thức thiết lập kích thước tối thiều và kích thước tối đa (đơn vị tính B)
	public function isSize()
	{
		if ($this->_maxSize) {
			if (preg_match('/(\d+)(\D+)/i', $this->_maxSize, $match)) {
				$sizeNumeric = $match[1];
				$sizeUnit = strtoupper($match[2]);
				foreach ($this->_units as $unit) {
					if ($unit !== 'B') {
						$sizeNumeric *= 1024;
						if ($sizeUnit == $unit) {
							break;
						}
					}
				}
				if ($this->_size > $sizeNumeric) {
					$this->_errors = "Kích thước tệp quá lớn! ( kích thước tối đa: " . $this->_maxSize . ")";
				}
			} else {
				$this->_errors = "Thiết lập kích thước không đúng!";
			}
		}
	}

	// Phương thức thiết lập đường dẫn đến thư mục lưu file
	public function setDir($dir)
	{
		$this->_dir = $dir;
	}

	// Phương thức trả về đường dẫn đến thư mục lưu file
	public function getDir()
	{
		return $this->_dir;
	}

	// Phương thức kiểm tra thư mục tồn tại
	public function isDir()
	{
		if (!file_exists($this->_dir)) {
			$this->_errors = "Thư mục không tồn tại!";
		}
	}

	// Phương thức thiết lập đường dẫn thu mục tạm
	public function setDirTmp($dir)
	{
		$this->_dirTmp = $dir;
	}

	// Phương thức trả về đường dẫn thư mục tạm
	public function getDirTmp($dir)
	{
		return $this->_dirTmp;
	}

	// Phương thức kiểm tra thư mục tồn tại
	public function isDirTmp()
	{
		if (!file_exists($this->_dirTmp)) {
			$this->_errors = "Thư mục không tồn tại!";
		}
	}

	// Phương thức kiểm tra điều kiện upload của tập tin
	public function isError()
	{
		if ($this->_errors) {
			return true;
		}
		return false;
	}

	// Phương thức lưu file tạm
	public function saveTmp()
	{
		$this->isDirTmp();
		$this->isSize();
		$this->isExtension();
		if (!$this->isError() && $this->_tmp) {
			$fileTmp = $this->_dirTmp . DS . $this->rename();
			if ($this->_type == 'base64') {
				if (!@file_put_contents($fileTmp, base64_decode($this->_tmp)) !== false) {
					$this->_errors = 'Lỗi lưu tập tin tạm!';
				}
			} else {
				if (!@move_uploaded_file($this->_tmp, $fileTmp)) {
					$this->_errors = 'Lỗi lưu tập tin tạm!';
				}
			}
			if (!$this->_errors) {
				// Convert to webp				
				$this->saveWebP();

				// Resize file
				if ($data = $this->saveResize()) {
					return $data;
				}
				return [$this->rename()];
			}
		}
		return false;
	}

	// Phương thức chuyển đổi định dạng tập tin thành webp
	public function saveWebP()
	{
		if ($this->_webp) {
			$source = $this->_dirTmp . DS . $this->rename();
			$this->_exten = 'webp';
			$destination = $this->_dirTmp . DS . $this->rename();
			$imageResize = new Image($source);
			$imageResize->scale(95);
			if ($imageResize->save($destination, IMAGETYPE_WEBP)) {
				@unlink($source);
				return true;
			}
		}
		return false;
	}

	// Phương thức thay đổi kích thước tập tin
	public function saveResize()
	{
		$data = [];
		if ($this->_resize) {
			$source = $this->_dirTmp . DS . $this->rename();
			foreach ($this->_resize as $value) {
				$imageResize = new Image($source);
				$resizeName = $this->_name . $value['filename'] . '.' . $this->_exten;
				$imageResize->crop($value['width'], $value['height']);
				$imageResize->save($this->_dirTmp . DS . $resizeName);
				$data[] = $resizeName;
			}
		}
		return $data;
	}

	// Phương thức delete file Tạm
	public function deleteTmp($data)
	{
		if ($data) {
			$data[] = $this->rename();
			foreach ($data as $file) {
				$pathFile = $this->_dirTmp . DS . $file;
				if (is_file($pathFile)) {
					@unlink($pathFile);
				}
			}
		}
	}

	// Phương thức upload tập tin
	public function upload()
	{
		$this->isDir();
		$this->isExtension();
		$this->isSize();
		$filename = $this->rename();
		if (!$this->isError()) {
			$destination = $this->_dir . DS . $filename;
			if (@move_uploaded_file($this->_tmp, $destination)) {
				// Convert webp
				if ($this->_webp) {
					$source = $destination;
					$this->_exten = 'webp';
					$filename = $this->rename();
					$destination = $this->_dir . DS . $filename;
					$imageResize = new Image($source);
					$imageResize->scale(95);
					if ($imageResize->save($destination, IMAGETYPE_WEBP)) {
						@unlink($source);
						return true;
					}
				}
				// Resize image
				if ($this->_resize) {
					$response = [
						'status' => false,
						'message' => $this->_errors,
						'data'	=> []
					];
					foreach ($this->_resize as $value) {
						$imageResize = new Image($destination);
						$resizeName = $this->_name . $value['filename'];
						$imageResize->crop($value['width'], $value['height']);
						$imageResize->save($this->_dir . DS . $resizeName);

						$result = $this->responsive($resizeName);
						$response['status'] = $result['status'];
						$response['message'] = $result['message'];
						$response['data'][] = $result;
					}
					@unlink($destination);
					return $response;
				}
			} else {
				$this->_errors = "Lỗi tải tập tin!";
			}
		}
		$response = $this->responsive($filename);
		$response['data'][] = $response;
		return $response;
	}

	// Phương thức upload nhiều tập tin
	public function uploadMulti()
	{
		$filename = $this->_name;
		$this->setName($filename . '1');
		$response = $this->upload();
		if ($response['status'] && $this->_data) {
			foreach ($this->_data as $key => $item) {
				$this->setParams($item);
				$this->setName($filename . ($key + 2));
				$result = $this->upload();
				$response['status'] = $result['status'];
				$response['message'] = $result['message'];
				$response['data'] = array_merge($response['data'], $result['data']);
				if ($result['status'] == false) {
					break;
				}
			}
		}
		return $response;
	}

	// Phương thức kết nối máy chủ FTP Server
	public function ftpConnect()
	{
		$config = Config::get('ftp');
		if (!$this->_ftp = ftp_connect($config['host'], $config['port'])) {
			$this->_errors = 'Không thể kết nối máy chủ ' . $config['host'];
			return false;
		}
		if (!ftp_login($this->_ftp, $config['username'], $config['password'])) {
			$this->_errors = 'Không thể đăng nhập vào máy chủ ' . $config['host'];
			return false;
		}
		ftp_pasv($this->_ftp, true);
		return true;
	}

	// Phương thức đóng kết nối máy chủ FTP Server
	public function ftpClose()
	{
		if ($this->_ftp) {
			ftp_close($this->_ftp);
		}
	}

	// Phương thức upload tập tin tới FTP Server
	public function ftpUpload()
	{
		if ($this->_ftp && !$this->isError()) {
			if ($files = $this->saveTmp()) {
				$response = [
					'status' => false,
					'message' => $this->_errors,
					'data'	=> []
				];
				foreach ($files as $file) {
					if ($this->isError()) {
						break;
					}
					$destination = $this->_dir . DS . $file;
					$localFile = $this->_dirTmp . DS . $file;
					if (!@ftp_put($this->_ftp, $destination, $localFile, FTP_BINARY)) {
						$this->_errors = 'Lỗi tải tập tin!';
					}
					$result = $this->responsive($destination);
					$response['status'] 	= $result['status'];
					$response['message'] 	= $result['message'];
					$response['data'][]	 	= $result;
				}
				$this->deleteTmp($files);
				return $response;
			}
		}
		$this->_errors = 'Lỗi kết nối đến máy chủ!';
		$response = $this->responsive($this->_name);
		$response['data'][] = $response;
		return $response;
	}

	// Phương thức upload nhiều tập tin tới FTP Server
	public function ftpUploadMulti()
	{
		$filename = $this->_name;
		$this->setName($filename . '1');
		$response = $this->ftpUpload();
		if ($response['status'] && $this->_data) {
			foreach ($this->_data as $key => $item) {
				$this->setParams($item);
				$this->setName($filename . ($key + 2));
				$result = $this->ftpUpload();
				$response['status'] = $result['status'];
				$response['message'] = $result['message'];
				$response['data'] = array_merge($response['data'], $result['data']);
				if ($result['status'] == false) {
					break;
				}
			}
		}
		return $response;
	}

	public function ftpMKDir($dir)
	{
		if ($this->_ftp && !$this->isError()) {
			return @ftp_mkdir($this->_ftp, $dir);
		}
		return false;
	}

	// Phương thức xóa tập tin trên FTP Server
	public function ftpFileDelete($filename)
	{
		if ($this->_ftp && !$this->isError()) {
			if (!@ftp_delete($this->_ftp, $filename)) {
				$this->_errors = "Tập tin không tồn tại!";
			}
		}
		return $this->responsive($filename);
	}

	// Phương thức trả kết quả upload
	public function responsive($filename)
	{
		$responsive = [
			'status' => true,
			'filename' => $filename
		];
		if ($this->isError()) {
			$responsive['status'] = false;
			$responsive['message'] = $this->_errors;
			$this->_errors = NULL;
		} else {
			$responsive['message'] = 'Tải tập tin thành công!';
		}
		return $responsive;
	}
}
