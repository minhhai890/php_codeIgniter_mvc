<?php

namespace resources\admin\controllers;

class DashboardController extends \resources\admin\libs\Controller
{

    // Phương thức login
    public function index()
    {
        $this->setView();
        $publish = $this->_view->setObject('publish');
        echo '<pre>';
        print_r($publish->getFolderImage(false, false));
        echo '</pre>';
    }
}
