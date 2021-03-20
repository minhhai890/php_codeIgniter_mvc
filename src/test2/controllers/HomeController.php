<?php

namespace src\test2\controllers;

use src\test2\libs\Controller;

class HomeController extends Controller
{
    // Trang chủ
    public function index()
    {
        echo 'trang chủ test 2';
    }

    // Trang lỗi
    public function error()
    {
        echo 'trang lỗi test 2';
    }
}
