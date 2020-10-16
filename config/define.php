<?php
define('SCHEME', (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 'https' : 'http') . '://');
// Vhost or Hosting
// define('HOST_NAME'		    , $_SERVER['HTTP_HOST']);                   	// example.com
// define('URL_HOST'			, SCHEME . HOST_NAME);               			// http://example.com/
// define('URL_SITE'			, URL_HOST . $_SERVER['REQUEST_URI']);     		// http://example.com/abcdef.html

// Local Host
define('HOST_NAME', $_SERVER['HTTP_HOST'] . '/CodeIgniter');    				// /mvcobject
define('URL_HOST', SCHEME . HOST_NAME);               		    				// http://localhost/mvcobject/
define('URL_SITE', SCHEME . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); 	// http://localhost/mvcobject/abcdef.html

// Browser Agent
define('PLATFORM', 'platform');
define('BROWSER', 'browser');
define('BROWSER_DEVICE', 'mobile');
define('BROWSER_VERSION', 'version');

// Dir or Path Url
define('DIR_CONFIG', DIR_ROOT . 'configs' . DS);     	    					// Đường dẫn đến thư mục config
define('DIR_LIBRARY', DIR_ROOT . 'libs' . DS); 		    						// Đường dẫn đến thư mục libs
define('DIR_VENDOR', DIR_ROOT . '..' . DS . 'vendor' . DS . 'autoload.php'); 	// Đường dẫn đến thư mục Vendor
define('DIR_RESOURCE', DIR_ROOT . 'resources' . DS); 		    				// Đường dẫn đến thư mục resources
define('URL_RESOURCE', URL_HOST . 'resources' . DS); 							// Đường dẫn đến thư mục resources

// File Upload
define('DIR_UPLOAD', DIR_ROOT . 'upload');										// Đường dẫn đến thư mục upload
define('FILE_SIZE', '3MB'); 													// Kích thức tối đa của tập tin được tải lên
define('FILE_EXTENSION', 'xls, xlsx, jpg');											// Định dạng tập tin tải lên hơp lệ

// Database
define('TB_PREFIX', '');                                   						// Tiền tố của bảng
define('RD_LIMIT', 10);															// Số dòng sql lấy ra tối đa
define('DB_HOST', 'localhost');													// Đường dẫn host sql
define('DB_USER', 'root');														// User sql
define('DB_PWD', '');															// Password sql
define('DB_NAME', 'bida');														// Tên database

// Send Email
define('SEND_EMAIL', [
	'username' 	=> '',		// Email gửi
	'password' 	=> '',		// Mật khẩu ứng dụng
	'from'		=> '',		// Gửi từ đâu
	'name'		=> '',		// Tên người gửi
	'reply'		=> ''		// Email trả lời
]);

// FTP Server
define('FTP_SERVER', '');	// Máy chủ
define('FTP_USER', '');		// Tên tài khoản
define('FTP_PASS', '');		// Mật khẩu
define('FTP_PORT', 21);		// Port kết nối

// Status
define('STATUS', [
	'ALLOW' 		=> 1,	// Hoạt động
	'PENDING' 		=> 2,	// Chờ duyệt
	'PAUSE' 		=> 3,	// Tạm ngưng
	'DELETE' 		=> 4,	// Đã xóa
]);
