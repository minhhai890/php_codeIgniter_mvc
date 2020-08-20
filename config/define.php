<?php
define('SCHEME', (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 'https' : 'http') . '://');
//vhost or hosting
// define('HOST_NAME'		    , $_SERVER['HTTP_HOST']);                   	// example.com
// define('BASE_NAME'			, SCHEME . HOST_NAME);               			// http://example.com/
// define('PATH_URL'			, BASE_NAME . $_SERVER['REQUEST_URI']);     	// http://example.com/abcdef.html

// Local host
define('HOST_NAME', $_SERVER['HTTP_HOST'] . '/CodeIgniter');    		// /mvcobject
define('BASE_NAME', SCHEME . HOST_NAME);               		    // http://localhost/mvcobject/
define('PATH_URL', SCHEME . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); // http://localhost/mvcobject/abcdef.html

define('PLATFORM', 'platform');
define('BROWSER', 'browser');
define('BROWSER_DEVICE', 'mobile');
define('BROWSER_VERSION', 'version');

define('PATH_APPLICATION', PATH_ROOT . DS . 'applications' . DS);     	// Đường dẫn đến thư mục application
define('PATH_CONFIG', PATH_ROOT . DS . 'configs' . DS);     	    // Đường dẫn đến thư mục application
define('PATH_LIBRARY', PATH_ROOT . DS . 'libs' . DS); 		    	// Đường dẫn đến thư mục libs
define('PATH_VENDOR', PATH_ROOT . DS . '..' . DS . 'vendor' . DS . 'autoload.php'); 	// Đường dẫn đến thư mục Vendor
define('PATH_RESOURCE', PATH_ROOT . DS . 'resources' . DS); 		    // Đường dẫn đến thư mục resources
define('URL_RESOURCE', BASE_NAME . DS . 'resources' . DS); 			// Đường dẫn đến thư mục resources

define('FILE_SIZE', '3MB'); 										// Kích thức tối đa của tập tin được tải lên
define('FILE_EXTENSION', 'xls, xlsx');									// Định dạng tập tin tải lên hơp lệ

define('TB_PREFIX', '');                                   		// Tiền tố của bảng
define('RD_LIMIT', 10);											// Số dòng sql lấy ra tối đa
define('DB_HOST', 'localhost');									// Đường dẫn host sql
define('DB_USER', 'root');										// User sql
define('DB_PWD', '');											// Password sql
define('DB_NAME', 'bida');										// Tên database

// Status
define('STATUS', [
	'ALLOW' 		=> 1,	// Hoạt động
	'PENDING' 		=> 2,	// Chờ duyệt
	'PAUSE' 		=> 3,	// Tạm ngưng
	'DELETE' 		=> 4,	// Đã xóa
]);

// Thông tin thiết lập email gửi
define('SEND_EMAIL', [
	'username' 	=> '',
	'password' 	=> '',
	'from'		=> '',		// gửi từ đâu
	'name'		=> '',		// tên người gửi
	'reply'		=> ''		// Email trả lời
]);