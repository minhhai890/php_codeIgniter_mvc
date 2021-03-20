<?php

namespace libs;

class Files
{

	// Get filename
	static function getFilename($path)
	{
		$pathinfo = pathinfo($path);
		if (isset($pathinfo['extension'])) {
			return $pathinfo['basename'];
		}
		return false;
	}

	// Get Extension
	static function getExtension($path)
	{
		$pathinfo = pathinfo($path);
		if (isset($pathinfo['extension'])) {
			return $pathinfo['extension'];
		}
		return false;
	}

	// Read file $type: true = array || false: text
	static function readFile($path, $type = true)
	{
		if (file_exists($path)) {
			if ($type == true) {
				return file($path);
			}
			if ($type == false) {
				return file_get_contents($path);
			}
		}
		return false;
	}

	// Ghi file
	static function writeFile($path, $source)
	{
		if (file_exists($path)) {
			$fp = fopen($path, 'a');
		} else {
			$fp = fopen($path, 'w');
		}
		fwrite($fp, $source);
		fclose($fp);
	}

	// Copy file
	static function copyFile($pathOld, $pathNew)
	{
		if (file_exists($pathOld) && file_exists(self::getDirectory($pathNew))) {
			return @copy($pathOld, $pathNew);
		}
		return false;
	}

	// Rename file or directory
	static function rename($path, $newname)
	{
		if (file_exists($path)) {
			if (is_file($path)) {
				$pathFilenamenew = self::getDirectory($path) . DS . $newname;
			} else {
				$pos = strripos($path, DS);
				$pathFilenamenew = substr($path, 0, $pos) . DS . $newname;
			}
			return rename($path, $pathFilenamenew);
		}
		return false;
	}

	// Delete file
	static function deleteFile($path)
	{
		if (is_file($path)) {
			return @unlink($path);
		}
		return false;
	}

	// get all list file or directory current $mode = all | file | dir
	static function list($path, $mode = 'all')
	{
		$result = [];
		$handle = opendir($path);
		while (($name = readdir($handle)) != false) {
			if (strlen($name) > 2) {
				$pathNew = $path . DS . $name;;
				if ($mode == 'all') {
					$result[] = $pathNew;
					continue;
				}
				if ($mode == 'file' && is_file($pathNew)) {
					$result[] = $pathNew;
					continue;
				}
				if ($mode == 'dir' && is_dir($pathNew)) {
					$result[] = $pathNew;
				}
			}
		}
		return $result;
	}

	// get all list file or directory 
	static function listAll($path, $file = true)
	{
		$list = self::relist($path, $file);
		return array_keys($list);
	}

	// get all list file or directory recursive list
	static function relist($path, $file = true)
	{
		$result = [];
		$handle = opendir($path);
		while (($name = readdir($handle)) != false) {
			if (strlen($name) > 2) {
				$pathNew = $path . DS . $name;
				if (self::getFilename($pathNew) == false) {
					// folder
					$result = \array_merge($result, self::relist($pathNew));
				} else {
					if ($file == true) {
						$result[$pathNew] = '';
					} else {
						$result[$path] = '';
					}
				}
			}
		}
		return $result;
	}


	// Create directory
	static function createDirectory($path)
	{
		if (!\is_dir($path)) {
			return @mkdir($path);
		}
		return false;
	}

	// Get directory
	static function getDirectory($path)
	{
		$pathinfo = pathinfo($path);
		if (isset($pathinfo['extension'])) {
			return $pathinfo['dirname'];
		}
		return $path;
	}

	// Copy directory
	static function copyDirectory($pathOld, $pathNew)
	{
		if (\is_dir($pathOld) && \is_dir($pathNew)) {
			$items = self::listAll($pathOld, true);
			foreach ($items as $value) {
				$sub = substr($value, \strlen($pathOld));
				$itemsNew = explode(DS, $sub);
				$pathSubOld = $pathOld;
				$pathSubNew = $pathNew;
				foreach ($itemsNew as $name) {
					$pathSubOld .= DS . $name;
					$pathSubNew .= DS . $name;
					if (self::getFileName($pathSubOld)) {
						self::copyFile($pathSubOld, $pathSubNew);
						break;
					} else {
						self::createDirectory($pathSubNew);
					}
				}
			}
		}
		return false;
	}

	// Delete directory
	static function deleteDirectory($path)
	{
		if (\is_dir($path)) {
			$items = self::listAll($path, true);
			foreach ($items as $filename) {
				self::deleteFile($filename);
			}
			return @rmdir($path);
		}
		return false;
	}
}
