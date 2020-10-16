<?php
define('DS', '/');
define('DIR_ROOT', __DIR__ . DS);
Autoload::register();
class Autoload
{
	public static function loadClassLoader($class)
	{
		$filename = DIR_ROOT . str_replace(['.', '\\'], '/', $class) . ".php";
		if (is_file($filename)) {
			require_once $filename;
		}
	}

	public static function register()
	{
		self::config();
		spl_autoload_register(array('Autoload', 'loadClassLoader'), true, true);
	}

	public static function config()
	{
		$folder = DIR_ROOT . 'config';
		$handle = opendir($folder);
		while (($filename = readdir($handle)) != false) {
			if (strlen($filename) > 2) {
				require_once $folder . DS . $filename;
			}
		}
	}
}
