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

	// Biến lưu giá trị lỗi
	protected $_error;

	// Phương thước khởi tạo
	public function __construct($params)
	{
		$this->setParams($params);
		$this->setJson();
		$this->setValidate();
		// $this->setModel();
	}

	// Phương thức thiết lập tham số
	public function setParams($params)
	{
		$this->_params = $params;
	}

	/*
	 * Phương thức khởi tạo đối tượng Model tương ứng với Controller
	 * $name là tên model được truyền vào
	 * $params Tham số connect DB
	 */
	public function setModel($name = NULL, $params = array())
	{
		if ($this->_params['controller']) {
			$excute = $this->_params['excute'];
			$className = $excute['prefixNamespace'] . '\\models\\' . ucfirst($name ? $name : $this->_params['controller']) . 'Model';
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
			$className = $excute['prefixNamespace']  . '\\libs\\View';
			$filename =  DIR_ROOT . \str_replace('\\', '/', $className) . '.php';
			if (file_exists($filename)) {
				require_once $filename;
				if (class_exists($className, false)) {
					$this->_view = new $className($this->_params);
				} else {
					$this->_view = new \libs\View($this->_params);
				}
				unset($this->_params['route']);
			}
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

	// Phương thức hiển thị lỗi
	public function pageError()
	{
		if (isset($this->_view->_params['route'])) {
			$this->_view->_params['route']->error();
		} elseif (isset($this->_params['route'])) {
			$this->_params['route']->error();
		}
		http_response_code(500);
	}

	// Trả dữ liệu API REST
	public function response($options)
	{
		$status = [
			102 => 'Yêu cầu đã được tiếp nhận.',
			200 => 'Yêu cầu được xử lý thành công.',
			400 => 'Thông số truyền vào chưa hợp lệ.',
			401 => 'Lỗi ủy quyền.',
			403 => 'Lỗi quyền truy cập.',
			404 => 'Yêu cầu không hợp lệ.',
			405 => 'Phương thức HTTP không hợp lệ.',
			500 => 'Lỗi máy chủ nội bộ'
		];
		if (is_numeric($options)) {
			$options = ['code' => $options];
		}
		if (!isset($status[$options['code']])) {
			$options['code'] = 404;
		}
		$result = [
			'status' => ($options['code'] == 200 ? true : false),
			'code' => $options['code'],
			'message' => $status[$options['code']]
		];
		if (isset($options['message'])) {
			$result['message'] = $options['message'];
		}
		if (isset($options['total'])) {
			$result['total'] = $options['total'];
		}
		if (isset($options['data']) && is_array($options['data'])) {
			$result['data'] = $options['data'];
		}
		return $result;
	}

	// Phương thức thông báo lỗi và dừng chương trình
	public function exits($data)
	{
		header('Content-Type: application/json');
		echo json_encode($data);
		die();
	}
}
