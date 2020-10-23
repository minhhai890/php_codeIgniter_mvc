<?php

namespace libs;

class Controller
{

	// Biến lưu giá trị params route
	protected $_params;

	// Biến đối tượng Model
	protected $_model;

	// Biến đối tượng View
	protected $_view;

	// Biến đối tượng json
	protected $_json;

	// Biến đối tượng validate input form
	protected $_validate;

	// Biến lưu số phần tử hiển thị
	protected $_length = RD_LIMIT;

	// Biến lưu giá trị lỗi
	protected $_error;

	// Phương thước khởi tạo
	public function __construct($params)
	{
		$this->setParams($params);
		$this->setJson();
		$this->setValidate();
		//$this->setModel();
	}

	// Phương thức thiết lập tham số
	public function setParams($params)
	{
		$this->_params = $params;
	}

	/*
	 * Phương thức khởi tạo đối tượng Model tương ứng với Controller
	 * $modelName là tên model được truyền vào
	 * $params Tham số connect DB
	 */
	public function setModel($name = NULL, $params = array())
	{
		if ($this->_params['controller']) {
			$excute = $this->_params['excute'];
			$className = 'resources\\' . $excute['object'] . '\\' . $excute['src']['models'] . '\\' . ($name ? $name : $this->_params['controller']) . 'Model';
			$filename =  DIR_ROOT . \str_replace('\\', '/', $className) . '.php';
			if (file_exists($filename)) {
				require_once $filename;
				if (class_exists($className, false)) {
					if ($name == NULL) {
						$this->_model = new $className($params);
					} else {
						return new $className($params);
					}
				}
			} else {
				$this->_model = new \libs\Model($params);
			}
		}
	}

	/* Phương thức khởi tạo đối tượng View */
	public function setView()
	{
		if ($this->_params['controller']) {
			$excute = $this->_params['excute'];
			$className = 'resources\\' . $excute['object']  . '\\' .  $excute['src']['libs'] . '\\View';
			$filename =  DIR_ROOT . \str_replace('\\', '/', $className) . '.php';
			if (!file_exists($filename)) {
				$filename = DIR_LIBRARY . 'View.php';
				$className = '\\libs\\View';
			}
			require_once $filename;
			if (class_exists($className, false)) {
				$this->_view = new $className($this->_params);
			} else {
				$this->_view = new \libs\View($this->_params);
			}
			unset($this->_params['route']);
		}
	}

	/* Phương thức khởi tạo đối tượng Json */
	public function setJson()
	{
		$this->_json = new Json();
	}

	// Phương thức tạo đối đượng validate
	public function setValidate()
	{
		$this->_validate = new Validate();
	}

	// Phương thức lấy ra đường dẫn route
	public function route($name, $options = [])
	{
		if (isset($this->_view)) {
			return $this->_view->route($name, $options);
		}
	}

	// gửi dữ liệu
	public function postCurl($url, $data)
	{
		if ($url && $data) {
			$curl = curl_init($url);
			$content = json_encode($data);
			curl_setopt($curl, CURLOPT_HEADER, false);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt(
				$curl,
				CURLOPT_HTTPHEADER,
				array("Content-type: application/json")
			);
			curl_setopt($curl, CURLOPT_POST, true);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
			$response = curl_exec($curl);
			curl_close($curl);
		}
	}

	/* Phương thức gán giá trị lỗi */
	public function setError($error)
	{
		$this->_error = $error;
	}

	/* Phương thức kiểm tra lỗi
		* True: có lỗi
		* False: không có lỗi
		*/
	public function isError()
	{
		if (empty($this->_error)) {
			return false;
		}
		return true;
	}

	/* Phương thức trả về giá trị lỗi */
	public function getError()
	{
		return $this->_error;
	}

	// Phương thức hiển thị trang lỗi
	public function pageError()
	{
		if ($this->_view) {
			$this->_view->_params['route']->error();
		} else {
			$this->_params['route']->error();
		}
	}
}
