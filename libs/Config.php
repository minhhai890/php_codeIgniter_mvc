<?php

namespace libs;

class Config
{

	static $_data;

	// Phương thức thiết lập dữ liệu config
	public static function set()
	{
		$folder = DIR_ROOT . 'config';
		$handle = opendir($folder);
		while (($filename = readdir($handle)) != false) {
			$path = $folder . DS . $filename;
			$pathinfo = pathinfo($path);
			if (strtolower(@$pathinfo['extension']) == 'php') {
				self::$_data[$pathinfo['filename']] = include_once $path;
			}
		}
	}

	// Phương thức trả về giá trị 
	public static function get($keyword)
	{
		if (self::$_data && $keyword) {
			if ($items = explode('.', $keyword)) {
				$data = self::$_data;
				foreach ($items as $key) {
					if (isset($data[$key])) {
						$data = $data[$key];
					} else {
						$data = null;
						break;
					}
				}
				return $data;
			}
		}
	}
}
