<?php

namespace src\test2\libs;

class Controller extends \libs\Controller
{

    public function __construct($params)
    {
        parent::__construct($params);
        $this->setView();
    }
}
