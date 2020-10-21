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
	public $_folderImage;		// Thư mục chứa hình ảnh
	public $_folderUpload;		// Thư mục tập tin tải lên từ client
	public $_title;				// Tiêu đề của trang
	public $_linkTags;			// Thẻ link
	public $_metaTags;			// Thẻ meta
	public $_cssTags;			// Thẻ css
	public $_jsTags;			// Thẻ js
	public $_data;				// Lựu dữ liệu được truyền từ controller
	public $_device = '';		// Desktop | Mobile
	public $_phpExt = '.php';	// Phần mở rộng của tập tin

	// Phương thức khởi tạo
	public function __construct($params)
	{
		$this->setParams($params);
		$this->setDevice();
		$this->setFolderView();
		$this->setFolderViewContent();
		$this->setFileView();
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

	// Phương thức thiết lập thư mục chứa giao diện | $folder => folder or folder1.folder2
	public function setFolderView()
	{
		$folderView = $this->_params['excute']['object'] . DS . $this->_params['excute']['src']['views'] . DS;
		$this->_folderView = Func::convertCslashes($folderView);
	}

	// Phương thức lấy ra thư mục chứa giao diện  | $path = true => path or $path = false => url
	public function getFolderView($path = true, $device = true)
	{
		$dir = DIR_RESOURCE;
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
		$this->_fileView = Func::convertCslashes($filename) . $this->_phpExt;
	}

	// Phương thức lấy ra tập tin hiển thị giao diện | $path = true => path or $path = false => url
	public function getFileView($path = true)
	{
		return $this->getFolderView($path) . $this->_fileView;
	}

	// Phương thức thiết lập thư mục chứa tập tin giao diện chi tiết | $folder => folder or folder1.folder2
	public function setFolderViewContent($folder = 'pages')
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
		$this->_fileViewContent = $this->_folderViewContent . Func::convertCslashes($filename) . $this->_phpExt;
	}

	// Phương thức thiết lập tập tin hiển thị giao diện thay đổi | $path = true => path or $path = false => url
	public function getFileViewContent($path = true)
	{
		return $this->getFolderView($path) . $this->_fileViewContent;
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

	// Phương thức thiết lập icon shortcut như một ứng dụng mobile
	public function setShortcut($name, $icon)
	{
		$filename = $this->getFolderView() . 'manifest.json';
		$urlPath = $this->getFolderView(false);
		if (!file_exists($filename)) {
			$content = [
				"version" => "1.0",
				"lang" => "en",
				"name" => $name,
				"scope" => "/",
				"display" => "fullscreen",
				"start_url" =>  URL_HOST,
				"short_name" => $name,
				"description" => "",
				"orientation" => "portrait",
				"background_color" => "#000000",
				"theme_color" => "#000000",
				"generated" => "true",
				"icons" => [
					[
						"src" => $urlPath . $icon,
						"sizes" => "36x36",
						"type" => "image/png"
					]
				]
			];
			$json = new Json();
			$json->write($filename, $content);
		}
		$this->_linkTags .= '<link href="' . $urlPath . $icon . '" type="image/png" rel="shortcut icon"/>';
		$this->_linkTags .= '<link rel="manifest" href="' . $urlPath . 'manifest.json">';
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

	// Phương thứ lấy ra title
	public function getTitleTags()
	{
		return '<title>' . $this->_title . '</title>';
	}

	// Phương thức thiết lập thẻ link tags
	public function setLinkTags($tags)
	{
		$this->_linkTags .= $tags;
	}

	// Phương thức trả về thẻ link tags
	public function getLinkTags()
	{
		return $this->_linkTags;
	}

	// Phương thức thiết lập thẻ meta
	public function setMetaTags($tags)
	{
		$this->_metaTags .= $tags;
	}

	// Phương thức trả về thẻ meta
	public function getMetaTags()
	{
		return $this->_metaTags;
	}

	// Phương thức thiết lập link file css
	public function setCssTags($link, $onPage = false)
	{
		if ($link) {
			if ($onPage == true) {
				if (Func::getHost($link) == HOST_NAME) {
					$filename = $this->getFolderView() . $link;
					if (is_file($filename)) {
						if ($content = file_get_contents($filename)) {
							$this->_cssTags .= '<style type="text/css">' . $content . '</style>';
						}
					}
				}
			} else {
				$this->_cssTags .= '<link rel="stylesheet" type="text/css" href="' . $this->getFolderView(false) . $link . '">';
			}
		}
	}

	// Phương thức thiết lập nhiều link file css cùng lúc
	public function setMultiCssTags($options, $onPage = false)
	{
		if ($options) {
			foreach ($options as $link) {
				$this->setCssTags($link, $onPage);
			}
		}
	}

	// Phương thức lấy ra link hoặc nội dung css
	public function getCssTags()
	{
		return $this->_cssTags;
	}

	// Phương thức thiết lập link file js
	public function setJsTags($link, $onPage = false)
	{
		if ($link) {
			if ($onPage == true) {
				if (Func::getHost($link) == HOST_NAME) {
					$filename = $this->getFolderView() . $link;
					if (is_file($filename)) {
						if ($content = file_get_contents($filename)) {
							$this->_jsTags .= '<script type="text/javascript" src="' . $content . '"></script>';
						}
					}
				}
			} else {
				$this->_jsTags .= '<script type="text/javascript" src="' . $this->getFolderView(false) . $link . '"></script>';
			}
		}
	}

	// Phương thức thiết lập link file js
	public function setMultiJsTags($options, $onPage = false)
	{
		if ($options) {
			foreach ($options as $link) {
				$this->setJsTags($link, $onPage);
			}
		}
	}

	// Phương thức lấy ra file js
	public function getJsTags()
	{
		return $this->_jsTags;
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
		$filename = $this->getFolderView() . Func::convertCslashes($filename) . $this->_phpExt;
		if (file_exists($filename)) {
			if (($view = include $filename) != 1) {
				return $view;
			}
		}
	}

	// Phương thức include folder view content
	public function includeFolderContent($filename, $data = null)
	{
		$filename = $this->getFolderViewContent() . Func::convertCslashes($filename) . $this->_phpExt;
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
