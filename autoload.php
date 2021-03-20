<?php
define('DS', '/'); //DIRECTORY_SEPARATOR
define('DIR_ROOT', __DIR__ . DS);
define('SCHEME', (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 'https' : 'http') . '://');
define('URL_SITE', SCHEME . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
Autoload::register();
libs\Config::set();
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
		spl_autoload_register(array('Autoload', 'loadClassLoader'), true, true);
	}
}
