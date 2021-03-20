<?php

namespace src\test1\mobile\libs;

class Controller extends \libs\Controller
{
    // Phương thức khởi trạo
    public function __construct($params)
    {
        parent::__construct($params);
        $this->setView();
    }
}
