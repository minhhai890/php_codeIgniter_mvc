<?php

namespace libs;
// Chỉnh sửa lại phần upload cho phép upload 1 hay nhiều hình
class Upload
{
	// Biến lưu dữ liệu
	private $_data;

	// Biến lưu trữ tên tập tin
	private $_fileName;

	// Biến lưu trữ kích thước tập tin
	private $_fileSize;

	// Biến lưu trữ phần mỡ rộng của tập tin
	private $_fileExtension;

	// Biến lưu trữ đường dẫn tạm của tập tin
	private $_fileTmp;

	// Biến lưu trữ đường dẫn upload
	private $_dir;

	// Biến lưu đơn vị kích thước
	private $_units = ['B', 'KB', 'MB', 'GB', 'TB'];

	// Biến lưu Ftp Server
	private $_ftpServer = FTP_SERVER;

	// Biến lưu Ftp Username
	private $_ftpUser = FTP_USER;

	// Biến lưu Ftp Password
	private $_ftpPass = FTP_PASS;

	// Biến lưu Ftp Port
	private $_ftpPort = FTP_PORT;

	// Biến lưu kết nối FTP Server
	private $_ftpConnect;

	// Biến lưu trữ các giá trị lỗi
	private $_errors = NULL;

	// Phương thức khởi tạo
	public function init($fileName)
	{
		if (isset($_FILES[$fileName])) {
			if (is_array($_FILES[$fileName]['name'])) {
				foreach ($_FILES[$fileName]['name'] as $key => $name) {
					$this->_data[] = [
						'name' => $name,
						'type' => $_FILES[$fileName]['type'][$key],
						'tmp_name' => $_FILES[$fileName]['tmp_name'][$key],
						'error' => $_FILES[$fileName]['error'][$key],
						'size' => $_FILES[$fileName]['size'][$key]
					];
				}
				if ($options = current($this->_data)) {
					array_shift($this->_data);
					$this->setParams($options);
				}
			}
		} else {
			$this->_errors = 'Vui lòng chọn tập tin!';
		}
	}

	// Phương thức thiết lập tham số trước khi tải tập tin
	public function setParams($options)
	{
		if ($options['error'] > 0) {
			$this->_errors = 'Lỗi tải tập tin!';
		} else {
			$this->_fileName = $options['name'];
			$this->_fileSize = $options['size'];
			$this->_fileTmp = $options['tmp_name'];
			$this->_fileExtension = $this->getExtension($this->_fileName);
		}
	}

	// Phương thức random
	public function rename()
	{
		$search = '.' . $this->_fileExtension;
		$replace = '_' . time() . '.' . $this->_fileExtension;
		return str_replace($search, $replace, $this->_fileName);
	}

	// Phương thức get filename
	public function getFileName()
	{
		return $this->_fileName;
	}

	// Phương thức thiết lập phần mở rộng
	public function setExtension($strExtension)
	{
		if ($this->_fileExtension) {
			if (strpos($strExtension, $this->_fileExtension) === false) {
				$this->_errors = "Định dạng tập tin không hợp lệ! ( " . $strExtension . " )";
			}
		}
	}

	// Phương thức lấy phần mở rộng
	public function getExtension($path)
	{
		if ($exten = strtolower(pathinfo($path, PATHINFO_EXTENSION))) {
			return $exten;
		}
		return false;
	}

	// Phương thức get fileTmp
	public function getFileTmp()
	{
		return $this->_fileTmp;
	}

	// Phương thức thiết lập kích thước tối thiều và kích thước tối đa (đơn vị tính B)
	public function setFileSize($maxSize)
	{
		if ($sizeNumeric = Func::getNumeric($maxSize)) {
			$sizeUnit = Func::getString($maxSize);
			if ($sizeUnit) {
				foreach ($this->_units as $unit) {
					if ($unit !== 'B') {
						$sizeNumeric *= 1024;
						if (strtoupper($sizeUnit) == $unit) {
							break;
						}
					}
				}
			}
			if ($this->_fileSize > $sizeNumeric) {
				$this->_errors = "Kích thước tệp quá lớn! ( kích thước tối đa: " . $maxSize . ")";
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
		if (file_exists($dir)) {
			$this->_dir = $dir;
		} else {
			$this->_errors = "Thư mục không tồn tại!";
		}
	}

	// Phương thức trả về đường dẫn đến thư mục
	public function getDir()
	{
		return $this->_dir;
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

	// Phương thức hiển thị lỗi
	public function getError()
	{
		return $this->_errors;
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

	// Phương thức trả kết quả upload
	public function responsive($filename)
	{
		$responsive = [
			'status' => 'true',
			'filename' => $filename
		];
		if ($this->isError()) {
			$responsive['status'] = 'false';
			$responsive['error'] = $this->getError();
		} else {
			$responsive['message'] = 'Tải tập tin thành công!';
		}
		return $responsive;
	}

	// Phương thức upload tập tin
	public function fileUpload($rename = true)
	{
		$filename = $rename ? $this->rename() : $this->_fileName;
		$destination = $this->_dir . DS . $filename;
		if (!$this->isError()) {
			if (@move_uploaded_file($this->_fileTmp, $destination)) {
				if ($this->_data) {
					if ($options = current($this->_data)) {
						array_shift($this->_data);
						$this->setParams($options);
					}
				}
			} else {
				$this->_errors = "Lỗi tải tập tin!";
			}
		}
		return $this->responsive($filename);
	}

	// Phương thức kết nối máy chủ FTP Server
	public function ftpConnect()
	{
		if (!$this->_ftpConnect = ftp_connect($this->_ftpServer, $this->_ftpPort)) {
			$this->_errors = 'Không thể kết nối máy chủ ' . $this->_ftpServer;
			return false;
		}
		if (!ftp_login($this->_ftpConnect, $this->_ftpUser, $this->_ftpPass)) {
			$this->_errors = 'Không thể đăng nhập vào máy chủ ' . $this->_ftpServer;
			return false;
		}
		ftp_pasv($this->_ftpConnect, true);
		return true;
	}

	// Phương thức đóng kết nối máy chủ FTP Server
	public function ftpClose()
	{
		if ($this->_ftpConnect) {
			ftp_close($this->_ftpConnect);
		}
	}

	// Phương thức upload to FTP Server
	public function ftpUpload($pathFile)
	{
		if ($this->_ftpConnect && !$this->isError()) {
			$destination = $this->_dir . DS . $this->_fileName;
			if (!ftp_put($this->_ftpConnect, $destination, $pathFile, FTP_BINARY)) {
				$this->_errors = "Lỗi tải tập tin!";
			}
		}
		return $this->responsive($pathFile);
	}
}
