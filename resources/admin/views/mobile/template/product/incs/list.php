<?php
$str = '';
$empty = '<li class="empty">Không có dữ liệu!</li>';
if (is_array($data)) {
    foreach ($data as $value) {
        $status = ($value['products_status'] == STATUS['UNBUSINESS'] ? ' class="reason"' : '');
        $str .= '<li' . $status . '>
                        <a href="' . $this->route('app/product/index') . '" data-id="' . $value['products_id'] . '" title="' . $value['products_name'] . '">
                            <div class="clearfix">
                                <div class="image"><img src="' . $this->getPicture(null, $value['products_keyword']) . '" alt="' . $value['products_keyword'] . '" title="' . $value['products_name'] . '" /></div>
                                <div class="item">
                                    <div class="row1">
                                        <h3 class="overflow">' . $value['products_name'] . '</h3>
                                        <span class="time">' . $this->convertDate($value['products_created']) . '</span>
                                    </div>
                                    <div class="row2 clearfix">
                                        <p class="col col6">Trạng thái: <strong>' . $this->status($value['products_status']) . '</strong></p>
                                        <p class="col col6">Đơn vị tính: <strong>' . $value['units_name'] . '</strong></p>
                                    </div>                       
                                </div>
                            </div>
                        </a>
                    </li>';
    }
}
return ($str ? $str : $empty);
