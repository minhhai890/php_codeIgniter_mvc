<?php

namespace libs;

use libs\Func;

class View
{
	public $_params; 			// Tham số
	public $_folderView;		// Thư mục chứa tập tin giao diện
	public $_fileView;			// Tập tin hiển thị giao diện
	public $_folderViewContent;	// Thư mục chứa tập tin giao diện chi tiết
	public $_fileViewContent;	// Tập tin hiển thị giao diện chi tiết
	public $_fileViewConfig;	// Tập tin cấu hình tải css, js, meta, title
	public $_folderImage;		// Thư mục chứa hình ảnh
	public $_folderUpload;		// Thư mục tập tin tải lên từ client
	public $_title;				// Tiêu đề của trang
	public $_metaHttp;			// Meta http
	public $_metaName;			// Meta name
	public $_fileCss;			// Tập tin hoặc nội dung của css
	public $_fileJs;			// Tập tin hoạc nội dung của js
	public $_data;				// Lựu dữ liệu được truyền từ controller
	public $_device = '';		// Desktop | Mobile

	// Phương thức khởi tạo
	public function __construct($params)
	{
		$this->setParams($params);
		$this->setDevice();
		$this->setFolderView();
		$this->setFolderViewContent();
		$this->setFileView();
		$this->setFileViewConfig();
		$this->setFolderImage();
		$this->setFolderUpload();
	}

	// Phương thức thiết lập tham số
	public function setParams($params)
	{
		$this->_params = $params;
	}

	// Phương thức lấy ra giá trị params
	public function getParams($name)
	{
		if (isset($this->_params[$name])) {
			return $this->_params[$name];
		}
	}

	// Phương thức user agent
	public function setDevice()
	{
		if ($this->_params['excute']['device'] == true) {
			$this->_device = UserAgent::getDevice();
		}
	}

	// Phương thức trả về một object
	public function setObject($objectName)
	{
		$object = Func::getRowArray($this->_params['data'], 'object', $objectName);
		if ($object) {
			$params = $this->_params;
			$params['excute'] = $object;
			return new View($params);
		}
	}

	// Phướng thức lấy ra tập tin mở rộng php
	public function getExtension()
	{
		return '.php';
	}

	// Phương thức thiết lập thư mục chứa giao diện | $folder => folder or folder1.folder2
	public function setFolderView()
	{
		$folderView = $this->_params['excute']['object'] . DS . $this->_params['excute']['src']['views'] . DS;
		$this->_folderView = Func::convertCslashes($folderView);
	}

	// Phương thức lấy ra thư mục chứa giao diện  | $path = true => path or $path = false => url
	public function getFolderView($path = true, $device = true)
	{
		$dir = PATH_RESOURCE;
		if ($path == false) {
			$dir = URL_RESOURCE;
		}
		if ($device == true && $this->_device) {
			return $dir . $this->_folderView . $this->_device . DS;
		} else {
			return $dir . $this->_folderView;
		}
	}

	// Phương thức thiết lập tập tin hiển thị giao diện | $filename => name or folder.name
	public function setFileView($filename = 'web')
	{
		$this->_fileView = Func::convertCslashes($filename) . $this->getExtension();
	}

	// Phương thức lấy ra tập tin hiển thị giao diện | $path = true => path or $path = false => url
	public function getFileView($path = true)
	{
		return $this->getFolderView($path) . $this->_fileView;
	}

	// Phương thức thiết lập thư mục chứa tập tin giao diện chi tiết | $folder => folder or folder1.folder2
	public function setFolderViewContent($folder = 'template')
	{
		$this->_folderViewContent = Func::convertCslashes($folder) . DS;
	}

	// Phương thức lấy ra thư mục chứa tập tin giao diện chi tiết | $path = true => path or $path = false => url
	public function getFolderViewContent($path = true)
	{
		return $this->getFolderView($path) . $this->_folderViewContent;
	}

	// Phương thức thiết lập tập tin hiển thị giao diện thay đổi | $filename => name or folder.name
	public function setFileViewContent($filename)
	{
		$this->_fileViewContent = $this->_folderViewContent . Func::convertCslashes($filename) . $this->getExtension();
	}

	// Phương thức thiết lập tập tin hiển thị giao diện thay đổi | $path = true => path or $path = false => url
	public function getFileViewContent($path = true)
	{
		return $this->getFolderView($path) . $this->_fileViewContent;
	}

	// Phương thức thiết lập tập tin cấu hình tải css, js, meta, title | $filename => name or folder.name
	public function setFileViewConfig($filename = 'config')
	{
		$this->_fileViewConfig = Func::convertCslashes($filename) . $this->getExtension();
	}

	// Phương thức lấy ra tập tin cấu hình tải css, js, meta, title | $path = true => path or $path = false => url
	public function getFileViewConfig($path = true)
	{
		return $this->getFolderView($path) . $this->_fileViewConfig;
	}

	// Phương thức thiết lập thư mục chứa hình ảnh $folder => folder or folder1.folder2
	public function setFolderImage($folder = 'images')
	{
		$this->_folderImage = Func::convertCslashes($folder) . DS;
	}

	// Phương thức lấy ra thư mục chứa hình ảnh $path = true => path or $path = false => url
	public function getFolderImage($path = true)
	{
		return $this->getFolderView($path) . $this->_folderImage;
	}

	// Phương thức thiết lập thư mục tập tin tải lên từ máy khách $folder => folder or folder1.folder2
	public function setFolderUpload($folder = 'uploads')
	{
		$this->_folderUpload = Func::convertCslashes($folder) . DS;
	}

	// Phương thức lấy ra thư mục tập tin tải lên từ máy khách $path = true => path or $path = false => url
	public function getFolderUpload($path = true)
	{
		return $this->getFolderView($path) . $this->_folderUpload;
	}

	// Phương thức thiết lập thẻ meta http
	public function setMetaHttp($metaHttp = array(), $conact = false)
	{
		if ($metaHttp) {
			$str = '';
			foreach ($metaHttp as $meta) {
				if ($meta = explode('|', $meta)) {
					$str .= '<meta http-equiv="' . $meta[0] . '" content="' . $meta[1] . '">';
				}
			}
			if ($conact == false) {
				$this->_metaHttp = $str;
			} else {
				$this->_metaHttp .= $str;
			}
		}
	}

	// Phương thức lấy ra thẻ meta http
	public function getMetaHttp()
	{
		return $this->_metaHttp;
	}

	// Phương thức thiết lập thẻ meta name
	public function setMetaName($metaName = array(), $conact = false)
	{
		if ($metaName) {
			$str = '';
			foreach ($metaName as $meta) {
				if ($meta = explode('|', $meta)) {
					$str .= '<meta name="' . $meta[0] . '" content="' . $meta[1] . '">';
				}
			}
			if ($conact == false) {
				$this->_metaName = $str;
			} else {
				$this->_metaName .= $str;
			}
		}
	}

	// Phương thức lấy ra thẻ meta name
	public function getMetaName()
	{
		return $this->_metaName;
	}

	// Phương thức thiết lập title
	public function setTitle($title)
	{
		$this->_title = $title;
	}

	// Phương thứ lấy ra title
	public function getTitle()
	{
		return $this->_title;
	}

	// Phương thức thiết lập link file css
	public function setCss($option, $onPage = false)
	{
		if ($option) {
			$files = new Files();
			foreach ($option as $key => $value) {
				if ($value) {
					$host = Func::getHost($value);
					if ($host && ($host != HOST_NAME)) {
						$this->_fileCss .= '<link rel="stylesheet" type="text/css" href="' . $value . '">';
					} elseif ($onPage == false) {
						$this->_fileCss .= '<link rel="stylesheet" type="text/css" href="' . $this->getFolderView(false) . $value . '">';
					} else {
						$filename = $this->getFolderView() . $value;
						if (is_file($filename)) {
							$this->_fileCss .= '<style type="text/css">' . $files->readFile($filename, false) . '</style>';
						}
					}
				}
			}
		}
	}

	// Phương thức lấy ra file css
	public function getCss()
	{
		return $this->_fileCss;
	}

	// Phương thức thiết lập link file js
	public function setJs($option, $onPage = false)
	{
		if ($option) {
			$files = new Files();
			foreach ($option as $key => $value) {
				if ($value) {
					$host = Func::getHost($value);
					if ($host && ($host != HOST_NAME)) {
						$this->_fileJs .= '<script type="text/javascript" src="' . $value . '"></script>';
					} elseif ($onPage == false) {
						$this->_fileJs .= '<script type="text/javascript" src="' . $this->getFolderView(false) . $value . '"></script>';
					} else {
						$filename = $this->getFolderView() . $value;
						if (is_file($filename)) {
							$this->_fileJs .= '<script type="text/javascript">' . $files->readFile($filename, false) . '</script>';
						}
					}
				}
			}
		}
	}

	// Phương thức lấy ra file js
	public function getJs()
	{
		return $this->_fileJs;
	}

	// Phương thức thiết lập data
	public function setData($key, $data)
	{
		$this->_data[$key] = $data;
	}

	// Phương thức lấy data
	public function getData($name)
	{
		if (gettype($this->_data) == 'object') {
			if (isset($this->_data->$name)) {
				return $this->_data->$name;
			}
		}
		if (gettype($this->_data) == 'array') {
			if (isset($this->_data[$name])) {
				return $this->_data[$name];
			}
		}
	}

	// Phương thức lấy data cấp 2
	public function getItem($name, $item)
	{
		$data = $this->getData($name);
		if ($data) {
			if (gettype($data) == 'object') {
				if (isset($data->$item)) {
					return $data->$item;
				}
			}
			if (gettype($data) == 'array') {
				if (isset($data[$item])) {
					return $data[$item];
				}
			}
		}
	}

	// Phương thức include
	public function include($filename, $data = null)
	{
		$filename = $this->getFolderView() . Func::convertCslashes($filename) . $this->getExtension();
		if (file_exists($filename)) {
			if (($view = include $filename) != 1) {
				return $view;
			}
		}
	}

	// Phương thức include folder view content
	public function includeFolderContent($filename, $data = null)
	{
		$filename = $this->getFolderViewContent() . Func::convertCslashes($filename) . $this->getExtension();
		if (file_exists($filename)) {
			if (($view = include $filename) != 1) {
				return $view;
			}
		}
	}

	// Phương thức lấy ra đường dẫn route
	public function route($name, $options = [])
	{
		if ($this->_params['route']) {
			return $this->_params['route']->getUrl($name, $options);
		}
	}

	// Phương thức load
	public function load($onPage = false)
	{
		$filename = $this->getFileViewConfig();
		if (is_file($filename)) {
			$items = require_once $filename;
			if ($items && isset($items[$this->_params['controller']][$this->_params['action']])) {
				$this->setMetaHttp($items['metaHttp']);
				$this->setMetaName($items['metaName']);
				$config = $items[$this->_params['controller']][$this->_params['action']];
				$this->setTitle($config['title']);
				// css
				$css = $items['css'];
				if (isset($config['onlyone']['css'])) {
					$css = $config['onlyone']['css'];
				} else {
					if (isset($config['css'])) {
						$css = array_merge($css, $config['css']);
					}
				}
				$this->setCss($css, $onPage);
				// js
				$js = $items['js'];
				if (isset($config['onlyone']['js'])) {
					$js = $config['onlyone']['js'];
				} else {
					if (isset($config['js'])) {
						$js = array_merge($js, $config['js']);
					}
				}
				$this->setJs($js, $onPage);
			}
		}
	}

	// Phương thức render nạp tập tin giao diện $fileName => name or folder.name
	public function render($fileName, $tempFull = true)
	{
		$this->setFileViewContent($fileName);
		$fileName = $this->getFileViewContent();
		if (is_file($fileName)) {
			if ($tempFull == true) {
				require_once $this->getFileView();
			} else {
				require_once $fileName;
			}
		}
	}
}
