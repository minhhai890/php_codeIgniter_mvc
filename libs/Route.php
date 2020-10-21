<?php

namespace libs;

class Route
{
	protected $_data; 				// Lưu tên của phương thức get (type array)
	protected $_params; 			// Lưu tham số của hằng số $_GET và $_POST (type array)
	protected $_dataUrl; 				// Lưu đường dẫn khi gọi qua name (type array)
	protected $_controller; 		// Lưu tên controller và phương thức hoặc lưu function (type array)
	protected $_excute; 			// Lưu điều kiện thực hiện cho phương thức get (type boolean)
	protected $_url = URL_SITE; 	// Lưu đường dẫn url hiện tại (type string)
	protected $_pathGroup; 				// Lưu tên where (type array)

	public $fixUrl 	= '([A-z0-9_\-\.]+)';
	public $fixNumeric = '([0-9]+)';
	public $fixString = '([A-z_\-\.]+)';

	public function __construct()
	{
		// Thiết lập thông số trình duyệt, hệ điều hành
		UserAgent::set();
	}

	// Phương thức thiết lập params
	protected function setParams($key, $value)
	{
		$this->_params[$key] = trim($value, "-");
	}

	// Phương thức kiểm tra đường dẫn url
	protected function isPathUrl($data)
	{
		if ($data) {
			preg_match($data['pattern'], $this->_url, $matches);
			if ($matches) {
				$this->_excute = $data;
				if ($data['items']) {
					$i = 1;
					foreach ($data['items'] as $key => $value) {
						$value = ((isset($matches[$i])) ? $matches[$i] : '');
						$this->setParams($key, $value);
						$i++;
					}
				}
			}
		}
	}

	// Phương thức thiết lập giá trị từ khóa
	protected function setItemsPattern($pattern, $options = [])
	{
		$result = [
			'items' => [],
			'pattern' => $pattern
		];
		preg_match_all('#{([A-z0-9]+)\??}#', $result['pattern'], $matches);
		if (isset($matches[0]) && $matches[0]) {
			foreach ($matches[0] as $key => $value) {
				$replace = $this->fixUrl;
				if ($options) {
					if (isset($options[$matches[1][$key]])) {
						$replace =  $options[$matches[1][$key]];
					}
				}
				$result['items'][$matches[1][$key]] = preg_replace(
					[
						'#{' . $matches[1][$key] . '}#',
						'#{' . $matches[1][$key] . '\?}#'
					],
					[
						$replace,
						$replace . '?',
					],
					$value
				);
				$result['pattern'] = preg_replace(
					[
						'#{'   . $matches[1][$key] . '}#',
						'#\/{' . $matches[1][$key] . '\?}#',
						'#\-{' . $matches[1][$key] . '\?}#',
						'#{'   . $matches[1][$key] . '\?}#'
					],
					[
						$replace,
						'/?' . $replace . '?',
						'-?' . $replace . '?',
						$replace . '?',
					],
					$result['pattern']
				);
			}
		}
		return $result;
	}

	// Phương thức chuyển đổi ký tự đặc biệt
	protected function convertPattern($pattern)
	{
		return \str_replace(['/', '-', '.'], ['\/', '\-', '\.'], URL_HOST . $pattern);
	}

	// Phương thức thiết lập pattern
	protected function setPattern()
	{
		if ($this->_data) {
			$dataNew = [];
			foreach ($this->_data as $key => $value) {
				if (isset($value['url'])) {
					foreach ($value['url'] as $k => $v) {
						if ($v['excute'] == NULL && $v['method'] == 'GET') {
							$v['path'] .= '/{controller}/{action}';
						}
						$pattern = '#^' . $this->convertPattern($v['path']);
						if ($v['method'] == 'GET') {
							$pattern .= '(\?.+)?(\#[A-z0-9\-_]+)?$#';
						} else {
							$pattern .= '$#';
						}
						// Thiết lập tham số truyền vào
						$path = $this->setItemsPattern($pattern, $v['where']);
						$v['items'] = $path['items'];
						$v['pattern'] = $path['pattern'];
						// Thiết lập giá trị
						$this->_data[$key]['url'][$k] = $v;
						$data = $value;
						unset($data['url']);
						// Kiểm tra đường dẫn
						$this->isPathUrl(\array_merge($data, $v));
						// Lưu url
						$this->setUrl($v['name'], $v['path'], $v['excute']);
					}
				}
				$dataNew[] = $data;
			}
			$this->_data = $dataNew;
		}
	}

	// Phương thức thực hiện chương trình
	protected function setExcute()
	{
		if ($this->_excute) {
			if (gettype($this->_excute['excute']) == 'object') {
				return $this->_excute['excute']($this);
			}
			if ($this->_excute['excute'] == NULL) {
				if (isset($this->_params['controller']) && isset($this->_params['action'])) {
					// Tạo đối tượng Controller và gọi phương thức xử lý
					$this->excute($this->_params['controller'], $this->_params['action']);
				} else {
					$this->error();
				}
				return;
			}
			if ($excute = explode('@', $this->_excute['excute'])) {
				// Tạo đối tượng Controller và gọi phương thức xử lý
				$this->excute($excute[0], $excute[1]);
			}
		} else {
			$this->error();
		}
	}

	// Phương thức khởi tạo đối tượng controller
	protected function excute($controller, $action)
	{
		if ($controller && $action) {
			$this->_params['controller'] = $controller;
			$this->_params['action'] = $action;
			$className = 'resources' . '\\' . $this->_excute['object'] . '\\' . $this->_excute['src']['controllers'] . '\\' . $controller . 'Controller';
			$filename =  DIR_ROOT . \str_replace('\\', '/', $className) . '.php';
			if (file_exists($filename)) {
				require_once $filename;
				if (class_exists($className, false)) {
					$params = $this->_params;
					$params['data'] = $this->_data;
					$params['excute'] = $this->_excute;
					$this->_data = NULL;
					$this->_params = NULL;
					$this->_excute = NULL;
					$params['route'] = $this;
					$params['route']->_data = NULL;
					$this->_controller = new $className($params);
					$this->method($action);
				}
			} else {
				$this->error();
			}
		} else {
			$this->error();
		}
	}

	// Phương thước gọi phương thức xử lý
	protected function method($action)
	{
		if (method_exists($this->_controller, $action) == true) {
			$responsive = $this->_controller->$action();
			if ($responsive) { // Responsive API
				if (\is_array($responsive)) {
					header('Content-Type: application/json');
					echo json_encode($responsive, JSON_UNESCAPED_UNICODE);
				} else {
					echo $responsive;
				}
			}
		} else {
			$this->error();
		}
	}

	// Thiết lập dường dẫn khi gọi theo name
	protected function setUrl($name, $path, $excute)
	{
		$this->_dataUrl[$name] = [
			'path' => $path,
			'excute' => $excute
		];
	}

	/* Phương thức thiết lập đường dẫn
	 *  $method: phương thức GET | POST
     * $name: là tên route dùng để lấy đường dẫn url
     * $path: là đường dẫn hiển thị trên thanhd địa chỉ
     * 		Bao gồm:
     * 			không có tham số
     * 			có tham số
     * 				- {id} là tham số bắt buộc phải có
     * 				- {id?} là tham số có cũng được, không có cũng được
     * $controllerAction: được chấp nhận có dạng controller@action | NULL
     */
	protected function request($method, $name, $path, $excute)
	{
		// Kiểm tra function
		if (gettype($path) == 'object') {
			$excute = $path;
			$path = $name;
		}
		// Nếu sử dụng group
		if ($this->_pathGroup) {
			$path = $this->_pathGroup . $path;
		}
		// Kiểm tra phương thức
		$key = Func::getLastKeyArray($this->_data);
		// Gán kết quả		
		$this->_data[$key]['url'][] = [
			'method' => $method,
			'name' => $name,
			'path' => ltrim($path, DS),
			'excute' => $excute,
			'where' => []
		];
		return $this;
	}

	// Phương thức thông báo lỗi
	public function error()
	{
		foreach (array_reverse($this->_data) as $value) {
			if (isset($value['error']['startpath'])) {
				$pattern = '#^' . $this->convertPattern($value['error']['startpath']) . '#';
				if (\preg_match($pattern, $this->_url, $matches)) {
					$routename = $value['error']['routename'];
					if (isset($this->_dataUrl[$routename])) {
						if ($value['error']['redirect'] == true) {
							Url::redirect($this->getUrl($routename));
						} else {
							$excute = $this->_dataUrl[$routename]['excute'];
							if ($excute) {
								if (gettype($excute) == 'object') {
									return $excute($this);
								} else {
									if ($excute = explode('@', $excute)) {
										// Thiết lập giá trị excute
										$this->_excute = $value;
										// Tạo đối tượng Controller và gọi phương thức xử lý										
										$this->excute($excute[0], $excute[1]);
									}
								}
							}
						}
					}
				}
			}
		}
	}

	// Phương thức thiết lập thông tin cho website
	public function set($options = array())
	{
		$default = [
			'object' => '',						// Tiền tố namespace					
			'src' => [							// thư mục chứa mã nguồn
				'libs' => 'libs',				// thư mục thư việc của site
				'controllers' => 'controllers',	// thư mục chứa controller xử lý
				'models' => 'models',				// thư mục chứa model xử lý database
				'views' => 'views'				// thư mục chứa giao diện
			],
			'device' => false,					// Sử dụng responsive mobile | desktop
			'error' => [
				'redirect'  => false,			// Cho phép chuyển về trang lỗi hoặc không chuyển
				'startpath'  => '/',				// Đường dẫn nhận biết trang lỗi host + path
				'routename' => 'error',			// Route gọi tranh lỗi
			],
		];
		if ($options) {
			$this->_data[] = array_merge($default, $options);
		}
	}

	/* Phương thức thiết lập đường dẫn GET
     * $name: là tên route dùng để lấy đường dẫn url
     * $path: là đường dẫn hiển thị trên thanhd địa chỉ
     * 		Bao gồm:
     * 			không có tham số
     * 			có tham số
     * 				- {id} là tham số bắt buộc phải có
     * 				- {id?} là tham số có cũng được, không có cũng được
     * $controllerAction: được chấp nhận có dạng controller@action | NULL
     */
	public function get($name, $path, $excute = NULL)
	{
		return $this->request('GET', $name, $path, $excute);
	}

	/* Phương thức thiết lập đường dẫn POST
     * $name: là tên route dùng để lấy đường dẫn url
     * $path: là đường dẫn hiển thị trên thanhd địa chỉ
     * 		Bao gồm:
     * 			không có tham số
     * 			có tham số
     * 				- {id} là tham số bắt buộc phải có
     * 				- {id?} là tham số có cũng được, không có cũng được
     * $controllerAction: được chấp nhận có dạng controller@action | NULL
     */
	public function post($name, $path, $excute = NULL)
	{
		return $this->request('POST', $name, $path, $excute);
	}

	/* Phương thức thiết lập điều kiện cho đường dẫn
     * $options là mảng nhưng tham số tương ứng được truyền từ phương thức get();
     * Mặc định tham số được truyền có pattern #{([A-z0-9]+)\??}#
     * Phương thức where cho phép thiết lập lại pattern cho tham số truyền vào
     */
	public function where($options)
	{
		if (is_array($options)) {
			$where = [];
			foreach ($options as $key => $value) {
				if (substr($value, 0, 1) !== '(') {
					$value = '(' . $value . ')';
				}
				$where[$key] = $value;
			}
			$appKey = Func::getLastKeyArray($this->_data);
			$urlKey = Func::getLastKeyArray($this->_data[$appKey]['url']);
			$this->_data[$appKey]['url'][$urlKey]['where'] = $where;
		}
	}

	/* Phương thức thiết lập nhóm đường dẫn có chung giá trị phía trước nó
     * vd: admin/user.html && admin/profile.html 
     */
	public function groups($path, $excute)
	{
		if (gettype($excute) == 'object') {
			$this->_pathGroup = ltrim($path, DS);
			$excute($this);
			$this->_pathGroup = null;
		}
	}

	// Phương thức trả về đường dẫn url
	public function getUrl($routeName, $options = [])
	{
		$url = URL_HOST;
		if (isset($this->_dataUrl[$routeName])) {
			$url .= $this->_dataUrl[$routeName]['path'];
			$pattern = ['#(\/?\-?{[A-z0-9_\-\?]+})+#'];
			$replace = [''];
			if ($options) {
				foreach ($options as $key => $value) {
					array_unshift($pattern, '#{' . $key . '\??}#');
					array_unshift($replace, $value);
				}
			}
			$url = preg_replace($pattern, $replace, $url);
		}
		return $url;
	}

	// Phương thức kết thúc chương trình
	public function __destruct()
	{
		// Thiết lập pattern
		$this->setPattern();
		// Thực hiện chương trình
		$this->setExcute();
	}
}
