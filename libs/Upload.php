<?php

namespace libs;

class Upload
{
	// Biến lưu dữ liệu
	private $_data;

	// Biến lưu tên tập tin
	private $_fileName;

	// Biến lưu kích thước tập tin
	private $_fileSize;

	// Biến lưu kích thước tập tin tối da
	private $_maxSize;

	// Biến lưu phần mỡ rộng của tập tin
	private $_fileExtension;

	// Biến lưu phần mỡ rộng của tập tin được phép
	private $_extensionAccess;

	// Biến lưu phần thay đổi kích thước ảnh
	private $_resize;

	// Biến lưu trữ đường dẫn tạm của tập tin
	private $_fileTmp;

	// Biến cho biết filetype là file hay là base64
	private $_fileType;

	// Biến lưu trữ đường dẫn upload
	private $_dir;

	// Biến lưu trữ đường dẫn upload file tạm
	private $_dirTmp;

	// Biến lưu đơn vị kích thước
	private $_units = ['B', 'KB', 'MB', 'GB', 'TB'];

	// Biến lưu Ftp Server
	private $_ftpServer;

	// Biến lưu trữ các thời gian milisecond
	private $_prefixExtension;

	// Biến lưu trữ các giá trị lỗi
	private $_errors = NULL;

	// Phương thức khởi tạo
	public function init($fileName)
	{
		if (isset($_FILES[$fileName])) {
			if (is_array($_FILES[$fileName]['name'])) { // Multi
				foreach ($_FILES[$fileName]['name'] as $key => $name) {
					$this->_data[] = [
						'name' => $name,
						'type' => $_FILES[$fileName]['type'][$key],
						'tmp' => $_FILES[$fileName]['tmp_name'][$key],
						'error' => $_FILES[$fileName]['error'][$key],
						'size' => $_FILES[$fileName]['size'][$key]
					];
				}
				if ($item = current($this->_data)) {
					array_shift($this->_data);
					$this->setParams($item);
				}
			} else { // Single
				$this->setParams($_FILES[$fileName]);
			}
		} else {
			$this->_fileType = 'base64';
			if (is_array($fileName)) { // multi file
				foreach ($fileName as $value) {
					if (!$this->isError()) {
						if ($item = $this->checkBase64($value)) {
							$this->_data[] = $item;
							continue;
						}
					}
					break;
				}
				if ($item = current($this->_data)) {
					array_shift($this->_data);
					$this->setParams($item);
				}
			} else { // single file				
				if ($item = $this->checkBase64($fileName)) {
					$this->setParams($item);
				}
			}
		}
		$this->_dirTmp = Config::get('app.dir.src') . 'api/caches';
		$this->_prefixExtension = '-' . time() . '.' . $this->_fileExtension;
	}

	// Phương thức kiểm tra và trả về dữ liệu base64 hợp lệ
	public function checkBase64($content)
	{
		if (preg_match('/^data:image\/(\w+);base64,(\S+)/', $content, $match)) {
			return [
				'error' => 0,
				'exten' => $match[1],
				'tmp' => $match[2],
				'size' => (int) (strlen($match[2]) * 3 / 4)
			];
		}
		$this->_errors = 'Sai định dạng!';
		return false;
	}

	// Phương thức thiết lập tham số trước khi tải tập tin
	public function setParams($options)
	{
		if ($options['error'] > 0) {
			$this->_errors = 'Lỗi tải tập tin!';
		} else {
			$this->_fileName = @$options['name'];
			$this->_fileSize = @$options['size'];
			$this->_fileTmp = @$options['tmp'];
			if (@$options['exten']) {
				$this->_fileExtension = @$options['exten'];
			} else {
				$this->_fileExtension = $this->getExtension($this->_fileName);
			}
		}
	}

	// Phương thức thiết lập file name
	public function setFileName($filename)
	{
		$this->_fileName = $filename;
	}

	// Phương thức đổi tên tập tin upload
	public function rename()
	{
		return $this->_fileName . $this->_prefixExtension;
	}

	// Phương thức get filename
	public function getFileName()
	{
		return $this->_fileName;
	}

	// Phương thức đổi tên tập tin với kích thước
	public function renameSize($width, $height)
	{
		return '-' . $width . 'x' . $height . $this->_prefixExtension;
	}

	// Phương thức thiết lập phần mở rộng
	public function setExtension($extensionAccess)
	{
		$this->_extensionAccess = $extensionAccess;
	}

	// Phương thức thiết lập phần mở rộng
	public function isExtension()
	{
		if ($this->_fileExtension) {
			if ($this->_extensionAccess) {
				if (strpos($this->_extensionAccess, $this->_fileExtension) === false) {
					$this->_errors = "Định dạng tập tin không hợp lệ! ( " . $this->_extensionAccess . " )";
				}
			}
		} else {
			$this->_errors = 'Vui lòng chọn tập tin!';
		}
	}

	// Phương thức lấy phần mở rộng
	public function getExtension()
	{
		return $this->_fileExtension;
	}

	// Phương thức thiết lập kích thước tối thiều và kích thước tối đa (đơn vị tính B)
	public function setFileSize($maxSize)
	{
		$this->_maxSize = $maxSize;
	}

	// Phương thức thiết lập kích thước tối thiều và kích thước tối đa (đơn vị tính B)
	public function isFileSize()
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
				if ($this->_fileSize > $sizeNumeric) {
					$this->_errors = "Kích thước tệp quá lớn! ( kích thước tối đa: " . $this->_maxSize . ")";
				}
			} else {
				$this->_errors = "Thiết lập kích thước không đúng!";
			}
		}
	}

	// Phương thức trả về kích thước của tập tin
	public function getFileSize()
	{
		return $this->_fileSize;
	}

	// Phương thức thiết lập đường dẫn đến thư mục
	public function setDir($dir)
	{
		$this->_dir = $dir;
	}

	// Phương thức trả về đường dẫn đến thư mục
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
		$flag = true;
		if ($this->_errors == NULL) {
			$flag = false;
		}
		return $flag;
	}

	// Phương thức chuyển đổi đơn vị của tập tin
	public function convertSizeUnit($totalDigit = 2, $ditance = ' ')
	{
		if ($fileSize = $this->_fileSize) {
			$unit = '';
			for ($i = 0; $i < count($this->_units); $i++) {
				if ($fileSize >= 1024) {
					$fileSize = $fileSize / 1024;
				} else {
					$unit = $this->_units[$i];
					break;
				}
			}
			return round($fileSize, $totalDigit) . $ditance . $unit;
		} else {
			$this->_errors = 'Kích thước tập tin không tồn tại!';
		}
	}

	// Phương thức thêm mới logo vào ảnh
	public function addLogo($logo)
	{
		$this->_logo = $logo;
	}

	// Phương thức lưu file tạm
	public function saveFileTmp()
	{
		$this->isDirTmp();
		$this->isExtension();
		$this->isFileSize();
		if (!$this->isError() && $this->_fileTmp) {
			$newFile = $this->rename();
			$fileTmp = $this->_dirTmp . DS . $newFile;
			if (file_put_contents($fileTmp, base64_decode($this->_fileTmp)) !== false) {
				if ($this->_resize) {
					$this->_fileTmp = [];
					$imageResize = new Image($fileTmp);
					foreach ($this->_resize as $value) {
						$resizeName = $this->_fileName . $value['filename'];
						$this->_fileTmp[] = $resizeName;
						$imageResize->crop($value['width'], $value['height']);
						if ($this->_logo) {
							$fileLogo = $this->_logo;
							$imageResize->addFilter(function ($imageDesc) use ($fileLogo) {
								$logo = imagecreatefrompng($fileLogo);
								$logo_width = imagesx($logo);
								$logo_height = imagesy($logo);
								$image_width = imagesx($imageDesc);
								$image_height = imagesy($imageDesc);
								$image_x = $image_width - $logo_width - 5;
								$image_y = $image_height - $logo_height - 5;
								// right top
								// imagecopy($imageDesc, $logo, $image_x, 10, 0, 0, $logo_width, $logo_height);
								// right bottom
								imagecopy($imageDesc, $logo, $image_x, $image_y, 0, 0, $logo_width, $logo_height);
							});
						}
						$imageResize->save($this->_dirTmp . DS . $resizeName);
					}
				} else {
					$this->_fileTmp = [$newFile];
				}
			} else {
				$this->_fileTmp = null;
			}
		}
		return $this->_fileTmp;
	}

	// Phương thức delete file Tạm
	public function deleteFileTmp()
	{
		if ($this->_fileTmp) {
			$this->_fileTmp[] = $this->rename();
			foreach ($this->_fileTmp as $file) {
				$file = $this->_dirTmp . DS . $file;
				if (is_file($file)) {
					@unlink($file);
				}
			}
		}
	}

	// Phương thức thiết lập resize kích thức hình ảnh
	public function resize($width, $height)
	{
		$this->_resize[] = [
			'width' => $width,
			'height' => $height,
			'filename' => $this->renameSize($width, $height)
		];
	}

	// Phương thức upload tập tin
	public function upload()
	{
		$this->isDir();
		$this->isExtension();
		$this->isFileSize();
		$filename = $this->rename();
		if (!$this->isError()) {
			$destination = $this->_dir . DS . $filename;
			if (!@move_uploaded_file($this->_fileTmp, $destination)) {
				$this->_errors = "Lỗi tải tập tin!";
			}
		}
		return $this->responsive($filename);
	}

	// Phương thức upload nhiều tập tin
	public function uploadMulti()
	{
		$result = $this->upload();
		$response = [
			'status' => $result['status'],
			'message' => $result['message'],
			'data'	=> [$result]
		];
		if ($this->_data) {
			foreach ($this->_data as $key => $options) {
				unset($this->_data[$key]);
				$this->setParams($options);
				$result = $this->upload();
				if ($response['status'] == true) {
					$response['status'] = $result['status'];
					$response['message'] = $result['message'];
				}
				$response['data'][] = $result;
			}
		}
		return $response;
	}

	// Phương thức kết nối máy chủ FTP Server
	public function ftpConnect()
	{
		$config = Config::get('ftp');
		if (!$this->_ftpServer = ftp_connect($config['host'], $config['port'])) {
			$this->_errors = 'Không thể kết nối máy chủ ' . $config['host'];
			return false;
		}
		if (!ftp_login($this->_ftpServer, $config['username'], $config['password'])) {
			$this->_errors = 'Không thể đăng nhập vào máy chủ ' . $config['host'];
			return false;
		}
		ftp_pasv($this->_ftpServer, true);
		return true;
	}

	// Phương thức đóng kết nối máy chủ FTP Server
	public function ftpClose()
	{
		if ($this->_ftpServer) {
			ftp_close($this->_ftpServer);
		}
	}

	// Phương thức upload tập tin tới FTP Server
	public function ftpUpload()
	{
		if ($this->_ftpServer && !$this->isError()) {
			if ($this->_fileType == 'base64') {
				if ($fileTmp = $this->saveFileTmp()) {
					$response = [
						'status' => true,
						'message' => $this->_errors,
						'data'	=> []
					];
					foreach ($fileTmp as $file) {
						if ($this->isError()) {
							break;
						}
						$destination = $this->_dir . DS . $file;
						$localFile = $this->_dirTmp . DS . $file;
						if (!@ftp_put($this->_ftpServer, $destination, $localFile, FTP_BINARY)) {
							$this->_errors = "Lỗi tải tập tin!";
						}
						$result = $this->responsive($destination);
						$response['status'] 	= $result['status'];
						$response['message'] 	= $result['message'];
						$response['data'][] 	= $result;
					}
					$this->deleteFileTmp();
					return $response;
				}
			} else {
				$destination = $this->_dir . DS . $this->rename();
				if ($this->_ftpServer && !$this->isError()) {
					if (!@ftp_put($this->_ftpServer, $destination, $this->_fileTmp, FTP_BINARY)) {
						$this->_errors = "Lỗi tải tập tin!";
					}
				}
			}
		}
		return $this->responsive($this->_fileName);
	}

	// Phương thức upload nhiều tập tin tới FTP Server
	public function ftpUploadMulti()
	{
		$filename = $this->_fileName;
		$this->setFileName($filename . '1');
		$result = $this->ftpUpload();
		$response = [
			'status' => $result['status'],
			'message' => $result['message'],
			'data'	=> [$result['data']]
		];
		if ($this->_data) {
			foreach ($this->_data as $key => $options) {
				unset($this->_data[$key]);
				$this->setFileName($filename . ($key + 2));
				$this->setParams($options);
				$result = $this->ftpUpload();
				if ($response['status'] == true) {
					$response['status'] = $result['status'];
					$response['message'] = $result['message'];
				}
				$response['data'][] = $result['data'];
			}
		}
		return $response;
	}

	public function ftpMKDir($dir)
	{
		if ($this->_ftpServer && !$this->isError()) {
			return @ftp_mkdir($this->_ftpServer, $dir);
		}
		return false;
	}

	// Phương thức xóa tập tin trên FTP Server
	public function ftpFileDelete($filename)
	{
		if ($this->_ftpServer && !$this->isError()) {
			if (!@ftp_delete($this->_ftpServer, $filename)) {
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
