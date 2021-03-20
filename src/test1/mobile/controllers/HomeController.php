<?php

namespace src\test1\mobile\controllers;

use src\test1\mobile\libs\Controller;

class HomeController extends Controller
{

    public function __construct($params)
    {
        parent::__construct($params);
    }

    // Thông báo lỗi 404
    public function index()
    {
        echo 'Trang chủ mobile';
    }

    // Thông báo lỗi 404
    public function error()
    {
        echo 'Trang lỗi mobile!';
    }
}
