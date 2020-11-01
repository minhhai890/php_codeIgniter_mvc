<?php
if (isset($data) && $data) {
    $link = $this->route('product');
    $str = '<ul class="clearfix">';
    foreach ($data as $value) {
        $str .= '<li class="item">
                    <div class="imgbox">
                        <a href="'. $link.'" title="">
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
                            <h3>Sản phẩm của bạn được đặt tên như thế nào Sản phẩm của bạn được đặt tên như thế nào</h3>
                            <span class="price"><span>₫</span><strong>9.999.999</strong></span>
                            <span class="sold">đã bán 169</span>
                        </a>
                    </div>
                </li>';
    }
    $str .= '</ul>';
    return $str;
}
