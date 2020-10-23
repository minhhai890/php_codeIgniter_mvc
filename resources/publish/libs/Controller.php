<?php

namespace resources\publish\libs;

class Controller extends \libs\Controller
{
    // phương thức khởi tạo
    public function __construct($params)
    {
        parent::__construct($params);
        $this->setView();
    }
}
