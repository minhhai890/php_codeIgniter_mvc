<?php

use libs\Session;
use libs\Route;

require 'autoload.php';
Session::init();

// Thiết lập đường dẫn url
$route = new Route();

// Cấu hình website home
$route->set([
    'object' => 'home',                     // tên dự án					
    'src' => [                              // thư mục chứa mã nguồn
        'libs' => 'libs',                   // thư mục thư việc của site
        'controllers' => 'controllers',     // thư mục chứa controller xử lý
        'models' => 'models',               // thư mục chứa model xử lý database
        'views' => 'views'                  // thư mục chứa giao diện
    ],
    'device' => false,                      // Sử dụng responsive mobile | desktop
    'error' => [
        'redirect'  => false,               // Cho phép chuyển về trang lỗi hoặc không chuyển
        'startpath'  => '',                 // Đường dẫn nhận biết trang lỗi host + path
        'routename' => 'error',             // Route gọi tranh lỗi
    ],
]);

// trang chủ
$route->get('home', '/', 'main@home');

$route->get('testupload', '/upload.html', 'main@upload');

$route->get('testresize', '/resize.html', 'main@resize');

$route->get('error', '/error.html', function () {
    echo 'Trang website không tồn tại';
});
