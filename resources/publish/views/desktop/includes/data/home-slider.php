<?php
if (isset($data) && $data) {
    $str = '<div class="slider">
            <a href="#" class="next">&#10095;</a>
            <a href="#" class="prev">&#10094;</a>
            <ul>';
    foreach ($data as $value) {
        $str .= '<li>
                    <div class="content">
                        <h2>Chương trình giảm giá 50%</h2>
                        <p>Fill the web page with one new div element for each item in an array. The HTML code of each
                            div element is inside the template element</p>
                        <a href="" title="">Xem thêm</a>
                    </div>
                    <div class="image">
                        <a href="" title="">
                            <img src="images/slider/01.jpg" alt="" title="">
                        </a>
                    </div>
                </li>';
    }
    $str .= '</ul></div>';
    return $str;
}
