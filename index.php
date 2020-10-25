<?php

use libs\Session;
use libs\Route;

require 'autoload.php';
Session::init();

// Thiết lập đường dẫn url
$route = new Route();

// Cấu hình website người dùng public
$route->set([
    'object' => 'publish',                     // tên dự án					
    'src' => [                              // thư mục chứa mã nguồn
        'libs' => 'libs',                   // thư mục thư việc của site
        'controllers' => 'controllers',     // thư mục chứa controller xử lý
        'models' => 'models',               // thư mục chứa model xử lý database
        'views' => 'views'                  // thư mục chứa giao diện
    ],
    'device' => true,                      // Sử dụng responsive mobile | desktop
    'error' => [
        'redirect'  => false,               // Cho phép chuyển về trang lỗi hoặc không chuyển   
        'startpath'  => '',                 // Đường dẫn nhận biết trang lỗi host + path    
        'routename' => 'error',             // Route gọi tranh lỗi
    ],
]);

// Trang chủ
$route->get('home', '', 'home@index');

// Trang chuyên mục
$route->get('category', 'chuyen-muc.html', 'category@index');

// Trang chi tiết sản phẩm
$route->get('product', 'chi-tiet.html', 'product@index');

// Trang trả về đường dẫn hình ảnh
$route->get('system/image', 'images/{filename}', 'system@viewimage')->where([
    'filename' => '([A-z0-9\-_\.\/]+)'
]);

// Trang thông báo lỗi
$route->get('error', '/error.html', function () {
    echo 'Trang website không tồn tại';
});



// Cấu hình website quản trị admin
$route->set([
    'object' => 'admin',            // Tiền tố namespace
    'device' => true,                    // repsonsiv mobile or desktop
    'error' => [                            // page error
        'startpath' => 'cms_admin',                    // nhận dạng error host + path
        'routename' => '',        // gọi gọi error route
        'redirect' => true                // cho phép chuyển tranh
    ],
    'src' => [                            // cấu trúc thư mục website
        'libs' => 'libs',
        'controllers' => 'controllers',
        'models' => 'models',
        'views' => 'views'
    ]
]);


$route->groups('cms_admin', function ($route) {

    $route->post('admin/dashboard', '/dashboard.html', 'dashboard@index');
});
