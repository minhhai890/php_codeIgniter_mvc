<?php

namespace libs;

class Validate
{

	// Kiểu định dạng cần kiểm tra
	protected $_types = [
		'integer', 'float', 'email', 'string', 'numeric', 'array', 'boolean'
	];

	// Phương thức POST form
	public function post($options = array(), $prefix = NULL)
	{
		$result = [];
		$flag = true;
		if ($options && \is_array($options)) {
			foreach ($options as $name => $validate) {
				$item = ((isset($_POST[$name])) ? $_POST[$name] : null);
				if ($validate) {
					// require
					if (\strpos($validate, 'require') !== false) {
						if (is_null($item) || $item == '') {
							$flag = false;
							break;
						}
						$validate = \preg_replace('/\|?require\|?/', '', $validate);
					}
					// Type && validate
					if ($validate) {
						if (\in_array($validate, $this->_types)) {
							if (!is_null($item) && !empty($item)) {
								if (\method_exists($this, $validate)) {
									$item = $this->$validate($item);
									if (\is_bool($item)) {
										$flag = false;
										break;
									}
								}
							}
						} else {
							$flag = false;
							break;
						}
					}
				}
				$result[$prefix . $name] = $item;
			}
		}
		// trả kết quả
		if ($flag) {
			return $result;
		}
		return false;
	}

	// Phương thức GET form
	public function get($options = array(), $prefix = NULL)
	{
		$result = [];
		$flag = true;
		if ($options && \is_array($options)) {
			foreach ($options as $name => $validate) {
				$item = ((isset($_GET[$name])) ? $_GET[$name] : null);
				if ($validate) {
					// require
					if (\strpos($validate, 'require') !== false) {
						if (is_null($item) || $item == '') {
							$flag = false;
							break;
						}
						$validate = \preg_replace('/\|?require\|?/', '', $validate);
					}
					// Type && validate
					if ($validate) {
						if (\in_array($validate, $this->_types)) {
							if (!is_null($item) && !empty($item)) {
								if (\method_exists($this, $validate)) {
									$item = $this->$validate($item);
									if (\is_bool($item)) {
										$flag = false;
										break;
									}
								}
							}
						} else {
							$flag = false;
							break;
						}
					}
				}
				$result[$prefix . $name] = $item;
			}
		}
		// trả kết quả
		if ($flag) {
			return $result;
		}
		return false;
	}

	// Phương thức FILES form
	public function files($options = array(), $prefix = NULL)
	{
		$result = [];
		if ($options && \is_array($options)) {
			foreach ($options as $name) {
				$flag = true;
				$result[$prefix . $name] = null;
				if (isset($_FILES[$name])) {
					if (is_array($_FILES[$name]['error'])) { // multiple						
						foreach ($_FILES[$name]['error'] as $error) {
							if ($error > 0) {
								$flag = false;
								break;
							}
						}
					} elseif ($_FILES[$name]['error'] > 0) {
						$flag = false;
					}
					$result[$prefix . $name] = $_FILES[$name];
				}else{
					$flag = false;
					break;
				}
			}
		}
		// trả kết quả
		if ($flag) {
			return $result;
		}
		return false;
	}


	//===================== FUNCTION VALIDATE =========================//

	// Phương thức kiểm tra email và trả về $input nếu đúng, null nếu sai
	public function email($input)
	{
		return filter_var($input, FILTER_VALIDATE_EMAIL);
	}

	// Phương thức kiểm tra integer và trả về $input nếu đúng, null nếu sai
	public function integer($input)
	{
		return filter_var($input, FILTER_VALIDATE_INT);
	}

	// Phương thức kiểm tra float và trả về $input nếu đúng, null nếu sai
	public function float($input)
	{
		$data = filter_var($input, FILTER_VALIDATE_FLOAT);
		if ($data) {
			return round($data, 2);
		}
		return $data;
	}

	// Phương thức kiểm tra array và trả về $input nếu đúng, null nếu sai
	public function array($input)
	{
		if (is_array($input)) {
			return $input;
		}
		return;
	}

	// Phương thức kiểm tra string và trả về $input nếu đúng, null nếu sai
	public function string($input)
	{
		if (is_string($input)) {
			return $input;
		}
		return;
	}

	// Phương thức kiểm tra số và trả về $input nếu đúng, null nếu sai
	public function numeric($input)
	{
		if (preg_match('/^\d+$/', $input)) {
			return $input;
		}
		return;
	}

	// Phương thức kiểm tra định dạnh boolean
	public function boolean($input)
	{
		if (is_bool($input)) {
			return true;
		}
		return false;
	}
}