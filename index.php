<?php
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Asia/Ho_Chi_Minh');

require 'autoload.php';

// Khởi tạo đối tượng Route
$route = new libs\Route();

// APP 1
$route->setApp('test1', true);
$route->setError('/', 'error', false);

// Trang home
$route->get('home1', '/', 'home@index');

// Trang error
$route->get('error', '/error.html', 'home@error');


// APP 2
$route->setApp('test2', false);
$route->setError('/test2', 'error2', true);

$route->groups('/test2', function ($route) {
    // Trang lỗi
    $route->get('home2', '/', 'home@index');

    // Trang lỗi
    $route->get('error2', '/error.html', 'home@error');
});
