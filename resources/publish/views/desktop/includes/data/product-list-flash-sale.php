<?php
if (isset($data) && $data) {
    $str = '<ul class="clearfix">';
    foreach ($data as $value) {
        $str .= '<li class="item">
                    <div class="imgbox">
                        <a href="" title="">
                            <img src="' . $this->getData('dirImage') . 'product/product-01.png" alt="">
                        </a>
                    </div>
                    <div class="boxsale">
                        <a href="" title="">
                            <h4>-40%</h4>
                            <span>Giảm</span>
                        </a>
                    </div>
                    <div class="infobox">
                        <a href="" title="">
                            <p class="price"><span>₫</span><span>9.999.999</span></p>
                            <p class="sold"><span>Đã bán 109</span><span class="sold-add" style="width: 60%"></span></p>
                        </a>
                    </div>
                </li>';
    }
    $str .= '</ul>';
    return $str;
}
