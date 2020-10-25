<?php
if (isset($data) && $data) {
    $str = '<div class="category"><ul class="clearfix">';
    foreach ($data as $value) {
        $str .= '<li class="item">
                    <a href="" title="">
                        <picture>
                            <img src="' . $this->getData('dirImage') . 'icons/thoi-trang-nu.png" alt="thoi trang nu, thoi trang nam">
                        </picture>
                        <h2>Thời trang nữ - nam</h2>
                    </a>
                </li>';
    }
    $str .= '</ul></div>';
    return $str;
}
