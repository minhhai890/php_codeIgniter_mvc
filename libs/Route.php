<?php

namespace libs;

class Route
{
	protected $_data; 					// Lưu tên của phương thức get (type array)
	protected $_params; 				// Lưu tham số của hằng số $_GET và $_POST (type array)
	protected $_dataUrl; 				// Lưu đường dẫn khi gọi qua name (type array)
	protected $_controller; 			// Lưu tên controller và phương thức hoặc lưu function (type array)
	protected $_excute; 				// Lưu điều kiện thực hiện cho phương thức get (type boolean)
	protected $_host; 					// Thiết lập đường dẫn host (type string)
	protected $_url; 					// Lưu đường dẫn url hiện tại (type string)
	protected $_pathGroup; 				// Lưu tên where (type array)

	public $fixUrl 	= '([A-z0-9_\-\.]+)';
	public $fixNumeric = '([0-9]+)';
	public $fixString = '([A-z_\-\.]+)';

	// Phương thức khởi tạo
	public function __construct()
	{
		// Thiết lập url
		$this->_url = URL_SITE;
		$this->_host = rtrim(Config::get('app.url.host'), '/');
		// Khởi tạo Session
		Session::init();
		// Thiết lập thông số trình duyệt, hệ điều hành
		Device::set();
	}

	// Phương thức thiết lập thông tin cho website
	public function setApp($appName, $device = false)
	{
		if ($appName) {
			$this->_data[] = [
				'appName' => $appName,			// Tiền tố namespace
				'device' => $device				// Sử dụng responsive mobile | desktop (true | false)
			];
			// Thiết lập load file image|css|js
			$this->get('loadfile', '/' . $appName . '/{folder}/{filename}')->where([
				'folder' => '(images|css|js)',
				'filename' => '([A-z0-9\-_\.\/]+)'
			]);
		}
	}

	// Thiết lập trang lỗi
	public function setError($startPath, $routeName, $redirect = false)
	{
		if ($this->_data) {
			$key = Func::getLastKeyArray($this->_data);
			$this->_data[$key]['error'] = [
				'startpath'  => $startPath,				// Đường dẫn nhận biết trang lỗi host + path
				'routename' => $routeName,				// Route gọi tranh lỗi
				'redirect'  => $redirect,				// Cho phép chuyển về trang lỗi hoặc không chuyển
			];
		}
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
		return \str_replace(['/', '-', '.'], ['\/', '\-', '\.'], $this->_host . rtrim($pattern, '/')) . '\/?';
	}

	// Phương thức thiết lập pattern
	protected function setPattern()
	{
		if ($this->_data) {
			$dataNew = [];
			foreach ($this->_data as $key => $value) {
				if (isset($value['url'])) {
					foreach ($value['url'] as $k => $v) {
						$pattern = '#^' . $this->convertPattern($v['path']);
						if ($v['method'] == 'GET') {
							$pattern .= '(\?.+)?(&.+)?(\#[A-z0-9\-_]+)?$#';
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
				if ($this->_excute['name'] == 'loadfile') {
					// Tải tập tin image | css | js
					$this->loadfile();
				} elseif (isset($this->_params['controller']) && isset($this->_params['action'])) {
					// Tạo đối tượng Controller và gọi phương thức xử lý
					$this->excute($this->_params['controller'], $this->_params['action']);
				} else {
					$this->error();
				}
			} else {
				if ($excute = explode('@', $this->_excute['excute'])) {
					// Tạo đối tượng Controller và gọi phương thức xử lý
					$this->excute($excute[0], $excute[1]);
				}
			}
		} else {
			$this->error();
		}
	}

	// Phương thức khởi tạo đối tượng controller
	protected function excute($controller, $action, $error = false)
	{
		if ($controller && $action) {
			$this->_params['action'] = $action;
			$this->_params['controller'] = $controller = ucfirst($controller);
			$prefixNamespace = 'src' . '\\' . $this->_excute['appName'];
			if ($this->_excute['device'] == true) {
				$prefixNamespace .= '\\' . Device::get();
			}
			$className = $prefixNamespace . '\\controllers\\' . $controller . 'Controller';
			$filename =  DIR_ROOT . \str_replace('\\', '/', $className) . '.php';
			if (file_exists($filename)) {
				require_once $filename;
				if (class_exists($className, false)) {
					$params = $this->_params;
					$params['excute'] = $this->_excute;
					$params['excute']['prefixNamespace'] = $prefixNamespace;
					$this->_params = NULL;
					$this->_excute = NULL;
					$params['route'] = $this;
					$this->_controller = new $className($params);
					$this->method($action);
				}
			} else {
				if (!$error) {
					$this->error();
				}
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
			'path' => $path,
			'excute' => $excute,
			'where' => []
		];
		return $this;
	}

	// Phương thức tải tập tin Image | Css | Js
	protected function loadfile()
	{
		$flag = false;
		$filename = DIR_ROOT . 'src' . DS . $this->_excute['appName'] . DS;
		if ($this->_params['folder'] != 'images') {
			if ($this->_excute['device'] == true) {
				$filename .= Device::get() . DS;
			}
			$filename .= 'views' . DS;
		}
		$filename .= $this->_params['folder'] . DS . $this->_params['filename'];
		if (is_file($filename)) {
			if ($exten = strtolower(pathinfo($filename, PATHINFO_EXTENSION))) {
				if ($type = Func::getTypeFileExtension($exten)) {
					$flag = true;
					header('Content-Type: ' . $type);
					header('Content-Length: ' . filesize($filename));
					echo @file_get_contents($filename);
				}
			}
		}
		if ($flag == false) {
			http_response_code(404);
		}
	}

	// Phương thức thông báo lỗi
	public function error()
	{
		if ($this->_data) {
			foreach (array_reverse($this->_data) as $value) {
				if (isset($value['error']['startpath'])) {
					$pattern = '#^' . $this->convertPattern($value['error']['startpath']) . '#';
					if (\preg_match($pattern, $this->_url, $matches)) {
						$routename = $value['error']['routename'];
						if (isset($this->_dataUrl[$routename])) {
							if ($value['error']['redirect'] == true) {
								header('Location: ' . $this->url($routename));
								exit();
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
											$this->excute($excute[0], $excute[1], true);
										}
									}
								}
							}
						}
						break;
					}
				}
			}
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
			$this->_pathGroup = $path;
			$excute($this);
			$this->_pathGroup = null;
		}
	}

	// Phương thức trả về đường dẫn url
	public function url($routeName, $options = [])
	{
		$url = $this->_host;
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
