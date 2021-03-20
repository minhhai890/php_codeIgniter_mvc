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
	public $_host;				// Đường dẫn host
	public $_viewUrl;			// Đường dẫn CSS | JS
	public $_imgUrl;			// Đường dẫn hình ảnh
	public $_folderPublic;		// Thư mục hiển thị ra bên ngoài người dùng
	public $_title;				// Tiêu đề của trang
	public $_headTags;			// Thẻ tags head
	public $_customCode;		// Code tùy chỉnh
	public $_cssTags;			// Thẻ css
	public $_jsTags;			// Thẻ js
	public $_data;				// Lựu dữ liệu được truyền từ controller
	public $_device = '';		// Desktop | Mobile
	public $_exten = '.php';	// Phần mở rộng của tập tin

	// Phương thức khởi tạo
	public function __construct($params)
	{
		$this->setParams($params);
		$this->setDevice();
		$this->setFolderView();
		$this->setFolderViewContent();
		$this->setFileView();
		$this->setViewUrl();
		$this->setImageUrl();
	}

	// Phương thức trả về tập hợp thẻ trong head
	public function head()
	{
		$xhtml  = '<title>' . $this->_title . '</title>';
		$xhtml .= '<base href="' . $this->_host . '">';
		$xhtml .= '<meta name="author" content="' . Config::get('app.author') . '">';
		$xhtml .= '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
		$xhtml .= '<meta property="og:site_name" content="' . Config::get('app.name') . '" />';
		$xhtml .= '<meta property="og:type" content="website"/>';
		$xhtml .= '<meta property="og:title" content="' . $this->_title . '" />';
		$xhtml .= $this->tagsHead();
		$xhtml .= $this->getCssTags();
		$xhtml .= $this->getJsTags();
		$xhtml .= $this->customCode();
		return $xhtml;
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
			$this->_device = Device::get() . DS;
		}
	}

	// Phương thức thiết lập thư mục chứa giao diện | $folder => folder or folder1.folder2
	public function setFolderView()
	{
		$this->_folderView = 'src' . DS . $this->_params['excute']['appName'] . DS . $this->_device . 'views' . DS;
	}

	// Phương thức lấy ra thư mục chứa giao diện  | $path = true => path or $path = false => url
	public function getFolderView()
	{
		return DIR_ROOT . $this->_folderView;
	}

	// Phương thức thiết lập tập tin hiển thị giao diện | $filename => name
	public function setFileView($filename = 'web')
	{
		$this->_fileView = $filename . $this->_exten;
	}

	// Phương thức lấy ra tập tin hiển thị giao diện | $path = true => path or $path = false => url
	public function getFileView()
	{
		return $this->getFolderView() . $this->_fileView;
	}

	// Phương thức thiết lập thư mục chứa tập tin giao diện chi tiết | $folder => folder or folder1.folder2
	public function setFolderViewContent($folder = 'pages')
	{
		$this->_folderViewContent = $folder . DS;
	}

	// Phương thức lấy ra thư mục chứa tập tin giao diện chi tiết | $path = true => path or $path = false => url
	public function getFolderViewContent()
	{
		return $this->getFolderView() . $this->_folderViewContent;
	}

	// Phương thức thiết lập tập tin hiển thị giao diện thay đổi | $filename => name or folder.name
	public function setFileViewContent($filename)
	{
		$this->_fileViewContent = $this->_folderViewContent . Func::convertCslashes($filename) . $this->_exten;
	}

	// Phương thức thiết lập tập tin hiển thị giao diện thay đổi | $path = true => path or $path = false => url
	public function getFileViewContent()
	{
		return $this->getFolderView() . $this->_fileViewContent;
	}

	// Phương thức thiết lập đường dẫn CSS | JS
	public function setViewUrl()
	{
		$this->_host = rtrim(Config::get('app.url.host'), '/') . DS;
		$this->_viewUrl = $this->_host . @$this->_params['excute']['appName'] . DS;
	}

	// Phương thức thiết lập đường dẫn chứa hình ảnh
	public function setImageUrl()
	{
		$this->_imgUrl = rtrim(Config::get('app.url.image'), '/') . DS;
	}

	// Phương thức trả về đường dẫn của một hình ảnh với /views/{$pathFile}
	// Đường dẫn hình ảnh bên trong code
	public function imageInside($pathFile)
	{
		return $this->_viewUrl . @$this->_params['excute']['appName'] . DS . 'images' . DS . $pathFile;
	}

	// Phương thức trả về đường dẫn của một hình ảnh với /views/{$pathFile}
	// Đường dẫn hình ảnh bên ngoài
	public function imageOutside($pathFile)
	{
		return $this->_imgUrl . $pathFile;
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

	// Phương thức tạo thẻ tags url
	public function tagsUrl($url)
	{
		$this->_headTags .= '<meta property="og:url" content="' . $url . '" />';
		$this->_headTags .= '<link rel="canonical" href="' . $url . '" />';
	}

	// Phương thức tạo thẻ tags image url
	public function tagsImageUrl($urlImage)
	{
		if ($exten = strtolower(pathinfo($urlImage, PATHINFO_EXTENSION))) {
			if ($type = Func::getTypeFileExtension($exten)) {
				$this->_headTags .= '<meta property="og:image" content="' . $urlImage . '" />';
				$this->_headTags .= '<meta property="og:image:type" content="' . $type . '">';
			}
		}
	}

	// Phương thức tạo thẻ tags keywords
	public function tagsKeywords($content)
	{
		$this->_headTags .= '<meta name="keywords" content="' . $content . '" />';
	}

	// Phương thức tạo thẻ tags description
	public function tagsDescription($content)
	{
		$this->_headTags .= '<meta name="description" content="' . $content . '" />';
		$this->_headTags .= '<meta property="og:description" content="' . $content . '" />';
	}

	// Phương thức thiết lập icon shortcut như một ứng dụng mobile
	public function shortcut($imgIcon)
	{
		$this->_headTags .= '<link href="' . $this->imageInside($imgIcon) . '" type="image/png" rel="shortcut icon"/>';
	}

	// Phương thức thiết lập trình duyệt như một ứng dụng mobile app
	public function getManifest($name, $icon)
	{
		echo json_encode([
			"version" => "1.0",
			"lang" => "en",
			"name" => $name,
			"scope" => "/",
			"display" => "fullscreen",
			"start_url" =>  $this->_host,
			"short_name" => $name,
			"description" => "",
			"orientation" => "portrait",
			"background_color" => "#000000",
			"theme_color" => "#000000",
			"generated" => "true",
			"icons" => [
				[
					"src" => $this->_imgUrl . $icon,
					"sizes" => "36x36",
					"type" => "image/png"
				]
			]
		]);
	}

	// Phương thức thiết lập icon shortcut như một ứng dụng mobile
	public function tagsManifest()
	{
		$this->_headTags .= '<link rel="manifest" href="' . $this->_viewUrl . 'manifest.json">';
	}

	// Phương thức tạo thuộc tính schema
	public function schema($name, $image, $description, $rating = [])
	{
		$this->_headTags .= '<script type="application/ld+json">
			{
				"@context": "https://schema.org",
				"name": "' . $name . '",
				"image": "' . $image . '",
				"description": "' . $description . '",
				"sku": "CTG-10",
				"review": {
					"@type": "Review",
					"reviewRating": {
						"@type": "Rating",
						"ratingValue": "5",
						"bestRating": "5"
					},
					"reviewBody": "' . @$rating['content'] . '",
					"author": {
						"@type": "Person",
						"name": "' . @$rating['name'] . '"
					}
				},
				"brand": {
					"@type": "Brand",
					"name": "LinaHouse"
				},
				"@type": "Organization",
				"aggregateRating": {
					"@type": "AggregateRating",
					"ratingValue": "4.9",
					"bestRating": "5",
					"ratingCount": "' . @$rating['count'] . '"
				}
			}
			</script>';
	}

	// Phương thức thiết lập thẻ link tags
	public function tagsHead($tags = '')
	{
		if ($tags) {
			$this->_headTags .= $tags;
		} else {
			return $this->_headTags;
		}
	}

	// Phương thức thiết lập thẻ link tags
	public function customCode($code = '')
	{
		if ($code) {
			$this->_customCode .= $code;
		} else {
			return $this->_customCode;
		}
	}

	// Phương thức thiết lập link file css
	public function setCssTags($path, $onPage = false)
	{
		if ($path) {
			if ($onPage == true) {
				$filename = $this->_viewUrl . $path;
				if ($content = @file_get_contents($filename)) {
					$this->_cssTags .= '<style type="text/css">' . $content . '</style>';
				}
			} else {
				$this->_cssTags .= '<link rel="stylesheet" type="text/css" href="' . $this->_viewUrl . $path . '">';
			}
		}
	}

	// Phương thức thiết lập nhiều link file css cùng lúc
	public function setMultiCssTags($options, $onPage = false)
	{
		if ($options) {
			foreach ($options as $path) {
				$this->setCssTags($path, $onPage);
			}
		}
	}

	// Phương thức lấy ra link hoặc nội dung css
	public function getCssTags()
	{
		return $this->_cssTags;
	}

	// Phương thức thiết lập link file js
	public function setJsTags($path, $onPage = false)
	{
		if ($path) {
			if ($onPage == true) {
				$filename = $this->_viewUrl . $path;
				if ($content = @file_get_contents($filename)) {
					$this->_jsTags .= '<script type="text/javascript">' . $content . '</script>';
				}
			} else {
				$this->_jsTags .= '<script type="text/javascript" src="' . $this->_viewUrl . $path . '"></script>';
			}
		}
	}

	// Phương thức thiết lập link file js
	public function setMultiJsTags($options, $onPage = false)
	{
		if ($options) {
			foreach ($options as $path) {
				$this->setJsTags($path, $onPage);
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
		if (gettype($this->_data) == 'array') {
			if (isset($this->_data[$name])) {
				return $this->_data[$name];
			}
		}
		if (gettype($this->_data) == 'object') {
			if (isset($this->_data->$name)) {
				return $this->_data->$name;
			}
		}
	}

	// Phương thức lấy data cấp 2
	public function getItem($name, $item)
	{
		$data = $this->getData($name);
		if ($data) {
			if (gettype($data) == 'array') {
				if (isset($data[$item])) {
					return $data[$item];
				}
			}
			if (gettype($data) == 'object') {
				if (isset($data->$item)) {
					return $data->$item;
				}
			}
		}
	}

	// Phương thức include
	public function include($filename, $data = null)
	{
		$filename = $this->getFolderView() . Func::convertCslashes($filename) . $this->_exten;
		if (file_exists($filename)) {
			if (($view = include $filename) != 1) {
				return $view;
			}
		}
	}

	// Phương thức include folder view content
	public function includeView($filename, $data = null)
	{
		$filename = $this->getFolderViewContent() . Func::convertCslashes($filename) . $this->_exten;
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
			return $this->_params['route']->url($name, $options);
		}
	}

	// Phương thức chuyển trang tới đường đẫn url
	public function redirect($url)
	{
		header('Location: ' . $url);
		exit();
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
