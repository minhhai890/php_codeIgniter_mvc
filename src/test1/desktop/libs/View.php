<?php

namespace src\test1\desktop\libs;

class View extends \libs\View
{

    public function __construct($params)
    {
        parent::__construct($params);
        $this->setTags();
    }

    // Thiết lập thẻ link meta javasctip trong head
    public function setTags()
    {
        $this->setCssTags('css/style.css');
    }
}
