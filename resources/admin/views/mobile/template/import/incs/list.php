<?php
$str = '';
$empty = '<li class="empty">Không có dữ liệu!</li>';
if (is_array($data)) {
    foreach ($data as $value) {
        if ($value['imports_status'] == STATUS['ALLOW']) {
            $status = ' class="success"';
        } else {
            $status = '';
        }
        $str .= '<li' . $status . '>
                        <a href="' . $this->route('app/import/index') . '" data-id="' . $value['imports_id'] . '" title="' . $value['products_name'] . '">
                            <div class="clearfix">
                                <div class="image">
                                    <img src="' . $this->getPicture(null, $value['products_keyword']) . '" alt="' . $value['products_keyword'] . '" title="' . $value['products_name'] . '">
                                </div>
                                <div class="item">
                                    <div class="row1">
                                        <h3 class="overflow">' . $value['products_name'] . '</h3>
                                        <span class="time">' . $this->convertDate($value['imports_created']) . '</span>
                                    </div>
                                    <div class="row2 clearfix">
                                        <p class="col col5 orverflow">Mã: <strong>' . $value['products_key'] . '</strong></p>                                       
                                        <p class="col col4 orverflow"><strong>' . $value['inventorys_name'] . '</strong></p>
                                        <p class="col col3 alignright orverflow">SL: <strong>' . \libs\Func::formatPrice($value['imports_amount_import']) . '</strong></p>
                                    </div>                       
                                </div>
                            </div>
                        </a>
                    </li>';
    }
}
return ($str ? $str : $empty);