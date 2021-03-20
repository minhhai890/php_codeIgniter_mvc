<?php

namespace src\test1\desktop\libs;

class Controller extends \libs\Controller
{
    public function __construct($params)
    {
        parent::__construct($params);
        $this->setView();
    }
}
