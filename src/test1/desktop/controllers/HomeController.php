<?php

namespace src\test1\desktop\controllers;

use src\test1\desktop\libs\Controller;

class HomeController extends Controller
{

    public function __construct($params)
    {
        parent::__construct($params);
    }

    // Thông báo lỗi 404
    public function index()
    {
        $this->_view->setTitle('test');
        $this->_view->tagsUrl('http://localhost/CodeIgniter/');
        $this->_view->tagsImageUrl('test.png');
        $this->_view->tagsKeywords('Từ khóa');
        $this->_view->tagsDescription('Mô tả');
        $this->_view->render('test');
    }

    // Thông báo lỗi 404
    public function error()
    {
        echo 'Trang lỗi!';
    }
}
