<?php
    use resources\app\libs\Func;
    $str = '';
    $empty = '<li class="empty">Không có dữ liệu!</li>';
    if($data && is_array($data)){       
        foreach ($data as $key => $value){           
            $str .= '<li class="'. $this->status($value['tbl_status'], 'class') .'">';
            $str .= '<a href="'.$this->route('app/bill/index').'" title="'. $value['tcs_name'] .'" data-id="'. $value['tbl_id'] .'" data-cid="'. $value['tcs_id'] .'">';
            $str .= '<div class="clearfix">';
            $str .= '<div class="image">';                     
            $str .= '<img class="circle" src="'. $this->getPicture($value['tcs_picture'], $value['tcs_keyword']) .'" alt="'. $value['tcs_keyword'] .'" title="'. $value['tcs_name'] .'">';
            $str .= '</div>';
            $str .= '<div class="item">';
            $str .= '<div class="row1">';
            $str .= '<h3 class="overflow">'. $value['tcs_name'] .'</h3>';
            $str .= '<span class="time">'. $this->convertDate($value['tbl_created'], true) .'</span>';
            $phone = '';
            if($arPhone = json_decode($value['tcs_phone'], true)){
                if(isset($arPhone['default'])){
                    $phone = $arPhone['default'];
                }
            }            
            if(empty($phone) || empty($value['tad_provinceid'].$value['tad_districtid'])){
                $str .= '<span class="warning">Thông tin</span>';
            }
            if ($value['tbl_purchase'] == STATUS['ALLOW']) {
                $str .= '<span class="warning green">Mua hàng</span>';
            }
            if ($value['tbl_many']) {
                $str .= '<span class="warning orange">Gửi chung</span>';
            }
            $str .= '</div>';
            $str .= '<div class="row2 clearfix">';
            $str .= '<p class="phone">ĐT: <strong>'. $phone .'</strong></p>';
            $str .= '<p class="amount">SL: <strong>'. Func::formatPrice($value['tbl_amount']) .'</strong></p>';
            $str .= '<p class="price">T.Tiền: <strong>'. Func::formatPrice($value['tbl_collect']) .'</strong></p>';
            $str .= '</div>';
            $str .= '<div class="row3 clearfix">';                      
            $address = $note = 'show';
            if($value['tbl_note']){
                $address = 'hidden';
            }else{
                $note = 'hidden';
            }
            $str .= '<p class="address '. $address .'">ĐC: <span>'. $value['tad_fulladdress'] .'</span></p>';
            $str .= '<p class="reason '. $note .'">'. $this->status($value['tbl_status'], 'name') .': <span>'. $value['tbl_note'] .'</span></p>';
            $str .= '</div>';
            $str .= '</div>';
            $str .= '</div>';
            $str .= '</a>';
            $str .= '</li>';
        }
    }
    return ($str?$str:$empty);    
?>